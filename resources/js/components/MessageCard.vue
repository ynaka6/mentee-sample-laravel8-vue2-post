<template>
    <div
        class="p-3 border rounded shadow hover:shadow-xl"
    >
        <p class="text-xs text-gray-600">{{ post.created_at }}</p>
        <p>{{ post.message }}</p>
        <div
            
            class="mt-2 flex justify-between"
        >
            <div></div>
            <div>
                <button
                    v-if="post.me"
                    class="hidden lg:inline-block bg-red-500 text-white text-sm text-center rounded-full px-6 py-1 shadow-lg hover:opacity-50 mr-2"
                    @click.prevent="onClickDelete"
                >
                    削除
                </button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        post: {
            type: Object,
            require: true,
            default: null,
        },
    },
    emits: ['delete'],
    methods: {
        onClickDelete() {
            if (confirm('削除してもよろしいですか？')) {
                this.$emit('delete', this.post)
            }
        },
    },
}
</script>