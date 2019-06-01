<template>
	<ul class="sidenav sidenav-fixed">
		<li>
			<div class="user-view">
				<!--<div class="background">-->
					<!--<img src="">-->
				<!--</div>-->
				<div class="user-info">
					<img class="circle" src="/img/users/default_user.png" />
				</div>

				<div class="user-info">
					<span class="blue-text name">John Doe</span>
				</div>

				<div class="user-info">
					<span class="blue-text email">jdandturk@gmail.com</span>
				</div>
			</div>
		</li>
		<router-link tag="li" to="/projetos/listar" class="menu-item">
			<a class="waves-effect waves-teal">
				Projetos
			</a>
		</router-link>
		<router-link tag="li" to="/tasks" class="menu-item">
			<a class="waves-effect waves-teal">
				Tarefas
			</a>
		</router-link>
	</ul>
</template>

<script>
    export default {
        name: 'NavMenu'
    }
</script>

<style scoped>
	.user-info {
		display: flex;
		align-items: center;
		justify-content: center;
	}

	.menu-item {
		cursor: pointer;
	}

	a {
		text-decoration: none !important;
	}
</style>