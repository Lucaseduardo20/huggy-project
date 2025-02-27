<script setup lang="ts">
import { computed, defineProps, defineEmits } from 'vue';

const props = defineProps({
    width: {
        type: String,
        default: '200px',
    },
    height: {
        type: String,
        default: '36px',
    },
    label: {
        type: String,
        default: '',
    },
    labelColor: {
        type: String,
        default: '#fff',
    },
});

const emit = defineEmits(['click']);
</script>

<template>
    <button
        class="button"
        :style="{ width: width, height: height, color: labelColor }"
        @click="emit('click')"
    >
        <slot name="icon"></slot>
        {{ label }}
    </button>
</template>

<style scoped>
.button {
    border-radius: 8px;
    padding: 0 16px;
    transition: background-color 0.3s ease;
    letter-spacing: 1.25px;
    background-color: #321BDE;
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-weight: 500;
    font-size: 14px;
    font-family: 'Roboto', sans-serif;
    cursor: pointer;
    border: none;
    outline: none;
}

.button:hover {
    background-color: #2a15c7;
}

@media (max-width: 768px) {
    .button {
        width: 100%;
        height: auto;
        padding: 8px 16px;
        font-size: 12px;
    }
}

@media (max-width: 480px) {
    .button {
        font-size: 10px;
        padding: 6px 12px;
        width: 150px !important;
    }
}
</style>
