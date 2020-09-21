<template>
    <footer>
        <div class="text-gray-800 p-2 mt-0">
            <div class="w-full border-b"></div>
            <div class="container mx-auto flex px-3 py-8">
                <div class="w-full mx-auto flex flex-wrap">
                    <div class="flex w-full lg:w-1/2">
                        <div class="px-3 md:px-0">
                            <h3 class="font-bold text-gray-900">About</h3>
                            <p class="py-4 text-sm text-gray-600">
                                <a rel="noopener noreferrer" href="https://laravel.com/docs/8.x" target="_blank">Laravel8</a> と <a rel="noopener noreferrer" href="https://jp.vuejs.org/index.html" target="_blank">Vue.js</a>を利用したサンプルWebアプリ<br>
                                LaravelとVue.jsの基本構成を学びたい人向け<br>
                                <a rel="noopener noreferrer" href="https://tailwindcss.com/" target="_blank">tailwindcss</a> を利用してUIを構築しています。
                            </p>
                        </div>
                    </div>
                    <div class="flex w-full lg:w-1/2 lg:justify-end lg:text-right">
                        <div class="px-3 md:px-0">
                            <h3 class="font-bold text-gray-900">Links</h3>
                            <ul class="list-reset items-center pt-3">
                                <li>
                                    <a
                                        href="https://github.com/ynaka6/mentee-sample-laravel8-vue2-post"
                                        target="_blank"
                                        class="flex items-center"
                                        rel="noopener noreferrer"
                                    >
                                        <font-awesome-icon
                                            :icon="['fab', 'github']"
                                            class="w-6 h-6 mr-1"
                                        />
                                        Open sourced on GitHub
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center text-xs py-8">
                Copyright ©
            </div>
        </div>
    </footer>
</template>