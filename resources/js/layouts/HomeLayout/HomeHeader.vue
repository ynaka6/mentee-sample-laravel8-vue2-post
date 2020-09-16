<template>
    <header>
        <div class="w-full bg-white">
            <div class="container mx-auto">
                <nav
                    class="flex items-center justify-between px-2 lg:px-6 py-3"
                >
                    <div class="flex items-center flex-shrink-0">
                        <router-link
                            to="/"
                            class="text-base xl:text-xl font-bold"
                        >
                            logo
                        </router-link>
                    </div>
                    <div class="w-full lg:w-auto mx-0">
                        <div v-if="user" class="flex items-center justify-end">
                            <div class="p-2">
                                <a href="#" @click.prevent="onClickLogout">
                                    Logout
                                </a>
                            </div>
                        </div>
                        <div v-else class="flex items-center justify-end">
                            <router-link
                                to="/login"
                                class="hidden lg:inline-block bg-purple-500 text-white text-sm text-center rounded-full px-6 py-1 shadow-lg hover:opacity-50 mr-2"
                            >
                                Login
                            </router-link>
                            <router-link
                                to="/register"
                                class="inline-block bg-orange-400 text-white text-sm text-center rounded-full px-6 py-1 shadow-lg hover:opacity-50"
                            >
                                Register
                            </router-link>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
</template>

<script>
export default {
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