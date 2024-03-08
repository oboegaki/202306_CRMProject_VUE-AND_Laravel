<script setup>
import { Chart, registerables } from "chart.js";
import { BarChart } from "vue-chart-3";
import { reactive, computed } from "vue"


// Propsをcomputedでリアルタイム検知
const props = defineProps({ 'data': Object })
const labels = computed(() => props.data.labels)
const totals = computed(() => props.data.totals)


Chart.register(...registerables);


// グラフに反映する情報
const barData = reactive({
    // labels: ['ラベル', 'ラベル'],
    labels: labels,
    datasets: [
        {
            label: '売上',
            data: totals,
            // data: [65, 59, 80, 81, 56, 55, 40],
            backgroundColor: "rgb(75, 192, 192)",
            tension: 0.1,
        }
    ]
})

</script>

<template>
    <div v-show="props.data">
        <BarChart :chartData="barData" />
    </div>
</template>
