<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps, defineEmits } from "vue";
import axios from "axios";


const props = defineProps({
    role: Object, 
    permissions: Array, 
});


const emit = defineEmits(["close", "roleUpdated"]);

const form = useForm({
    name: props.role.name,
    description: props.role.permissions[0]?.name || "",
    // name: '', 
    // description: '', 
});

const closeModal = () => {
    emit("close");
};

// onMounted(() => {
//     form.name = props.role.name; 
//     form.description = props.role.permissions[0]?.name || ""; 
// });

// onMounted(async () => {
//     await getRoles();
// })

// const getRoles = async () => {
//     let response = await axios.get('/api/get_all_roles');
//     roles.value = response.data.roles;
// }

const updateRole = async () => {
    await form.post(route("roles.update", props.role.id), {
        onSuccess: () => {
            closeModal();
        },
        onError: (errors) => {
            console.error("Error updating roles:", errors); 
        },
    });
};

const deleteRole = async () => {
    if (confirm("Are you sure you want to delete this roles?")) {
        await form.delete(route("roles.delete", props.role.id), {
            onSuccess: () => {
                closeModal(); 
            },
            onError: (errors) => {
                console.error("Error deleting roles:", errors);
            },
        });
    }
};
</script>



<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-lg min-w-[500px]">
            <h2>Edit Role</h2>
            <form @submit.prevent="updateRole">
            <div class="mb-15 mt-5">
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="form.name" required />
            </div>
            <div class="mb-15 mt-5">
                <label for="description">Description:</label>
                <input type="text" id="description" v-model="form.description" required />
            </div>

                <div class="flex justify-between mt-4">
            <button type="button" @click="deleteRole" class="_button-danger">Delete</button>

            <div class="flex">
                <button type="button" @click="closeModal" class="mr-4 _button-secondary">Close</button>
                <button type="submit" class="_button-primary">Update</button>
                
            </div>
            </div>
            
            </form>

        </div>
    </div>
</template>

