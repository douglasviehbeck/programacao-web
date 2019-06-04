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
                event.stopPropagation();

                if (this.validateComponent(this)) {
                    var methods = ['get', 'post', 'put', 'delete'];

                    if (!methods.includes(this.method.toLowerCase())) {
                        throw new Error('Método "' + this.method + '" não existe');
                    }

                    var values = {};

                    $(this.$el).serializeArray().forEach((field) => {
						values[field.name] = field.value;
					});

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
								this.elements[field]['validation'].setErrors(res.data.Vuelidation.messages[field]);
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
						var name = child.name || this.findName(child);

						this.elements[name] = this.elements[name] || {};

						this.elements[name]['validation'] = child;

						proceed = child.validate() && proceed;
                    }

                    if (child.$children && child.$children.length) {
						proceed = this.validateComponent(child) && proceed;
					}
                });

                return proceed;
			},
            findElement: function (vnode = this._vnode) {
                var tags = ['input', 'textarea', 'select', 'm-text-field'];

                var element = null;

				if (vnode.children) {
                    vnode.children.forEach((child) => {
                        if (tags.includes(child.tag) || (child.componentOptions && tags.includes(child.componentOptions.tag))) {
                            element = child;
                        } else if (child.children) {
                            var nestedEl = this.findElement(child);

                            if (nestedEl && tags.includes(nestedEl.tag)) {
                                element = nestedEl;
                            }
                        }
                    });
                }

                return element || vnode;
            },
			findName: function (vnode) {
                var element = this.findElement(vnode._vnode);

                return (element.data.domProps || element.data.attrs || element.componentOptions.propsData).name;
            },
		}
    }
</script>

<style scoped>

</style>