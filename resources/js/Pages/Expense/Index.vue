<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import CreateModal from './Create.vue';
import EditModal from './Edit.vue';

const props = defineProps({
  expenses: Array,
});

let expenses =  ref(props.expenses);
let expenseCategories = ref([]);
//let searchUser = ref('');
let isAddModalOpen = ref(false);
let isEditModalOpen = ref(false);
let selectedExpense = ref(null)
//let successMessage = ref(props.success.message || '');

onMounted(async () => {
  
  await getExpenses();
  await getExpenseCategories();
});


const getExpenses= async () => {
  await axios.get('/sanctum/csrf-cookie');
  let response = await axios.get('/api/get_all_expenses', { withCredentials: true });
  console.log('response', response)
  expenses.value = response.data.expenses;
  // axios.get('/api/get_all_expenses')
  // .then(response => {
  //   console.log(response.data);
  // });
};

const getExpenseCategories = async () => {
    let response = await axios.get('/api/get_all_expense_categories');
  console.log('response1', response)

  expenseCategories.value = response.data.expenseCategories;
};


// const search = async () => {
//   let response = await axios.get('/api/search_user?s=' + searchUser.value);
//   users.value = response.data.users;
// };


const openAddModal = () => {
  isAddModalOpen.value = true;
};

const closeAddModal = async () => {
  isAddModalOpen.value = false;
  selectedExpense.value = null
  await getExpenses();

};

const openEditModal = (expense) => {
    selectedExpense.value = expense;
    isEditModalOpen.value = true;
}

const closeEditModal = async () => {
  isEditModalOpen.value = false;
  selectedExpense.value = null; 
  await getExpenses();
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toISOString().split('T')[0]; // Format to YYYY-MM-DD
};
</script>

<template>
  <Head title="Expense" />

  <AuthenticatedLayout>

    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Expense</h2>
        <button class="_button-primary" @click="openAddModal">Create Expense</button>
      </div>


    <!-- Create Modal Component -->
    <CreateModal v-if="isAddModalOpen" @close="closeAddModal" />

    <EditModal v-if="isEditModalOpen" :expense="selectedExpense" :expenseCategories="expenseCategories" @close="closeEditModal" />
    
    <!-- <div v-if="$page.props.flash.success" class="bg-green-500 text-white p-4 rounded">
      {{ $page.props.flash.success }}
    </div> -->

    <!-- User Table -->
    <div class="container flex justify-center mx-auto">
      <div class="flex flex-col">
        <div class="w-full">
          <div class="border-b border-gray-200 shadow">
            <table class="divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-2 text-xs text-gray-500">Expense Category</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Amount</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Entry Date</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Created At</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-300">
                <tr
                  class="whitespace-nowrap"
                  v-for="expense in expenses"
                  :key="expense.id" @click="openEditModal(expense)"
                >
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500">{{ expense.category?.name }}</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ expense.amount }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ formatDate(expense.entry_date) }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ formatDate(expense.created_at) }}
                  </td>
                </tr>
                <tr v-if="!expenses.length">
                  <td colspan="4" class="text-center text-gray-500">No expenses found.</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
