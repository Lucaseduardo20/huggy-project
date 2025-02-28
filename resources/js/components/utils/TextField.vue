<script setup>
import { computed, defineProps, onMounted, onUnmounted, ref } from 'vue';
import { SizeEnum } from "../../type/global.js";
import { vMaska } from "maska/vue"
const props = defineProps({
    label: {
        type: String,
        required: true
    },
    modelValue: {
        required: true
    },
    placeholder: {
        type: String,
        required: false
    },
    size: {
        required: false,
        default: SizeEnum.md
    },
    mask: {
        type: [String, Array],
        required: false,
        default: null
    }
});

const emit = defineEmits(["update:modelValue"]);

const isSmallScreen = ref(window.innerWidth < 820);

const updateScreenSize = () => {
    isSmallScreen.value = window.innerWidth < 820;
};

onMounted(() => {
    window.addEventListener('resize', updateScreenSize);
});

onUnmounted(() => {
    window.removeEventListener('resize', updateScreenSize);
});

const fieldSize = computed(() => {
    return isSmallScreen.value ? SizeEnum.sm : props.size;
});

const handleInput = (event) => {
    emit('update:modelValue', event.target.value);
};
</script>

<template>
    <div :style="{ width: fieldSize }" class="flex flex-col">
        <label class="text-[12px] font-[#262626] font-medium">{{ label }}</label>
        <input
            class="bg-[#F8F8F8] border border-[#e1e1e1] text-[14px] h-[36px] rounded-md pl-3 outline-none"
            :placeholder="placeholder"
            :value="modelValue"
            @input="handleInput"
            type="text"
            v-maska="mask"
        />
    </div>
</template>

<style scoped>
</style>
