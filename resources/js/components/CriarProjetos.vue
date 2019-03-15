<template>
	<div class="container">
		<div class="card horizontal">
			<div class="card-content">
				<h2>Criar Projeto</h2>

				<div>
					<ajax-form v-if="ready" action="/projetos/salvar" method="POST" @beforeSubmit="beforeSubmit" @success="$router.push('/listar/projetos')">
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

						<div>
							<button class="white-text waves-effect btn-small green darken-1 right" style="margin-top: 20px;">
								Salvar
							</button>

							<router-link to="/listar/projetos">
								<a class="white-text waves-effect btn-small red darken-1 right" style="margin-top: 20px; margin-right: 10px;">
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
</template>

<script>
    export default {
        name: 'CriarProjetos',
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

				axios.get('/projetos/usuarios').then((usuarios) => {
				    this.usuariosPossiveis = usuarios.data;

				    this.ready = true;

                    this.$nextTick(() => {
                        M.FormSelect.init(this.$refs.usuarios);
                    });
				});
            },
            beforeSubmit: function (params) {
                params['projeto'] = this.projeto;
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

	.row {
		margin-bottom: 0;
	}
</style>