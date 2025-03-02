<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import Chart from "../utils/Chart.vue";
import {clientsByAge, clientsByCity} from "../../service/dashboard";
import {toast} from "vue3-toastify";

const customersByCity = ref<{ city: string; total: number }[]>([]);
const customersByAge = ref<{ age_group: string; total: number }[]>([]);
const selectedCity = ref("");
const loading = ref(true);

const notify = (message, timer, type) => {
    toast(message, {
        type: type,
        autoClose: timer,
    });
}

const fetchClientsByCity = async () => {
    return await clientsByCity().then((res) => {
        customersByCity.value = res.data;
    }).catch((err) => {
        notify('Erro ao buscar dados.', 2000, 'error')
    })
}

const fetchClientsByAge = async () => {
    return await clientsByAge().then((res) => {
        customersByAge.value = res.data;
    }).catch((err) => {
        notify('Erro ao buscar dados.', 2000, 'error')
    })
}

const fetchData = async () => {
    await fetchClientsByCity();
    await fetchClientsByAge();
    loading.value = false;
};

onMounted(fetchData);

const cityChartOptions = computed(() => ({
    chart: { type: "pie" },
    labels: customersByCity.value.map(item => item.city),
    colors: ["#2715B0", "#180D6E", "#5946E4", "#7E6FEA", "#BDB5F4"],
    tooltip: { y: { formatter: (val: number) => `${val} clientes` } },
    dataLabels:{enabled: false},
    stroke: {
        show: false
    }
}));

const cityChartSeries = computed(() => customersByCity.value.map(item => item.total));

const ageChartOptions = computed(() => ({
    chart: { type: "pie" },
    labels: customersByAge.value.map(item => item.age_group),
    colors: ["#2715B0", "#180D6E", "#5946E4", "#7E6FEA", "#BDB5F4"],
    tooltip: { y: { formatter: (val: number) => `${val} clientes` } },
    dataLabels:{enabled: false},
    stroke: {
        show: false
    },
}));

const ageChartSeries = computed(() => customersByAge.value.map(item => item.total));

const totalCustomers = computed(() => customersByCity.value.reduce((sum, item) => sum + item.total, 0));
const averagePerCity = computed(() => (customersByCity.value.length ? (totalCustomers.value / customersByCity.value.length).toFixed(2) : 0));
</script>

<template>
    <div class="container">
        <div class="flex flex-col md:grid grid-cols-2 gap-4 w-full h-full ">
            <Chart :loading="loading" title="Segmentação por Cidade" :options="cityChartOptions" :series="cityChartSeries" height="200px" />
            <Chart :loading="loading" title="Segmentação por Idade" :options="ageChartOptions" :series="ageChartSeries" height="200px" />
        </div>
    </div>
</template>

<style scoped>
.container {
    padding: 20px;
    width: 100%;
    height: 800px;
}
.summary {
    background: #f1f5f9;
    padding: 10px;
    border-radius: 8px;
    margin-bottom: 20px;
}
</style>
