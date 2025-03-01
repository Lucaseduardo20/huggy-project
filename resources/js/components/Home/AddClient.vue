<script setup lang="ts">
import {defineProps, ref, onMounted, onUnmounted, computed} from 'vue';
import {SizeEnum} from "../../type/global.js";
import TextField from "../utils/TextField.vue";
import Button from "../utils/Button.vue";
import {Client} from "../../type/client";
import {store} from "../../service/client";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import jsonData from '../../json/brazil.json'

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

const validate = () => {
    const requiredFields = [
        { field: formData.value.name, message: 'O campo Nome é obrigatório.' },
        { field: formData.value.email, message: 'O campo Email é obrigatório.' },
        { field: formData.value.birthday, message: 'O campo Data de Nascimento é obrigatório.' },
        { field: formData.value.phone, message: 'O campo Celular é obrigatório.' },
        { field: formData.value.address, message: 'O campo Endereço é obrigatório.' },
        { field: formData.value.city, message: 'O campo Cidade é obrigatório.' },
        { field: formData.value.state, message: 'O campo Estado é obrigatório.' }
    ];

    for (const requiredField of requiredFields) {
        if (!requiredField.field) {
            notify(requiredField.message, 2000, 'error');
            return false;
        }
    }

    return true;
}

const storeClient = async () => {
    if(!validate()) return;
    const response = await store(formData.value as Client);
    if(response.status !== 201) {
        return notify(response.data.message, 2000, 'error');
    }
    emit('close');
    clearForm();
    window.location.reload();
    return notify('Contato adicionado com sucesso!', 2000, 'success');

}
const cities = computed(() => {
    const selectedState = states.value.find((s) => s.value === formData.value.state);
    return selectedState ? selectedState.cities : [];
});

const states = computed(() =>
    jsonData.states.map((state) => ({
        value: state.uf,
        label: state.name,
        cities: state.cities,
    }))
);

const formData = ref<Client>({
    name: '',
    email: '',
    phone: '',
    address: '',
    birthday: '',
    city: '',
    state: ''
});

const clearForm = () => {
    formData.value = {
        name: '',
        email: '',
        phone: '',
        address: '',
        city: '',
        birthday: '',
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
            <TextField mask="##/##/####" v-model="formData.birthday" :size="SizeEnum.sm" placeholder="Data de Nascimento" label="Data de Nascimento"></TextField>
            <TextField :required="true" mask="(##) #####-####" v-model="formData.phone" :size="SizeEnum.sm" placeholder="Celular" label="Celular"></TextField>
            <TextField :required="true" v-model="formData.address" :size="SizeEnum.lg" placeholder="Endereço" label="Endereço"></TextField>
            <div class="w-3/5 flex gap-5 flex-col sm:flex-row">
                <div :style="{ width: '100%' }" class="flex flex-col">
                    <label class="text-[12px] font-medium text-[#262626]">Estado</label>
                    <select
                        class="bg-[#F8F8F8] border border-[#e1e1e1] text-[14px] h-[36px] rounded-md pl-3 outline-none"
                        v-model="formData.state"
                    >
                        <option value="" disabled>Estado</option>
                        <option v-for="state in states" :key="state.value" :value="state.value">
                            {{ state.label }}
                        </option>
                    </select>
                </div>
                <div :style="{ width: '100%' }" class="flex flex-col">
                    <label class="text-[12px] font-medium text-[#262626]">Cidade</label>
                    <select
                        class="bg-[#F8F8F8] border border-[#e1e1e1] text-[14px] h-[36px] rounded-md pl-3 outline-none"
                        v-model="formData.city"
                        :disabled="!formData.state"
                    >
                        <option value="" disabled>Cidade</option>
                        <option v-if="formData.state === 'SP'" value="São Paulo">São Paulo</option>
                        <option v-for="city in cities" :key="city" :value="city">
                            {{ city }}
                        </option>
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
