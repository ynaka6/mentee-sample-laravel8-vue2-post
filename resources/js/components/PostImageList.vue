<template>
    <div class="flex flex-wrap">
        <div
            v-for="(image, index) in images"
            :key="index"
            class="h-32 w-1/2"
        >
            <div
                class="border h-full w-full bg-gray-100 bg-center bg-cover"
                :style="{ backgroundImage: `url('${image}')` }"
                @click.prevent="onClick(image)"
            />
        </div>
        <portal to="modal">
            <app-modal
                ref="imageModal"
                :handle-close-modal="handleCloseModal"
            >
                <img :src="selectImage" class="w-full" />
            </app-modal>
        </portal>
    </div>
</template>

<script>
import AppModal from './AppModal.vue'

export default {
    components: {
        AppModal,
    },
    props: {
        images: {
            type: Array,
            require: true,
            default: () => [],
        },
    },
    data() {
        return {
            selectImage: null,
        }
    },
    methods: {
        onClick(image) {
            this.selectImage = image
            this.$refs.imageModal.show()
        },
        handleCloseModal() {
            this.selectImage = null
        },
    },
}
</script>