<template>
	<div>
		<navbar></navbar>
		<section class="content content--full">
			<div class="content__inner">
				<fade-transition mode="out-in" :duration="100">
					<router-view />
				</fade-transition>
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