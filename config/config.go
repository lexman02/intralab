package config

import (
	"github.com/spf13/viper"
)

type Config struct {
	App       AppConfig       `mapstructure:"app"`
	Auth      AuthConfig      `mapstructure:"auth"`
	LDAPSync  LDAPSyncConfig  `mapstructure:"ldap_sync"`
	Ticketing TicketingConfig `mapstructure:"ticketing"`
}

func LoadConfig(configFile string) (*Config, error) {
	v := viper.New()
	v.SetConfigFile(configFile)
	v.SetConfigType("json")
	v.AddConfigPath("./data")
	v.AddConfigPath(".")

	v.SetDefault("app.name", "Intralab")
	v.SetDefault("app.env", "production")
	v.SetDefault("app.url", "http://0.0.0.0")
	v.SetDefault("app.port", 3000)
	v.SetDefault("app.debug", false)
	v.SetDefault("auth.basic_auth.username", "admin")

	err := v.ReadInConfig()
	if err != nil {
		if _, ok := err.(viper.ConfigFileNotFoundError); ok {
			err = v.SafeWriteConfigAs(configFile)
			if err != nil {
				return nil, err
			}
		} else {
			return nil, err
		}
	}

	var config Config
	err = v.Unmarshal(&config)
	if err != nil {
		return nil, err
	}

	return &config, nil
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

func (*Config) SetConfigValue(key string, value interface{}) {
	viper.Set(key, value)
	err := viper.WriteConfig()
	if err != nil {
		return
	}
}

func setEnvBindings(envMappings map[string]string) {
	for configKey, envVarName := range envMappings {
		err := viper.BindEnv(configKey, envVarName)
		if err != nil {
			return
		}
	}
}
