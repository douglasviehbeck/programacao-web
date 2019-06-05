<template>
    <div>
        <header class="header">
            <div class="navigation-trigger d-xl-none" data-sa-action="aside-open" data-sa-target=".sidebar">
                <i class="zwicon-hamburger-menu"></i>
            </div>
        </header>
        <aside class="sidebar">
            <scrollbar>
                <div class="user">
                    <div class="user__info">
                        <img class="user__img" src="/img/users/default_user.png">
                        <div>
                            <div class="user__name">John Doe</div>
                            <div class="user__email">john.doe@gmail.com</div>
                        </div>
                    </div>
                </div>

                <ul class="navigation">
                    <menu-item route="projetos.listar">
                        <i class="zwicon-layer-stack"></i> Projetos
                    </menu-item>
                </ul>
            </scrollbar>
        </aside>
    </div>
</template>

<script>
    export default {
        name: 'Navigation',
        data: function () {
            return {
                selectedMenu: null,
            };
        },
    }
</script>

<style scoped>

</style>