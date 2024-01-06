package ui

import (
	"embed"
	"errors"
	"io/fs"
	"net/http"
	"path"
	"strings"
)

//go:embed all:dist/**
var distFS embed.FS

func Handler() http.HandlerFunc {
	uiFs, err := fs.Sub(distFS, "dist")
	if err != nil {
		panic(err)
	}
	return func(w http.ResponseWriter, r *http.Request) {
		f, err := uiFs.Open(strings.TrimPrefix(path.Clean(r.URL.Path), "/"))
		if err == nil {
			defer f.Close()
		}
		if errors.Is(err, fs.ErrNotExist) {
			r.URL.Path = "/"
		}
		http.FileServer(http.FS(uiFs)).ServeHTTP(w, r)
	}
}
