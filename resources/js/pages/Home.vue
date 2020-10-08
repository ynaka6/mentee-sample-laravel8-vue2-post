<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-lg">
            <div class="relative">
                <form class="my-8" @submit.prevent="onSubmit">
                    <app-title title="「いま」をログに残そう" icon="edit" class="small text-gray-600 mb-2" />
                    <app-textarea
                        v-model="form.message"
                        :error="formState('message')"
                        :disabled="!loggedIn"
                    />
                    <external-site-card
                        v-if="externalSite"
                        :title="externalSite.title"
                        :description="externalSite.description"
                        :image="externalSite.image"
                        :url="externalSite.url"
                        class="mb-4"
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
                :handle-fetch-post="fetchPost"
                :handle-like-post="likePost"
                :handle-delete-post="deletePost"
            />
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import AppButton from '../components/AppButton'
import AppTitle from '../components/AppTitle.vue'
import AppTextarea from '../components/AppTextarea.vue'
import ExternalSiteCard from '../components/ExternalSiteCard.vue'
import PostCardList from '../components/PostCardList.vue'
import { REGEXP_URL } from '../util/const'

export default {
    components: {
        AppButton,
        AppTitle,
        AppTextarea,
        ExternalSiteCard,
        PostCardList,
    },
    data() {
        return {
            next: null,
            posts: [],
            form: {
                message: null,
            },
            externalSite: null,
            errors: null,
        }
    },
    computed: {
        loggedIn() {
            return this.$store.getters['auth/loggedIn']
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
        this.fetchPost()
    },
    methods: {
        async fetchPost() {
            const params = {}
            if (this.next) {
                params.maxId = this.next
            }
            const response = await axios.get('/api/posts', { params })
            this.posts.push(...response.data.posts)
            this.next = response.data.next
        },
        async fetchExternalSiteData(url) {
            const response = await axios.get('/api/external/crawler', { params: { url } })
            this.externalSite = response.data
        },
        formState(name) {
            return this.errors && this.errors[name] && 0 < this.errors[name].length
                ? this.errors[name][0]
                : ''
        },
        onSubmit() {
            axios
                .post('/api/post', this.form)
                .then((response) => {
                    this.form.message = null
                    this.posts = [response.data, ...this.posts]
                    this.externalSite = null
                })
                .catch((err) => {
                    const response = err.response
                    const errors = response.data.errors
                    if (errors) {
                        this.errors = errors
                    }
                })
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
            axios.delete(`/api/post/${post.id}`, this.form).then((response) => {
                this.posts = this.posts.filter((p) => p.id !== post.id)
            })
        },
    },
}
</script>