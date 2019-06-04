<template>
	<div>
		<header class="content__title">
			<h1>Projetos</h1>

			<div class="actions">
				<router-link to="/projetos/criar" class="btn btn-theme-dark zwicon-plus">
					Adicionar
				</router-link>
			</div>
		</header>
		<div class="card">
			<div class="card-body">
				<div>
					<fade-transition>
						<div v-if="ready">
							<table class="table table-dark table-hover">
								<thead class="thead-dark">
									<tr>
										<th>Nome</th>
										<th>Criador</th>
									</tr>
								</thead>
								<tbody>
									<tr v-if="!projetos.length">
										<td colspan="2" class="text-center">
											Parece que você não participa de nenhum projeto...
										</td>
									</tr>
									<tr v-for="projeto in projetos" @click="$router.push(`/projetos/editar/${projeto.id}`)" style="cursor: pointer;">
										<td>{{ projeto.nome }}</td>
										<td>{{ projeto.criador }}</td>
									</tr>
								</tbody>
							</table>
						</div>

						<loader v-else></loader>
					</fade-transition>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: 'ListagemProjeto',
		data: function () {
			return {
				ready: false,
				projetos: [],
			};
        },
		mounted: function () {
			this.carregarProjetos();
        },
		methods: {
			carregarProjetos: function () {
                this.ready = false;

                axios.get('/projetos').then((projetos) => {
                    this.projetos = projetos.data;

                    this.ready = true;
                });
            },
        }
    }
</script>

<style scoped>
	table {
		margin-bottom: 0;
	}
</style>