<template>
  <div>
    <div
      v-show="open"
      class="absolute top-0 right-0 w-full h-full opacity-0"
      @click="open = false"
    />
    <div class="relative">
        <a href="#" @click.prevent="open = !open">
            <slot />
        </a>
        <div
            v-show="open"
            class="absolute text-left right-0 border mt-2 py-2 w-64 bg-white rounded-lg shadow-full"
        >
            <component
                v-for="(m, index) in menu"
                :key="index"
                :is="m.tag || `a`"
                :to="m.to || null"
                :href="m.href || null"
                class="block px-3 py-2 text-gray-800 hover:opacity-75"
                @click="onClick(m)"
            >

                <font-awesome-icon
                    v-if="m.icon"
                    :icon="m.icon"
                />
                {{ m.label }}
            </component>
        </div>
    </div>
  </div>
</template>


<script>
export default {
    props: {
        menu: {
            type: Array,
            require: true,
            default: [],
        },
    },
    data() {
        return {
            open: false
        }
    },
    methods: {
        onClick(m) {
            if (m.handleClick) {
                m.handleClick()
            }
        }
    }
}
</script>
