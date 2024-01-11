package main

import (
	"intralab/config"
	"intralab/db"
	"intralab/pkg/auth"
	"intralab/server"
	"log"
)

func main() {
	cfg, err := config.LoadConfig()
	if err != nil {
		log.Fatal("Failed to load config: ", err)
	}

	dbPath := "./data/data.db"
	if cfg.App.Env == "dev" {
		log.Println("Running in development mode")
		dbPath = "data.db"
	}

	// Initialize database
	err = db.Init(dbPath)
	if err != nil {
		log.Fatal("Failed to initialize database: ", err)
	}
	defer db.DB.Close() // Close the database when the program exits

	// Initialize auth
	auth.InitAuth(cfg)

	// Rebuild frontend (if needed?)
	server.StartServer(cfg)
}
