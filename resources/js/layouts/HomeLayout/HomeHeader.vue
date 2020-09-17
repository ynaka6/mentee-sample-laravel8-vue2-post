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
                            <app-button
                                tag-name="router-link"
                                to="/login"
                                size="sm"
                                color="primary"
                                rounded="full"
                                class="mr-2"
                            >
                                Login
                            </app-button>
                            <app-button
                                tag-name="router-link"
                                to="/register"
                                size="sm"
                                rounded="full"
                                class="mr-2"
                            >
                                Register
                            </app-button>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </header>
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