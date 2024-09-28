<template>
    <div>
      <canvas id="expenseChart"></canvas>
    </div>
  </template>
  
  <script setup>
  import { ref, onMounted } from 'vue';
  import { Chart, registerables } from 'chart.js';
  
  // Register chart.js components
  Chart.register(...registerables);
  
  // Props
  const props = defineProps({
    chartData: Object,
  });
  
  // Chart reference
  const chartRef = ref(null);
  
  // Create the chart
  onMounted(() => {
    const ctx = document.getElementById('expenseChart').getContext('2d');
    
    new Chart(ctx, {
      type: 'bar', // You can change this to 'line' or other chart types
      data: {
        labels: props.chartData.labels,
        datasets: [{
          label: 'Total Expenses by Category',
          data: props.chartData.totals,
          backgroundColor: 'rgba(75, 192, 192, 0.2)',
          borderColor: 'rgba(75, 192, 192, 1)',
          borderWidth: 1,
        }],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true,
          },
        },
      },
    });
  });
  </script>
  
  <style scoped>
  canvas {
    max-width: 600px;
    margin: auto;
  }
  </style>
  