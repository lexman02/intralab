package items

import (
	"encoding/json"
	"github.com/boltdb/bolt"
	"intralab/db"
)

type Item struct {
	Name         string  `json:"name"`
	Position     int     `json:"position"`
	Description  *string `json:"description"`
	URL          string  `json:"url"`
	Icon         string  `json:"icon"`
	AllowedRoles string  `json:"allowed_roles"`
}

//var itemList []Item

func GetItems() ([]Item, error) {
	var itemList []Item

	err := db.DB.View(func(tx *bolt.Tx) error {
		bucket := tx.Bucket([]byte("items"))
		if bucket == nil {
			// Handle bucket not found
			return nil
		}

		// Iterate through the bucket and decode items
		return bucket.ForEach(func(k, v []byte) error {
			var item Item
			err := json.Unmarshal(v, &item)
			if err != nil {
				return err
			}
			itemList = append(itemList, item)
			return nil
		})
	})
	if err != nil {
		return nil, err
	}

	return itemList, nil
}

func StoreItems(items []Item) error {
	err := db.DB.Update(func(tx *bolt.Tx) error {
		b, err := tx.CreateBucketIfNotExists([]byte("items"))
		if err != nil {
			return err
		}

		// Store items in the bucket
		for _, item := range items {
			// Encode item to JSON or other format
			itemJSON, err := json.Marshal(item)
			if err != nil {
				return err
			}

			err = b.Put([]byte(item.Name), itemJSON)
			if err != nil {
				return err
			}
		}
		return err
	})
	if err != nil {
		return err
	}

	return nil
}
