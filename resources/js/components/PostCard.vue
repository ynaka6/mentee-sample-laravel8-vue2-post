<template>
    <intersect @enter="handleViewPost(post)">
        <article
            class="p-3 bg-white border rounded shadow hover:shadow-xl"
        >
            <div
                class="flex justify-between items-center"
            >
                <div>
                    <p class="mt-1">{{ post.user.name }}</p>
                </div>
                <div>
                    <app-dropdown-menu
                        v-if="menu.length > 0"
                        :menu="menu"
                    >
                        <span class="flex items-center justify-center h-8 w-8 rounded-full text-green-800 hover:bg-green-100">
                            <font-awesome-icon
                                :icon="['fas', 'ellipsis-h']"
                            />
                        </span>
                    </app-dropdown-menu>
                </div>
            </div>
            <div class="mt-2 mb-4 px-6 border-b"></div>
            <p class="text-xs text-gray-600">{{ post.created_at }}</p>
            <p
                class="text-sm whitespace-pre-line break-all"
            >
                <convert-link :text="post.message" />
            </p>
            <div
                v-if="post.product"
            >
                <div class="flex justify-between items-center mt-6">
                    <div>
                        <p class="font-bold text-3xl">{{ post.product.price.toLocaleString() }}円</p>
                    </div>
                    <div>
                        <app-button
                            v-if="!post.me"
                            rounded="full"
                            @click="handleCheckoutPost(post)"
                        >
                            購入
                        </app-button>
                    </div>
                </div>
                <div class="border-b mx-auto w-1/6 my-4" />
            </div>
            <post-image-list
                v-if="post.images.length"
                :images="post.images"
                class="my-2"
            />
            <external-site-card
                v-if="post.externalSite"
                :title="post.externalSite.title"
                :description="post.externalSite.description"
                :image="post.externalSite.image"
                :url="post.externalSite.url"
                class="my-4"
            />
            <div
                
                class="mt-2 flex justify-between items-center"
            >
                <div class="flex">
                    <like-button
                        :liking="post.liking"
                        :count="post.likesCount"
                        class="mr-4"
                        @click="handleLikePost(post)"
                    />
                    <span class="flex items-center text-gray-500">
                        <font-awesome-icon
                            :icon="['far', 'comment']"
                            class="mr-1"
                        /> 
                        <span class="text-xs">{{ post.commentsCount }}</span>
                    </span>
                </div>
                <div>
                    <app-button
                        v-if="!detail"
                        tag-name="router-link"
                        :to="`/user/${post.user.name}/post/${post.id}`"
                        size="xs"
                        color="success"
                        rounded="full"
                        outline
                    >
                        詳細
                        <font-awesome-icon
                            :icon="['fas', 'chevron-right']"
                            class="ml-1"
                        />
                    </app-button>
                </div>
            </div>
        </article>
    </intersect>
</template>

<script>
import Intersect from 'vue-intersect'
import AppButton from './AppButton'
import AppDropdownMenu from './AppDropdownMenu'
import LikeButton from './LikeButton'
import ConvertLink from './ConvertLink'
import ExternalSiteCard from './ExternalSiteCard.vue'
import PostImageList from '../components/PostImageList.vue'
export default {
    components: {
        Intersect,
        AppButton,
        AppDropdownMenu,
        LikeButton,
        ConvertLink,
        ExternalSiteCard,
        PostImageList,
    },
    props: {
        post: {
            type: Object,
            require: true,
            default: null,
        },
        detail: {
            type: Boolean,
            require: false,
            default: false,
        },
        handleViewPost: {
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
    data() {
        const menu = []
        if (this.post.me) {
            menu.push({
                label: '削除',
                icon: ['far', 'trash-alt'],
                handleClick: this.handleDeletePost,
            })
        } else {
            menu.push({
                label: '通報する',
                icon: ['far', 'flag'],
                handleClick: this.handleDeletePost,
            })
        }
        return { menu }
    },
}
</script>