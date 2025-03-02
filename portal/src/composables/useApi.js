// src/api/useApi.js
import axios from 'axios'
import router from '@/router'  // adjust path if needed
import { useAuthStore } from '@/store/auth'

axios.defaults.headers.common['Accept'] = 'application/json';
axios.defaults.withCredentials = true;
axios.defaults.withXSRFToken = true;
axios.defaults.baseURL = import.meta.env.VITE_API_URL;

axios.interceptors.response.use(
    response => response,
    error => {
        const authStore = useAuthStore();

        if(authStore.isAuthenticated) {
            // Check if the response has a status of 401 (unauthenticated)
            if (error.response && error.response.status === 401) {
                authStore.setUser(null);
                router.push({ name: 'Login' });
            }
        }

        return Promise.reject(error);
    }
);

export function useApi() {
    const get = async (endpoint, query) => {
        const response = await axios.get(endpoint, { params: query });
        return response.data;
    }

    const post = async (endpoint, data) => {
        const response = await axios.post(endpoint, data);
        return response.data;
    }

    const put = async (endpoint, data) => {
        const response = await axios.put(endpoint, data);
        return response.data;
    }

    const destroy = async (endpoint) => {
        const response = await axios.delete(endpoint);
        return response.data;
    }

    return { get, post, put, destroy }
}
