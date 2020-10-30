<template>
    <div class="flex flex-col items-center justify-center">
        <div class="mx-auto mb-4 flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 text-red-500 sm:mx-0 sm:h-10 sm:w-10">
            <font-awesome-icon
                :icon="['fas', 'exclamation-triangle']"
            />
        </div>
        <div class="w-full p-4 text-center mb-4">
            <p class="font-semibold text-xl mb-2">ログインが必要になります</p>
            <p class="text-sm text-gray-600 mb-2">ログイン画面からログインしてください。</p>
        </div>
        <app-button
            tag-name="router-link"
            to="/login"
            size="lg"
            rounded="full"
        >
            ログイン
        </app-button>
    </div>
</template>

<script>
import AppButton from '../components/AppButton'
export default {
    components: {
        AppButton,
    },
}
</script>
