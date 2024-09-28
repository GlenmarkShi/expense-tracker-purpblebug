<script setup>
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { defineProps, defineEmits } from 'vue'
import axios from 'axios'


const props = defineProps({
  permissions: Array
})


const emit = defineEmits(['close', 'roleCreated'])

const successMessage = ref('');

let permissions = ref([]);
// User data object
// const user = ref({
//   name: '',
//   email: '',
//   password: '',
//   role: ''
// })
const form = useForm({
  name: '',
  description: '',
});

const closeModal = () => {
    emit('close')
}

onMounted(async () => {
    await getRoles();
})

// const getRoles = async () => {
//     let response = await axios.get('/api/get_all_roles');
//   roles.value = response.data.roles;
// }

const addRole = async () => {

await form.post(route('roles.store'), {
    onSuccess: () => {
        emit('userCreated')
      closeModal(); 

    },
    onError: (errors) => {
      console.error('Error adding user:', errors);
    }
  });
}


</script>


<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-lg min-w-[500px]">
       
            <h2>Add Role</h2>
            <form @submit.prevent="addRole">
                <div class="mb-15 mt-5">
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="form.name" required />
              </div>
              <div class="mb-15 mt-5">
                <label for="description">Description:</label>
                <input type="text" id="email" v-model="form.description" required />
              </div>
            

      

                <!-- Add and Close Buttons -->
                <div class="flex justify-end">
                <button type="button" @click="closeModal" class="mr-4 _button-secondary">Close</button>
                <button type="submit" @click="addRole" class="_button-primary">Add User</button>
                </div>
            </form>
           
        </div>
    </div>
</template>

