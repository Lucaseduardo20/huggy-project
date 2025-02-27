<script setup lang="ts">
import {defineProps, ref} from "vue";

const props = defineProps({
    title: {
        type: String,
        required: true,
    }
})

</script>

<template>
    <div class="flex items-center h-[64px]">
        <h2 class="text-[20px]/28 tracking-[0.15px]">
            {{title}}
        </h2>
    </div>
</template>

<style scoped>

</style>
