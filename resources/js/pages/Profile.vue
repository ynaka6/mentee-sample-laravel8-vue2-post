<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-sm">
            <app-title title="Profile" class="text-center" />
        </div>
    </div>
</template>

<script>
import AppButton from "../components/AppButton";
import AppInput from "../components/AppInput.vue";
import AppTitle from "../components/AppTitle.vue";
export default {
    components: {
        AppButton,
        AppInput,
        AppTitle,
    },
    data() {
        return {
            errors: null,
        };
    },
    methods: {},
};
</script>
