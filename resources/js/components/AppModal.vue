<template>
    <transition v-if="open" name="modal">
        <div
            class="modal fixed w-full h-full top-0 left-0 flex items-center justify-center"
        >
            <div
                class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"
                @click.prevent="hide"
            />
            <div
                class="absolute cursor-pointer top-0 right-0 mr-4 mt-4 modal-close z-50"
                @click.prevent="hide"
            >
                <div class="flex items-center justify-center rounded-full h-10 w-10 bg-gray-600 text-white">
                    <font-awesome-icon :icon="['fas', 'times']" size="lg" />
                </div>
            </div>
            <div
                class="bg-white w-full mx-auto rounded shadow-lg z-40"
                :class="[modalSize]"
            >
                <div
                    class="min-h-screen lg:min-h-0 max-h-screen flex flex-col py-8 text-left px-6"
                >
                    <div v-show="title" class="flex justify-between items-center pb-3">
                        <p class="text-2xl font-bold">{{ title }}</p>
                    </div>

                    <div class="flex flex-grow items-center overflow-y-auto">
                        <div class="w-full">
                            <slot />
                        </div>
                    </div>
                </div>
            </div>
            <div class="absolute bottom-0 right-0  mr-4 mb-4 flex justify-end pt-2 z-50">
                <app-button
                    v-if="actionText"
                    class="mr-2"
                    @click="action"
                >
                    {{ actionText }}
                </app-button>
                <app-button
                    color="default"
                    class="modal-close"
                    @click="hide"
                >
                    Close
                </app-button>
            </div>
        </div>
    </transition>
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
        size: {
            type: String,
            require: false,
            default: 'md',
        },
        actionText: {
            type: String,
            require: false,
            default: null,
        },
        handleActionModal: {
            type: Function,
            require: false,
            default: () => {},
        },
        handleCloseModal: {
            type: Function,
            require: false,
            default: () => {},
        },
    },
    data() {
        return {
            open: false,
        }
    },
    computed: {
        modalSize() {
            return this.size === 'md' ? 'lg:max-w-3xl' : 'lg:max-w-3xl'
        },
    },
    methods: {
        action() {
            this.handleActionModal()
        },
        show() {
            this.open = true
            document.body.classList.add('overflow-hidden')
        },
        hide() {
            this.open = false
            this.handleCloseModal()
            document.body.classList.remove('overflow-hidden')
        },
    },
}
</script>

<style scoped>
.modal-enter-active,
.modal-leave-active {
    transition: opacity 0.5s;
}
.modal-enter,
.modal-leave-to {
    opacity: 0;
}
</style>
