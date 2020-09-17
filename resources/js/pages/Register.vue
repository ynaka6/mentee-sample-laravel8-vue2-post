<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-sm">
            <app-title title="Create a account" class="text-center" />
            <form class="my-8" @submit.prevent="onSubmit">
                <app-input
                    v-model="form.name"
                    label="ユーザー名"
                    type="text"
                    :error="formState('name')"
                />
                <app-input
                    v-model="form.email"
                    label="メールアドレス"
                    type="email"
                    :error="formState('email')"
                />
                <app-input
                    v-model="form.password"
                    label="パスワード"
                    type="password"
                    :error="formState('password')"
                />
                <app-input
                    v-model="form.password_confirmation"
                    label="パスワード（確認）"
                    type="password"
                    :error="formState('password_confirmation')"
                />
                <app-button
                    tag-name="button"
                    type="submit"
                    size="lg"
                    rounded="sm"
                    class="w-full"
                >
                    新規登録
                </app-button>
            </form>
        </div>
    </div>
</template>

<script>
import AppButton from '../components/AppButton'
import AppInput from '../components/AppInput.vue'
import AppTitle from '../components/AppTitle.vue'
export default {
    components: {
        AppButton,
        AppInput,
        AppTitle,
    },
    data() {
        return {
            form: {
                name: null,
                email: null,
                password: null,
                password_confirmation: null,
            },
            errors: null,
            completed: false,
        }
    },
    methods: {
        formState(name) {
            return this.errors && this.errors[name] && 0 < this.errors[name].length
                ? this.errors[name][0]
                : ''
        },
        onSubmit() {
            this.$store
                .dispatch('auth/register', this.form)
                .then(() => {
                    this.$router.push('/')
                })
                .catch((err) => {
                    console.log(err)
                    const response = err.response
                    console.log(response)
                    const errors = response.data.errors || null
                    if (errors) {
                        this.errors = errors
                    }
                })
        },
    },
}
</script>