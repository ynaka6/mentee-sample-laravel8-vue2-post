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
            <div>
                <post-card
                    v-for="post in posts"
                    :key="post.id"
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
import AppTextarea from '../components/AppTextarea.vue'
import PostCard from '../components/PostCard.vue'
export default {
    components: {
        AppButton,
        AppTitle,
        AppTextarea,
        PostCard,
    },
    data() {
        return {
            next: null,
            posts: [],
            form: {
                message: null,
            },
            errors: null,
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
            const response = await axios.get('/api/posts')
            this.posts.push(...response.data.posts)
            this.next = response.data.next
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

            // TODO: ログイン処理
        },
        deletePost(post) {
            axios.delete(`/api/post/${post.id}`, this.form).then((response) => {
                this.posts = this.posts.filter((p) => p.id !== post.id)
            })
        },
    },
}
</script>