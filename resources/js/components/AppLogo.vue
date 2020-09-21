<template>
    <component
        :is="tagName"
        :to="targetTo"
        class="text-base xl:text-xl font-bold"
    >
        Imalog
    </component>
</template>

<script>
export default {
    props: {
        tagName: {
            type: String,
            require: false,
            default: 'router-link',
            validator: function (value) {
                return ['div', 'span', 'router-link'].indexOf(value) !== -1
            },
        },
        to: {
            type: String,
            require: false,
            default: null,
        },
    },
    computed: {
        targetTo() {
            return this.tagName === 'router-link' ? this.to : null
        },
    },
}
</script>
