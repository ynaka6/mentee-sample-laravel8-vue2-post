<template>
    <a
        class="text-red-500"
        @click.prevent="$emit('click')"
    >
        <font-awesome-icon
            :icon="[(liking ? 'fas' : 'far'), 'heart']"
            class="mr-1"
        />
    </a>
</template>

<script>
export default {
    props: {
        liking: {
            type: Boolean,
            require: true,
            default: false,
        },
    },
    emits: ['click'],
    computed: {
        targetType() {
            return this.tagName === 'button' ? this.type : null
        },
        targetTo() {
            return this.tagName === 'router-link' ? this.to : null
        },
        targetHref() {
            return this.tagName === 'a' ? this.href : null
        },
    },
}
</script>
