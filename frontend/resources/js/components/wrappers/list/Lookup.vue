<template>
	<modal ref="modal" size="lg" @open="onOpen" @close="filter = {}" centered>
		<template v-slot:header>
			<slot name="header"></slot>
		</template>
		<template v-slot:body>
			<fade-transition>
				<loader v-if="loading"></loader>
			</fade-transition>
			<div class="mb-3">
				<div class="input-group">
					<input ref="search" type="text" class="form-control d-inline-block" v-model="filter[campo]" @keypress.enter="$refs['tabela'].get()">
					<div class="input-group-append bg-primary" style="cursor: pointer;" @click="$refs['tabela'].get()">
						<span class="input-group-text"><i class="zwicon-search"></i><span class="d-none d-sm-inline">Pesquisar</span></span>
					</div>
				</div>
			</div>
			<endpoint-list ref="tabela" :endpoint="endpoint" @beforeSearch="loading = true" @afterSearch="loading = false" :filter="filter" paginate changeUrl>
				<template v-slot:header>
					<tr>
						<slot name="table-header"></slot>
						<th style="width: 10%;" class="text-center">&nbsp;</th>
					</tr>
				</template>
				<template v-slot:row="{ row }">
					<tr>
						<slot name="table-row" :row="row"></slot>
						<td style="width: 10%;" class="text-center">
							<i @click="select(row)" class="zwicon-arrow-circle-right text-success" title="Selecionar" style="font-size: 1.75rem; cursor: pointer;"></i>
						</td>
					</tr>
				</template>
			</endpoint-list>
		</template>
		<template v-slot:footer>
			<div class="w-100 d-flex justify-content-center">
				<button @click="$refs['modal'].close()" class="btn btn-theme">Cancelar</button>
			</div>
		</template>
	</modal>
</template>

<script>
    export default {
        name: 'Lookup',
		props: ['endpoint', 'campo'],
		data: function () {
			return {
			    loading: true,
				filter: {},
			};
        },
		methods: {
            open: function () {
				this.$refs['modal'].open();
            },
			select: function (usuario) {
                this.$emit('select', usuario);
                this.$refs['modal'].close();
            },
			onOpen: function () {
				this.$refs['tabela'].get();
				this.$refs['search'].focus();
            },
		},
    }
</script>

<style scoped>

</style>