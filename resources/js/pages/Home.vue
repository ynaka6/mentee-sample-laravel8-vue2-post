<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-lg">
            <form class="my-8" @submit.prevent="onSubmit">
                <app-textarea
                    v-model="form.message"
                    :error="formState('message')"
                    :disabled="!loggedIn"
                />

                <button
                    type="submit"
                    class="w-full px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150"
                    :disabled="!loggedIn"
                >
                    投稿
                </button>
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
import axios from 'axios';
import AppTextarea from '../components/AppTextarea.vue';
import MessageCard from '../components/MessageCard.vue';
export default {
    components: {
        AppTextarea,
        MessageCard
    },
    data() {
        return {
            posts: [],
            form: {
                message: null,
            },
            errors: null
        };
    },
    created() {
        this.fetchPost()
    },
    computed: {
        loggedIn() {
            return this.$store.getters['auth/loggedIn']
        }
    },
    methods: {
        async fetchPost() {
            const response = await axios.get('/api/posts')
            this.posts = [...response.data]
        },
        formState(name) {
            return this.errors &&
                this.errors[name] &&
                0 < this.errors[name].length
                ? this.errors[name][0]
                : ""
        },
        onSubmit() {
            axios.post('/api/post', this.form)
                .then(response => {
                    this.form.message = null;
                    this.posts = [response.data, ...this.posts]
                })
                .catch(err => {
                    const response = err.response;
                    const errors = response.data.errors;
                    if (errors) {
                        this.errors = errors;
                    }
                });
        },
        deletePost(post) {
            axios.delete(`/api/post/${post.id}`, this.form)
                .then(response => {
                    this.posts = this.posts.filter(p => p.id !== post.id)
                });
        }
    }
};
</script>