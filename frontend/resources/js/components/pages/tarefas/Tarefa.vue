<template>
	<section>
		<div>
			<div class="card">
				<div class="card-body">
					<header class="content__title">
						<h1 v-if="$route.params.tarefa">Editar Tarefa</h1>
						<h1 v-else>Nova Tarefa</h1>
					</header>

					<div>
						<ajax-form :action="'/projetos/' + $route.params.projeto + '/tarefas/salvar'" method="POST" @beforeSubmit="beforeSubmit" @success="onSuccess" @afterSubmit="loadingTarefa = false">
							<div class="row">
								<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }">
									<label>Título</label>
									<input v-model="titulo" name="titulo" type="text" :class="{'form-control': true, 'is-invalid': error}" :disabled="$route.params.tarefa">
									<div class="invalid-tooltip">{{ error }}</div>
								</validation>

								<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }">
									<label>Descrição</label>
									<v-textarea v-model="descricao" name="descricao" :class="{'is-invalid': error}" :disabled="$route.params.tarefa"></v-textarea>
									<div class="invalid-tooltip">{{ error }}</div>
								</validation>

								<div class="form-group col col-12 col-sm-6">
									<label>Situação</label>
									<select v-model="situacao" name="situacao" class="form-control">
										<option v-for="situacao in situacoes" :value="situacao.id">{{ situacao.nome }}</option>
									</select>
								</div>

								<div class="form-group col col-12 col-sm-6">
									<label>Atribuição</label>
									<select v-model="atribuido" name="atribuido" class="form-control">
										<option :value="null"></option>
										<option v-for="usuario in usuarios" :value="usuario.id">{{ usuario.nome }}</option>
									</select>
								</div>

								<validation class="form-group col col-12" :rules="['required']" v-slot="{ error }" v-if="$route.params.tarefa">
									<label>Comentário</label>
									<v-textarea v-model="comentario" name="comentario" :class="{'is-invalid': error}"></v-textarea>
									<div class="invalid-tooltip">{{ error }}</div>
								</validation>
							</div>

							<div>
								<button class="btn btn-success float-right ml-3">
									Salvar
								</button>

								<router-link :to="{name: 'projetos.tarefas'}" class="btn btn-theme float-right">
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
		<div v-if="this.$route.params.tarefa && historico.length">
			<div class="card">
				<div class="card-body">
					<header class="content__title">
						<h1>Histórico da Tarefa</h1>
					</header>

					<div class="row m-0">
						<div class="col col-12" style="border-top: #FFFFFF33 solid 1px" v-for="registro in historico">
							<div class="mt-3">
								Tarefa alterada por <b>{{ registro.usuario.nome }}</b> em <b>{{ registro.criacao }}</b>
							</div>

							<div class="row mr-0 ml-0 mt-3" v-if="registro.campos.length">
								<div class="col col-12" v-for="campo in registro.campos">
									<b>{{ campos[campo.nomeCampo] }}</b> era <b>{{ campo.antes || 'vazio' }}</b> para <b>{{ campo.depois || 'vazio' }}</b>
								</div>
							</div>

							<div class="mt-3 mb-3">
								{{ registro.comentario }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</template>

<script>
    export default {
        name: 'Tarefa',
        data: function () {
            var loading = typeof this.$route.params.tarefa !== 'undefined';

            return {
                loadingTarefa: loading,
                loadingHistorico: false,
                titulo: '',
                descricao: '',
                situacao: 1,
                atribuido: '',
                criador: '',
                comentario: '',
                usuarios: [],
                situacoes: [],
                historico: [],
				campos: {
                    usuarioId: 'Atribuição',
                    situacaoId: 'Situação',
				},
            };
        },
        mounted: function () {
			this.carregarDados();

			if (this.$route.params.tarefa) {
			    this.carregarHistorico();
			}
        },
        methods: {
            carregarDados: function () {
                this.loadingTarefa = true;

                axios.get('/projetos/' + this.$route.params.projeto + '/tarefas/' + (this.$route.params.tarefa || 'dados')).then((res) => {
					this.loadingTarefa = false;

					if (res.response && res.response.status === 404) {
                        this.$flash('error', 'Esta tarefa não existe');
                        this.$router.push({name: 'projetos.tarefas'});
					} else {
                        if (res.data.tarefa) {
                            this.titulo = res.data.tarefa.titulo;
                            this.descricao = res.data.tarefa.descricao;
                            this.situacao = res.data.tarefa.situacao;
                            this.atribuido = res.data.tarefa.atribuido;
                            this.criador = res.data.tarefa.criador;
                        }

                        this.usuarios = res.data.usuarios;
                        this.situacoes = res.data.situacoes;
                    }
				});
			},
            carregarHistorico: function () {
                this.loadingHistorico = true;

                axios.get('/projetos/' + this.$route.params.projeto + '/tarefas/' + this.$route.params.tarefa + '/historico').then((res) => {
                    this.loadingHistorico = false;

					this.historico = res.data.historico;
                });
			},
            beforeSubmit: function (params) {
                this.loadingTarefa = true;

                params['tarefa'] = this.$route.params.tarefa;
            },
            onSuccess: function (res) {
                this.$flash('success', 'Tarefa salvo com sucesso!');
                this.$router.push({name: 'projetos.tarefas.editar', params: {tarefa: res.data.tarefaId}});
                this.comentario = '';
                this.carregarHistorico();
            },
        },
        computed: {
            loading: function () {
                return this.loadingTarefa || this.loadingHistorico;
            },
        },
    }
</script>

<style scoped>
	select option {
		background: rgba(0, 0, 0, 0.9);
	}

	input:disabled, textarea:disabled {
		background: #11111133;
	}
</style>