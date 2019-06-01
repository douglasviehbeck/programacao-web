<template>
	<div style="width: 100%; height: 100%; background-color: #505050">
		<div class="login-wrapper">
			<div class="card">
				<div class="card-content">
					<div style="text-align: center">
						<img src="/img/system.png" height="150px" width="150px" />
					</div>
					<ajax-form action="/login" method="POST" @success="redirect">
						<validation name="loginError" v-slot="{ error }">
							<div v-if="error" style="margin-bottom: 30px;" class="card-panel white-text red darken-1">{{ error }}</div>
						</validation>

						<validation class="input-field" :rules="['required']" v-slot="{ error }">
							<label>Usuário</label>
							<m-text-field v-model="username" name="username" :class="{ invalid: error }"></m-text-field>
							<span class="helper-text" :data-error="error"></span>
						</validation>
						<validation class="input-field" :rules="['required']" v-slot="{ error }">
							<label>Senha</label>
							<m-text-field v-model="password" name="password" type="password" :class="{ invalid: error }"></m-text-field>
							<span class="helper-text" :data-error="error"></span>
						</validation>

						<button class="btn btn-primary waves-effect waves-light">Entrar</button>
					</ajax-form>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: 'Login',
		data: function () {
			return {
			    username: null,
				password: null,
			};
        },
		methods: {
            redirect: function (res) {
                localStorage.setItem('authToken', res.data);

                axios.defaults.headers.common['Authorization'] = 'Bearer ' + localStorage.getItem('authToken');

				this.$router.push(sessionStorage.getItem('intended') || '/');

                sessionStorage.removeItem('intended');
            },
		},
    }
</script>

<style>
	html, body {
		min-height: 100%;
		height: 100%;
	}
</style>

<style scoped>
	body {
		background-color: #505050;
	}

	.login-wrapper {
		position: absolute;
		left: 50%;
		top: 50%;
		transform: translate(-50%, -50%);
		width: 500px;
	}

	div.card-panel {
		padding: 15px;
	}

	button {
		width: 100%;
	}
</style>