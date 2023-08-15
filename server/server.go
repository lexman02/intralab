package server

import (
	"encoding/json"
	"github.com/go-chi/chi"
	"github.com/go-chi/chi/middleware"
	"github.com/go-chi/cors"
	"intralab/types"
	"log"
	"net/http"
	"time"

	"intralab/pkg/config"
	"intralab/pkg/items"
)

var cfg *config.Config

func StartServer(config *config.Config) {
	cfg = config

	r := chi.NewRouter()

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

	// Register routes
	//r.Get("/", frontend.HomeHandler)
	r.Get("/api/items", GetItemsHandler)
	r.Get("/api/config", ExportConfigHandler)
	r.Post("/api/config", ImportConfigHandler)

	log.Println("Server started on :3000")
	err := http.ListenAndServe(":3000", r)
	if err != nil {
		return
	}
}

func GetItemsHandler(w http.ResponseWriter, r *http.Request) {
	itemList, dbErr := items.GetItems()
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
	}

	w.Header().Set("Content-Type", "application/json")
	err := json.NewEncoder(w).Encode(itemList)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{EncodeError, err.Error()})
	}
}

func ExportConfigHandler(w http.ResponseWriter, r *http.Request) {
	getItems, dbErr := items.GetItems()
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
	}

	data, err := json.Marshal(types.Intralab{
		Config: *cfg,
		Items:  getItems,
	})
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{EncodeError, err.Error()})
	}

	w.Header().Set("Content-Type", "application/json")
	filename := "intralab_config_" + time.Now().Format("2006-01-02") + ".json"
	w.Header().Set("Content-Disposition", "attachment; filename="+filename)

	_, err = w.Write(data)
	if err != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, err.Error()})
	}
	log.Println("Config exported")
}

func ImportConfigHandler(w http.ResponseWriter, r *http.Request) {
	var intralab types.Intralab

	err := json.NewDecoder(r.Body).Decode(&intralab)
	if err != nil {
		jsonError(w, http.StatusUnprocessableEntity, Error{DecodeError, err.Error()})
	}

	config.ImportConfig(intralab.Config)

	dbErr := items.StoreItems(intralab.Items)
	if dbErr != nil {
		jsonError(w, http.StatusInternalServerError, Error{GeneralError, dbErr.Error()})
	}

	log.Println("New config imported")
	jsonResponse(w, http.StatusOK, map[string]string{"success": "Import successful"})
}
