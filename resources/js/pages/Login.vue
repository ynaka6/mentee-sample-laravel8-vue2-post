<template>
    <div class="h-full flex justify-center items-center lg:p-6">
        <div class="w-full max-w-sm">
            <app-title title="Login" class="text-center" />
            <form class="my-8" @submit.prevent="onSubmit">
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
                <button
                    type="submit"
                    class="w-full px-4 py-2 border border-transparent text-sm leading-5 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:shadow-outline-blue active:bg-blue-700 transition ease-in-out duration-150"
                >
                    ログイン
                </button>
            </form>
        </div>
    </div>
</template>

<script>
import AppInput from '../components/AppInput.vue'
import AppTitle from '../components/AppTitle.vue'
export default {
    components: {
        AppInput,
        AppTitle,
    },
    data() {
        return {
            form: {
                email: null,
                password: null,
            },
            errors: null,
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
                .dispatch('auth/login', this.form)
                .then(() => {
                    this.$router.push('/')
                })
                .catch((err) => {
                    const response = err.response
                    const errors = response.data.errors
                    if (errors) {
                        this.errors = errors
                    }
                })
        },
    },
}
</script>