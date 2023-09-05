package config

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
