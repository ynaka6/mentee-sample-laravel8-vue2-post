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
            <div>
                <post-card
                    v-for="(post, index) in posts"
                    :key="index"
                    :post="post"
                    class="mb-2"
                    @like="likePost"
                    @delete="deletePost"
                >
                </post-card>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import AppButton from '../components/AppButton'
import AppTitle from '../components/AppTitle.vue'
import PostCard from '../components/PostCard.vue'
export default {
    components: {
        AppButton,
        AppTitle,
        PostCard,
    },
    data() {
        return {
            hashtag: this.$route.params.hashtag,
            posts: [],
        }
    },
    computed: {
        loggedIn() {
            return this.$store.getters['auth/loggedIn']
        },
    },
    created() {
        this.fetchPost()
    },
    methods: {
        async fetchPost() {
            const response = await axios.get('/api/posts', { params: { hashtag: this.hashtag } })
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
                axios
                    .delete(`/api/post/${post.id}/unlike`)
                    .then((response) => {
                        post.liking = false
                    })
            } else {
                axios
                    .post(`/api/post/${post.id}/like`)
                    .then((response) => {
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
    watch: {
        $route(to, from) {
            console.log(to);
            this.hashtag = to.params.hashtag
            this.fetchPost()
        }
    }
}
</script>