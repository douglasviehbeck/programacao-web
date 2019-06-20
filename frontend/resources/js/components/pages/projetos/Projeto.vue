<template>
	<section>
		<div>
			<div class="card">
				<div class="card-body">
					<header class="content__title">
						<h1 v-if="$route.params.id">Editar Projeto</h1>
						<h1 v-else>Novo Projeto</h1>
					</header>

					<div>
						<ajax-form action="/projetos/salvar" method="POST" @beforeSubmit="beforeSubmit" @success="onSuccess" @afterSubmit="loadingProjeto = false">
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
		<div v-if="this.$route.params.id">
			<div class="card">
				<div class="card-body">
					<header class="content__title">
						<h1>Usuários do Projeto</h1>
						<div class="actions d-block" style="top: unset;">
							<button @click="$refs['usuarioLookup'].open()" class="btn btn-theme-dark zwicon-plus">
								Adicionar
							</button>
						</div>
					</header>

					<lookup ref="usuarioLookup" :endpoint="'/projetos/' + $route.params.id + '/usuarios/lookup'" campo="nome" @select="adicionarUsuario">
						<template v-slot:header>
							<h1>Novo Usuário do Projeto</h1>
						</template>
						<template v-slot:table-header>
							<th style="width: 40%;">Username</th>
							<th style="width: 40%;">Nome</th>
						</template>
						<template v-slot:table-row="{ row }">
							<td>{{ row.username }}</td>
							<td>{{ row.nome }}</td>
						</template>
					</lookup>

					<endpoint-list ref="tabelaUsuarios" :endpoint="'/projetos/' + $route.params.id + '/usuarios'" @beforeSearch="loadingUsuarios = true" @afterSearch="loadingUsuarios = false" paginate>
						<template v-slot:header>
							<tr>
								<th style="width: 30%;">Username</th>
								<th style="width: 35%;">Nome</th>
								<th style="width: 25%;" class="text-right">Data da Permissão</th>
								<th style="width: 10%;" class="text-center">Ações</th>
							</tr>
						</template>
						<template v-slot:row="{ row }">
							<tr>
								<td>{{ row.username }}</td>
								<td>{{ row.nome }}</td>
								<td class="text-right">{{ row.dataPermissao }}</td>
								<td class="text-center" style="padding: 0.9rem;">
									<i @click="removerUsuario(row)" class="zwicon-close" :title="row.criador ? 'O usuário é o criador do projeto' : 'Remover permissão'" :style="'font-size: 1.75rem; color: ' + (row.criador ? '#dddddd' : '#b93c48; cursor: pointer') + ';'"></i>
								</td>
							</tr>
						</template>
					</endpoint-list>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
    export default {
        name: 'Projeto',
		data: function () {
            var loading = typeof this.$route.params.id !== 'undefined';

			return {
				loadingProjeto: loading,
				loadingUsuarios: loading,
                nome: '',
				descricao: '',
			};
        },
		mounted: function () {
            if (this.$route.params.id) {
                this.carregarDados();
            }
        },
		methods: {
            carregarDados: function () {
				this.loadingProjeto = true;

				axios.get('/projetos/' + this.$route.params.id).then((res) => {
					if (res.data.projeto) {
						this.nome = res.data.projeto.nome;
						this.descricao = res.data.projeto.descricao;
					}

					this.loadingProjeto = false;
				}).catch((error) => {
					if (error.response.status === 404) {
						this.$flash('error', 'Este registro não existe');
						this.$router.push('/projetos/listar');
					}
				});
            },
            beforeSubmit: function (params) {
                this.loadingProjeto = true;

                params['projeto'] = this.$route.params.id;
            },
			onSuccess: function (res) {
                this.$flash('success', 'Projeto salvo com sucesso!');
                this.$router.push({name: 'projetos.editar', params: {id: res.data.projetoId}});
            },
			deletar: function () {
                this.$confirm().then((result) => {
                    if (result.value) {
                        this.loadingProjeto = true;

                        axios.post('/projetos/deletar/' + this.$route.params.id).then((res) => {
                            this.$flash('success', 'Projeto excluído com sucesso!');
                            this.$router.push('/projetos/listar');
                        }).catch(() => {
							this.$router.push('/projetos/listar');
                        });
					}
				});
            },
			adicionarUsuario: function (usuario) {
                this.loadingUsuarios = true;

				axios.post('/projetos/' + this.$route.params.id + '/usuarios/salvar', {
				    usuario: usuario.usuarioId,
				}).then(() => this.$refs['tabelaUsuarios'].get());
            },
            removerUsuario: function (usuario) {
                this.loadingUsuarios = true;

                axios.post('/projetos/' + this.$route.params.id + '/usuarios/deletar/' + usuario.usuarioId).then(() => this.$refs['tabelaUsuarios'].get());
            },
        },
		computed: {
            loading: function () {
                return this.loadingProjeto || this.loadingUsuarios;
			},
		},
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