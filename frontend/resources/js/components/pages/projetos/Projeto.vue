<template>
	<section>
		<div>
			<div class="card">
				<div class="card-body">
					<h2 v-if="$route.params.id">Editar Projeto</h2>
					<h2 v-else>Criar Projeto</h2>

					<div>
						<ajax-form action="/projetos/salvar" method="POST" @beforeSubmit="beforeSubmit" @success="onSuccess" @afterSubmit="loading = false">
							<div class="row">
								<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }">
									<label>Nome</label>
									<input v-model="nome" name="nome" type="text" :class="{'form-control': true, 'is-invalid': error}">
									<div class="invalid-tooltip">{{ error }}</div>
								</validation>

								<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }">
									<label>Descrição</label>
									<v-textarea v-model="descricao" :class="{'is-invalid': error}" name="descricao"></v-textarea>
									<div class="invalid-tooltip">{{ error }}</div>
								</validation>
							</div>

							<div>
								<button v-if="$route.params.id" type="button" class="btn btn-danger float-left" @click="deletar">
									Excluir
								</button>

								<button class="btn btn-success float-right ml-3">
									Salvar
								</button>

								<router-link to="/projetos/listar" class="btn btn-theme float-right">
									Cancelar
								</router-link>
							</div>
						</ajax-form>

						<fade-transition>
							<loader v-show="loading"></loader>
						</fade-transition>
					</div>
				</div>
			</div>
		</div>
		<!--<div v-if="this.$route.params.id">-->
			<!--<div class="card">-->
				<!--<div class="card-body">-->
					<!--<h2>Usuários do Projeto</h2>-->
					<!--<table v-if="usuarios" class="table table-dark table-hover mb-5">-->
						<!--<thead class="thead-dark">-->
							<!--<tr>-->
								<!--<th style="width: 50%;">Nome</th>-->
								<!--<th style="width: 50%;">Criador</th>-->
							<!--</tr>-->
						<!--</thead>-->
						<!--<tbody>-->
							<!--<tr v-if="!usuarios.length">-->
								<!--<td colspan="2" class="text-center">-->
									<!--Parece que você não participa de nenhum projeto...-->
								<!--</td>-->
							<!--</tr>-->
							<!--<tr v-for="projeto in projetos.data" @click="$router.push({name: 'projetos.editar', params: {id: projeto.id}})" style="cursor: pointer;">-->
								<!--<td>{{ projeto.nome }}</td>-->
								<!--<td>{{ projeto.criador }}</td>-->
							<!--</tr>-->
						<!--</tbody>-->
					<!--</table>-->
				<!--</div>-->
			<!--</div>-->
		<!--</div>-->
	</section>
</template>

<script>
    export default {
        name: 'Projeto',
		data: function () {
			return {
				loading: false,
                nome: '',
				descricao: '',
				usuarios: [],
                erros: {},
			};
        },
		mounted: function () {
            if (this.$route.params.id) {
                this.carregarDados();
            }
        },
		methods: {
            carregarDados: function () {
				this.loading = true;

				axios.get('/projetos/' + this.$route.params.id).then((res) => {
					if (res.data.projeto) {
						this.nome = res.data.projeto.nome;
						this.descricao = res.data.projeto.descricao;
						this.usuarios = res.data.projeto.usuarios || [];
					}

					this.loading = false;
				}).catch((error) => {
					if (error.response.status === 404) {
						this.$flash('error', 'Este registro não existe');
						this.$router.push('/projetos/listar');
					}
				});
            },
            beforeSubmit: function (params) {
                this.loading = true;

                params['projeto'] = this.$route.params.id;
            },
			onSuccess: function () {
                this.$router.push('/projetos/listar');
            },
			deletar: function () {
                this.$confirm().then((result) => {
                    if (result.value) {
                        this.loading = true;

                        axios.post('/projetos/deletar/' + this.$route.params.id).then((res) => {
                            this.$router.push('/projetos/listar');
                        }).catch(() => {
							this.$router.push('/projetos/listar');
                        });
					}
				});
            }
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

	.row {
		margin-bottom: 0;
	}
</style>