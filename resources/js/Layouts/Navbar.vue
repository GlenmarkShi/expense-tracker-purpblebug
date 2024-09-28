<template>
  <nav class="bg-gray-800 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
      <div class="text-lg font-bold">Expense Tracker</div>
      <div>
        <!-- <a :href="route('profile.edit')" class="hover:bg-gray-700 p-2 rounded">Profile</a>
        <a :href="route('logout')" method="post" as="button" class="hover:bg-gray-700 p-2 rounded">Logout</a> -->

        <NavLink :href="route('profile.edit')" class="text-xl text-white"> Profile </NavLink>
        <NavLink :href="route('logout' )" class="text-xl text-white" method="post" as="button">
            Log Out
        </NavLink>
    </div>
    </div>
  </nav>
</template>

<script setup>
// Any logic if needed (e.g., checking authentication)
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import NavLink from '@/Components/NavLink.vue';
</script>

<style scoped>
/* Any additional styling for navbar if needed */
</style>
