<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import CreateModal from './Create.vue'; // Import the Create modal component
import EditModal from './Edit.vue';

const props = defineProps({
  users: Array,
});

let users = ref([]);
let roles = ref([]);
let searchUser = ref('');
let isAddModalOpen = ref(false);
let isEditModalOpen = ref(false);
let selectedUser = ref(null)
//let successMessage = ref(props.success.message || '');

onMounted(async () => {
  
  await getUsers();
  await getRoles();
});


const getUsers = async () => {
  let response = await axios.get('/api/get_all_users');
  
  users.value = response.data.users;
};

const getRoles = async () => {
    let response = await axios.get('/api/get_all_roles');
    roles.value = response.data.roles;
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
  await getUsers();

};

const openEditModal = (user) => {
    selectedUser.value = user;
    isEditModalOpen.value = true;
}

const closeEditModal = async () => {
  isEditModalOpen.value = false;
  selectedUser.value = null; 
  await getUsers();
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toISOString().split('T')[0]; // Format to YYYY-MM-DD
};

</script>

<template>
  <Head title="Users" />

  <AuthenticatedLayout>

    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Users</h2>

      <button class="_button-primary" @click="openAddModal">Create User</button>
     

      </div>
      <input
        class="search-input"
        type="text"
        placeholder="Search user..."
        v-model="searchUser"
        @keyup="search"
      />
    

  


    <!-- Create Modal Component -->
    <CreateModal v-if="isAddModalOpen" @close="closeAddModal" />

    <EditModal v-if="isEditModalOpen" :user="selectedUser" :roles="roles" @close="closeEditModal" />
    
    <div v-if="$page.props.flash.success" class="bg-green-500 text-white p-4 rounded">
      {{ $page.props.flash.success }}
    </div>

    <!-- User Table -->
    <div class="container flex justify-center mx-auto">
      <div class="flex flex-col">
        <div class="w-full">
          <div class="border-b border-gray-200 shadow">
            <table class="divide-y divide-gray-300">
              <thead class="bg-gray-50">
                <tr>
                  <th class="px-6 py-2 text-xs text-gray-500">Name</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Email Address</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Role</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Created At</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-300">
                <tr
                  class="whitespace-nowrap"
                  v-for="user in users"
                  :key="user.id" @click="openEditModal(user)"
                >
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500">{{ user.name }}</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ user.email }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ user.roles[0]?.name }}
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ formatDate(user.created_at) }}
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
