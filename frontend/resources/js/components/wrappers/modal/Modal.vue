<template>
	<div class="modal fade" tabindex="-1" role="dialog">
		<div :class="{'modal-dialog': true, 'modal-dialog-centered': centered, ['modal-' + size]: true}" role="document">
			<div class="modal-content">
				<div class="modal-header" v-if="$slots['header']">
					<slot name="header"></slot>
				</div>
				<div class="modal-body" v-if="$slots['body']">
					<slot name="body"></slot>
				</div>
				<div class="modal-footer" v-if="$slots['footer']">
					<slot name="footer"></slot>
				</div>
			</div>
		</div>
	</div>
</template>

<script>
    export default {
        name: 'Modal',
		props: {
            centered: {
                type: Boolean,
			},
            size: {
                default: 'md',
            },
		},
		mounted: function () {
            $(this.$el).on('show.bs.modal', () => this.$emit('open'));
            $(this.$el).on('shown.bs.modal', () => this.$emit('opened'));
            $(this.$el).on('hide.bs.modal', () => this.$emit('close'));
            $(this.$el).on('hidden.bs.modal', () => this.$emit('closed'));
		},
		methods: {
            open: function () {
				$(this.$el).modal('show');
			},
            close: function () {
                $(this.$el).modal('hide');
            },
		},
    }
</script>

<style scoped>

</style>