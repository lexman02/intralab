package server

import (
	"crypto/rand"
	"encoding/hex"
	"encoding/json"
	"fmt"
	"github.com/go-chi/chi"
	"github.com/go-chi/chi/middleware"
	"github.com/go-chi/cors"
	"github.com/gorilla/sessions"
	"intralab/config"
	ui "intralab/frontend"
	"intralab/pkg/auth"
	"intralab/pkg/ticketing"
	"intralab/types"
	"log"
	"maps"
	"net/http"
	"slices"
	"time"

	"intralab/pkg/items"
)

var cfg *config.Config
var store *sessions.CookieStore
var authType string

func StartServer(config *config.Config) {
	cfg = config

	findAuthType, err := auth.FindAuthType(cfg.Auth)
	if err != nil {
		log.Fatal("Failed to find auth type: ", err)
	}

	authType = findAuthType

	sessionSecret, err := generateRandomSecret()
	if err != nil {
		log.Fatal("Failed to generate session secret: ", err)
	}

	if cfg.App.Key == "" {
		cfg.App.Key = sessionSecret
		cfg.SetConfigValue("app.key", sessionSecret)
	}

	// Create a new CookieStore with the generated secret
	store = sessions.NewCookieStore([]byte(cfg.App.Key))

	r := chi.NewRouter()

	r.Use(AuthMiddleware)
	r.Use(middleware.Logger)
	r.Use(middleware.Recoverer)
	r.Use(cors.Handler(cors.Options{
		// AllowedOrigins:   []string{"https://foo.com"}, // Use this to allow specific origin hosts
		AllowedOrigins: []string{"https://*", "http://*"},
		// AllowOriginFunc:  func(r *http.Request, origin string) bool { return true },
		AllowedMethods:   []string{"GET", "POST", "PUT", "DELETE", "OPTIONS"},
		AllowedHeaders:   []string{"Accept", "Authorization", "Content-Type", "X-CSRF-Token"},
		ExposedHeaders:   []string{"Link"},
		AllowCredentials: false,
		MaxAge:           300, // Maximum value not ignored by any of major browsers
	}))

	// Serve static files
	r.Mount("/", ui.Handler())

	// Register routes
	r.Get("/api/items", GetItemsHandler)
	r.Post("/api/items", PostItemsHandler)
	r.Delete("/api/items", DeleteItemsHandler)
	r.Put("/api/items", UpdateItemsHandler)
	r.Post("/api/ticket", PostTicketHandler)
	r.Get("/api/settings", GetSettingsHandler)
	r.Post("/api/settings/{section}", PostSettingsHandler)
	r.Get("/api/config", ExportConfigHandler)
	r.Post("/api/config", ImportConfigHandler)
	r.Get("/auth/callback", CallbackHandler)
	r.Get("/auth/info", GetAuthInfoHandler)
	r.Get("/auth/logout", LogoutHandler)
	r.Get("/auth/login", LoginHandler)

	log.Println("Server started on :3000")
	err = http.ListenAndServe(":3000", r)
	if err != nil {
		return
	}
}

func GetItemsHandler(w http.ResponseWriter, r *http.Request) {
	itemList, err := items.GetItems()
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, err.Error()})
		return
	}

	if authType == "oidc" {
		session, err := store.Get(r, "session")
		if err != nil {
			http.Error(w, "Session error", http.StatusInternalServerError)
			return
		}

		userRoles, ok := session.Values["roles"].([]string)
		if !ok {
			jsonError(w, http.StatusInternalServerError, Error{GeneralError, "Failed to get user roles"})
			return
		}

		if slices.Contains(userRoles, cfg.Auth.AdminRole) {
			var filteredItems []items.Item

			for _, item := range itemList {
				// If allowed_roles is not set or the role check passes, include the item
				if len(item.AllowedRoles) == 0 || auth.HasRequiredRoles(userRoles, item.AllowedRoles) {
					filteredItems = append(filteredItems, item)
				}
			}

			itemList = filteredItems
		}
	}

	w.Header().Set("Content-Type", "application/json")
	err = json.NewEncoder(w).Encode(itemList)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{EncodeError, err.Error()})
		return
	}
}

func PostItemsHandler(w http.ResponseWriter, r *http.Request) {
	var itemList []items.Item

	err := json.NewDecoder(r.Body).Decode(&itemList)
	if err != nil {
		jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
		return
	}

	dbErr := items.StoreItems(itemList)
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
		return
	}

	log.Println("Items added")
	jsonResponse(w, http.StatusOK, map[string]string{"success": "Items added"})
}

func UpdateItemsHandler(w http.ResponseWriter, r *http.Request) {
	var item items.Item

	err := json.NewDecoder(r.Body).Decode(&item)
	if err != nil {
		jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
		return
	}

	dbErr := items.UpdateItems(item)
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
		return
	}

	log.Println("Items updated")
	jsonResponse(w, http.StatusOK, map[string]string{"success": "Items updated"})
}

func DeleteItemsHandler(w http.ResponseWriter, r *http.Request) {
	var item items.Item

	err := json.NewDecoder(r.Body).Decode(&item)
	if err != nil {
		jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
		return
	}

	dbErr := items.DeleteItems(item)
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
		return
	}

	log.Println("Items deleted")
	jsonResponse(w, http.StatusOK, map[string]string{"success": "Items deleted"})
}

func PostTicketHandler(w http.ResponseWriter, r *http.Request) {
	var ticket ticketing.Ticket

	if authType == "basic" {
		jsonError(w, http.StatusUnauthorized, Error{GeneralError, "Ticketing is not available with basic auth"})
		return
	}

	session, err := store.Get(r, "session")
	if err != nil {
		http.Error(w, "Session error", http.StatusInternalServerError)
		return
	}

	ticket.Name = session.Values["name"].(string)
	ticket.Email = session.Values["email"].(string)

	err = json.NewDecoder(r.Body).Decode(&ticket)
	if err != nil {
		jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
	}

	err = ticketing.OSTicket(cfg.Ticketing, ticket)
	if err != nil {
		fmt.Println(err)
		return
	}
}

func GetSettingsHandler(w http.ResponseWriter, r *http.Request) {
	response := map[string]interface{}{
		"ticketing": cfg.Ticketing,
	}

	jsonResponse(w, http.StatusOK, response)
}

func PostSettingsHandler(w http.ResponseWriter, r *http.Request) {
	section := chi.URLParam(r, "section")

	switch section {
	case "ticketing":
		var ticketing config.TicketingConfig
		err := json.NewDecoder(r.Body).Decode(&ticketing)
		if err != nil {
			jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
			return
		}

		cfg.SetConfigValue("ticketing", ticketing)
	}

	log.Println("Settings updated")
	jsonResponse(w, http.StatusOK, map[string]string{"success": "Settings updated"})
}

func ExportConfigHandler(w http.ResponseWriter, r *http.Request) {
	getItems, dbErr := items.GetItems()
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
		return
	}

	data, err := json.Marshal(types.Intralab{
		Config: *cfg,
		Items:  getItems,
	})
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{EncodeError, err.Error()})
		return
	}

	w.Header().Set("Content-Type", "application/json")
	filename := "intralab_config_" + time.Now().Format("2006-01-02") + ".json"
	w.Header().Set("Content-Disposition", "attachment; filename="+filename)

	_, err = w.Write(data)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, err.Error()})
		return
	}
	log.Println("Config exported")
}

func ImportConfigHandler(w http.ResponseWriter, r *http.Request) {
	var intralab types.Intralab

	err := json.NewDecoder(r.Body).Decode(&intralab)
	if err != nil {
		jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
		return
	}

	config.ImportConfig(intralab.Config)
	err = items.PurgeItems()
	if err != nil {
		return
	}

	err = items.StoreItems(intralab.Items)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, err.Error()})
		return
	}

	err = expireSession(w, r)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, err.Error()})
		return
	}

	log.Println("New config imported")
	jsonResponse(w, http.StatusOK, map[string]string{"success": "Import successful"})
}

func CallbackHandler(w http.ResponseWriter, r *http.Request) {
	// Assuming you have your app configuration stored globally or retrieved from somewhere
	err := auth.CheckStateAndExpireCookie(w, r)
	if err != nil {
		jsonError(w, http.StatusUnauthorized, Error{GeneralError, err.Error()})
		return
	}

	_, token, err := auth.VerifyOIDCToken(r)
	if err != nil {
		jsonError(w, http.StatusUnauthorized, Error{GeneralError, err.Error()})
		return
	}

	// Store user roles in session or anywhere else for use in your application
	userClaims, err := auth.GetUserClaimsFromAccessToken(token)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, err.Error()})
		fmt.Println("Failed to get user claims")
		return
	}

	session, _ := store.Get(r, "session")
	session.Options.HttpOnly = true
	session.Values["authenticated"] = true
	session.Values["roles"] = userClaims.Roles
	session.Values["username"] = userClaims.Username
	session.Values["name"] = userClaims.Name
	session.Values["email"] = userClaims.Email
	err = session.Save(r, w)
	if err != nil {
		return
	}

	// Check if the user needs to be redirected to a specific URL
	redirectURL, ok := session.Values["redirect_url"].(string)
	if ok {
		session.Values["redirect_url"] = nil
		err = session.Save(r, w)
		if err != nil {
			return
		}

		http.Redirect(w, r, redirectURL, http.StatusFound)
		return
	}

	// Set up a session or return the roles to the frontend for storage
	// Example: You can send the roles to your Svelte frontend
	jsonResponse(w, http.StatusOK, map[string]interface{}{
		"message":     "Authentication successful",
		"user_claims": userClaims,
	})
}

func GetAuthInfoHandler(w http.ResponseWriter, r *http.Request) {
	session, err := store.Get(r, "session")
	if err != nil {
		return
	}

	var user auth.UserClaims
	basePayload := map[string]interface{}{
		"auth_type":      authType,
		"authenticated":  session.Values["authenticated"],
		"session_expiry": session.Options.MaxAge,
	}

	if authType == "oidc" {
		user = auth.UserClaims{
			Name:     session.Values["name"].(string),
			Email:    session.Values["email"].(string),
			Username: session.Values["username"].(string),
			Roles:    session.Values["roles"].([]string),
		}

		maps.Copy(basePayload, map[string]interface{}{
			"admin_role": cfg.Auth.AdminRole,
			"user":       user,
		})
	}

	jsonResponse(w, http.StatusOK, basePayload)
}

func LogoutHandler(w http.ResponseWriter, r *http.Request) {
	redirectUrl := "/"
	statusCode := http.StatusFound

	err := expireSession(w, r)
	if err != nil {
		return
	}

	if authType == "oidc" {
		redirectUrl = auth.LogoutURL(cfg.Auth.OIDC.AuthURL)
	}

	if authType == "basic" {
		statusCode = http.StatusUnauthorized
	}

	http.Redirect(w, r, redirectUrl, statusCode)
	return
}

func expireSession(w http.ResponseWriter, r *http.Request) error {
	session, err := store.Get(r, "session")
	if err != nil {
		return err
	}

	session.Options.MaxAge = -1
	session.Values = make(map[interface{}]interface{})
	err = session.Save(r, w)
	if err != nil {
		return err
	}

	return nil
}

func LoginHandler(w http.ResponseWriter, r *http.Request) {
	session, err := store.Get(r, "session")
	if err != nil {
		return
	}

	w.Header().Set("WWW-Authenticate", `Basic realm="Authentication required"`)

	username, password, ok := r.BasicAuth()
	fmt.Println(username, password, ok)
	if !ok {
		// No credentials provided, show the basic auth prompt again
		http.Error(w, "Unauthorized", http.StatusUnauthorized)
		return
	}

	if !auth.ValidateBasicAuthCredentials(cfg.Auth.BasicAuth.Username, cfg.Auth.BasicAuth.Password, username, password) {
		// Invalid credentials, show the basic auth prompt again
		http.Error(w, "Unauthorized", http.StatusUnauthorized)
		return
	}

	session.Values["authenticated"] = true
	err = session.Save(r, w)
	if err != nil {
		return
	}

	http.Redirect(w, r, "/", http.StatusFound)
}

func generateRandomSecret() (string, error) {
	bytes := make([]byte, 32)
	_, err := rand.Read(bytes)
	if err != nil {
		return "", err
	}
	return hex.EncodeToString(bytes), nil
}
