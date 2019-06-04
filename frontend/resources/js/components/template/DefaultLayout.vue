<template>
	<div>
		<navigation></navigation>
		<section class="content">
			<div class="content__inner">
				<router-view />
			</div>
		</section>
	</div>
</template>

<script>
    export default {
        name: 'DefaultLayout',
    }
</script>

<style scoped>

</style>