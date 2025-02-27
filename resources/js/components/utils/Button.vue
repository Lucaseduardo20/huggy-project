<script setup lang="ts">
import {computed, defineProps, defineEmits} from 'vue'
const props = defineProps({
    width: {
        type: String,
        default: '200px'
    },
    height: {
        type: String,
        default: '36px'
    },
    label: {
        type: String,
        default: '',
    },
    labelColor: {
        type: String,
        default: '#fff'
    }
})

console.log(props.label)

const emit = defineEmits(['click'])

</script>

<template>
    <button
        class="rounded-[8px] px-4 transition-hover tracking-[1.25px] py-2 bg-[#321BDE] flex items-center justify-between font-[500] text-[14px] font-roboto
                hover:bg-blue-600"
        :style="{width: width, height: height, color: labelColor}"
        @click="emit('click')"
    >
        <slot name="icon"></slot>
        {{label}}
    </button>
</template>

<style scoped>

</style>
