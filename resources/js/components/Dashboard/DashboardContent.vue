<script setup lang="ts">
import { ref, computed, onMounted } from "vue";
import axios from "axios";
import Chart from "../utils/Chart.vue";
import {clientsByAge, clientsByCity} from "../../service/dashboard";

const customersByCity = ref<{ city: string; count: number }[]>([]);
const customersByAge = ref<{ age_range: string; count: number }[]>([]);
const selectedCity = ref("");
const loading = ref(true);

const fetchData = async () => {
    try {
        const cityResponse = await clientsByCity();
        customersByCity.value = cityResponse.data.data;

        const ageResponse = await clientsByAge();
        customersByAge.value = ageResponse.data.data;
        loading.value = false
    } catch (error) {
        console.error("Erro ao buscar dados:", error);
    }
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

const cityChartSeries = computed(() => customersByCity.value.map(item => item.count));

const ageChartOptions = computed(() => ({
    chart: { type: "bar" },
    xaxis: { categories: customersByAge.value.map(item => item.age_range) },
    colors: ["#1E40AF"],
    tooltip: { y: { formatter: (val: number) => `${val} clientes` } }
}));

const ageChartSeries = computed(() => [{ name: "Clientes", data: customersByAge.value.map(item => item.count) }]);

const totalCustomers = computed(() => customersByCity.value.reduce((sum, item) => sum + item.count, 0));
const averagePerCity = computed(() => (customersByCity.value.length ? (totalCustomers.value / customersByCity.value.length).toFixed(2) : 0));
</script>

<template>
    <div class="container">
        <div class="flex flex-col md:grid grid-cols-2 gap-4 w-full h-full ">
            <Chart :loading="loading" title="Segmentação por Cidade" :options="cityChartOptions" :series="cityChartSeries" height="200px" />
            <Chart :loading="loading" title="Segmentação por Idade" :options="cityChartOptions" :series="cityChartSeries" height="200px" />
            <Chart :loading="loading" title="Segmentação por cidade" :options="cityChartOptions" :series="cityChartSeries" height="200px" />
            <Chart :loading="loading" title="Segmentação por cidade" :options="cityChartOptions" :series="cityChartSeries" height="200px" />
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
