<template>
    <component
        :is="tagName"
        :type="targetType"
        :to="targetTo"
        :href="targetHref"
        :disabled="disabled"
        class="button hover:opacity-50"
        :class="[ `button-${size}`, `rounded-${rounded}`, `button-${color}` ]"
        @click="$emit('click')"
    >
        <slot></slot>
    </component>
</template>

<script>
export default {
    props: {
        tagName: {
            type: String,
            require: false,
            default: 'a',
            validator: function (value) {
                return ['button', 'a', 'router-link'].indexOf(value) !== -1
            },
        },
        type: {
            type: String,
            require: false,
            default: 'button',
            validator: function (value) {
                return ['button', 'submit'].indexOf(value) !== -1
            },
        },
        to: {
            type: String,
            require: false,
            default: null,
        },
        href: {
            type: String,
            require: false,
            default: null,
        },
        size: {
            type: String,
            require: false,
            default: 'md',
            validator: function (value) {
                return ['sm', 'md', 'lg'].indexOf(value) !== -1
            },
        },
        color: {
            type: String,
            require: false,
            default: 'brand',
            validator: function (value) {
                return !value || ['success', 'danger', 'primary', 'brand', 'default'].indexOf(value) !== -1
            },
        },
        rounded: {
            type: String,
            require: false,
            default: 'none',
            validator: function (value) {
                return !value || ['none', 'sm', 'lg', 'full'].indexOf(value) !== -1
            },
        },
        disabled: {
            type: Boolean,
            require: false,
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

<style scoped>
.button {
    @apply bg-gray-500 text-white text-center px-8 py-2 shadow-lg;
}
.button-sm {
    @apply text-sm px-6 py-1 shadow-lg;
}
.button-lg {
    @apply text-lg px-10 py-3 shadow-lg;
}
.button-success {
    @apply bg-green-500;
}
.button-danger {
    @apply bg-red-500;
}
.button-primary {
    @apply bg-blue-600;
}
.button-brand {
    @apply bg-orange-400;
}
.button-default {
    @apply bg-gray-500;
}

.button:disabled {
    @apply cursor-not-allowed opacity-50;
}
</style>