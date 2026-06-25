<script setup>
// Importamos el componente Navbar que acabamos నో crear
import Navbar from '@/Components/Shop/Navbar.vue';
import ShopFooter from '@/Components/Shop/ShopFooter.vue';
</script>

<template>
  <div class="min-h-screen bg-[#111111] text-white font-sans relative">

    <Navbar />

    <main>
      <slot />
    </main>

    <ShopFooter />

  </div>
</template>
