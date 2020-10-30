<template>
    <form @submit.prevent="onSubmit(form)">
        <app-textarea
            v-model="form.message"
            :error="formState('message')"
            :disabled="!loggedIn"
        />
        <div class="w-full flex justify-between items-center mb-2">
            <div class="w-1/2">
                <a
                    v-if="loggedIn"
                    href="#"
                    class="text-gray-800 opacity-75"
                    @click.prevent="$refs.file.click()"
                >
                    <font-awesome-icon
                        :icon="['far', 'images']"
                    />
                </a>
                <input ref="file" type="file" class="w-0 opacity-0" multiple @change="previewImages" />
            </div>
            <div class="w-1/2 text-right">
                <text-length-counter :text="form.message" />
            </div>
        </div>
        <post-image-list v-if="form.images.length" :images="form.images" class="mb-1" />
        <div v-if="form.images.length" class="mb-2">
            <a
                v-if="form.images.length"
                href="#"
                class="font-bold text-red-500 text-xs"
                @click.prevent="clearImages"
            >
                <font-awesome-icon
                    :icon="['far', 'trash-alt']"
                    class="mr-1"
                />
                画像を全て削除する
            </a>
        </div>
        <external-site-card
            v-if="externalSite"
            :title="externalSite.title"
            :description="externalSite.description"
            :image="externalSite.image"
            :url="externalSite.url"
        />
        <app-button
            tag-name="button"
            type="submit"
            size="lg"
            rounded="sm"
            class="w-full"
            :disabled="!loggedIn"
        >
            コメントを投稿する
        </app-button>
    </form>
</template>

<script>
import AppButton from '../components/AppButton'
import AppTextarea from '../components/AppTextarea.vue'
import ExternalSiteCard from '../components/ExternalSiteCard.vue'
import PostImageList from '../components/PostImageList.vue'
import TextLengthCounter from '../components/TextLengthCounter.vue'

export default {
    components: {
        AppButton,
        AppTextarea,
        ExternalSiteCard,
        PostImageList,
        TextLengthCounter,
    },
    props: {
        postId: {
            type: Number,
            require: true,
            default: 0,
        },
        loggedIn: {
            type: Boolean,
            require: false,
            default: false,
        },
        handlePostedComment: {
            type: Function,
            require: true,
            default: () => {},
        },
    },
    data() {
        return {
            form: {
                message: null,
                images: [],
            },
            externalSite: null,
        }
    },
    methods: {
        formState(name) {
            return this.errors && this.errors[name] && 0 < this.errors[name].length
                ? this.errors[name][0]
                : ''
        },
        previewImages(event) {
            this.form.images = []
            if (event.target.files.length > 4) {
                alert('画像は4つまでアップロードすることが可能です。')
                this.$refs.file.value = null
                return
            }
            Array.from(event.target.files).forEach((file) => {
                const reader = new FileReader()
                reader.onload = (e) => {
                    this.form.images.push(e.target.result)
                }
                reader.readAsDataURL(file)
            })
        },
        clearImages() {
            this.$refs.file.value = null
            this.form.images = []
        },
        async onSubmit() {
            if (!this.loggedIn) {
                return
            }
            let formData = new FormData()
            formData.append('parentId', this.postId)
            if (this.form.message) {
                formData.append('message', this.form.message)
            }
            if (this.isStore) {
                formData.append('product[price]', this.form.product.price)
                formData.append('product[payment_count]', this.form.product.payment_count || '')
            }
            Array.from(this.$refs.file.files).forEach((file, index) => {
                formData.append('images[' + index + ']', file)
            })

            try {
                await this.$store.dispatch('post/createComment', formData)
                this.form.message = null
                this.externalSite = null
                this.form.images = []
                this.$refs.file.value = null
                this.handlePostedComment()
            } catch (err) {
                const response = err.response
                const errors = response.data.errors
                if (errors) {
                    this.errors = errors
                }
            }
        },
    },
}
</script>
