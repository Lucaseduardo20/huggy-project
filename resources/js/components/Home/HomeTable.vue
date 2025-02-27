<script setup lang="ts">
import { ref, computed } from 'vue';
import Search from "../icons/Search.vue";
import Button from "../utils/Button.vue";
import Add from "../icons/Add.vue";
import Insight from "../icons/Insight.vue";

const contacts = ref([
    { id: 1, avatar: "HG", name: "Henrique Gomes Santana", email: "henrique.gomes@huggy.io", phone: "75992503245" },
    { id: 2, avatar: "RM", name: "Rafael Macedo", email: "rafael.macedo@huggy.io", phone: "-" },
    { id: 3, avatar: "PG", name: "Philippe Gomes Santana", email: "-", phone: "75992514121" },
    { id: 4, avatar: "LM", name: "Lucas Matos", email: "lucas.matos@huggy.io", phone: "75991457893" },
    { id: 5, avatar: "CS", name: "Carla Silva", email: "carla.silva@huggy.io", phone: "-" },
    { id: 6, avatar: "FT", name: "Fernando Torres", email: "-", phone: "75991234567" },
    { id: 7, avatar: "AB", name: "Ana Beatriz", email: "ana.beatriz@huggy.io", phone: "75995672389" },
]);

const currentPage = ref(1);
const itemsPerPage = ref(5);

const sortColumn = ref('name');
const sortDirection = ref('asc');

const sortedContacts = computed(() => {
    return [...contacts.value].sort((a, b) => {
        const aValue = a[sortColumn.value];
        const bValue = b[sortColumn.value];
        if (aValue < bValue) return sortDirection.value === 'asc' ? -1 : 1;
        if (aValue > bValue) return sortDirection.value === 'asc' ? 1 : -1;
        return 0;
    });
});

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
</script>

<template>
    <div class="w-full flex flex-col gap-8">
        <!-- Barra de busca e botões -->
        <div class="flex justify-between">
            <div class="w-[250px] h-[36px] rounded-[8px] border border-[#e1e1e1] bg-[#f8f8f8] flex items-center justify-around">
                <Search />
                <input type="text" class="bg-transparent border-0 text-[14px] font-roboto w-[198px] outline-none" placeholder="Buscar contato">
            </div>
            <div class="flex items-center gap-[8px]">
                <Button width="198px" label="Adicionar contato">
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
            <table class="min-w-full">
                <thead class="text-gray-600 border-b border-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left ths cursor-pointer" @click="sortBy('name')">
                        Nome {{ sortColumn === 'name' ? (sortDirection === 'asc' ? '▲' : '▼') : '' }}
                    </th>
                    <th class="px-4 py-2 text-left ths cursor-pointer" @click="sortBy('email')">
                        Email {{ sortColumn === 'email' ? (sortDirection === 'asc' ? '▲' : '▼') : '' }}
                    </th>
                    <th class="px-4 py-2 text-left ths cursor-pointer" @click="sortBy('phone')">
                        Telefone {{ sortColumn === 'phone' ? (sortDirection === 'asc' ? '▲' : '▼') : '' }}
                    </th>
                    <th class="px-4 py-2 text-center ths">Ações</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="contact in paginatedContacts" :key="contact.id" class="hover:bg-gray-50 h-[64px]">
                    <td class="px-4 table-data flex items-center space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gray-300 flex items-center justify-center text-white font-bold">
                            {{ contact.avatar }}
                        </div>
                        <span>{{ contact.name }}</span>
                    </td>
                    <td class="px-4 table-data">{{ contact.email || '-' }}</td>
                    <td class="px-4 table-data">{{ contact.phone || '-' }}</td>
                    <td class="px-4 table-data flex justify-center space-x-2">
                        <button class="text-gray-500 hover:text-blue-500">
                            ✏️
                        </button>
                        <button class="text-gray-500 hover:text-red-500">
                            🗑️
                        </button>
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

/* Responsividade */
@media (max-width: 768px) {
    .flex.justify-between {
        flex-direction: column;
        gap: 16px;
    }

    .w-[250px] {
    width: 100%;
}

    .overflow-x-auto {
        overflow-x: auto;
    }

    table {
        min-width: 600px;
    }
}
</style>
