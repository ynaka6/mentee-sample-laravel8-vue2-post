<template>
    <div class="bg-white rounded-xl p-4" style="border-radius: 1.5rem;">
        <nav class="mb-6">
            <router-link
                to="/"
                class="block px-4 py-2 text-xl text-green-800 rounded-full hover:bg-white hover:border-green-800"
            >
                <font-awesome-icon
                    :icon="['fas', 'home']"
                    class="mr-2"
                />
                HOME
            </router-link>
            <router-link
                :to="user ? `/` : `/login`"
                class="block px-4 py-2 text-xl text-green-800 rounded-full hover:bg-white hover:border-green-800"
            >
                <font-awesome-icon
                    :icon="['fas', 'user']"
                    class="mr-2"
                />
                プロフィール
            </router-link>
        </nav>
        <div class="w-full">
            <app-button
                tag-name="button"
                size="lg"
                color="brand"
                rounded="full"
                class="w-full"
                :disabled="!user"
            >
                投稿する
            </app-button>
        </div>
    </div>
</template>

<script>
import AppButton from '../../components/AppButton'
export default {
    components: {
        AppButton,
    },
    computed: {
        user() {
            return this.$store.getters['auth/user']
        },
    },
    methods: {
        onClickLogout() {
            this.$store.dispatch('auth/logout').then(() => {
                this.$router.push('/login')
            })
        },
    },
}
</script>