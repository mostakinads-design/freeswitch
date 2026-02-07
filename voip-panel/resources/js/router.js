import { createRouter, createWebHistory } from 'vue-router';

const routes = [
  {
    path: '/',
    redirect: '/dashboard',
  },
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: () => import('./pages/Dashboard.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/extensions',
    name: 'Extensions',
    component: () => import('./pages/Extensions.vue'),
    meta: { requiresAuth: true, role: 'admin' },
  },
  {
    path: '/dids',
    name: 'DIDs',
    component: () => import('./pages/DIDs.vue'),
    meta: { requiresAuth: true, role: 'admin' },
  },
  {
    path: '/ivr',
    name: 'IVR',
    component: () => import('./pages/IVRBuilder.vue'),
    meta: { requiresAuth: true, role: 'admin' },
  },
  {
    path: '/queues',
    name: 'Queues',
    component: () => import('./pages/Queues.vue'),
    meta: { requiresAuth: true, role: 'admin' },
  },
  {
    path: '/campaigns',
    name: 'Campaigns',
    component: () => import('./pages/Campaigns.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/cdr',
    name: 'CDR',
    component: () => import('./pages/CDR.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/agent',
    name: 'AgentDashboard',
    component: () => import('./pages/AgentDashboard.vue'),
    meta: { requiresAuth: true, role: 'agent' },
  },
  {
    path: '/conferences',
    name: 'Conferences',
    component: () => import('./pages/Conferences.vue'),
    meta: { requiresAuth: true },
  },
  {
    path: '/login',
    name: 'Login',
    component: () => import('./pages/Login.vue'),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
});

router.beforeEach((to, from, next) => {
  const isAuthenticated = localStorage.getItem('token');
  
  if (to.meta.requiresAuth && !isAuthenticated) {
    next('/login');
  } else {
    next();
  }
});

export default router;
