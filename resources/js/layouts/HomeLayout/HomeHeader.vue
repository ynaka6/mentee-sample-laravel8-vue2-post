<template>
    <header>
        <div class="w-full bg-gray-100">
            <div class="container mx-auto">
                <nav
                    class="flex items-center justify-between px-2 lg:px-4 py-3"
                >
                    <div class="flex items-center flex-shrink-0">
                        <app-logo to="/" />
                    </div>
                    <div class="w-full lg:w-auto mx-0">
                        <div v-if="user" class="flex items-center justify-end">
                            <app-dropdown-menu
                                v-if="menu.length > 0"
                                :menu="menu"
                            >
                                <span class="flex items-center justify-center h-8 w-8 rounded-full text-green-800 hover:bg-green-100">
                                    <font-awesome-icon
                                        :icon="['fas', 'ellipsis-v']"
                                    />
                                </span>
                            </app-dropdown-menu>
                        </div>
                        <div v-else class="flex items-center justify-end">
                            <app-button
                                tag-name="router-link"
                                to="/login"
                                size="sm"
                                color="success"
                                rounded="full"
                                class="mr-2"
                            >
                                Login
                            </app-button>
                            <app-button
                                tag-name="router-link"
                                to="/register"
                                size="sm"
                                color="success"
                                rounded="full"
                                class="mr-2"
                                outline
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
import AppDropdownMenu from '../../components/AppDropdownMenu'
import AppLogo from '../../components/AppLogo'
export default {
    components: {
        AppButton,
        AppDropdownMenu,
        AppLogo,
    },
    data() {
        const menu = [
            { label: 'ログアウト', icon: ['fas', 'sign-out-alt'], handleClick: this.onClickLogout },
        ]
        return { menu }
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