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
                                <a ref="nolooper" href="https://laravel.com/docs/8.x" target="_blank">Laravel8</a> と <a ref="nolooper" href="https://jp.vuejs.org/index.html" target="_blank">Vue.js</a>を利用したサンプルWebアプリ<br>
                                LaravelとVue.jsの基本構成を学びたい人向け<br>
                                <a ref="nolooper" href="https://tailwindcss.com/" target="_blank">tailwindcss</a> を利用してUIを構築しています。
                            </p>
                        </div>
                    </div>
                    <div class="flex w-full lg:w-1/2 lg:justify-end lg:text-right">
                        <div class="px-3 md:px-0">
                            <h3 class="font-bold text-gray-900">Social</h3>
                            <ul class="list-reset items-center pt-3">
                                <li>
                                    <a class="inline-block no-underline hover:text-black hover:underline py-1" href="#">Add social links</a>
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