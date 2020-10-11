<template>
    <div>
        <div class="flex flex-col">
            <div class="min-h-screen flex flex-col">
                <home-header />
                <div class="flex flex-grow">
                    <div class="w-full overflow-hidden p-2 lg:py-4 lg:px-12">
                        <div class="container max-w-5xl mx-auto">
                            <router-view></router-view>
                        </div>
                    </div>
                </div>
                <home-footer />
            </div>
        </div>
        <portal-target name="modal"></portal-target>
    </div>
</template>

<script>
import HomeHeader from './HomeLayout/HomeHeader.vue'
import HomeFooter from './HomeLayout/HomeFooter.vue'
export default {
    components: {
        HomeHeader,
        HomeFooter,
    },
    data() {
        return {
            drawer: false,
        }
    },
    methods: {
        onClickMenu() {
            this.drawer = !this.drawer
        },
    },
}
</script>