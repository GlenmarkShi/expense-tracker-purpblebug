<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps, defineEmits } from "vue";
import axios from "axios";


const props = defineProps({
    user: Object, 
    roles: Array, 
});


const emit = defineEmits(["close", "userUpdated"]);

const form = useForm({
    name: props.user.name, // Initialize with existing user data
    email: props.user.email,
    role: props.user.roles[0]?.id || "",
});

const closeModal = () => {
    emit("close");
};

// onMounted(async () => {
//     await getRoles();
// })

// const getRoles = async () => {
//     let response = await axios.get('/api/get_all_roles');
//     roles.value = response.data.roles;
// }

const updateUser = async () => {
    await form.post(route("user.update", props.user.id), {
        onSuccess: () => {
            closeModal();
        },
        onError: (errors) => {
            console.error("Error updating user:", errors); 
        },
    });
};

const deleteUser = async () => {
    if (confirm("Are you sure you want to delete this user?")) {
        await form.delete(route("user.delete", props.user.id), {
            onSuccess: () => {
                closeModal(); 
            },
            onError: (errors) => {
                console.error("Error deleting user:", errors);
            },
        });
    }
};
</script>



<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-lg min-w-[500px]">
            <h2>Edit User</h2>
            <form @submit.prevent="updateUser">
            <div class="mb-15 mt-5">
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="form.name" required />
            </div>
            <div class="mb-15 mt-5">
                <label for="email">Email:</label>
                <input type="email" id="email" v-model="form.email" required />
            </div>
            <div class="mb-15 mt-5">
                <label for="role">Role:</label>
                <select id="role" v-model="form.role" required>
                    <option value="">Select Role</option>
                    <option
                        v-for="role in props.roles"
                        :key="role.id"
                        :value="role.id"
                    >
                        <!-- Use role.id here -->
                        {{ role.name }}
                    </option>
                </select>
            </div>

            
                <div class="flex justify-between mt-4">
            <button type="button" @click="deleteUser" class="_button-danger">Delete</button>

            <div class="flex">
                <button type="button" @click="closeModal" class="mr-4 _button-secondary">Close</button>
                <button type="submit" class="_button-primary">Update</button>
                
            </div>
            </div>
            
            </form>

        </div>
    </div>
</template>

