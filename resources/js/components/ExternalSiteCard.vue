<template>
    <a
        :href="url || `#`"
        class="block h-24 lg:h-36 border rounded shadow flex items-center mb-4"
        target="_blank"
    >
        <div class="w-auto h-full">
            <div
                class="border-r h-full w-24 lg:w-36 bg-gray-100 bg-center bg-cover"
                :style="backgroundImageStyle"
            />
        </div>
        <div class="w-full p-2 text-xs">
            <p class="max-h-4 break-all mb-1 overflow-y-hidden lg:text-sm lg:mb-2">{{ title }}</p>
            <div w-show="description" class="max-h-8 break-all text-gray-600 overflow-y-hidden lg:mb-2">{{ description }}</div>
            <p w-show="url" class="break-all text-gray-500">{{ url }}</p>
        </div>
    </a>
</template>

<script>
export default {
    props: {
        title: {
            type: String,
            require: true,
            default: null,
        },
        description: {
            type: String,
            require: false,
            default: null,
        },
        image: {
            type: String,
            require: false,
            default: null,
        },
        url: {
            type: String,
            require: false,
            default: null,
        },
    },
    data() {
        return {
            backgroundImageStyle: this.image ? { backgroundImage: `url('${this.image}')` } : null,
        }
    },
}
</script>