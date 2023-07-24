package items

type Item struct {
	ID           int     `json:"id"`
	Name         string  `json:"name"`
	Description  *string `json:"description"`
	URL          string  `json:"url"`
	Icon         string  `json:"icon"`
	AllowedRoles string  `json:"allowed_roles"`
}

var itemList []Item

func GetItems() []Item {
	return itemList
}

func SetItems(items []Item) {
	itemList = items
}
