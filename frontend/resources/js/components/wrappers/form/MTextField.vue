<template>
	<input type="text" @input="$emit('input', $event.target.value)" v-bind="$attrs" />
</template>

<script>
    export default {
        name: 'MTextField',
		props: ['value'],
		mounted: function () {
        	this.$nextTick(() => {
                M.updateTextFields();
			});
		},
    }
</script>

<style scoped>

</style>