package main

import (
	"github.com/spf13/viper"
	"intralab/config"
	"intralab/db"
	"intralab/pkg/auth"
	"intralab/server"
	"log"
)

func main() {
	err := db.Init("intralab.db")
	if err != nil {
		log.Fatal("Failed to initialize database: ", err)
	}
	defer db.DB.Close() // Close the database when the program exits

	cfg, err := config.LoadConfig("config.json")
	if err != nil {
		log.Fatal("Failed to load config: ", err)
	}
	viper.WatchConfig()

	// Initialize auth
	auth.InitAuth(cfg)

	// Rebuild frontend (if needed?)
	server.StartServer(cfg)
}
