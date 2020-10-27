<template>
    <div v-if="post" class="h-full flex justify-center">
        <div class="w-full">
            <div class="flex items-center bg-gray-900 p-4 mb-2">
                <router-link to="/" class="text-white mr-2">
                    <font-awesome-icon
                        :icon="['fas', 'arrow-left']"
                        class="mr-4"
                        size="lg"
                    />
                </router-link>
                <div>
                    <app-title :title="`${post.user.name}の投稿`" class="text-white" />
                </div>
            </div>

            <post-card
                v-if="post"
                :post="post"
                :detail="true"
                :handle-like-post="likePost"
                :handle-delete-post="deletePost"
                :handle-checkout-post="checkoutPost"
                class="mb-2"
            >
            </post-card>

            <div class="my-6">
                <div
                    class="w-full bg-white rounded-full shadow-xl text-gray-600 text-sm p-4 cursor-pointer"
                    @click.prevent="$refs.commentModal.show()"
                >
                    <font-awesome-icon
                        :icon="['fas', 'comments']"
                        class="mr-1"
                        size="lg"
                    />
                    コメントを投稿する
                </div>
            </div>

            <post-card-list
                v-if="comments"
                :posts="comments"
                :next="!!nextComment"
                :handle-fetch-post="fetchComments"
                :handle-like-post="likePost"
                :handle-delete-post="deletePost"
                :handle-checkout-post="checkoutPost"
            />
        </div>
        <portal to="modal">
            <app-modal
                ref="commentModal"
            >
                <form class="mb-8" @submit.prevent="onSubmit">
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
            </app-modal>
        </portal>
    </div>
</template>

<script>
import axios from 'axios'
import AppButton from '../components/AppButton'
import AppModal from '../components/AppModal.vue'
import AppTitle from '../components/AppTitle.vue'
import AppTextarea from '../components/AppTextarea.vue'
import ExternalSiteCard from '../components/ExternalSiteCard.vue'
import PostCard from '../components/PostCard.vue'
import PostCardList from '../components/PostCardList.vue'
import PostImageList from '../components/PostImageList.vue'
import TextLengthCounter from '../components/TextLengthCounter.vue'

export default {
    components: {
        AppButton,
        AppModal,
        AppTitle,
        AppTextarea,
        ExternalSiteCard,
        PostCard,
        PostCardList,
        PostImageList,
        TextLengthCounter,
    },
    data() {
        return {
            postId: this.$route.params.id,
            post: null,
            form: {
                message: null,
                images: [],
            },
            externalSite: null,
        }
    },
    computed: {
        loggedIn() {
            return this.$store.getters['auth/loggedIn']
        },
        comments() {
            return this.$store.getters['post/comments']
        },
        nextComment() {
            return this.$store.getters['post/nextComment']
        },
    },
    watch: {
        async $route(to, from) {
            this.postId = to.params.id
            this.post = await this.fetchPost()
            await this.fetchComments({ reset: true })
        },
    },
    async created() {
        try {
            this.post = await this.fetchPost()
            await this.fetchComments({ reset: true })
        } catch (err) {
            const response = err.response
            // FIXME: 親のデータ取得するのがいけてない・・・
            this.$parent.$parent.template = 'error'
        }
    },
    methods: {
        fetchPost() {
            return this.$store.dispatch('post/fetchPost', { id: this.postId })
        },
        fetchComments(option = {}) {
            this.$store.dispatch('post/fetchComments', { ...option, parentId: this.postId })
        },
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
                this.$refs.commentModal.hide()
            } catch (err) {
                const response = err.response
                const errors = response.data.errors
                if (errors) {
                    this.errors = errors
                }
            }
        },
        likePost(post) {
            if (!this.loggedIn) {
                if (confirm('いいねするにはログインが必要です')) {
                    this.$router.push('/login')
                }
                return
            }
            if (post.liking) {
                axios.delete(`/api/post/${post.id}/unlike`).then((response) => {
                    post.liking = false
                    post.likesCount = response.data.count
                })
            } else {
                axios.post(`/api/post/${post.id}/like`).then((response) => {
                    post.liking = true
                    post.likesCount = response.data.count
                })
            }
        },
        async deletePost(post) {
            await this.$store.dispatch('post/deletePost', post)
            this.$router.push('/')
        },
        checkoutPost(post) {
            if (!this.loggedIn) {
                if (confirm('商品を購入するにはログインが必要です')) {
                    this.$router.push('/login')
                }
                return
            }
        },
    },
}
</script>