<script setup>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  BarElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import {Bar} from 'vue-chartjs'
import { onMounted, ref, watch } from "vue"
import Moment from "moment"

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    BarElement,
    Title,
    Tooltip,
    Legend
)


const chartData = {
  labels: [],
  datasets: [
    {
      label: 'New Student',
      backgroundColor: '#193B68',
      data: [],
    },
    {
      label: 'Graduated Students',
      backgroundColor: '#13C296',
      data: [],
    }
  ]
}

const loaded = ref(false)

onMounted(() => {
    getStudentsCount()
})

function getStudentsCount() {
    loaded.value = false
    const url = route('admin.dashboard.getStudentsCount');
    axios.get(url).then((response) => {

        let labels = []

        for (const month of response.data.months) {
            labels.push(Moment(month).format('MMM'))
        }

        chartData.labels = labels
        chartData.datasets[0].data = response.data.totalEnrolledStudents
        chartData.datasets[1].data = response.data.graduatedStudents
        loaded.value = true
    })
}

const chartOptions = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      display: false
    }
  },
}

</script>
<template>
  <div class="bg-white shadow-lg rounded-lg px-4 py-6">
    <h5 class="font-bold font-heading text-2xl">Activity Chart</h5>
    <div class="inline-flex gap-6">
      <div class="inline-flex items-center gap-3">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="7" cy="7" r="7" fill="white"/>
          <circle cx="7" cy="7" r="6.5" stroke="#3377FF" stroke-opacity="0.25"/>
          <circle cx="7" cy="7" r="4" fill="#193B68"/>
        </svg>
        <p class="text-sm"> New Student </p>
      </div>
      <div class="inline-flex items-center gap-3">
        <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
          <circle cx="7" cy="7" r="7" fill="white"/>
          <circle cx="7" cy="7" r="6.5" stroke="#93CFE2" stroke-opacity="0.25"/>
          <circle cx="7" cy="7" r="4" fill="#13C296"/>
        </svg>
        <p class="text-sm">Graduated Students </p>
      </div>
    </div>
    <div class="pt-4 h-96">
      <Bar v-if="loaded" :data="chartData" :options="chartOptions" class="h-full"/>
    </div>
  </div>
</template>