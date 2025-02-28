<script setup lang="ts">
import { ref, computed, onBeforeMount } from 'vue';
import Search from "../icons/Search.vue";
import Button from "../utils/Button.vue";
import Add from "../icons/Add.vue";
import Insight from "../icons/Insight.vue";
import Trash from '../icons/Trash.vue'
import Pencil from "../icons/Pencil.vue";
import {MoveDown, MoveUp} from "lucide-vue-next";
import Modal from '../utils/Modal.vue'
import { VueFinalModal, useModal } from 'vue-final-modal'
import AddClient from "./AddClient.vue";
import {getClients} from "../../service/services";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';

const notify = (message, timer, type) => {
    toast(message, {
        type: type,
        autoClose: timer,
    });
}

const contacts = ref([]);

const rowsState = ref<Record<number, boolean>>({});

const currentPage = ref(1);
const itemsPerPage = ref(10);

const sortColumn = ref('name');
const sortDirection = ref('asc');
const searchTerm = ref('');
const isModalOpen = ref(false);
const loading = ref(true);

const sortedContacts = computed(() => {
    return [...filteredContacts.value].sort((a, b) => {
        const aValue = a[sortColumn.value];
        const bValue = b[sortColumn.value];
        if (aValue < bValue) return sortDirection.value === 'asc' ? -1 : 1;
        if (aValue > bValue) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });
});

const openAddModal = () => {
    isModalOpen.value = true;
}

const sortBy = (column: string) => {
    if (sortColumn.value === column) {
        sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    } else {
        sortColumn.value = column;
        sortDirection.value = 'asc';
    }
};

const paginatedContacts = computed(() => {
    const start = (currentPage.value - 1) * itemsPerPage.value;
    const end = start + itemsPerPage.value;
    return sortedContacts.value.slice(start, end);
});

const changePage = (page: number) => {
    currentPage.value = page;
};

const handleOpenActions = (key: number) => {
    rowsState.value[key] = true;
};

const handleCloseActions = (key: number) => {
    rowsState.value[key] = false;
};

const filteredContacts = computed(() => {
    if (!searchTerm.value) {
        return contacts.value;
    }

    const term = searchTerm.value.toLowerCase();
    return contacts.value.filter(contact => {
        return (
            contact.name.toLowerCase().includes(term) ||
            contact.email.toLowerCase().includes(term) ||
            contact.phone.toLowerCase().includes(term)
        );
    });
});

const getData = async () => {
    const response = await getClients();
    if(!response.status !== 201){
        return notify('Erro ao buscar dados.', 2000, 'error');
    }

    contacts.value = response.data;
    loading.value = false;
}


onBeforeMount(() => {
    getData();
})
</script>

<template>
    <div class="w-full flex flex-col gap-8">
        <div class="flex justify-between">
            <div class="search-input w-[250px] h-[36px] rounded-[8px] border border-[#e1e1e1] bg-[#f8f8f8] flex items-center justify-around">
                <Search />
                <input v-model="searchTerm" type="text" class="bg-transparent border-0 text-[14px] w-[198px] outline-none" placeholder="Buscar contato">
            </div>
            <div class="flex items-center gap-[8px]">
                <Button @click="openAddModal()" width="198px" label="Adicionar contato">
                    <template v-slot:icon>
                        <Add />
                    </template>
                </Button>
                <button class="insight-button flex items-center justify-center rounded-3xl transition-hover">
                    <Insight />
                </button>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full h-auto">
                <thead class="text-gray-600 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left ths cursor-pointer" @click="sortBy('name')">
                        <div class="flex items-center">
                            Nome
                            <MoveDown size="12" v-if="sortColumn === 'name' && sortDirection === 'asc'" />
                            <MoveUp size="12" v-if="sortColumn === 'name' && sortDirection === 'desc'" />
                        </div>
                    </th>
                    <th class="px-4 py-2 text-left ths cursor-pointer" @click="sortBy('email')">
                        <div class="flex items-center">
                            E-mail
                            <MoveDown size="12" v-if="sortColumn === 'email' && sortDirection === 'asc'" />
                            <MoveUp size="12" v-if="sortColumn === 'email' && sortDirection === 'desc'" />
                        </div>
                    </th>
                    <th class="px-4 py-2 text-left ths cursor-pointer" @click="sortBy('phone')">
                        <div class="flex items-center">
                            Telefone
                            <MoveDown size="12" v-if="sortColumn === 'phone' && sortDirection === 'asc'" />
                            <MoveUp size="12" v-if="sortColumn === 'phone' && sortDirection === 'desc'" />
                        </div>
                    </th>
                    <th class="px-4 py-2 text-center ths"></th>
                </tr>

                </thead>
                <tbody class="min-h-[1000px]">
                <tr v-if="contacts.length > 0" v-for="contact in paginatedContacts" :key="contact.id" class="hover:bg-gray-50 h-[64px] max-h-[64px]"
                    @mouseenter="handleOpenActions(contact.id)"
                    @mouseleave="handleCloseActions(contact.id)"
                >
                    <td class="px-4 table-data flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#180D6E] font-bold font-roboto">
                            {{ contact.avatar }}
                        </div>
                        <span>{{ contact.name }}</span>
                    </td>
                    <td class="px-4 table-data">{{ contact.email || '-' }}</td>
                    <td class="px-4 table-data">{{ contact.phone || '-' }}</td>
                    <td class="px-4 table-data space-x-2 min-w-[83px]">
                        <div class="w-full h-full flex justify-center gap-1.5">
                            <button v-if="rowsState[contact.id]" class="text-gray-500">
                                <Pencil />
                            </button>
                            <button v-if="rowsState[contact.id]" class="text-gray-500 hover:text-red-500">
                                <Trash />
                            </button>
                        </div>
                    </td>
                </tr>
                <tr v-else class=" w-full">
                    <td colspan="4" class="w-full h-full">
                        <div class="h-[500px] flex flex-col items-center justify-center gap-4">
                            <img class="w-[200px] h-[200px]" src="../../../../public/assets/book.png">
                            <span class=" text-[#757575]">{{`${loading ? 'Buscando dados...' : 'Ainda não há contatos'}`}}</span>
                            <Button @click="openAddModal()" width="198px" label="Adicionar contato">
                                <template v-slot:icon>
                                    <Add />
                                </template>
                            </Button>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="flex justify-center items-center gap-4">
            <button
                v-for="page in Math.ceil(contacts.length / itemsPerPage)"
                :key="page"
                @click="changePage(page)"
                :class="['px-3 py-1 rounded', currentPage === page ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700']"
            >
                {{ page }}
            </button>
        </div>
        <Modal v-model:trigger="isModalOpen">
            <template v-slot:content>
                <AddClient @close="isModalOpen = false"/>
            </template>
        </Modal>
    </div>
</template>

<style scoped>
.insight-button {
    width: 30px;
    height: 30px;

    &:hover {
        background-color: #cbd5e0;
    }
}

.table-data {
    font-family: Roboto, sans-serif;
    font-size: 14px;
    line-height: 18px;
    height: 64px;
    letter-spacing: 0.25px;
    color: #262626;
}

.ths {
    color: #505050;
    font-size: 12px;
    font-family: Roboto, sans-serif;
    letter-spacing: 0.4px;
}

@media (max-width: 768px) {
    .flex.justify-between {
        flex-direction: column;
        gap: 16px;
    }


    .overflow-x-auto {
        overflow-x: auto;
    }

    table {
        min-width: 600px;
    }
}

@media (max-width: 368px) {
    .search-input {
        width: 180px !important;

        input {
            width: 140px;
        }
    }
}
</style>
