<template>
    <div>
        <navbar sidebar></navbar>
        <projeto-sidebar></projeto-sidebar>
    </div>
</template>

<script>
    export default {
        name: 'ProjetosNavigation',
        data: function () {
            return {
                selectedMenu: null,
            };
        },
    }
</script>

<style scoped>

</style>