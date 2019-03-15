<template>
	<div class="input-field" v-bind="divAttrs">
		<label v-if="label">Título</label>
		<input type="text" v-bind="$attrs" @input="$emit('input', $event.target.value)" />
		<span v-if="errors.length" class="helper-text " style="min-height: 0;" :data-error="errors.join(', ')"></span>
	</div>
</template>

<script>
	import SelfValidatingMixin from '@mixins/self-validating-mixin';

    export default {
        name: 'SelfValidatingInput',
		mixins: [SelfValidatingMixin],
		props: ['value', 'label', 'divAttrs'],
    }
</script>

<style scoped>

</style>