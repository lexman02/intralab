package server

import (
	"fmt"
	"github.com/google/uuid"
	"intralab/pkg/auth"
	"net/http"
	"time"
)

func AuthMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		switch authType {
		case "oidc":
			handleOIDCAuthentication(w, r)
		case "basic":
			handleBasicAuthentication(w, r)
		}

		next.ServeHTTP(w, r)
	})
}

func handleOIDCAuthentication(w http.ResponseWriter, r *http.Request) {
	// Get the session
	session, err := store.Get(r, "session")
	if err != nil {
		fmt.Println(w, "Session error", http.StatusInternalServerError)
		return
	}

	// Check if the session contains authentication data
	if authenticated, ok := session.Values["authenticated"].(bool); ok && authenticated {
		return
	}

	// User is not authenticated, initiate authentication flow
	// Generate a random state and set the state as a cookie
	_, err = r.Cookie("p_state")
	if err != nil {
		state := uuid.New().String()
		http.SetCookie(w, &http.Cookie{
			Name:     "p_state",
			Value:    state,
			Expires:  time.Now().Add(1 * time.Minute),
			HttpOnly: true,
		})

		// Save the current URL in the session
		session.Values["redirect_url"] = r.URL.String()
		err = session.Save(r, w)
		if err != nil {
			fmt.Println(w, "Session error", http.StatusInternalServerError)
			return
		}

		// Include the state in the authorization request
		authURL := auth.GetAuthURL(state)
		http.Redirect(w, r, authURL, http.StatusFound)
		return
	}
}

func handleBasicAuthentication(w http.ResponseWriter, r *http.Request) {
	// Get the session
	session, err := store.Get(r, "session")
	if err != nil {
		fmt.Println(w, "Session error", http.StatusInternalServerError)
		return
	}

	// Check if the session contains authentication data
	authenticated, ok := session.Values["authenticated"].(bool)
	if !ok || !authenticated {
		// Set authenticated to false if it doesn't exist or is false
		session.Options.HttpOnly = true
		session.Values["authenticated"] = false
		err = session.Save(r, w)
		if err != nil {
			fmt.Println(w, "Session error", http.StatusInternalServerError)
			return
		}
	}

	authRoutes := map[string]bool{
		"/auth/logout": true,
	}

	if _, ok := authRoutes[r.URL.Path]; ok && !authenticated {
		http.Redirect(w, r, "/auth/login", http.StatusFound)
		return
	}
}
