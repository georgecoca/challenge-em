// src/router/index.js
import { createRouter, createWebHistory } from 'vue-router'
import GuestLayout from '../layouts/GuestLayout.vue'
import Login from '../views/auth/Login.vue'
import Register from '../views/auth/Register.vue'
import { useAuthStore } from '@/store/auth'
import { useRouteHelper } from '@/composables/useRouteHelper'

import teacherRoutes from './teacherRoutes'
import studentRoutes from './studentRoutes'

const routes = [
    // Public routes for unauthenticated users
    {
        path: '/',
        component: GuestLayout,
        children: [
            { path: 'login', name: 'Login', component: Login },
            { path: 'register', name: 'Register', component: Register },
            {
                path: '/:pathMatch(.*)*',
                name: 'NotFound',
                meta: {
                    title: 'Page not found',
                },
                component: () => import('../views/errors/404.vue')
            }
        ],
    },
    // Authenticated routes
    {
        path: '/',
        component: () => import('../layouts/AuthLayout.vue'),
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/teacher',
                meta: { requiresTeacher: true },
                children: teacherRoutes
            },
            {
                path: '/student',
                meta: { requiresStudent: true },
                children: studentRoutes
            },
            {
                path: 'logout',
                name: 'Logout',
                beforeEnter: async (to, from, next) => {
                    const authStore = useAuthStore()
                    await authStore.logout()
                    next({ name: 'Login' });
                }
            },
            {
                path: '/:pathMatch(.*)*',
                name: 'NotFound',
                meta: {
                    title: 'Page not found',
                },
                component: () => import('../views/errors/404.vue')
            }
        ]
    },
]

const router = createRouter({
    history: createWebHistory(),
    routes
})

// Global navigation guard
router.beforeEach(async (to, from, next) => {
    const authStore = useAuthStore()
    const { toRoute } = useRouteHelper()

    // If the user lands on the root path, redirect based on authentication status
    if (to.path === '/') {
        return next(authStore.isAuthenticated ? toRoute('Dashboard') : { name: 'Login' })
    }

    // Wait for the store to initialize if necessary
    if (!authStore.initialized) {
        await authStore.fetchUser()
    }

    // Redirect authenticated users away from guest routes
    if (['Root', 'Login', 'Register'].includes(to.name) && authStore.isAuthenticated) {
        return next(toRoute('Dashboard'))
    }

    // Ensure authenticated routes are accessed only when authenticated
    if (to.meta.requiresAuth && !authStore.isAuthenticated) {
        return next({ name: 'Login' })
    }

    // Check if any matched route requires teacher access
    if (to.matched.some(record => record.meta.requiresTeacher) && authStore.user.role !== 'teacher') {
        return next({ name: 'StudentDashboard' })
    }

    // Check if any matched route requires student access
    if (to.matched.some(record => record.meta.requiresStudent) && authStore.user.role !== 'student') {
        return next({ name: 'TeacherDashboard' })
    }

    next()
})

export default router
