<template>
    <component
        :is="tagName"
    >
        <font-awesome-icon
            v-if="icon"
            :icon="['far', icon]"
            class="mr-1"
        />
        {{ title }}
    </component>
</template>

<script>
export default {
    props: {
        tagName: {
            type: String,
            require: false,
            default: 'h1',
        },
        title: {
            type: String,
            require: true,
            default: null,
        },
        icon: {
            type: String,
            require: false,
            default: null,
        },
    },
}
</script>

<style scoped>
h1 {
    @apply font-bold text-2xl;
}
h1.small {
    @apply font-bold text-lg;
}
</style>