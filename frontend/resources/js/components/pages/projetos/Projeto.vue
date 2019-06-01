<template>
	<div class="container">
		<div class="row">
			<div class="card">
				<div class="card-content">
					<h2 v-if="$route.params.id">Editar Projeto</h2>
					<h2 v-else>Criar Projeto</h2>

					<div>
						<ajax-form v-if="ready" action="/projetos/salvar" method="POST" @beforeSubmit="beforeSubmit" @success="onSuccess">
							<div class="row">
								<validation class="input-field col l12" :rules="['required']" v-slot="{ error }">
									<label>Nome</label>
									<input v-model="nome" name="nome" type="text" :class="{ 'invalid': error }">
									<span class="helper-text" style="min-height: 5px;" :data-error="error"></span>
								</validation>
							</div>

							<div class="row">
								<validation class="input-field col l12" :rules="['required']" v-slot="{ error }">
									<label>Descrição</label>
									<textarea v-model="descricao" name="descricao" :class="{'materialize-textarea': true, 'invalid': error}" />
									<span class="helper-text" style="min-height: 10px;" :data-error="error"></span>
								</validation>
							</div>

							<div class="row">
								<div class="input-field col l12">
									<label :class="usuarios.length ? 'active' : ''">Usuários</label>
									<select ref="usuarios" v-model="usuarios" name="usuarios" multiple>
										<template v-if="usuariosPossiveis.length">
											<option v-for="usuario in usuariosPossiveis" :value="usuario.id">{{ usuario.nome }}</option>
										</template>
										<template v-else>
											<option disabled>Nenhum usuário disponível</option>
										</template>
									</select>
								</div>
							</div>

							<div class="row" style="margin-top: 20px;">
								<button v-if="$route.params.id" type="button" class="white-text waves-effect btn-small red darken-3 left" @click="deletar">
									Excluir
								</button>

								<button class="white-text waves-effect btn-small green darken-1 right">
									Salvar
								</button>

								<router-link to="/projetos/listar">
									<a class="white-text waves-effect btn-small red darken-1 right" style="margin-right: 10px;">
										Cancelar
									</a>
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

                    this.$nextTick(() => {
                        M.FormSelect.init(this.$refs.usuarios);
                        M.updateTextFields();
                    });
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