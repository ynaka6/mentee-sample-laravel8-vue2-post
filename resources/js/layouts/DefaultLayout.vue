<template>
    <div>
        <div class="flex flex-col">
            <div class="min-h-screen flex flex-col">
                <header>
                    <div class="w-full bg-gray-100">
                        <div class="container mx-auto">
                            <nav
                                class="flex items-center justify-between px-2 lg:px-6 py-3"
                            >
                                <div class="flex items-center flex-shrink-0">
                                    <app-logo to="/" />
                                </div>
                            </nav>
                        </div>
                    </div>
                </header>
                <div class="flex flex-grow">
                    <div class="w-full overflow-hidden p-2 lg:py-4 lg:px-12">
                        <router-view></router-view>
                    </div>
                </div>
                <home-footer />
            </div>
        </div>
    </div>
</template>

<script>
import AppLogo from '../components/AppLogo'
import HomeFooter from './HomeLayout/HomeFooter.vue'
export default {
    components: {
        AppLogo,
        HomeFooter,
    },
}
</script>