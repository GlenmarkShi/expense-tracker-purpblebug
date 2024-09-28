<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps, defineEmits } from "vue";
import axios from "axios";

const props = defineProps({
    expenseCategory: Object, 
});


const emit = defineEmits(["close", "userUpdated"]);

const form = useForm({
    name: props.expenseCategory.name,
    description: props.expenseCategory.description,
   
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

const updateExpenseCategory = async () => {
    await form.post(route("expense_category.update", props.expenseCategory.id), {
        onSuccess: () => {
            closeModal();// Close the modal if the user was updated successfully
        },
        onError: (errors) => {
            console.error("Error updating user:", errors); 
        },
    });
};

const deleteExpenseCategory = async () => {
    if (confirm("Are you sure you want to delete this expense category?")) {
        await form.delete(route("expense_category.delete", props.expenseCategory.id), {
            onSuccess: () => {
                console.log(props.expenseCategory.id)
                closeModal(); 
            },
            onError: (errors) => {
                console.error("Error deleting expense category:", errors);
            },
        });
    }
};
</script>

<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" >
        <div class="bg-white p-5 rounded-lg min-w-[500px]">
            <div class="_modal-header">Edit Expense Category</div>
            <form @submit.prevent="updateExpenseCategory">
                <div class="mb-15 mt-5">
                <label for="name">Display Name:</label>
                <input type="text" id="name" v-model="form.name" required />
                </div>
                <div class="mb-15 mt-5">
                <label for="description">Description:</label>
                <input type="text" id="description" v-model="form.description" required />
                </div>
              
                <div class="flex justify-between mt-4">
            <button type="button" @click="deleteExpenseCategory" class="_button-danger">Delete</button>

            <div class="flex">
                <button type="button" @click="closeModal" class="mr-4 _button-secondary">Close</button>
                <button type="submit" class="_button-primary">Update</button>
                
            </div>
            </div>
            </form>
       
        </div>
    </div>
</template>

