<template>
    <transition name="fade" :mode="mode" :duration="duration">
        <slot></slot>
    </transition>
</template>

<script>
    export default {
        name: 'FadeTransition',
        props: {
            duration: {
                default: 400,
            },
            mode: {
                default: undefined,
            },
        },
    }
</script>

<style scoped>
    .fade-enter-active, .fade-leave-active {
        transition: opacity .4s;
    }

    .fade-enter, .fade-leave-to {
        opacity: 0;
    }
</style>