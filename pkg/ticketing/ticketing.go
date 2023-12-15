package ticketing

import (
	"bytes"
	"encoding/json"
	"errors"
	"intralab/config"
	"net/http"
)

type Ticket struct {
	Name    string `json:"name"`
	Email   string `json:"email"`
	Subject string `json:"subject"`
	Message string `json:"message"`
}

func OSTicket(cfg config.TicketingConfig, ticket Ticket) error {
	url := cfg.OSTicket.BaseURL + "/api/tickets.json"
	apiKey := cfg.OSTicket.APIKey

	headers := http.Header{}
	headers.Set("X-API-Key", apiKey)

	data := map[string]string{
		"alert":   "true",
		"source":  "API",
		"name":    ticket.Name,
		"email":   ticket.Email,
		"subject": ticket.Subject,
		"message": ticket.Message,
	}

	response, err := postRequest(url, data, headers)
	if err != nil {
		return err
	}
	defer response.Body.Close()

	if response.StatusCode != 201 {
		var results map[string]interface{}
		err := json.NewDecoder(response.Body).Decode(&results)
		if err != nil {
			return err
		}

		return errors.New(results["error"].(string))
	}
	return nil
}

func postRequest(url string, data map[string]string, headers http.Header) (*http.Response, error) {
	jsonData, err := json.Marshal(data)
	if err != nil {
		return nil, err
	}

	request, err := http.NewRequest("POST", url, bytes.NewBuffer(jsonData))
	if err != nil {
		return nil, err
	}

	request.Header = headers

	client := &http.Client{}
	response, err := client.Do(request)
	if err != nil {
		return nil, err
	}

	return response, nil
}
