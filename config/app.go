package config

type AppConfig struct {
	Name  string `mapstructure:"name"`
	Env   string `mapstructure:"env"`
	Key   string `mapstructure:"key"`
	URL   string `mapstructure:"url"`
	Port  int    `mapstructure:"port"`
	Debug bool   `mapstructure:"debug"`
}

func initAppEnv() {
	appEnvMappings := map[string]string{
		"app.name":  "APP_NAME",
		"app.env":   "APP_ENV",
		"app.key":   "APP_KEY",
		"app.url":   "APP_URL",
		"app.port":  "APP_PORT",
		"app.debug": "APP_DEBUG",
	}
	setEnvBindings(appEnvMappings)
}
