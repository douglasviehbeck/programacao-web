import VueRouter from 'vue-router';

Vue.use(VueRouter);

const routes = [
    {
        path: '/login',
        name: 'login',
        component: Vue.component('login'),
    },
    {
        path: '',
        component: Vue.component('default-layout'),
        children: [
            {
                name: 'projetos.listar',
                path: '/projetos/listar',
                component: Vue.component('listagem-projeto'),
                meta: { menu: 'projetos.listar' },
            },
            {
                name: 'projetos.criar',
                path: '/projetos/criar',
                component: Vue.component('projeto'),
            },
        ],
    },
    {
        path: '',
        component: Vue.component('projeto-layout'),
        children: [
            {
                name: 'projetos.editar',
                path: '/projetos/:id/editar',
                component: Vue.component('projeto'),
                meta: { menu: 'projetos.editar' },
            },
            {
                name: 'projetos.tarefas',
                path: '/projetos/:id/tarefas',
                component: Vue.component('projeto'),
                meta: { menu: 'projetos.tarefas' },
            },
        ],
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

router.beforeEach((to, from, next) => {
    if (to.name === 'login' && localStorage.getItem('authToken')) {
        return next('/');
    }

    return next();
});

if (localStorage.getItem('authToken')) {
    axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('authToken');
}

axios.interceptors.response.use(response => response, (error) => {
    if (error.request.status === 401) {
        localStorage.removeItem('authToken');
        sessionStorage.setItem('intended', router.currentRoute.fullPath);
        router.push('/login');
    }

    return error;
});

export default router;