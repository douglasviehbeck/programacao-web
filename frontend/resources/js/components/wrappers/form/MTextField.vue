<template>
	<input type="text" @input="$emit('input', $event.target.value)" v-bind="$attrs" />
</template>

<script>
    export default {
        name: 'MTextField',
		props: ['value'],
    }
</script>

<style scoped>

</style>