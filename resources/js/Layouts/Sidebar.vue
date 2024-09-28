<template>
<div class="w-64 bg-gray-100 p-5 shadow-lg h-screen overflow-y-auto">
  <!-- width: 250px (w-64), background-color: #f8f9fa (bg-gray-100), padding: 20px (p-5), box-shadow (shadow-lg), max height: 100vh (max-h-screen), overflow scroll for y-axis (overflow-y-auto) -->
  
  
    <NavLink class="text-xl mb-5" :href="route('dashboard')" :active="route().current('dashboard')">
        Dashboard
    </NavLink>

    <h2 class="text-xl mb-5">User Management</h2>
  <ul class="list-none p-0">
    <li>
    <NavLink class="text-xl mb-5" :href="route('user.index')" :active="route().current('user.index')">
        User
    </NavLink>
    </li>

    <li>
    <NavLink class="text-xl mb-5" :href="route('roles.index')" :active="route().current('roles.index')">
        Role
    </NavLink>
    </li>
    </ul>

    <h2 class="text-xl mb-5">Expense Management</h2>
    <ul class="list-none p-0">
    <li>
    <NavLink class="text-xl mb-5" :href="route('expense_category.index')" :active="route().current('expense_category.index')">
        Expense Category
    </NavLink>
    </li>

    <li>
    <NavLink class="text-xl mb-5" :href="route('expense.index')" :active="route().current('expense.index')">
        Expense
    </NavLink>
    </li>
    </ul>
</div>

  </template>
  
  <script setup>
  import NavLink from '@/Components/NavLink.vue';
  const goTo = (route) => {
    window.location.href = `/${route}`; // Redirect to the route
  };
  </script>
  
