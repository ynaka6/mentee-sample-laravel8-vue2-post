<template>
    <div class="flex flex-wrap">
        <div
            v-for="(image, index) in images"
            :key="index"
            class="h-32 w-1/2"
        >
            <div
                class="border h-full w-full bg-gray-100 bg-center bg-cover"
                :style="{ backgroundImage: `url('${image}')` }"
            />
        </div>
    </div>
</template>

<script>
export default {
    props: {
        images: {
            type: Array,
            require: true,
            default: () => [],
        },
    },
}
</script>