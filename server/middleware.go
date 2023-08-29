package server

import (
	"fmt"
	"github.com/google/uuid"
	"intralab/pkg/auth"
	"net/http"
	"time"
)

func OIDCMiddleware(next http.Handler) http.Handler {
	return http.HandlerFunc(func(w http.ResponseWriter, r *http.Request) {
		if cfg.Auth.Enabled {
			// Get the session
			session, err := store.Get(r, "session")
			if err != nil {
				fmt.Println(w, "Session error", http.StatusInternalServerError)
				return
			}

			// Check if the session contains authentication data
			if authenticated, ok := session.Values["authenticated"].(bool); ok && authenticated {
				next.ServeHTTP(w, r)
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

		next.ServeHTTP(w, r)
	})
}
