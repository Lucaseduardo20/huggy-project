<script setup>
import {defineProps} from 'vue'
    const props = defineProps({
        trigger: {
            type: Boolean,
            default: false,
            required: true
        }
    })

const emit = defineEmits(['update:trigger'])

const closeModal = () => {
    emit('update:trigger', false)
}
</script>

<template>
    <div
        v-if="trigger"
        class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
        @click="closeModal"
    >
        <slot name="content" />
    </div>
</template>

<style scoped>

</style>
