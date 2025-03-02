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
import {deleteClient, getClients} from "../../service/client";
import {useRouter} from "vue-router";
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css';
import EditClient from "./EditClient.vue";
import {Client} from "../../type/client";
import X from '../icons/X.vue'

const notify = (message, timer, type) => {
    toast(message, {
        type: type,
        autoClose: timer,
    });
}

const router = useRouter();

const contacts = ref([]);

const rowsState = ref<Record<number, boolean>>({});

const currentPage = ref(1);
const itemsPerPage = ref(10);

const sortColumn = ref('name');
const sortDirection = ref('asc');
const searchTerm = ref('');
const addClientModal = ref(false);
const editClientModal = ref(false);
const deleteClientModal = ref(false);
const editingClient = ref({});
const deletingClient = ref({});
const viewClientModal = ref(false);
const viewingClient = ref({});
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

const openEditModal = (client) => {
    editClientModal.value = true;
    editingClient.value = client;
}

const viewEdit = (client: Client) => {
    viewClientModal.value = false
    openEditModal(client);
}

const viewDelete = (client) => {
    viewClientModal.value = false;
    openDeleteModal(client);
}

const openAddModal = () => {
    addClientModal.value = true;
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

const goToDashboard = () => {
    router.push('/dashboard');
};

const openDeleteModal = (client: Client) => {
    deletingClient.value = client;
    deleteClientModal.value = true;
}

const openViewModal = (client) => {
    viewingClient.value = client;
    viewClientModal.value = true;
}

const remove = async () => {
    return await deleteClient(deletingClient.value.id).then((res) => {
        deleteClientModal.value = false;
        notify(res.data.message, 2000, 'info')
        setTimeout(() => {
            window.location.reload();
        }, 2000)
    }).catch((error) => {
        notify(error.message, 2000, 'info')
    })
}

const getData = async () => {
    const response = await getClients();
    if(response.status !== 200){
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
                <button @click="goToDashboard" class="insight-button flex items-center justify-center rounded-3xl transition-hover">
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
                    <td @click="openViewModal(contact)"  class="px-4 table-data flex items-center space-x-2">
                        <div class="w-8 bg-gray-100 h-8 rounded-full flex items-center justify-center text-[#180D6E] font-bold font-roboto">
                            {{ contact.avatar }}
                        </div>
                        <span>{{ contact.name }}</span>
                    </td>
                    <td @click="openViewModal(contact)"  class="px-4 table-data">{{ contact.email || '-' }}</td>
                    <td @click="openViewModal(contact)"  class="px-4 table-data">{{ contact.phone || '-' }}</td>
                    <td class="px-4 table-data space-x-2 min-w-[83px]">
                        <div class="w-full h-full flex justify-center gap-1.5">
                            <button @click="openEditModal(contact)" v-if="rowsState[contact.id]" class="text-gray-500">
                                <Pencil />
                            </button>
                            <button @click="openDeleteModal(contact)" v-if="rowsState[contact.id]" class="text-gray-500 hover:text-red-500">
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
        <Modal v-model:trigger="addClientModal">
            <template v-slot:content>
                <AddClient @close="addClientModal = false"/>
            </template>
        </Modal>
        <Modal v-model:trigger="editClientModal">
            <template v-slot:content>
                <EditClient :client-editing="editingClient" @close="editClientModal = false"/>
            </template>
        </Modal>
        <Modal v-model:trigger="deleteClientModal">
            <template v-slot:content>
                <div class="bg-white w-[360px] h-[144px] rounded-2xl p-5">
                    <div class="w-full h-1/2 flex items-center">
                        <h2>Excluir este contato?</h2>
                    </div>
                    <div class="w-full h-1/2 flex items-end justify-end">
                        <button @click="deleteClientModal = false" class="w-[89px] h-[36px] rounded-xl hover:bg-gray-200 transition-hover text-[#505050]">Cancelar</button>
                        <button @click="remove()" class="w-[74px] h-[36px] rounded-xl hover:bg-gray-200 transition-hover text-[#DE321B]">Excluir</button>
                    </div>
                </div>
            </template>
        </Modal>
        <Modal v-model:trigger="viewClientModal">
            <template v-slot:content>
                <div class="relative rounded-2xl bg-white p-2 w-[300px] h-[420px] md:w-[610px] md:h-[312px]">
                    <button @click="viewClientModal = false" class="absolute right-1">
                        <X></X>
                    </button>
                    <div class="h-1/4 border-b flex flex-col items-center gap-3 md:flex-row md:w-full  md:justify-around">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[#180D6E] font-bold font-roboto bg-gray-100">
                            {{ viewingClient.avatar }}
                        </div>
                        <h4 class="font-roboto font-bold">{{viewingClient.name}}</h4>
                        <div class="w-full h-full flex justify-center gap-5 md:w-[100px]">
                            <button @click="viewEdit(viewingClient)" class="text-gray-500">
                                <Pencil />
                            </button>
                            <button @click="viewDelete(viewingClient)" class="text-gray-500">
                                <Trash />
                            </button>
                        </div>
                    </div>
                    <div class="h-3/4 flex flex-col w-full items-center justify-evenly">
                        <div class="flex items-center gap-4 w-[270px] md:w-[500px]">
                            <span class="text-[12px] text-[#757575] w-2/6 md:w-1/6">Email: </span>
                            <span class="text-[14px] text-[#262626] text-center w-au md:text-leftto">{{viewingClient.email}}</span>
                        </div>
                        <div class="flex items-center gap-4 w-[270px] md:w-[500px]">
                            <span class="text-[12px] text-[#757575] w-2/6 md:w-1/6">Endereço: </span>
                            <span class="text-[14px] text-[#262626] text-center w-auto md:text-left">{{viewingClient.address}}</span>
                        </div>
                        <div class="flex items-center gap-4 w-[270px] md:w-[500px]">
                            <span class="text-[12px] text-[#757575] w-2/6 md:w-1/6">Data de Nascimento: </span>
                            <span class="text-[14px] text-[#262626] text-center w-auto md:text-left">{{viewingClient.birthday}}</span>
                        </div>
                        <div class="flex items-center gap-4 w-[270px] md:w-[500px]">
                            <span class="text-[12px] text-[#757575] w-2/6 md:w-1/6">Estado: </span>
                            <span class="text-[14px] text-[#262626] text-center w-aut md:text-lefto">{{viewingClient.state}}</span>
                        </div>
                        <div class="flex items-center gap-4 w-[270px] md:w-[500px]">
                            <span class="text-[12px] text-[#757575] w-2/6 md:w-1/6">Cidade: </span>
                            <span class="text-[14px] text-[#262626] text-center w-aut md:text-lefto">{{viewingClient.city}}</span>
                        </div>
                    </div>
                </div>
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
