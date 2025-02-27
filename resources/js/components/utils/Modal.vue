<script setup>
import {defineProps, watch} from 'vue'
    const props = defineProps({
        trigger: {
            type: Boolean,
            default: false,
            required: true
        }
    })

watch(() => props.trigger, (newVal) => {
    if (newVal) {
        document.body.style.overflow = 'hidden'
    } else {
        document.body.style.overflow = ''
    }
})

</script>

<template>
    <div
        v-if="trigger"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center overflow-y-scroll"
    >
        <slot name="content" />
    </div>
</template>

<style scoped>

</style>
