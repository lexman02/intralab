package config

type Config struct {
	Synology     bool   `json:"synology"`
	SyncType     string `json:"sync_type"`
	DefaultGroup string `json:"default_group"`
	AdminRole    string `json:"admin_role"`
}

var config Config

func InitConfig() {
	config = Config{
		Synology:     false,
		SyncType:     "ldap",
		DefaultGroup: "users",
		AdminRole:    "admin",
	}
}

func GetConfig() Config {
	return config
}

func SetConfig(newConfig Config) {
	config = newConfig
}

func ImportConfig(newConfig Config) {
	config.Synology = newConfig.Synology
	config.SyncType = newConfig.SyncType
	config.DefaultGroup = newConfig.DefaultGroup
	config.AdminRole = newConfig.AdminRole
}
