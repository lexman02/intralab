package config

type TicketingConfig struct {
	Platform           string   `mapstructure:"platform" json:"platform"`
	SubjectPlaceholder string   `mapstructure:"subject_placeholder" json:"subject_placeholder"`
	OSTicket           OSTicket `mapstructure:"osticket" json:"osticket"`
}

type OSTicket struct {
	BaseURL string `mapstructure:"base_url" json:"base_url"`
	APIKey  string `mapstructure:"api_key" json:"api_key"`
}
