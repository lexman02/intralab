package types

import (
	"intralab/pkg/config"
	"intralab/pkg/items"
)

type Intralab struct {
	config.Config `json:"config"`
	Items         []items.Item `json:"items"`
}
