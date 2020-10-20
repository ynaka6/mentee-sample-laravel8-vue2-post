<template>
    <div>
        <post-card
            v-for="post in posts"
            :key="post.id"
            :post="post"
            :handle-like-post="handleLikePost"
            :handle-delete-post="handleDeletePost"
            :handle-checkout-post="handleCheckoutPost"
            class="mb-2"
        >
        </post-card>
        <intersect v-if="next" @enter="handleFetchPost">
            <span></span>
        </intersect>
    </div>
</template>

<script>
import Intersect from 'vue-intersect'
import PostCard from './PostCard.vue'

export default {
    components: {
        Intersect,
        PostCard,
    },
    props: {
        posts: {
            type: Array,
            require: true,
            default: () => [],
        },
        next: {
            type: Boolean,
            require: false,
            default: false,
        },
        handleFetchPost: {
            type: Function,
            require: true,
            default: () => {},
        },
        handleLikePost: {
            type: Function,
            require: true,
            default: () => {},
        },
        handleDeletePost: {
            type: Function,
            require: true,
            default: () => {},
        },
        handleCheckoutPost: {
            type: Function,
            require: true,
            default: () => {},
        },
    },
}
</script>