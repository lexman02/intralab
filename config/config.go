package config

import (
	"github.com/spf13/viper"
)

type AppConfig struct {
	Name  string `mapstructure:"name"`
	Env   string `mapstructure:"env"`
	Key   string `mapstructure:"key"`
	URL   string `mapstructure:"url"`
	Port  int    `mapstructure:"port"`
	Debug bool   `mapstructure:"debug"`
}

type OIDCConfig struct {
	AuthURL      string   `mapstructure:"auth_url"`
	ClientID     string   `mapstructure:"client_id"`
	ClientSecret string   `mapstructure:"client_secret"`
	RedirectURL  string   `mapstructure:"redirect_url"`
	Scopes       []string `mapstructure:"scopes"`
}

type BasicAuthConfig struct {
	Username string `mapstructure:"username"`
	Password string `mapstructure:"password"`
}

type AuthConfig struct {
	BasicAuth BasicAuthConfig `mapstructure:"basic_auth"`
	OIDC      OIDCConfig      `mapstructure:"oidc"`
	AdminRole string          `mapstructure:"admin_role"`
}

type LDAPConfig struct {
	Host     string `mapstructure:"host"`
	BindDN   string `mapstructure:"bind_dn"`
	Password string `mapstructure:"password"`
	Port     int    `mapstructure:"port"`
	BaseDN   string `mapstructure:"base_dn"`
	Timeout  int    `mapstructure:"timeout"`
	SSL      bool   `mapstructure:"ssl"`
	TLS      bool   `mapstructure:"tls"`
}

type LDAPSyncConfig struct {
	LDAP         LDAPConfig `mapstructure:"ldap"`
	Synology     bool       `mapstructure:"synology"`
	SyncType     string     `mapstructure:"sync_type"`
	DefaultGroup string     `mapstructure:"default_group"`
	AdminRole    string     `mapstructure:"admin_role"`
}

type TicketingConfig struct {
	Platform           string `mapstructure:"platform"`
	SubjectPlaceholder string `mapstructure:"subject_placeholder"`
	OSTicket           struct {
		BaseURL string `mapstructure:"base_url"`
		APIKey  string `mapstructure:"api_key"`
	} `mapstructure:"osticket"`
}

type Config struct {
	App       AppConfig       `mapstructure:"app"`
	Auth      AuthConfig      `mapstructure:"auth"`
	LDAPSync  LDAPSyncConfig  `mapstructure:"ldap_sync"`
	Ticketing TicketingConfig `mapstructure:"ticketing"`
}

func LoadConfig(configFile string) (*Config, error) {
	var config *Config

	viper.SetConfigFile(configFile)
	viper.SetConfigType("json")

	err := viper.ReadInConfig()
	if err != nil {
		return nil, err
	}

	err = viper.Unmarshal(&config)
	if err != nil {
		return nil, err
	}

	return config, nil
}

func ImportConfig(newConfig Config) {
	viper.Set("app", newConfig.App)
	viper.Set("ldap_sync", newConfig.LDAPSync)
	viper.Set("ticketing", newConfig.Ticketing)
	err := viper.WriteConfig()
	if err != nil {
		return
	}
}

func (*Config) SetConfig(key string, value interface{}) {
	viper.Set(key, value)
	err := viper.WriteConfig()
	if err != nil {
		return
	}
}
