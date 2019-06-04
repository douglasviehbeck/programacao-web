<template>
	<div class="login">

		<!-- Login -->
		<div class="login__block active">
			<div class="login__block__header">
				<img src="/img/system.png" />

				Por favor, faça seu login
			</div>

			<div class="login__block__body">
				<ajax-form action="/login" method="POST" @success="redirect" @validationError="loading = false" @beforeSubmit="loading = true">
					<validation name="loginError" v-slot="{ error }">
						<div style="font-size: 1.1rem" :class="{'invalid-feedback': true, 'd-block': error, 'mb-3': error}">{{ error }}</div>
					</validation>

					<validation :rules="['required']" class="form-group" v-slot="{ error }">
						<input type="text" name="username" :class="{'form-control': true, 'text-center': true, 'is-invalid': error}" placeholder="Login">
						<div class="invalid-feedback">{{ error }}</div>
					</validation>

					<validation :rules="['required']" class="form-group" v-slot="{ error }">
						<input type="password" name="password" :class="{'form-control': true, 'text-center': true, 'is-invalid': error}" placeholder="Senha">
						<div class="invalid-feedback">{{ error }}</div>
					</validation>

					<button href="javascript:;" class="btn btn-block btn-theme-dark btn--icon">
						<i v-if="loading" class="zwicon-rotate-right spin"></i>
						<i v-else class="zwicon-arrow-right"></i>
					</button>
				</ajax-form>
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
                loading : false,
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

<style scoped>

</style>