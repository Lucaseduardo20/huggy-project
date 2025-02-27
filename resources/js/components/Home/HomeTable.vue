<script setup lang="ts">
import Search from "../icons/Search.vue";
import Button from "../utils/Button.vue";
import Add from "../icons/Add.vue";
import Insight from "../icons/Insight.vue";

const contacts = [
    {
        id: 1,
        avatar: "HG",
        name: "Henrique Gomes Santana",
        email: "henrique.gomes@huggy.io",
        phone: "75992503245"
    },
    {
        id: 2,
        avatar: "RM",
        name: "Rafael Macedo",
        email: "rafael.macedo@huggy.io",
        phone: "-"
    },
    {
        id: 3,
        avatar: "PG",
        name: "Philippe Gomes Santana",
        email: "-",
        phone: "75992514121"
    },{
        id: 3,
        avatar: "PG",
        name: "Philippe Gomes Santana",
        email: "-",
        phone: "75992514121"
    },{
        id: 3,
        avatar: "PG",
        name: "Philippe Gomes Santana",
        email: "-",
        phone: "75992514121"
    },{
        id: 3,
        avatar: "PG",
        name: "Philippe Gomes Santana",
        email: "-",
        phone: "75992514121"
    },{
        id: 3,
        avatar: "PG",
        name: "Philippe Gomes Santana",
        email: "-",
        phone: "75992514121"
    },
    {
        id: 4,
        avatar: "LM",
        name: "Lucas Matos",
        email: "lucas.matos@huggy.io",
        phone: "75991457893"
    },
    {
        id: 5,
        avatar: "CS",
        name: "Carla Silva",
        email: "carla.silva@huggy.io",
        phone: "-"
    },
    {
        id: 6,
        avatar: "FT",
        name: "Fernando Torres",
        email: "-",
        phone: "75991234567"
    },
    {
        id: 7,
        avatar: "AB",
        name: "Ana Beatriz",
        email: "ana.beatriz@huggy.io",
        phone: "75995672389"
    }
];

const columns = [
    {
        label: '',
        value: 'avatar'
    },
    {
        label: 'Nome',
        value: 'name'
    },
    {
        label: 'E-mail',
        value: 'email'
    },
    {
        label: 'Telefone',
        value: 'phone'
    },
    {

    }
]

</script>

<template>
    <div class="w-full flex flex-col gap-8">
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
        <table class="min-w-full">
            <thead class="text-gray-600 border-b border-gray-100">
            <tr>
                <th class="px-4 py-2 text-left ths">Nome</th>
                <th class="px-4 py-2 text-left ths">Email</th>
                <th class="px-4 py-2 text-left ths">Telefone</th>
                <th class="px-4 py-2 text-center ths"></th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="contact in contacts" :key="contact.id" class="hover:bg-gray-50 h-[64px]">
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
</style>
