<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-sm">
            <app-title title="Profile" class="text-center" />
            <h1>{{ user.name }}</h1>
        </div>
    </div>
</template>

<script>
import axios from 'axios'
import AppButton from "../components/AppButton";
import AppInput from "../components/AppInput.vue";
import AppTitle from "../components/AppTitle.vue";
export default {
    components: {
        AppButton,
        AppTitle,
    },
    data() {
        return {
            user: null,
            errors: null,
        }
    },
    created() {
        this.fetchUser() 
    },
    methods: {
        async fetchUser() {
            const response = await axios.get(`/api/user/${this.$route.params.id}`)
            this.user = response.data.user
        }
    },
};
</script>
