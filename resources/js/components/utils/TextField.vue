<script setup>
import { computed, defineProps, onMounted, onUnmounted, ref } from 'vue';
import { SizeEnum } from "../../type/global.js";
import { vMaska } from "maska/vue";

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
    },
    required: {
        type: Boolean,
        default: false
    }
});

const emit = defineEmits(["update:modelValue", "validation"]);

const isSmallScreen = ref(window.innerWidth < 820);
const isInvalid = ref(false); // Estado para controlar se o campo é inválido

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

const validateField = (value) => {
    if (props.required && !value) {
        isInvalid.value = true;
        emit('validation', false);
    } else {
        isInvalid.value = false;
        emit('validation', true);
    }
};

const handleInput = (event) => {
    const value = event.target.value;
    emit('update:modelValue', value);
    validateField(value);
};
</script>

<template>
    <div :style="{ width: fieldSize }" class="flex flex-col">
        <label class="text-[12px] font-[#262626] font-medium">{{ label }}</label>
        <input
            class="bg-[#F8F8F8] border border-[#e1e1e1] text-[14px] h-[36px] rounded-md pl-3 outline-none"
            :class="{ 'border-red-500': isInvalid }"
            :placeholder="placeholder"
            :value="modelValue"
            @input="handleInput"
            @blur="validateField(modelValue);"
            type="text"
            v-maska="mask"
        />
        <span v-if="isInvalid" class="text-red-500 text-[10px] mt-1">Este campo é obrigatório.</span>
    </div>
</template>

<style scoped>
</style>
