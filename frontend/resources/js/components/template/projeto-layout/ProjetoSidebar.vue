<template>
	<aside class="sidebar">
		<scrollbar>
			<div class="user">
				<div class="user__info" v-if="$global.state.projeto">
					<div>
						<div class="user__name" style="font-size: 15px;"><b>{{ $global.state.projeto.nome }}</b></div>
					</div>
				</div>
			</div>

			<ul class="navigation">
				<menu-item route="projetos.tarefas">
					<i class="zwicon-task"></i> Tarefas
				</menu-item>
				<menu-item route="projetos.editar">
					<i class="zwicon-cog"></i> Configurações do Projeto
				</menu-item>
			</ul>
		</scrollbar>
	</aside>
</template>

<script>
    export default {
        name: 'ProjetoSidebar',
		mounted: function () {
			this.carregarProjeto();
		},
		methods: {
			carregarProjeto: function () {
                axios.get('/projetos/' + this.$route.params.projeto).then((res) => {
                    if (res.response && res.response.status === 404) {
                        this.$flash('error', 'Este projeto não existe');
                        this.$router.push('/projetos/listar');
                    } else {
						Vue.set(this.$global.state, 'projeto', res.data.projeto);
					}
                });
			},
        },
    }
</script>

<style scoped>

</style>