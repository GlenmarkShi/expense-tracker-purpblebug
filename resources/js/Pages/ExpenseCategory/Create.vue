<script setup>
import { onMounted, ref } from 'vue'
import { useForm } from '@inertiajs/vue3'
import { defineProps, defineEmits } from 'vue'
import axios from 'axios'


const props = defineProps({
  //: Array 
})


const emit = defineEmits(['close', 'categoryCreated'])

const successMessage = ref('');

//let roles = ref([]);

const form = useForm({
  name: '',
  description: '',
});

const closeModal = () => {
    emit('close')
}


const addExpenseCategory = async () => {

await form.post(route('expense_category.store'), {
    onSuccess: () => {
        emit('categoryCreated')
      closeModal(); 

    },
    onError: (errors) => {
      console.error('Error adding category:', errors);
    }
  });
}


</script>


<template>
    <div class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center" >
        <div class="bg-white p-5 rounded-lg min-w-[500px]">
       
            <div class="_modal-header">Add Expense Category</div>
            <form @submit.prevent="addExpenseCategory">
              <div class="mb-15 mt-5">
                <label for="name">Name:</label>
                <input type="text" id="name" v-model="form.name" required />
                </div>

                <div class="mb-15 mt-5">
                <label for="description">Description:</label>
                <input type="text" id="email" v-model="form.description" required />
              </div>
                <div class="flex justify-end">
                  <button type="button" @click="closeModal"  class="mr-4 _button-secondary">Cancel</button>
                <button type="submit" @click="addExpenseCategory" class="_button-primary">Save</button>

                </div>
            </form>
           
        </div>
    </div>
</template>

