<template>
  <div class="flex flex-col h-screen">
    <Navbar />
    <div class="flex flex-grow">
      <Sidebar />
      <div class="content">
        <slot />
      </div>
    </div>
  </div>



  </template>
  
  <script setup>
  import Sidebar from './Sidebar.vue'; // Make sure the path to Sidebar.vue is correct
  import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import Navbar from './Navbar.vue';

const showingNavigationDropdown = ref(false);
 </script>
  
  <style scoped>
  .app-layout {
    display: flex;
  }
  
  .content {
    flex: 1;
    padding: 20px;
  }
  </style> 