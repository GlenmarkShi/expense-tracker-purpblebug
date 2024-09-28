<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import ExpenseChart from './ExpenseChart.vue';
import { defineProps } from 'vue';

const props = defineProps({
  chartData: Object,
});
</script>

<template>
  <Head title="Dashboard" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </template>
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>

    <div class="p-6">
      <ExpenseChart :chartData="chartData" />
    

      <h2 class="text-xl font-bold mb-4">Expense Categories</h2>
    <table class="min-w-full border-collapse border border-gray-200">
      <thead>
        <tr>
          <th class="border border-gray-300 p-2 text-left">Category</th>
          <th class="border border-gray-300 p-2 text-left">Total</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="(total, index) in chartData.totals" :key="index">
          <td class="border border-gray-300 p-2">{{ chartData.labels[index] }}</td>
          <td class="border border-gray-300 p-2">${{ total }}</td>
        </tr>
      </tbody>
    </table>
    </div>
  </AuthenticatedLayout>
</template>
