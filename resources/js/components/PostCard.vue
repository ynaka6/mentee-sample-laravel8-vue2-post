<template>
    <div
        class="p-3 border rounded shadow hover:shadow-xl"
    >
        <div class="mb-2">
            <p class="mb-1">{{ post.user.name }}</p>
            <div class="px-6 border-b"></div>
        </div>
        <p class="text-xs text-gray-600">{{ post.created_at }}</p>
        <p class="text-sm whitespace-pre-line">
            <convert-link :text="post.message" />
        </p>
        <external-site-card
            v-if="post.externalSite"
            :title="post.externalSite.title"
            :description="post.externalSite.description"
            :image="post.externalSite.image"
            :url="post.externalSite.url"
            class="my-4"
        />
        <div
            
            class="mt-2 flex justify-between"
        >
            <div>
                <like-button
                    :liking="post.liking"
                    @click="onClickLike"
                />
            </div>
            <div>
                <app-button
                    v-if="post.me"
                    size="sm"
                    color="danger"
                    rounded="full"
                    @click="onClickDelete"
                >
                    削除
                </app-button>
            </div>
        </div>
    </div>
</template>

<script>
import AppButton from './AppButton'
import LikeButton from './LikeButton'
import ConvertLink from './ConvertLink'
import ExternalSiteCard from './ExternalSiteCard.vue'
export default {
    components: {
        AppButton,
        LikeButton,
        ConvertLink,
        ExternalSiteCard,
    },
    props: {
        post: {
            type: Object,
            require: true,
            default: null,
        },
    },
    emits: ['like', 'delete'],
    methods: {
        onClickLike() {
            this.$emit('like', this.post)
        },
        onClickDelete() {
            if (confirm('削除してもよろしいですか？')) {
                this.$emit('delete', this.post)
            }
        },
    },
}
</script>