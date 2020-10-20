<template>
    <div>
        <div class="flex flex-col">
            <div class="min-h-screen flex flex-col">
                <home-header />
                <div class="flex flex-grow">
                    <div class="container mx-auto flex">
                        <div class="hidden w-auto p-4 lg:block lg:w-3/12">
                            <home-sidemenu />
                        </div>
                        <div class="w-full p-4 lg:w-6/12">
                            <router-view></router-view>
                        </div>
                        <div class="hidden p-4 lg:block w-3/12">
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
import HomeSidemenu from './HomeLayout/HomeSidemenu.vue'
export default {
    components: {
        HomeHeader,
        HomeFooter,
        HomeSidemenu,
    },
}
</script>