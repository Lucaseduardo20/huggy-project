<script setup>
import {defineProps, ref, onMounted, onUnmounted} from 'vue';
import {SizeEnum} from "../../type/global.js";
import TextField from "../utils/TextField.vue";
import Button from "../utils/Button.vue";

const props = defineProps({
    modalTrigger: {
        type: Boolean
    }
})

const emit = defineEmits(['close'])

const name = ref('')
const email = ref('')
const tel = ref('')
const phone = ref('')
const address = ref('')
const neighborhood = ref('')
const state = ref('')
const states = [
    { value: "AC", label: "Acre" },
    { value: "AL", label: "Alagoas" },
    { value: "AP", label: "Amapá" },
    { value: "AM", label: "Amazonas" },
    { value: "BA", label: "Bahia" },
    { value: "CE", label: "Ceará" },
    { value: "DF", label: "Distrito Federal" },
    { value: "ES", label: "Espírito Santo" },
    { value: "GO", label: "Goiás" },
    { value: "MA", label: "Maranhão" },
    { value: "MT", label: "Mato Grosso" },
    { value: "MS", label: "Mato Grosso do Sul" },
    { value: "MG", label: "Minas Gerais" },
    { value: "PA", label: "Pará" },
    { value: "PB", label: "Paraíba" },
    { value: "PR", label: "Paraná" },
    { value: "PE", label: "Pernambuco" },
    { value: "PI", label: "Piauí" },
    { value: "RJ", label: "Rio de Janeiro" },
    { value: "RN", label: "Rio Grande do Norte" },
    { value: "RS", label: "Rio Grande do Sul" },
    { value: "RO", label: "Rondônia" },
    { value: "RR", label: "Roraima" },
    { value: "SC", label: "Santa Catarina" },
    { value: "SP", label: "São Paulo" },
    { value: "SE", label: "Sergipe" },
    { value: "TO", label: "Tocantins" }
];
</script>

<template>
    <div class="w-7/12 bg-white rounded-md p-3 my-5 min-w-[300px]">
        <div class="w-full h-[76px] border-b border-gray-200 flex items-center">
            <h2 class=" text-[#262626] text-[20px]">Adicionar novo contato</h2>
        </div>
        <div class="w-full flex flex-col gap-8 pb-3">
            <TextField :value="name" placeholder="Nome Completo" label="Nome"></TextField>
            <TextField :value="email" placeholder="Email" label="Email"></TextField>
            <TextField :size="SizeEnum.sm" :value="tel" placeholder="Telefone" label="Telefone"></TextField>
            <TextField :size="SizeEnum.sm" :value="phone" placeholder="Celular" label="Celular"></TextField>
            <TextField :size="SizeEnum.lg":value="name" placeholder="Endereço" label="Endereço"></TextField>
            <div class="w-3/5 flex gap-5 flex-col sm:flex-row">
                <TextField :value="name" placeholder="Bairro" label="Bairro"></TextField>
                <div :style="{width: SizeEnum.x_sm}" class="flex flex-col">
                    <label class="text-[12px] font-[#262626] font-medium">Endereço</label>
                    <select class="bg-[#F8F8F8] border border-[#e1e1e1] text-[14px] h-[36px] rounded-md pl-3 outline-none" v-model="address">
                        <option v-for="option in states" value="option.value">{{option.label}}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end pr-8 gap-1 border-t border-gray-200 h-[50px]">
            <button class="w-[100px] h-[36px] bg-white text-gray-500 rounded-xl hover:bg-gray-200 transition-hover font-medium" @click="emit('close')">Cancelar</button>
            <button class="w-[70px] h-[36px] bg-[#321BDE] text-white rounded-xl hover:bg-blue-950 transition-hover font-medium">Salvar</button>

        </div>
    </div>
</template>

<style scoped>

</style>
