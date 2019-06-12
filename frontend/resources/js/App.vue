<template>
	<fade-transition mode="out-in" :duration="100">
		<router-view></router-view>
	</fade-transition>
</template>

<script>
    export default {
        name: 'App'
    }
</script>

<style scoped>
	.content-spa {
		margin-left: 300px;
	}
</style>