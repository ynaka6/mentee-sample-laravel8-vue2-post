<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-lg">
            <form class="my-8" @submit.prevent="onSubmit">
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
            <div>
                <message-card
                    v-for="post in posts"
                    :key="post.id"
                    :post="post"
                    class="mb-2"
                    @delete="deletePost"
                >
                </message-card>
            </div>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import AppButton from '../components/AppButton'
import AppTextarea from '../components/AppTextarea.vue'
import MessageCard from '../components/MessageCard.vue'
export default {
    components: {
        AppButton,
        AppTextarea,
        MessageCard,
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
        deletePost(post) {
            axios.delete(`/api/post/${post.id}`, this.form).then((response) => {
                this.posts = this.posts.filter((p) => p.id !== post.id)
            })
        },
    },
}
</script>