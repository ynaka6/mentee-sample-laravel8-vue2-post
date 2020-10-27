<template>
    <component :is="layout" />
</template>

<script>
export default {
    metaInfo: {
        titleTemplate: 'Laravel8 & Vue.js Demo | %s',
        htmlAttrs: {
            lang: 'ja',
        },
    },
    data() {
        return {
            template: this.$route.meta.layout || `default`,
        }
    },
    computed: {
        layout: {
            cache: false,
            get: function () {
                return `${this.template}-layout`
            },
        },
    },
    watch: {
        $route: function (newVal, oldVal) {
            this.template = newVal.meta.layout
        },
    },
}
</script>