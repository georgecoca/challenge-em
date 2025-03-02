import { defineStore } from 'pinia'
import { useApi } from '@/composables/useApi'

export function createResourceStore(resourceName, options = {}) {
    // options can include names for singular items if they differ from the plural resourceName
    const singular = options.singular || resourceName.slice(0, -1); // simplistic singular form

    const apiEndpoint = options.endpoint || `/api/${resourceName}`;

    return defineStore(resourceName, {
        state: () => ({
            items: null,    // expected structure: { data: [...], links: {...}, meta: {...} }
            item: null,     // state for a single resource item
            loading: false,
            error: null,
        }),

        getters: {
            isEmpty: (state) => {
                if (!state.items && state.loading) {
                    return false;
                }
                return !state.items || !state.items.data || state.items.data.length === 0;
            },
            hasMore: (state) => {
                if (state.items && state.items.meta) {
                    return state.items.meta.current_page < state.items.meta.last_page;
                }
                return false;
            },
            currentPage: (state) => {
                return state.items && state.items.meta ? state.items.meta.current_page : null;
            },
        },

        actions: {
            resetState() {
                this.$reset();
            },
            async fetchItems(query) {
                this.loading = true;
                this.error = null;
                try {
                    const { get } = useApi();
                    // Dynamically build the endpoint based on resourceName
                    this.items = await get(apiEndpoint, query);
                } catch (err) {
                    this.error = err.message || `Error fetching ${resourceName}`;
                } finally {
                    this.loading = false;
                }
            },
            async loadMore(params) {
                if (!this.items || !this.items.meta) return;
                if (!this.hasMore) return;

                this.loading = true;
                this.error = null;
                try {
                    const nextPage = this.items.meta.current_page + 1;
                    const { get } = useApi();
                    const newData = await get(apiEndpoint, {...params, page: nextPage });
                    this.items = {
                        ...newData,
                        data: [...this.items.data, ...newData.data]
                    };
                } catch (err) {
                    this.error = err.message || `Error loading more ${resourceName}`;
                } finally {
                    this.loading = false;
                }
            },
            async fetchItem(id, params) {
                this.loading = true;
                this.error = null;
                try {
                    const { get } = useApi();
                    const { data } = await get(`${apiEndpoint}/${id}`, params);
                    this.item = data;
                } catch (err) {
                    this.error = err.message || `Error fetching ${singular}`;
                } finally {
                    this.loading = false;
                }
            },
            async deleteItem(id) {
                this.loading = true;
                this.error = null;
                try {
                    const { destroy } = useApi();
                    await destroy(`${apiEndpoint}/${id}`);

                    // Refresh the list after deletion
                    await this.fetchItems();

                    // Clear the current item if it was deleted
                    if (this.item && this.item.id === id) {
                        this.item = null;
                    }
                } catch (err) {
                    this.error = err.message || `Error deleting ${singular}`;
                } finally {
                    this.loading = false;
                }
            },
        },
    });
}
