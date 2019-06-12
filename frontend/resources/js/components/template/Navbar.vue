<template>
	<header class="header">
		<div class="navigation-trigger d-xl-none" data-sa-action="aside-open" data-sa-target=".sidebar" v-if="sidebar">
			<i class="zwicon-hamburger-menu"></i>
		</div>

		<div style="margin-left: 20px;">
			<router-link to="/projetos/listar" :class="{'nav-link': true, 'active': $route.meta.menu === 'projetos.listar'}">
				Projetos
			</router-link>
		</div>

		<ul class="top-nav">
			<li>
				<a href="javascript:;"><i class="zwicon-cog"></i></a>
			</li>
			<li>
				<a href="javascript:;"><img class="user__img" src="/img/users/default_user.png"></a>
			</li>
		</ul>
	</header>
</template>

<script>
    export default {
        name: 'Navbar',
		props: {
            sidebar: {
                type: Boolean
			}
		},
    }
</script>

<style scoped lang="scss">
	.user__img {
		margin-right: 0;
	}

	.toolbar {
		margin-bottom: 0;
	}

	.nav-link {
		font-size: 1.4rem;
		padding: 0.5rem 1rem;

		&.active {
			background-color: #ffffff11;
			border-radius: 5px;
		}
	}
</style>