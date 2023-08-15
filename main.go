package main

import (
	"fmt"
	"github.com/spf13/viper"
	"intralab/db"
	"intralab/pkg/config"
	"intralab/server"
	"log"
)

func main() {
	dbErr := db.Init("intralab.db")
	if dbErr != nil {
		log.Fatal("Failed to initialize database: ", dbErr)
	}
	defer db.DB.Close() // Close the database when the program exits

	cfg, cfgErr := config.LoadConfig("config.json")
	if cfgErr != nil {
		log.Fatal("Failed to load config: ", cfgErr)
	}
	viper.WatchConfig()

	fmt.Println(cfg)

	// Rebuild frontend (if needed?)
	server.StartServer(cfg)
}

//func ParseIntralab() {
//	var intralab Intralab
//
//	data, err := os.ReadFile("intralab.json")
//	if err != nil {
//		log.Fatal(err)
//	}
//
//	err = json.Unmarshal(data, &intralab)
//	if err != nil {
//		log.Fatal(err)
//	}
//
//	config.SetConfig(intralab.Config)
//	items.SetItems(intralab.Items)
//}
