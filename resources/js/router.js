import VueRouter from 'vue-router';
import ListagemProjeto from './components/ListagemProjeto';
import Projeto from './components/Projeto';

Vue.use(VueRouter);

const routes = [
    {
        path: '/projetos/listar',
        component: ListagemProjeto,
    },
    {
        path: '/projetos/criar',
        component: Projeto,
    },
    {
        path: '/projetos/editar/:id',
        component: Projeto,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

export default router;