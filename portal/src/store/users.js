// src/users.js
import { createResourceStore } from '@/store/createResourceStore';
export const useStudentsStore = createResourceStore('users', {
    endpoint: '/api/students'
});