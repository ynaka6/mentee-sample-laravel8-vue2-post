<template>
    <component :is="transformed"></component>
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
        transformed() {
            const template = this.convertHashTags(this.text)
            return {
                template: template,
                props: this.$options.props,
            }
        },
    },
    methods: {
        convertHashTags(str) {
            const spanned = `<span>${str}</span>`
            return spanned.replace(
                /#([\u30a0-\u30ff\u3040-\u309f\u3005-\u3006\u30e0-\u9fcf\w]+)/g,
                '<router-link to="/hashtag/$1" class="text-blue-600">#$1</router-link>'
            )
        },
    },
}
</script>
