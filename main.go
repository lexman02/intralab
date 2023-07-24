package main

import (
	"encoding/json"
	"intralab/pkg/config"
	"intralab/pkg/items"
	"intralab/server"
	"log"
	"os"
)

type Intralab struct {
	config.Config `json:"config"`
	Items         []items.Item `json:"items"`
}

func main() {
	ParseIntralab()
	// Rebuild frontend (if needed?)
	server.StartServer()
}

func ParseIntralab() {
	var intralab Intralab

	data, err := os.ReadFile("intralab.json")
	if err != nil {
		log.Fatal(err)
	}

	err = json.Unmarshal(data, &intralab)
	if err != nil {
		log.Fatal(err)
	}

	config.SetConfig(intralab.Config)
	items.SetItems(intralab.Items)
}
