import { reactive, ref } from 'vue';
import { useApi } from '@/composables/useApi';

export default function useForm(initialData = {}) {
    // Reactive state for form data and errors
    const data = reactive({ ...initialData });
    const errors = reactive({});
    const processing = ref(false);

    // Import API methods including PUT
    const { get, post, put } = useApi();

    // Helper to reset errors and toggle processing state
    const handleRequest = async (apiCall) => {
        processing.value = true;
        // Clear previous errors
        Object.keys(errors).forEach(key => delete errors[key]);
        try {
            const response = await apiCall();
            return response;
        } catch (error) {
            if (error.response && error.response.status === 422) {
                Object.assign(errors, error.response.data.errors);
            }
            throw error;
        } finally {
            processing.value = false;
        }
    };

    // Create a proxy for the form data to enable reactive access and method calls
    const form = new Proxy({}, {
        get(target, prop) {
            if (prop === 'processing') {
                return processing.value;
            }
            if (prop in data) {
                return data[prop];
            }
            return target[prop];
        },
        set(target, prop, value) {
            if (prop === 'processing') {
                processing.value = value;
                return true;
            }
            if (prop in data) {
                data[prop] = value;
                return true;
            }
            target[prop] = value;
            return true;
        }
    });

    // Expose errors and reset function
    form.errors = errors;
    form.reset = () => {
        Object.keys(initialData).forEach((key) => {
            data[key] = initialData[key];
        });
        Object.keys(errors).forEach(key => delete errors[key]);
    };

    // API call methods
    form.post = async (endpoint) => handleRequest(() => post(endpoint, data));
    form.put = async (endpoint) => handleRequest(() => put(endpoint, data));
    form.get = async (endpoint) => handleRequest(() => get(endpoint));

    return form;
}
