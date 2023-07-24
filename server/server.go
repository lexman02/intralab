package server

import (
	"encoding/json"
	"github.com/go-chi/chi"
	"github.com/go-chi/chi/middleware"
	"github.com/go-chi/cors"
	"intralab/pkg/config"
	"log"
	"net/http"

	"intralab/pkg/items"
)

func StartServer() {
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
	r.Get("/api/config", GetConfigHandler)

	log.Println("Server started on :3000")
	err := http.ListenAndServe(":3000", r)
	if err != nil {
		return
	}
}

func GetItemsHandler(w http.ResponseWriter, r *http.Request) {
	itemList := items.GetItems()

	w.Header().Set("Content-Type", "application/json")
	err := json.NewEncoder(w).Encode(itemList)
	if err != nil {
		http.Error(w, "Failed to encode items", http.StatusInternalServerError)
		return
	}
}

func GetConfigHandler(w http.ResponseWriter, r *http.Request) {
	configList := config.GetConfig()

	w.Header().Set("Content-Type", "application/json")
	err := json.NewEncoder(w).Encode(configList)
	if err != nil {
		http.Error(w, "Failed to encode config", http.StatusInternalServerError)
		return
	}
}
