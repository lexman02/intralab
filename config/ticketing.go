package config

type TicketingConfig struct {
	Platform           string `mapstructure:"platform"`
	SubjectPlaceholder string `mapstructure:"subject_placeholder"`
	OSTicket           struct {
		BaseURL string `mapstructure:"base_url"`
		APIKey  string `mapstructure:"api_key"`
	} `mapstructure:"osticket"`
}
