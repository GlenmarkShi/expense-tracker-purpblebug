<script setup>
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { defineProps, defineEmits } from 'vue'
import axios from 'axios'


const props = defineProps({
  categories: Array 
})


const emit = defineEmits(['close', 'expenseCreated'])

const successMessage = ref('');

let categories = ref([]);
// User data object
// const user = ref({
//   name: '',
//   email: '',
//   password: '',
//   role: ''
// })
const form = useForm({
  expense_category_id: '',
  amount: '',
  entry_date: ''
});

const closeModal = () => {
    emit('close')
}

onMounted(async () => {
    await getExpenseCategories();
})

const getExpenseCategories = async () => {
    let response = await axios.get('/api/get_all_expense_categories');
    console.log('response', response);
  categories.value = response.data.expenseCategories;
}

const addExpense = async () => {

await form.post(route('expense.store'), {
    onSuccess: () => {
        emit('expenseCreated')
      closeModal(); 

    },
    onError: (errors) => {
      console.error('Error adding expense:', errors); 
    }
  });
}


</script>


<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-5 rounded-lg min-w-[500px]" >
       
            <h2>Add User</h2>
            <form @submit.prevent="addExpense">
              <div class="mb-15 mt-5">
                <label for="expense-category">Expense Category:</label>
                <select id="expense-category" v-model="form.expense_category_id" required>
                    <option value="">Select Category</option>
                    <option v-for="category in categories" :key="category.name" :value="category.id">
                        {{ category.name }}
                    </option>
                </select>
                </div>

                <div class="mb-15 mt-5">
                <label for="amount">Amount:</label>
                <input type="number" id="name" v-model="form.amount" required />
                </div>

                <div class="mb-15 mt-5">
                <label for="entry_date">Entry Date:</label>
                <input type="date" id="entry_date" v-model="form.entry_date" required />
                </div>

                <div class="flex justify-end">
                  <button type="button" @click="closeModal" class="mr-4 _button-secondary">Close</button>
                <button type="submit" @click="addExpense" class="_button-primary">Add Expense</button>

                </div>
            </form>
           
        </div>
    </div>
</template>

