<template>
    <a
        class="flex items-center text-red-500"
        @click.prevent="$emit('click')"
    >
        <font-awesome-icon
            :icon="[(liking ? 'fas' : 'far'), 'heart']"
            class="mr-1"
        /> 
        <span class="text-xs">{{ count }}</span>
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
        count: {
            type: Number,
            require: true,
            default: 0,
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
