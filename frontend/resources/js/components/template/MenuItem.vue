<template>
    <li :class="($route.meta.menu === route) ? 'navigation__active' : 'navigation__sub'">
        <router-link :to="{ name: route }">
            <slot></slot>
        </router-link>
    </li>
</template>

<script>
    export default {
        name: 'MenuItem',
        props: ['route'],
    }
</script>

<style scoped>

</style>