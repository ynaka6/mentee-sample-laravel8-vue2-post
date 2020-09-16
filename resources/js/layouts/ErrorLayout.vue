<template>
    <div>
        <div class="flex flex-col">
            <div class="min-h-screen flex flex-col">
                <div class="flex flex-grow">
                    <div class="w-full overflow-hidden p-2 lg:py-4 lg:px-12">
                        <div class="container max-w-5xl mx-auto">
                            <error-page :status="$route.meta.error" />
                        </div>
                    </div>
                </div>
                <home-footer />
            </div>
        </div>
    </div>
</template>

<script>
import HomeFooter from "./HomeLayout/HomeFooter.vue";
import ErrorPage from "./Error/ErrorPage.vue";
export default {
    components: {
        HomeFooter,
        ErrorPage
    }
};
</script>