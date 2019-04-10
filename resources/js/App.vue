<template>
	<div>
		<nav-menu></nav-menu>
		<flash-message />
		<div class="content-spa">
			<router-view />
		</div>
	</div>
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