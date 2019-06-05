<template>
	<div class="card">
		<div class="card-body">
			<h2 v-if="$route.params.id">Editar Projeto</h2>
			<h2 v-else>Criar Projeto</h2>

			<div>
				<ajax-form v-if="ready" action="/projetos/salvar" method="POST" @beforeSubmit="beforeSubmit" @success="onSuccess">
					<div class="row">
						<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }">
							<label>Nome</label>
							<input v-model="nome" name="nome" type="text" :class="{'form-control': true, 'is-invalid': error}">
							<div class="invalid-tooltip">{{ error }}</div>
						</validation>

						<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }">
							<label>Descrição</label>
							<v-textarea v-model="descricao" name="descricao"></v-textarea>
<!--							<textarea v-model="descricao" name="descricao" :class="{'form-control': true, 'is-invalid': error}"></textarea>-->
							<div class="invalid-tooltip">{{ error }}</div>
						</validation>

						<div class="form-group col col-12">
							<label :class="usuarios.length ? 'active' : ''">Usuários</label>
							<base-select-search v-model="usuarios" :options="usuariosPossiveis" valueVar="id" textVar="nome" multiple></base-select-search>
						</div>
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
</template>

<script>
    export default {
        name: 'Projeto',
		data: function () {
			return {
				ready: false,
                nome: '',
				descricao: '',
				usuarios: [],
                usuariosPossiveis: [],
                erros: {},
			};
        },
		mounted: function () {
            this.carregarDados();
        },
		methods: {
            carregarDados: function () {
                this.ready = false;

                var route = '/projetos/dados';

                if (this.$route.params.id) {
                    route += '/' + this.$route.params.id;
				}

				axios.get(route).then((res) => {
				    this.usuariosPossiveis = res.data.usuarios;

				    if (res.data.projeto) {
                        this.nome = res.data.projeto.nome;
                        this.descricao = res.data.projeto.descricao;
                        this.usuarios = res.data.projeto.usuarios || [];
                    }

				    this.ready = true;
				}).catch((error) => {
				    if (error.response.status === 404) {
                        this.$flash('error', 'Este registro não existe');
						this.$router.push('/projetos/listar');
					}
				});
            },
            beforeSubmit: function (params) {
                params['projeto'] = this.$route.params.id;
            },
			onSuccess: function () {
                this.$flash('success', 'Registro inserido com sucesso');
                this.$router.push('/projetos/listar');
            },
			deletar: function () {
                axios.post('/projetos/deletar/' + this.$route.params.id).then((res) => {
					this.$router.push('/projetos/listar');
                }).catch((error) => {
                    if (error.response.status === 404) {
                        this.$flash('error', 'Este registro não existe');
                        this.$router.push('/projetos/listar');
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