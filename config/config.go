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
