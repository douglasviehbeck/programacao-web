import VueRouter from 'vue-router';
import ListagemProjetos from './components/ListagemProjetos';
import CriarProjetos from './components/CriarProjetos';

Vue.use(VueRouter);

const routes = [
    {
        path: '/listar/projetos',
        component: ListagemProjetos,
    },
    {
        path: '/criar/projetos',
        component: CriarProjetos,
    },
];

const router = new VueRouter({
    mode: 'history',
    routes: routes,
});

export default router;