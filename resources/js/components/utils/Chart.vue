<script setup lang="ts">
import { defineProps, shallowRef, watch } from "vue";
import VueApexCharts from "vue3-apexcharts";

const props = defineProps<{
    options: any;
    series: any;
    height?: string;
    title: string;
    loading: boolean;
}>();

const chart = shallowRef(null);

// watch(() => props.series, () => {
//     if (chart.value) {
//         chart.value.updateSeries(props.series);
//     }
// });
</script>

<template>
    <div class="flex flex-col gap-5">
        <h4 class="text-[#505050] font-roboto text-[14px]">{{title}}</h4>
        <h6 v-if="loading" class="text-[#505050] font-roboto text-[12px]">Carregando dados...</h6>
        <VueApexCharts v-else
            ref="chart"
            :options="options"
            :series="series"
            type="pie"
            :height="height || '100px'"
        />
    </div>
</template>
