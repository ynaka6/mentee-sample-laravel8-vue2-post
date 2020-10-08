<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-lg">
            <div class="flex items-center bg-gray-900 p-4 mb-2">
                <router-link to="/" class="text-white mr-2">
                    <font-awesome-icon
                        :icon="['fas', 'arrow-left']"
                        class="mr-4"
                        size="lg"
                    />
                </router-link>
                <div>
                    <app-title :title="`#${hashtag}`" class="text-white" />
                </div>
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
import AppTitle from '../components/AppTitle.vue'
import PostCardList from '../components/PostCardList.vue'
export default {
    components: {
        AppTitle,
        PostCardList,
    },
    data() {
        return {
            hashtag: this.$route.params.hashtag,
            next: null,
            posts: [],
        }
    },
    computed: {
        loggedIn() {
            return this.$store.getters['auth/loggedIn']
        },
    },
    watch: {
        $route(to, from) {
            this.hashtag = to.params.hashtag
            this.next = null
            this.posts = []
            this.fetchPost()
        },
    },
    created() {
        this.fetchPost()
    },
    methods: {
        async fetchPost() {
            const params = { hashtag: this.hashtag }
            if (this.next) {
                params.maxId = this.next
            }
            const response = await axios.get('/api/posts', { params })
            this.posts.push(...response.data.posts)
            this.next = response.data.next
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