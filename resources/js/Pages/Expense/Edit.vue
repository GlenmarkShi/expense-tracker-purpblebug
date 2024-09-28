<script setup>
import { onMounted, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { defineProps, defineEmits } from "vue";
import axios from "axios";

const props = defineProps({
    expense: Object, 
    expenseCategories: Array, 
});
console.log("props",props.expense)

const emit = defineEmits(["close", "expenseUpdated"]);

const form = useForm({
    expense_category_id: props.expense.expense_category_id || "",
    amount: props.expense.amount, 
    entry_date: props.expense.entry_date,
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

const updateExpense = async () => {
    await form.post(route("expense.update", props.expense.id), {
        onSuccess: () => {
            closeModal();
        },
        onError: (errors) => {
            console.error("Error updating expense:", errors); 
        },
    });
};

const deleteUser = async () => {
    if (confirm("Are you sure you want to delete this expense?")) {
        await form.delete(route("expense.delete", props.expense.id), {
            onSuccess: () => {
                closeModal(); 
            },
            onError: (errors) => {
                console.error("Error deleting expense:", errors);
            },
        });
    }
};
</script>


<template>
  <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" >
        <div class="bg-white p-5 rounded-lg min-w-[500px]">
            <div class="_modal-header">Edit Expense</div>
            <form @submit.prevent="updateExpense">
                <div class="mb-15 mt-5">
                <label for="role">Expense Category:</label>
                <select id="role" v-model="form.expense_category_id" required>
                    <option value="">Select Expense Category</option>
                    <option
                        v-for="category in props.expenseCategories"
                        :key="category.name"
                        :value="category.id"
                    >
                        {{ category.name }}
                    </option>
                </select>
                </div>

                <div class="mb-15 mt-5">
                <label for="amount">Amount:</label>
                <input type="text" id="name" v-model="form.amount" required />
                </div>
                <div class="mb-15 mt-5">
                <label for="entry_date">Entry Date:</label>
                <input type="date" id="entry_date" v-model="form.entry_date" required />
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

