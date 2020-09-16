<template>
    <component
        :is="tagName"
    >
        {{ title }}
    </component>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            require: true,
            default: null
        },
        tagName: {
            type: String,
            require: false,
            default: 'h1'
        }
    }
};
</script>

<style scoped>
h1 {
    @apply font-bold text-2xl;
}
</style>