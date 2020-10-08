<template>
    <a
        :href="url || '#'"
        class="h-36 border rounded shadow flex mb-4"
        target="_blank"
    >
        <div>
            <div
                class="border-r h-full w-36 bg-gray-100 bg-center bg-cover"
                :style="backgroundImageStyle"
            />
        </div>
        <div class="p-3">
            <p class="text-sm">{{ title }}</p>
            <div w-show="description" class="text-xs text-gray-600">{{ description }}</div>
            <p w-show="url" class="text-xs text-gray-500">{{ url }}</p>
        </div>
    </a>
</template>

<script>
import AppButton from './AppButton'
export default {
    components: {
        AppButton,
    },
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