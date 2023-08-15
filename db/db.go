package db

import (
	"github.com/boltdb/bolt"
)

// DB instance to hold the BoltDB connection
var DB *bolt.DB

// Init initializes the BoltDB database
func Init(dbPath string) error {
	db, err := bolt.Open(dbPath, 0600, nil)
	if err != nil {
		return err
	}
	DB = db
	return nil
}
