<template>
    <div>
        <div class="flex flex-col">
            <div class="min-h-screen flex flex-col">
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
import HomeFooter from "./HomeLayout/HomeFooter.vue";
export default {
    components: {
        HomeFooter
    }
};
</script>