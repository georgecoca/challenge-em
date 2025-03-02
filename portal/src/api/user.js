// src/api/user.js
import {useApi} from '@/composables/useApi';

const {get, post} = useApi();

// Function to request the Sanctum CSRF cookie
export const getCsrfCookie = async () => {
    await get('/sanctum/csrf-cookie');
}

/**
 * Log in the user using Laravel Sanctum.
 * This function first calls getCsrfCookie (to initialize CSRF protection)
 * then makes a POST request to the /login endpoint with the provided credentials.
 *
 * @param {Object} credentials - The user's login credentials.
 * @returns {Promise<Object>} - The response data from the /login endpoint.
 */
export const login = async (credentials) => {
    await getCsrfCookie();
    return post('/login', credentials);
}

/**
 * Log out the authenticated user.
 * This function makes a POST request to the /logout endpoint.
 *
 * @returns {Promise<Object>} - The response data from the /logout endpoint.
 */
export const logout = async () => {
    return post('/logout');
}
