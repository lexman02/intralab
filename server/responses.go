package server

import (
	"encoding/json"
	"fmt"
	"log"
	"net/http"
)

const EncodeError = "Failed to encode items"
const DecodeError = "Failed to decode items"
const GeneralError = "Something went wrong try again later"

type Error struct {
	Type  string `json:"type"`
	Error string `json:"error"`
}

func jsonError(w http.ResponseWriter, code int, message Error) {
	jsonResponse(w, code, map[string]Error{"error": message})
	log.Println(message.Error)
	return
}

func jsonResponse(w http.ResponseWriter, code int, payload interface{}) {
	response, _ := json.Marshal(payload)
	fmt.Println(payload)
	w.Header().Set("Content-Type", "application/json")
	w.WriteHeader(code)
	write, err := w.Write(response)
	if err != nil {
		log.Println(write)
	}
	return
}
