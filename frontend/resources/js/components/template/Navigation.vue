<template>
    <div>
        <header class="header">
            <div class="navigation-trigger hidden-xl-up" data-sa-action="aside-open" data-sa-target=".sidebar">
                <i class="zmdi zmdi-menu"></i>
            </div>
        </header>
        <aside class="sidebar">
            <div>
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
                        <i class="zmdi zmdi-home"></i> Projetos
                    </menu-item>
                </ul>
            </div>
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