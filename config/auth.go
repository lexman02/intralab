package config

type AuthConfig struct {
	BasicAuth BasicAuthConfig `mapstructure:"basic_auth"`
	OIDC      OIDCConfig      `mapstructure:"oidc"`
	AdminRole string          `mapstructure:"admin_role"`
}

type BasicAuthConfig struct {
	Username string `mapstructure:"username"`
	Password string `mapstructure:"password"`
}

type OIDCConfig struct {
	AuthURL      string   `mapstructure:"auth_url"`
	ClientID     string   `mapstructure:"client_id"`
	ClientSecret string   `mapstructure:"client_secret"`
	RedirectURL  string   `mapstructure:"redirect_url"`
	Scopes       []string `mapstructure:"scopes"`
}

func init() {
	authEnvMappings := map[string]string{
		"auth.basic_auth.username": "AUTH_BASIC_AUTH_USERNAME",
		"auth.basic_auth.password": "AUTH_BASIC_AUTH_PASSWORD",
	}

	setEnvBindings(authEnvMappings)
}
