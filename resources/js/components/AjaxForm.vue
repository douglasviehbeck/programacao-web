<template>
	<form @submit="onSubmit">
		<slot />
	</form>
</template>

<script>
    export default {
        name: 'AjaxForm',
		props: {
            action: {},
			method: {
                default: 'GET',
			},
		},
		data: function () {
            return {
                elements: {},
			};
		},
		methods: {
            onSubmit: function (event) {
                event.preventDefault();

                if (this.validateComponent(this)) {
                    var methods = ['get', 'post'];

                    if (!methods.includes(this.method.toLowerCase())) {
                        throw new Error('Método "' + this.method + '" não existe');
                    }

                    var values = this.findValues();

                    this.$emit('beforeSubmit', values);

                    var hash = btoa(new Date().getTime());

                    var status = 0;
                    var response = null;

                    axios.request({
                        url: this.action,
                        method: this.method.toUpperCase(),
                        data: values,
                        headers: {
                            'Vuelidation': hash
                        },
                    }).then((res) => {
                        response = res;

                        if (res.data && res.data.Vuelidation && res.data.Vuelidation.hash && res.data.Vuelidation.hash === hash) {
                            for (var field in res.data.Vuelidation.messages) {
                                if (this.elements[field]['validation']) {
                                    this.elements[field]['validation'].setErrors(res.data.Vuelidation.messages[field]);
                                }
                            }

                            status = -1;

                            this.$emit('validationError', res, res.data.Vuelidation.messages);
                        } else {
                            status = 1;

                            this.$emit('success', res);
                        }
                    }).catch((error) => {
                        this.$emit('error', error);

                        response = error.response;
                    }).finally(() => {
                    	this.$emit('afterSubmit', response, status);
					});
                }
            },
			validateComponent: function (component) {
                var proceed = true;

                component.$children.forEach((child) => {
                    if (child._isVue && child.$vnode.tag.includes('Validation') && child.validate) {
						if (!this.elements[this.findElement(child._vnode).data.attrs.name]) {
                            this.elements[this.findElement(child._vnode).data.attrs.name] = {};
						}

                        this.elements[this.findElement(child._vnode).data.attrs.name]['validation'] = child;

                        proceed = child.validate() && proceed;
                    }

                    if (child.$children && child.$children.length) {
						proceed = this.validateComponent(child) && proceed;
					}
                });

                return proceed;
			},
            findElement: function (vnode = this._vnode) {
                var tags = ['input', 'textarea', 'select'];

                var element = null;

                vnode.children.forEach((child) => {
                    if (tags.includes(child.tag)) {
                        element = child;
                    }
                });

                return element;
            },
			findValues: function (vnode = this._vnode, values = {}) {
                var tags = ['input', 'textarea', 'select'];

                vnode.children.forEach((child) => {
					if (tags.includes(child.tag)) {
					    if (!this.elements[child.data.attrs.name]) {
                            this.elements[child.data.attrs.name] = {};
						}

					    this.elements[child.data.attrs.name]['element'] = child;

						if (child.data.domProps) {
                            values[child.data.attrs.name] = child.data.domProps.value;
                        } else {
                            values[child.data.attrs.name] = $(child.elm).val();
						}
					}

					if (child.children && child.children.length) {
						this.findValues(child, values);
					} else if (child.child) {
                        this.findValues(child.child._vnode, values);
					}
				});

                return values;
            }
		}
    }
</script>

<style scoped>

</style>