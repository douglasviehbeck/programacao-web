<template>
	<div>
		<div class="card">
			<div class="card-body">
				<header class="content__title">
					<h1>Seus Projetos</h1>
					<div class="actions d-block" style="top: unset;">
						<router-link to="/projetos/criar" class="btn btn-theme-dark zwicon-plus">
							Adicionar
						</router-link>
					</div>
				</header>

				<endpoint-list endpoint="/projetos" @beforeSearch="loading = true" @afterSearch="loading = false" paginate changeUrl>
					<template v-slot:header>
						<tr>
							<th style="width: 50%;">Nome</th>
							<th style="width: 50%;">Criador</th>
						</tr>
					</template>
					<template v-slot:empty-message>
						<td colspan="2" class="text-center">
							Parece que você não participa de nenhum projeto...
						</td>
					</template>
					<template v-slot:row="{ row }">
						<tr @click="$router.push({name: 'projetos.tarefas', params: {projeto: row.id}})" style="cursor: pointer;">
							<td>{{ row.nome }}</td>
							<td>{{ row.criador }}</td>
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
        name: 'ListagemProjeto',
		data: function () {
			return {
				loading : true,
			};
        },
    }
</script>

<style scoped>
	table {
		margin-bottom: 0;
	}
</style>