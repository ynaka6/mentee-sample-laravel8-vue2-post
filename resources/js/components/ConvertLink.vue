<template>
    <component :is="transformed"></component>
</template>

<script>
import { REGEXP_URL, REGEXP_HATHTAG } from '../util/const'
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
            const template = this.convert(this.text)
            return {
                template: template,
                props: this.$options.props,
            }
        },
    },
    methods: {
        convert(str) {
            let spanned = `<span>${str}</span>`
            spanned = spanned.replace(REGEXP_URL, '<a href="$1" target="_blank">$1</a>')
            return spanned.replace(
                REGEXP_HATHTAG,
                '<router-link to="/hashtag/$1" class="text-blue-600">#$1</router-link>'
            )
        },
    },
}
</script>
