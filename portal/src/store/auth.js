// src/store/user.js
import { defineStore } from 'pinia'
import { useApi } from '@/composables/useApi';
import { logout } from '@/api/user';

export const useAuthStore = defineStore('auth', {
    state: () => ({
        user: null,
        // Track whether we've attempted to fetch the user
        initialized: false
    }),
    actions: {
        async fetchUser() {
            console.log('fetching user')
            try {
                const { get } = useApi();
                // Adjust the endpoint if needed; Laravel Sanctum typically provides /api/user
                const data = await get('/api/user')
                console.log('user is logged', data)
                this.user = data
            } catch (error) {
                console.log('No authenticated user', error)
                this.user = null
            } finally {
                this.initialized = true
            }
        },
        setUser(userData) {
            this.user = userData
            this.initialized = true
        },
        async logout() {
            console.log('logout');
            await logout();
            this.user = null;
        }
    },
    getters: {
        isAuthenticated: (state) => !!state.user
    }
})
