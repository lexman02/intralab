package db

import (
	"gorm.io/driver/sqlite"
	"gorm.io/gorm"
	"intralab/pkg/items"
	"log"
)

type Database struct {
	db *gorm.DB
}

// Auto-migrate the "Item" model to create the corresponding table

type DB struct {
	conn *gorm.DB
}

func (db *DB) Init() error {
	err := db.conn.AutoMigrate(&items.Item{})
	if err != nil {
		log.Fatal(err)
	}

	return nil
}

func ConnectDatabase() (*DB, error) {
	db, err := gorm.Open(sqlite.Open("items.db"), &gorm.Config{})
	if err != nil {
		return nil, err
	}

	return &DB{conn: db}, nil
}

func (db *DB) Close() error {
	sqlDB, err := db.conn.DB()
	if err != nil {
		return err
	}
	return sqlDB.Close()
}
