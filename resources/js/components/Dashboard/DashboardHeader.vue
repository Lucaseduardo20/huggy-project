<script setup>
import Back from '../icons/Back.vue';
import {useRouter} from "vue-router";;

const router = useRouter();
</script>

<template>
    <div class="w-full h-[80px]">
        <button @click="router.push('/home')" id="back-button" class="w-[96px] h-[36px] flex gap-1 items-center justify-center rounded-lg hover:bg-gray-100 transition-hover">
            <Back></Back>
            <span class="text-[#505050]">Voltar</span>
        </button>
    </div>
</template>

<style scoped>

</style>
