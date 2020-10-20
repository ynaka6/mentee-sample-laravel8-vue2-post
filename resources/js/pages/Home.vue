<template>
    <div class="h-full flex justify-center">
        <div class="w-full">
            <div class="relative">
                <form class="mb-8" @submit.prevent="onSubmit">
                    <app-title title="「いま」をログに残そう" icon="edit" class="small text-gray-600 mb-2" />
                    <div class="flex my-2">
                        <div
                            v-for="menu in postMenu"
                            :key="menu.key"
                        >
                            <app-button
                                tag-name="button"
                                size="lg"
                                color="success"
                                rounded="circle"
                                class="mr-2"
                                :disabled="!loggedIn"
                                :outline="selectedMenu.key !== menu.key"
                                @click="selectedMenu = menu"
                            >
                                <font-awesome-icon
                                    :icon="['fas', menu.icon]"
                                />
                            </app-button>
                            <p
                                class="my-1 text-xs text-center font-bold"
                                :class="{
                                    'text-green-500': selectedMenu.key === menu.key,
                                    'text-green-300': selectedMenu.key !== menu.key
                                }"
                            >
                                {{ menu.name }}
                            </p>
                        </div>
                    </div>
                    <div
                        v-if="isStore"
                        class="flex flex-wrap"
                    >
                        <div class="w-1/2 mb-2 pr-1">
                            <app-input
                                v-model="form.product.price"
                                label="料金"
                                type="text"
                                :error="formState('product.price')"
                            />
                        </div>
                        <div class="w-1/2 mb-2 pl-1">
                            <app-select
                                v-model="form.product.payment_count"
                                label="決済サイクル"
                                :options="[
                                    { label: '月額', value: null },
                                    { label: '１回', value: 1 },
                                ]"
                                :error="formState('product.payment_count')"
                            />
                        </div>
                    </div>
                    <app-textarea
                        v-model="form.message"
                        :error="formState('message')"
                        :disabled="!loggedIn"
                        :placeholder="selectedMenu.placeholder"
                    />
                    <div class="flex justify-between items-center mb-2">
                        <div>
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
                        <text-length-counter :text="form.message" />
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
                        投稿
                    </app-button>
                </form>
            </div>
            <post-card-list
                :posts="posts"
                :next="!!next"
                :handle-fetch-post="handleFetchPost"
                :handle-like-post="likePost"
                :handle-delete-post="deletePost"
                :handle-checkout-post="checkoutPost"
            />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import AppButton from '../components/AppButton'
import AppTitle from '../components/AppTitle.vue'
import AppInput from '../components/AppInput.vue'
import AppSelect from '../components/AppSelect.vue'
import AppTextarea from '../components/AppTextarea.vue'
import ExternalSiteCard from '../components/ExternalSiteCard.vue'
import PostCardList from '../components/PostCardList.vue'
import PostImageList from '../components/PostImageList.vue'
import TextLengthCounter from '../components/TextLengthCounter.vue'
import { REGEXP_URL } from '../util/const'
import { postMenu, POST_MENU_STORE } from './Home/PostMenu'

export default {
    components: {
        AppButton,
        AppTitle,
        AppInput,
        AppSelect,
        AppTextarea,
        ExternalSiteCard,
        PostCardList,
        PostImageList,
        TextLengthCounter,
    },
    data() {
        return {
            form: {
                message: null,
                images: [],
                product: {
                    price: null,
                    payment_count: null,
                },
            },
            externalSite: null,
            errors: null,
            selectedMenu: postMenu[0],
            postMenu,
        }
    },
    computed: {
        posts() {
            return this.$store.getters['post/posts']
        },
        next() {
            return this.$store.getters['post/next']
        },
        loggedIn() {
            return this.$store.getters['auth/loggedIn']
        },
        isStore() {
            return this.selectedMenu && this.selectedMenu.key === POST_MENU_STORE
        },
    },
    watch: {
        'form.message': function (newVal, oldVal) {
            if (!newVal || newVal == oldVal) {
                return
            }
            const url = newVal.match(REGEXP_URL)
            if (!url || url.length == 0) {
                this.externalSite = null
                return
            }

            if (this.externalSite) {
                return
            }
            this.fetchExternalSiteData(encodeURI(url[0]))
        },
    },
    created() {
        this.handleFetchPost({ reset: true })
    },
    methods: {
        handleFetchPost(option = {}) {
            this.$store.dispatch('post/fetchPosts', option)
        },
        async fetchExternalSiteData(url) {
            const response = await axios.get('/api/external/crawler', { params: { url } })
            this.externalSite = response.data
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
        formState(name) {
            return this.errors && this.errors[name] && 0 < this.errors[name].length
                ? this.errors[name][0]
                : ''
        },
       async onSubmit() {
            if (!this.loggedIn) {
                return
            }
            let formData = new FormData()
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
                await this.$store.dispatch('post/createPost', formData)
                this.form.message = null
                this.externalSite = null
                this.form.images = []
                this.form.product = { price: null, interval: null }
                this.$refs.file.value = null
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
                })
            } else {
                axios.post(`/api/post/${post.id}/like`).then((response) => {
                    post.liking = true
                })
            }
        },
        deletePost(post) {
            this.$store.dispatch('post/deletePost', post)
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