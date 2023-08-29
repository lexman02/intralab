package types

import (
	"intralab/config"
	"intralab/pkg/items"
)

type Intralab struct {
	config.Config `json:"config"`
	Items         []items.Item `json:"items"`
}
