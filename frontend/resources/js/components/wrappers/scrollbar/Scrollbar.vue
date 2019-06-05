<template>
    <div>
        <slot></slot>
    </div>
</template>

<script>
    export default {
        name: 'Scrollbar',
        mounted: function () {
            $(document).ready(() => {
                $(this.$el).overlayScrollbars({scrollbars:{autoHide:"l",clickScrolling: true},className:"os-theme-light"});
            });
        }
    }
</script>

<style scoped>

</style>