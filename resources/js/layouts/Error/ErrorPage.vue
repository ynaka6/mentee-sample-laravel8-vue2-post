<template>
    <section :title="`${status} Error`" class="max-w-lg mx-auto flex-grow">
        <div class="my-10">
            <svg
                width="104"
                height="104"
                xmlns="http://www.w3.org/2000/svg"
                class="mx-auto"
            >
                <g
                    id="Asset-Artboard-Page"
                    stroke="none"
                    stroke-width="1"
                    fill="none"
                    fill-rule="evenodd"
                >
                    <g id="icon_face">
                        <path
                            id="Fill-5"
                            d="M52 71.5c3.163 0 6.023.823 8.537 2.297.52-.607 3.726-4.247 4.376-4.94A23.353 23.353 0 0052 65c-4.81 0-9.23 1.43-12.957 3.813 4.204 4.724.044.087 4.377 4.94 2.557-1.43 5.417-2.253 8.58-2.253m0 15.167c-19.153 0-34.667-15.514-34.667-34.667 0-19.153 15.514-34.667 34.667-34.667 19.153 0 34.667 15.514 34.667 34.667 0 19.153-15.514 34.667-34.667 34.667m-.043-78C75.92 8.667 95.333 28.08 95.333 52c0 23.92-19.413 43.333-43.376 43.333-23.92 0-43.29-19.413-43.29-43.333 0-23.92 19.37-43.333 43.29-43.333zM35.75 39a5.414 5.414 0 00-5.417 5.417 5.414 5.414 0 005.417 5.416 5.414 5.414 0 005.417-5.416A5.414 5.414 0 0035.75 39zm30.333 0a5.416 5.416 0 100 10.833 5.416 5.416 0 000-10.833z"
                            fill="#777"
                        ></path>
                        <path
                            id="Oval"
                            d="M67.167 78a8.667 8.667 0 008.666-8.667c0-3.19-2.889-8.968-8.666-17.333-5.778 8.365-8.667 14.142-8.667 17.333A8.667 8.667 0 0067.167 78z"
                            fill="#A3D1F1"
                        ></path>
                    </g>
                </g>
            </svg>
        </div>
        <h2 class="text-gray-550 font-roboto text-center">
            {{ status }} Error
        </h2>
        <p class="font-sans text-xs text-gray-550 text-center mt-10">
            お探しのページを見つけることができませんでした<br />
            URLが削除されたか移動した可能性があります<br />
            サイトのTOPからお探しください
        </p>
        <t-button
            type="button"
            to="/"
            variant="primary"
            size="lg"
            class="mt-10 w-full"
        >
            トップページに戻る
        </t-button>
    </section>
</template>

<script>
export default {
    props: {
        status: {
            type: Number,
            require: true,
            default: 500,
        },
    },
}
</script>