<template>
    <textarea :value="value" @input="$emit('input', $event.target.value)" class="form-control" v-bind="$attrs"></textarea>
</template>

<script>
    export default {
        name: 'VTextArea',
        props: ['value'],
        mounted: function () {
            $(document).ready(() => {
                autosize(this.$el);
            });
        },
    }
</script>

<style scoped>

</style>