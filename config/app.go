package config

import "github.com/spf13/viper"

type AppConfig struct {
	Name  string `mapstructure:"name"`
	Env   string `mapstructure:"env"`
	Key   string `mapstructure:"key"`
	URL   string `mapstructure:"url"`
	Port  int    `mapstructure:"port"`
	Debug bool   `mapstructure:"debug"`
}

func init() {
	appEnvMappings := map[string]string{
		"app.name":  "APP_NAME",
		"app.env":   "APP_ENV",
		"app.key":   "APP_KEY",
		"app.url":   "APP_URL",
		"app.port":  "APP_PORT",
		"app.debug": "APP_DEBUG",
	}
	setEnvBindings(appEnvMappings)

	viper.SetDefault("app.name", "Intralab")
	viper.SetDefault("app.env", "production")
	viper.SetDefault("app.url", "http://0.0.0.0")
	viper.SetDefault("app.port", 3000)
	viper.SetDefault("app.debug", false)
}
