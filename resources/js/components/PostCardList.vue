<template>
    <div>
        <post-card
            v-for="post in posts"
            :key="post.id"
            :post="post"
            :handleLikePost="handleLikePost"
            :handleDeletePost="handleDeletePost"
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
import PostCard from '../components/PostCard.vue'

export default {
    components: {
        Intersect,
        PostCard,
    },
    props: {
        posts: {
            type: Array,
            require: true,
            default: [],
        },
        next: {
            type: Boolean,
            require: false,
            default: false,
        },
        handleFetchPost: {
            type: Function,
            require: true,
        },
        handleLikePost: {
            type: Function,
            require: true,
        },
        handleDeletePost: {
            type: Function,
            require: true,
        }
    }
}
</script>