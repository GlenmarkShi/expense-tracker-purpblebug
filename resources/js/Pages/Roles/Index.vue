<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import axios from 'axios';
import CreateModal from './Create.vue'; // Import the Create modal component
import EditModal from './Edit.vue';

const props = defineProps({
  roles: Array,
});

let permissions = ref([]);
let roles = ref(props.roles);
//let searchUser = ref('');
let isAddModalOpen = ref(false);
let isEditModalOpen = ref(false);
let selectedRole = ref(null)
//let successMessage = ref(props.success.message || '');

onMounted(async () => {
  
  await getRoles();
  await getPermissions();
});


const getUsers = async () => {
  let response = await axios.get('/api/get_all_users');
  
  users.value = response.data.users;
};

const getRoles = async () => {
    let response = await axios.get('/api/get_all_roles');
    console.log(response, 'role response')
    roles.value = response.data.roles;
};

const getPermissions = async () => {
  let response = await axios.get('/api/get_all_permissions'); // Ensure this endpoint returns permissions
  console.log('permission', response.data)
  permissions.value = response.data.permissions; // Assuming response.data.permissions is an array of permission objects
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
  await getRoles();

};

const openEditModal = (role) => {
    selectedRole.value = role;
    isEditModalOpen.value = true;
}

const closeEditModal = async () => {
  isEditModalOpen.value = false;
  selectedRole.value = null; 
  await getRoles();
};

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toISOString().split('T')[0]; // Format to YYYY-MM-DD
};

</script>

<template>
  <Head title="Roles" />

  <AuthenticatedLayout>

    <div class="flex justify-between items-center">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Roles</h2>

      <button class="_button-primary" @click="openAddModal">Create Roles</button>
     

      </div>
      
    

  


    <!-- Create Modal Component -->
    <CreateModal v-if="isAddModalOpen" @close="closeAddModal" />

    <EditModal v-if="isEditModalOpen" :role="selectedRole" :permissions="permissions" @close="closeEditModal" />
    
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
                  <th class="px-6 py-2 text-xs text-gray-500">Display Name</th>
                  <th class="px-6 py-2 text-xs text-gray-500">Description</th>
                  
                  <th class="px-6 py-2 text-xs text-gray-500">Created At</th>
                </tr>
              </thead>
              <tbody class="bg-white divide-y divide-gray-300">
                <tr
                  class="whitespace-nowrap"
                  v-for="role in roles"
                  :key="role.id" @click="openEditModal(role)"
                >
                  <td class="px-6 py-4">
                    <div class="text-sm text-gray-500">{{ role.name }}</div>
                  </td>
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ role.permissions[0]?.name}}
                  </td>
                
                  <td class="px-6 py-4 text-sm text-gray-500">
                    {{ formatDate(role.created_at) }}
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
