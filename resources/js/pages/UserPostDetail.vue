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
        </div>
    </div>
</template>

<script>
import AppTitle from '../components/AppTitle.vue'
import PostCard from '../components/PostCard.vue'

export default {
    components: {
        AppTitle,
        PostCard
    },
    data() {
        return {
            postId: this.$route.params.id,
            post: null,
        }
    },
    watch: {
        $route(to, from) {
            this.postId = to.params.id
            this.post = this.fetchPost()
        },
    },
    async created() {
        this.post = await this.fetchPost()
    },
    methods: {
        fetchPost() {
            return this.$store.dispatch('post/fetchPost', { id: this.postId })
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
    }
}
</script>