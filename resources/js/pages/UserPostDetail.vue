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
                    @click.prevent="onClickPostComment"
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
            <app-modal ref="commentModal">
                <post-comment-form
                    :post-id="postId"
                    :logged-in="loggedIn"
                    :handle-posted-comment="() => $refs.commentModal.hide()" />
            </app-modal>
            <app-modal ref="loginWarningModal">
                <login-warning-item />
            </app-modal>
        </portal>
    </div>
</template>

<script>
import axios from 'axios'
import AppModal from '../components/AppModal.vue'
import AppTitle from '../components/AppTitle.vue'
import PostCard from '../components/PostCard.vue'
import PostCardList from '../components/PostCardList.vue'
import LoginWarningItem from '../components/LoginWarningItem.vue'
import PostCommentForm from '../components/PostCommentForm.vue'

export default {
    components: {
        AppModal,
        AppTitle,
        PostCard,
        PostCardList,
        LoginWarningItem,
        PostCommentForm,
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
        onClickPostComment() {
            if (this.loggedIn) {
                this.$refs.commentModal.show()
            } else {
                if (this.$refs.loginWarningModal.show) {
                    this.$refs.loginWarningModal.show()
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