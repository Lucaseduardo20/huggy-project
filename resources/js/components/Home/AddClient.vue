<script setup lang="ts">
import {defineProps, ref, onMounted, onUnmounted} from 'vue';
import {SizeEnum} from "../../type/global.js";
import TextField from "../utils/TextField.vue";
import Button from "../utils/Button.vue";
import {Client} from "../../type/client";
import {store} from "../../service/services";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const notify = (message, timer, type) => {
    toast(message, {
        type: type,
        autoClose: timer,
    });
}

const props = defineProps({
    modalTrigger: {
        type: Boolean
    }
})

const emit = defineEmits(['close'])

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

const validate = () => {
    const requiredFields = [
        { field: formData.value.name, message: 'O campo Nome é obrigatório.' },
        { field: formData.value.email, message: 'O campo Email é obrigatório.' },
        { field: formData.value.phone, message: 'O campo Celular é obrigatório.' },
        { field: formData.value.address, message: 'O campo Endereço é obrigatório.' },
        { field: formData.value.neighborhood, message: 'O campo Bairro é obrigatório.' },
        { field: formData.value.state, message: 'O campo Estado é obrigatório.' }
    ];

    for (const requiredField of requiredFields) {
        if (!requiredField.field) {
            notify(requiredField.message, 2000, 'error');
            return false;
        }
    }
}

const storeClient = async () => {
    if(!validate()) return;
    const response = await store(formData.value as Client);
    if(response.status !== 201) {
        return notify(response.data.message, 2000, 'error');
    }
    return notify('Contato adicionado com sucesso!', 2000, 'success');

}

const formData = ref<Client>({
    name: '',
    email: '',
    tel: '',
    phone: '',
    address: '',
    neighborhood: '',
    state: ''
});

const clearForm = () => {
    formData.value = {
        name: '',
        email: '',
        tel: '',
        phone: '',
        address: '',
        neighborhood: '',
        state: ''
    };
};
</script>

<template>
    <div class="w-7/12 bg-white rounded-md p-3 my-5 min-w-[300px]">
        <div class="w-full h-[76px] border-b border-gray-200 flex items-center">
            <h2 class="text-[#262626] text-[20px]">Adicionar novo contato</h2>
        </div>
        <div class="w-full flex flex-col gap-8 pb-3">
            <TextField :required="true" v-model="formData.name" placeholder="Nome Completo" label="Nome"></TextField>
            <TextField :required="true" v-model="formData.email" placeholder="Email" label="Email"></TextField>
            <TextField mask="(##) ####-####" v-model="formData.tel" :size="SizeEnum.sm" placeholder="Telefone" label="Telefone"></TextField>
            <TextField :required="true" mask="(##) #####-####" v-model="formData.phone" :size="SizeEnum.sm" placeholder="Celular" label="Celular"></TextField>
            <TextField :required="true" v-model="formData.address" :size="SizeEnum.lg" placeholder="Endereço" label="Endereço"></TextField>
            <div class="w-3/5 flex gap-5 flex-col sm:flex-row">
                <TextField :required="true" v-model="formData.neighborhood" placeholder="Bairro" label="Bairro"></TextField>
                <div :style="{ width: SizeEnum.x_sm }" class="flex flex-col">
                    <label class="text-[12px] font-[#262626] font-medium">Estado</label>
                    <select
                        class="bg-[#F8F8F8] border border-[#e1e1e1] text-[14px] h-[36px] rounded-md pl-3 outline-none"
                        v-model="formData.state"
                    >
                        <option v-for="option in states" :value="option.value">{{ option.label }}</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="flex items-center justify-end pr-8 gap-1 border-t border-gray-200 h-[50px]">
            <button
                class="w-[100px] h-[36px] bg-white text-gray-500 rounded-xl hover:bg-gray-200 transition-hover font-medium"
                @click="emit('close')"
            >
                Cancelar
            </button>
            <button
                class="w-[70px] h-[36px] bg-[#321BDE] text-white rounded-xl hover:bg-blue-950 transition-hover font-medium"
                @click="storeClient"
            >
                Salvar
            </button>
        </div>
    </div>
</template>

<style scoped>

</style>
