package auth

import (
	"context"
	"errors"
	"fmt"
	"github.com/coreos/go-oidc/v3/oidc"
	"github.com/golang-jwt/jwt/v5"
	"golang.org/x/crypto/bcrypt"
	"golang.org/x/oauth2"
	"intralab/config"
	"net/http"
	"strings"
)

var (
	oidcProvider *oidc.Provider
	oauth2Config oauth2.Config
)

type UserClaims struct {
	Name     string   `json:"name"`
	Email    string   `json:"email"`
	Username string   `json:"username"`
	Roles    []string `json:"roles"`
}

func InitAuth(cfg *config.Config) {
	authType, err := FindAuthType(cfg.Auth)
	if err != nil {
		panic(err)
	}

	if authType == "oidc" {
		provider, err := oidc.NewProvider(context.Background(), cfg.Auth.OIDC.AuthURL)
		if err != nil {
			panic(err)
		}

		oidcProvider = provider

		oauth2Config = oauth2.Config{
			ClientID:     cfg.Auth.OIDC.ClientID,
			ClientSecret: cfg.Auth.OIDC.ClientSecret,
			Endpoint:     provider.Endpoint(),
			RedirectURL:  cfg.Auth.OIDC.RedirectURL,
			Scopes:       []string{oidc.ScopeOpenID, "profile", "email", "offline_access"},
		}
	}

	if authType == "basic" {
		// Check if the password is already hashed (e.g., bcrypt)
		if !strings.HasPrefix(cfg.Auth.BasicAuth.Password, "$2a$") {
			// The password is not hashed, so hash it securely using bcrypt
			hashedPassword, err := bcrypt.GenerateFromPassword([]byte(cfg.Auth.BasicAuth.Password), bcrypt.DefaultCost)
			if err != nil {
				panic(err)
			}
			// Store the hashed password in your configuration
			cfg.SetConfigValue("auth.basic_auth.password", string(hashedPassword))
		}
	}
}

func VerifyOIDCToken(r *http.Request) (*oidc.IDToken, *oauth2.Token, error) {
	ctx := r.Context()
	oidcVerifier := oidcProvider.Verifier(&oidc.Config{
		ClientID: oauth2Config.ClientID,
	})

	// Extract the OAuth2 token from the request
	code := r.URL.Query().Get("code")
	if code == "" {
		return nil, nil, errors.New("authorization code not found")
	}

	// Extract the OAuth2 token from the request
	token, err := oauth2Config.Exchange(ctx, r.URL.Query().Get("code"))
	if err != nil {
		return nil, nil, fmt.Errorf("failed to exchange token: %v", err)
	}

	rawIDToken, ok := token.Extra("id_token").(string)
	if !ok {
		return nil, nil, errors.New("id_token is not in the token response")
	}

	// Verify the ID Token
	idToken, err := oidcVerifier.Verify(ctx, rawIDToken)
	if err != nil {
		return nil, nil, fmt.Errorf("failed to verify ID token: %v", err)
	}

	return idToken, token, nil
}

func CheckStateAndExpireCookie(w http.ResponseWriter, r *http.Request) error {
	state, err := r.Cookie("p_state")
	if err != nil {
		return errors.New("state cookie not set")
	}

	if r.URL.Query().Get("state") != state.Value {
		return errors.New("invalid state")
	}

	expireCookie("p_state", w)
	return nil
}

func GetUserClaimsFromAccessToken(token *oauth2.Token) (*UserClaims, error) {
	accessToken := token.AccessToken
	claims := jwt.MapClaims{}

	// Parse the access token
	_, _, err := jwt.NewParser().ParseUnverified(accessToken, &claims)
	if err != nil {
		return nil, fmt.Errorf("failed to parse access token: %v", err)
	}

	userClaims := &UserClaims{}

	// Extract name
	if name, ok := claims["name"].(string); ok {
		userClaims.Name = name
	}

	// Extract email
	if email, ok := claims["email"].(string); ok {
		userClaims.Email = email
	}

	// Extract preferred_username
	if username, ok := claims["preferred_username"].(string); ok {
		userClaims.Username = username
	}

	// Extract roles from realm_access
	if realmAccess, ok := claims["realm_access"].(map[string]interface{}); ok {
		if roles, ok := realmAccess["roles"].([]interface{}); ok {
			for _, role := range roles {
				if roleStr, ok := role.(string); ok {
					userClaims.Roles = append(userClaims.Roles, roleStr)
				}
			}
		}
	}

	// Roles claim may be a string or an array, so we need to handle both cases
	//var roles []string
	//switch rolesClaim := rolesClaim.(type) {
	//case string:
	//	roles = append(roles, rolesClaim)
	//case []interface{}:
	//	for _, role := range rolesClaim {
	//		if roleStr, ok := role.(string); ok {
	//			roles = append(roles, roleStr)
	//		}
	//	}
	//default:
	//	return nil, errors.New("unexpected type for roles claim")
	//}

	return userClaims, nil
}

func HasRequiredRoles(roles []string, allowedRoles []string) bool {
	for _, role := range roles {
		for _, allowedRole := range allowedRoles {
			if role == allowedRole {
				return true
			}
		}
	}
	return false
}

func GetAuthURL(state string) string {
	return oauth2Config.AuthCodeURL(state)
}

func LogoutURL(url string) string {
	return url + "/protocol/openid-connect/logout"
}

func ValidateBasicAuthCredentials(cfgUsername, cfgPassword, username, password string) bool {
	return cfgUsername == username && bcrypt.CompareHashAndPassword([]byte(cfgPassword), []byte(password)) == nil
}

func FindAuthType(cfg config.AuthConfig) (string, error) {
	if cfg.OIDC.AuthURL != "" && cfg.OIDC.ClientID != "" && cfg.OIDC.ClientSecret != "" {
		return "oidc", nil
	}

	if cfg.BasicAuth.Username != "" && cfg.BasicAuth.Password != "" {
		return "basic", nil
	}

	return "", errors.New("invalid auth configuration")
}

func expireCookie(name string, w http.ResponseWriter) {
	cookie := &http.Cookie{
		Name:     "p_state",
		Value:    "",
		MaxAge:   -1,
		HttpOnly: true,
	}

	http.SetCookie(w, cookie)
}
