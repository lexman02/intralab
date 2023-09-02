import {get, writable} from "svelte/store";

interface User {
    name: string;
    email: string;
    username: string;
    roles: string[];
}

interface AuthState {
    auth_type: string;
    authenticated: boolean;
    session_expiry: number;
    admin_role?: string;
    user?: User;
}

export const authState = writable<AuthState | null>(null);

const fetchAuthStateData = async () => {
    try {
        const res = await fetch('/auth/info');
        const data = await res.json();
        authState.set(data);
    } catch (err) {
        console.error('Failed to fetch user data:', err);
    }
};

if (get(authState) === null) {
    fetchAuthStateData().catch((error) => {
        console.error('Error fetching user data:', error);
    });
}