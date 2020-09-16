<template>
    <component v-bind:is="layout" />
</template>

<script>
export default {
    metaInfo: {
        titleTemplate: "Laravel8 & Vue.js Demo | %s",
        htmlAttrs: {
            lang: "ja"
        }
    },
    computed: {
        layout: {
            cache: false,
            get: function() {
                return `${this.$route.meta.layout || "default"}-layout`;
            }
        }
    }
};
</script>