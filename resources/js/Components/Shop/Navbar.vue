<script setup>
import { ref, onMounted, onUnmounted } from 'vue';

const scrolled = ref(false);

const handleScroll = () => {
  scrolled.value = window.scrollY > 50;
};

onMounted(() => window.addEventListener('scroll', handleScroll));
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
  <nav
    class="fixed top-0 left-0 w-full z-50 px-6 md:px-12 transition-all duration-500 flex justify-between items-center"
    :class="scrolled ? 'py-5 bg-[#111111]/95 backdrop-blur-md shadow-lg shadow-black/20' : 'py-7 bg-transparent'"
  >

    <div class="text-3xl md:text-4xl font-black italic tracking-tighter uppercase shrink-0 text-white">
      Street <span class="font-light">Urban</span>
    </div>

    <div class="hidden lg:flex space-x-10 text-xs font-semibold tracking-widest uppercase text-gray-300">
      <a href="#" class="hover:text-white transition-colors">Home</a>
      <a href="#" class="hover:text-white transition-colors">Hombres</a>
      <a href="#" class="hover:text-white transition-colors">Mujeres</a>
      <a href="#" class="hover:text-white transition-colors">Contactos</a>
    </div>

    <div class="flex items-center space-x-8 text-sm text-white">
      <button class="hover:text-gray-400 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </button>

      <button class="flex items-center space-x-2 hover:text-gray-400 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
        <span class="text-xs font-medium tracking-wide">Cesta (0)</span>
      </button>
    </div>

  </nav>
</template>
