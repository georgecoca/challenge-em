import { computed } from 'vue';
import { useAuthStore } from '@/store/auth';

export function useRouteHelper() {
    const authStore = useAuthStore();

    // Map role to prefix.
    const prefixes = {
        teacher: 'Teacher',
        student: 'Student'
    };

    // Compute the prefix based on the user's role.
    const rolePrefix = computed(() => prefixes[authStore.user?.role] || '');

    /**
     * Generates a route object with a computed name based on the user's role.
     *
     * @param {string} baseName - The base name of the route (e.g. 'Worksheets').
     * @param {object} [params={}] - Route parameters.
     * @returns {object} A route location object usable with Vue Router.
     */
    function toRoute(baseName, params = {}) {
        return { name: `${rolePrefix.value}${baseName}`, params };
    }

    return { toRoute };
}
