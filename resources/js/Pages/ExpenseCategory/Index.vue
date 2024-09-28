<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import CreateModal from './Create.vue'; 
import EditModal from './Edit.vue';

const props = defineProps({
  expenseCategories: Array,
});

let expenseCategories = ref([]);
let searchUser = ref('');
let isAddModalOpen = ref(false);
let isEditModalOpen = ref(false);
let selectedCategory = ref(null)
//let successMessage = ref(props.success.message || '');

onMounted(async () => {
  
  await getExpenseCategories();
});


const getExpenseCategories = async () => {
  let response = await axios.get('/api/get_all_expense_categories');
  
  expenseCategories.value = response.data.expenseCategories;
};


const search = async () => {
  let response = await axios.get('/api/search_user?s=' + searchUser.value);
  users.value = response.data.users;
};


const openAddModal = () => {
  isAddModalOpen.value = true;
};

const closeAddModal = async () => {
  isAddModalOpen.value = false;
  await getExpenseCategories();

};

const openEditModal = (category) => {
    selectedCategory.value = category;
    isEditModalOpen.value = true;
}

const closeEditModal = async () => {
  isEditModalOpen.value = false;
  selectedCategory.value = null; 
  await getExpenseCategories();
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toISOString().split('T')[0]; // Format to YYYY-MM-DD
};

</script>

<template>
  <Head title="Expense Category" />

  <AuthenticatedLayout>
    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Expense Category</h2>
      <button class="_button-primary" @click="openAddModal">Create Expense Category</button>
     </div>
      <!-- <input
        class="search-input"
        type="text"
        placeholder="Search user..."
        v-model="searchUser"
        @keyup="search"
      /> -->

  


    <!-- Create Modal Component -->
    <CreateModal v-if="isAddModalOpen" @close="closeAddModal" />

    <EditModal v-if="isEditModalOpen" :expenseCategory="selectedCategory" @close="closeEditModal" />
    
    <!-- <div v-if="$page.props.flash.success" class="bg-green-500 text-white p-4 rounded">
      {{ $page.props.flash.success }}
    </div> -->


    <div class="container flex justify-center mx-auto">
      <div class="flex flex-col">
        <div class="w-full">
          <div class="border-b border-gray-200 shadow">
            <table class="divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-2 text-xs text-gray-500">Display Name</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Desciption</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Created At</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-300">
                <tr
                  class="whitespace-nowrap"
                  v-for="category in expenseCategories"
                  :key="category.id" @click="openEditModal(category)"
                >
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500">{{ category.name }}</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ category.description }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ formatDate(category.created_at) }}
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
