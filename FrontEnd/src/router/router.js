import { sendRequest } from '../utils/request'
import { createRouter, createWebHistory } from 'vue-router'

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            path: '/',
            component: () => import("../views/Members/Index.vue"),
        },
        {
            path: '/members',
            component: () => import("../views/Members/Index.vue"),
        },
        {
            path: '/members/create',
            component: () => import("../views/Members/Create.vue"),
        },
        {
            path: '/members/:id/edit',
            component: () => import("../views/Members/Edit.vue"),
        },
        {
            path: '/receipts',
            component: () => import("../views/Receipts/Index.vue"),
        },
        {
            path: '/materials',
            component: () => import("../views/Materials/Index.vue"),
        },
        {
            path: '/sales-order',
            component: () => import("../views/SalesOrder/Index.vue"),
        },
    ],
})

router.beforeEach((to, from) => {
    const token = localStorage.getItem('token')
    if (!token) {
        if (!from.path !== '/') return "/"
    }

    sendRequest('GET', `${import.meta.env.VITE_APP_BACKEND_HOST}/api/auth/verify`)
        .then(res => {
            if (!res.status) {
                localStorage.removeItem('token')
                window.location.href = "/"
            }
        })
        .catch(err => {
            console.log(err)
        })
})

export default router