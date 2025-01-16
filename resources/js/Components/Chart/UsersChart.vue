<script setup>
import {
  Chart as ChartJS,
  CategoryScale,
  LinearScale,
  PointElement,
  LineElement,
  Title,
  Tooltip,
  Legend
} from 'chart.js'
import { Line } from 'vue-chartjs'
import { onMounted, ref, watch } from "vue"
import Moment from "moment"

ChartJS.register(
    CategoryScale,
    LinearScale,
    PointElement,
    LineElement,
    Title,
    Tooltip,
    Legend
)

const props = defineProps({
   
})


const chartData = {
  labels: [],
  datasets: [
    {
      label: '',
      backgroundColor: 'rgba(0, 0, 0, 0)',
      borderColor: 'black', // Line color
      pointBackgroundColor: 'white', // Set dot color to white
      pointRadius: 5, // Increase the size of the dots
      data: [],
      cubicInterpolationMode: 'monotone' // Curve lines
    }
  ]
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

const loaded = ref(false)
const month = ref(null)
const total = ref(0)

onMounted(() => {
    getUserCount()
})

function getUserCount() {
    loaded.value = false
    const url = route('admin.dashboard.getUserCount');
    axios.get(url).then((response) => {
        total.value = response.data.total
        let bookings = response.data.count
        let labels = []
        let data = []
        for (const booking in bookings) {
            labels.push(Moment(booking).format('DD MMM'))
            data.push(bookings[booking])
        }
        chartData.labels = labels
        chartData.datasets[0].data = data
        loaded.value = true
    })
}

</script>
<template>
    <div class="bg-white shadow-lg rounded-lg px-4 py-6">
        <h5 class="font-bold font-heading text-2xl">{{ total }}</h5>
        <p class="text-gray-dark text-sm">Total Users</p>
        <div class="pt-4 h-96">
            <Line v-if="loaded" :data="chartData" :options="chartOptions" class="h-full" />
        </div>
    </div>
</template>