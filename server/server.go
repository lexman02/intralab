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
	"intralab/types"
	"log"
	"net/http"
	"time"

	"intralab/pkg/items"
)

var cfg *config.Config
var store *sessions.CookieStore

func StartServer(config1 *config.Config) {
	cfg = config1

	sessionSecret, err := generateRandomSecret()
	if err != nil {
		log.Fatal("Failed to generate session secret: ", err)
	}

	if cfg.App.Key == "" {
		cfg.App.Key = sessionSecret
		config.SetConfig("app.key", sessionSecret)
	}

	// Create a new CookieStore with the generated secret
	store = sessions.NewCookieStore([]byte(cfg.App.Key))

	r := chi.NewRouter()

	r.Use(OIDCMiddleware)
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
	r.Get("/api/config", ExportConfigHandler)
	r.Post("/api/config", ImportConfigHandler)
	r.Get("/auth/callback", CallbackHandler)
	r.Get("/auth/logout", LogoutHandler)
	//r.Post("/auth/validate", LoginHandler)

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

	if cfg.Auth.Enabled {
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

		var filteredItems []items.Item

		for _, item := range itemList {
			// If allowed_roles is not set or the role check passes, include the item
			if len(item.AllowedRoles) == 0 || auth.HasRequiredRoles(userRoles, item.AllowedRoles) {
				filteredItems = append(filteredItems, item)
			}
		}

		itemList = filteredItems
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
	purgeErr := items.PurgeItems()
	if purgeErr != nil {
		return
	}

	dbErr := items.StoreItems(intralab.Items)
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
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

func LogoutHandler(w http.ResponseWriter, r *http.Request) {
	session, err := store.Get(r, "session")
	if err != nil {
		return
	}

	session.Options.MaxAge = -1
	err = session.Save(r, w)
	if err != nil {
		return
	}

	url := auth.LogoutURL(cfg.Auth.AuthURL)

	http.Redirect(w, r, url, http.StatusFound)
	return
}

func generateRandomSecret() (string, error) {
	bytes := make([]byte, 32)
	_, err := rand.Read(bytes)
	if err != nil {
		return "", err
	}
	return hex.EncodeToString(bytes), nil
}
