<template>
    <label class="block mb-4">
        <span
            v-if="label"
            class="font-bold text-xs text-gray-600"
            :class="{ 'text-red-500': !!error }"
        >
            {{ label }}
            <sup v-show="required" class="text-red-500">*</sup>
        </span>
        <div class="relative rounded-md shadow-sm">
            <textarea
                class="form-input block w-full pr-10 sm:text-sm sm:leading-5"
                :class="{'border-red-300 text-red-900 placeholder-red-300 border-red-300 shadow-outline-red focus:shadow-outline-red focus:border-red-300': !!error, 'cursor-not-allowed': disabled }"
                :value="value"
                :disabled="disabled"
                @input="updateInput"
            />
            <div
                v-if="error"
                class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none"
            >
                <svg class="h-5 w-5 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                </svg>
            </div>
        </div>
        <div class="text-gray-500 text-right text-xs my-1">
            {{ charCount }}
            charactors
        </div>
        <p v-if="error" class="text-sm text-red-500" v-text="error" />
    </label>
</template>

<script>
export default {
    props: {
        label: {
            type: String,
            require: false,
            default: null,
        },
        value: {
            type: String,
            require: false,
            default: null,
        },
        required: {
            type: Boolean,
            require: false,
            default: true,
        },
        disabled: {
            type: Boolean,
            require: false,
            default: false,
        },
        error: {
            type: String,
            require: false,
            default: '',
        },
    },
    emits: ['input'],
    computed: {
        charCount() {
            return (this.value || '').length
        },
    },
    methods: {
        updateInput(event) {
            this.$emit('input', event.currentTarget.value)
        },
    },
}
</script>