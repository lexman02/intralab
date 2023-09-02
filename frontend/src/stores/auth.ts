import {get, writable} from "svelte/store";

interface User {
    name: string;
    email: string;
    username: string;
    roles: string[];
}

interface AuthState {
    type: string;
    authenticated: boolean;
    admin_role: string;
    session_expiry: number;
    user: User;
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