<template>
	<div>
		<div class="card">
			<div class="card-body">
				<header class="content__title">
					<h1>Tarefas do Projeto</h1>
					<div class="actions d-block" style="top: unset;">
						<router-link :to="{name: 'projetos.tarefas.criar'}" class="btn btn-theme-dark zwicon-plus">
							Adicionar
						</router-link>
					</div>
				</header>

				<endpoint-list :endpoint="'/projetos/' + $route.params.projeto + '/tarefas'" @beforeSearch="loading = true" @afterSearch="loading = false" paginate changeUrl>
					<template v-slot:header>
						<tr>
							<th style="width: 25%;">Título</th>
							<th style="width: 15%;">Situação</th>
							<th style="width: 35%;">Atribuído</th>
							<th style="width: 25%;" class="text-right">Criação</th>
						</tr>
					</template>
					<template v-slot:empty-message>
						<td colspan="4" class="text-center">
							O projeto não tem tarefas
						</td>
					</template>
					<template v-slot:row="{ row }">
						<tr @click="$router.push({name: 'projetos.tarefas.editar', params: {tarefa: row.id}})" style="cursor: pointer;">
							<td>{{ row.titulo }}</td>
							<td>{{ row.situacao }}</td>
							<td>{{ row.atribuido || 'Não atribuída' }}</td>
							<td class="text-right">{{ row.dataCriacao }}</td>
						</tr>
					</template>
				</endpoint-list>

				<fade-transition>
					<loader v-if="loading"></loader>
				</fade-transition>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: 'ListagemTarefa',
		data: function () {
			return {
			    loading: true,
			};
        },
    }
</script>

<style scoped>

</style>