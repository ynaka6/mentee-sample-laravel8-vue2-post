<template>
    <div class="h-full flex justify-center">
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
                    <app-title :title="`#${hashtag}`" class="text-white" />
                </div>
            </div>
            <post-card-list
                :posts="posts"
                :next="!!next"
                :handle-fetch-post="handleFetchPost"
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
    },
    watch: {
        $route(to, from) {
            this.hashtag = to.params.hashtag
            this.handleFetchPost({ reset: true })
        },
    },
    created() {
        this.handleFetchPost({ reset: true })
    },
    methods: {
        handleFetchPost(option = {}) {
            this.$store.dispatch('post/fetchPosts', { hashtag: this.hashtag, ...option })
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