<template>
    <span class="text-gray-500 text-xs">
        {{ charCount }}
        charactors
    </span>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            require: true,
            default: null,
        },
    },
    computed: {
        charCount() {
            return (this.text || '').length
        },
    },
}
</script>
