<template>
	<div class="container">
		<div class="card horizontal">
			<div class="card-content">
				<h2>Projetos</h2>

				<div>
					<div v-if="ready">
						<table class="highlight responsive-table">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Criador</th>
								</tr>
							</thead>
							<tbody>
								<tr v-for="projeto in projetos">
									<td @click="$router.push(`/projetos/editar/${projeto.id}`)">{{ projeto.nome }}</td>
									<td @click="$router.push(`/projetos/editar/${projeto.id}`)">{{ projeto.criador }}</td>
								</tr>
							</tbody>
						</table>

						<router-link to="/projetos/criar">
							<a class="white-text waves-effect btn-small blue darken-1" style="margin-top: 20px;">
								<i class="material-icons left">add</i>
								Adicionar
							</a>
						</router-link>
					</div>

					<div class="spinner-wrapper" v-else>
						<div class="preloader-wrapper big active">
							<div class="spinner-layer spinner-blue-only">
								<div class="circle-clipper left">
									<div class="circle"></div>
								</div>
								<div class="gap-patch">
									<div class="circle"></div>
								</div>
								<div class="circle-clipper right">
									<div class="circle"></div>
								</div>
							</div>
						</div>
					</div>
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
	.container {
		margin-top: 50px;
		max-width: 85%;
	}

	.spinner-wrapper {
		min-height: 300px;
		display: flex;
		align-items: center;
		justify-content: center;
	}
</style>