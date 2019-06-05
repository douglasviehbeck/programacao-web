<template>
    <select class="form-control select2" :value="value" v-bind="$attrs"></select>
</template>

<script>
    export default {
        name: 'BaseSelectSearch',
        props: ['value', 'options', 'valueVar', 'textVar'],
        mounted: function () {
            var vm = this;

            $(document).ready(() => {
                $(this.$el).select2({
                    data: this.getOptions()
                }).val(this.value).trigger('change')
                .on('change', function () {
                    vm.$emit('input', this.value);
                });
            });
        },
        watch: {
            value: function (value) {
                var change = false;

                this.options.forEach((option) => {
                    var opValue = undefined;

                    if (this.valueVar) {
                        opValue = option[this.valueVar];
                    } else {
                        opValue = option;
                    }

                    if (opValue == value) {
                        change = true;
                    }
                });

                if (change) {
                    $(this.$el)
                        .val(value)
                        .trigger('change');
                }
            },
            options: {
                handler: function () {
                    $(this.$el).empty().select2({
                        data: this.getOptions()
                    }).val(this.value || null).trigger('change');
                },
                deep: true
            }
        },
        destroyed: function () {
            setTimeout(() => {
                $(this.$el).off().select2('destroy');
            }, 1000);
        },
        methods: {
            getOptions: function () {
                var options = [];

                this.options.forEach((option, index, array) => {
                    var selectOption = {};

                    if (this.valueVar) {
                        selectOption.id = option[this.valueVar];
                    } else {
                        selectOption.id = option;
                    }

                    if (this.textVar) {
                        selectOption.text = option[this.textVar];
                    } else {
                        selectOption.text = option;
                    }

                    options.push(selectOption);
                });

                return options;
            }
        }
    }
</script>

<style scoped>

</style>