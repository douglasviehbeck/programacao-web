<template>
	<aside class="sidebar">
		<scrollbar>
			<div class="user">
				<div class="user__info">
					<img class="user__img" src="/img/users/default_user.png">
					<div>
						<div class="user__name">John Doe</div>
						<div class="user__email">john.doe@gmail.com</div>
					</div>
				</div>
			</div>

			<ul class="navigation">
				<menu-item route="projetos.tarefas">
					<i class="zwicon-task"></i> Tarefas
				</menu-item>
				<menu-item route="projetos.editar">
					<i class="zwicon-cog"></i> Configurações do Projeto
				</menu-item>
			</ul>
		</scrollbar>
	</aside>
</template>

<script>
    export default {
        name: 'ProjetoSidebar',
    }
</script>

<style scoped>

</style>