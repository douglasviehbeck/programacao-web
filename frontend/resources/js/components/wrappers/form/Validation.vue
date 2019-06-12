<template>
	<component :is="component">
		<slot :error="error" />
	</component>
</template>

<script>
    export default {
        name: 'Validation',
        props: {
            rules: {
                default: () => []
            },
			component: {
                default: 'div'
			},
			name: {},
        },
        data: function () {
            return {
                errors: []
            };
        },
        methods: {
            validate: function () {
                this.errors = [];

                var element = this.findElement();

                if (!element) {
                    return true;
				}

                this.rules.forEach((rule) => {
                    var ruleFunc = null;

                    if (typeof rule === 'string') {
                        if (!this.$rules[rule]) {
                            throw new Error('Regra "' + rule + '" não existe');
                        }

                        ruleFunc = this.$rules[rule];
                    } else if (typeof rule === 'function') {
						ruleFunc = rule;
					}

                    if (element.data.domProps) {
                        ruleFunc(element.data.domProps.value, this.errors);
                    } else {
                        ruleFunc($(element.elm).val(), this.errors);
                    }
                });

                if (this.errors.length) {
					return false
				}

                return true;
            },
			findElement: function () {
                var tags = ['input', 'textarea', 'select', 'v-textarea'];

                var element = null;

                this._vnode.children.forEach((child) => {
                    if (tags.includes(child.tag) || (child.componentOptions && tags.includes(child.componentOptions.tag))) {
						element = child;
                    }
				});

				return element;
            },
			setErrors: function (error) {
				if (typeof error === 'string') {
				    error = [error];
				}

				this.errors = error || [];
            }
        },
		computed: {
            error: function () {
                if (!this.errors.length) {
                    return null;
				}

				return this.errors.join(', ');
            }
		}
    }
</script>

<style scoped>

</style>