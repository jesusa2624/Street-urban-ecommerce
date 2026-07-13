<script setup>
import { ref, onMounted, onUnmounted } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { totalItems } from '@/cart';

const page = usePage();

const scrolled = ref(false);
const mobileMenuOpen = ref(false);

const handleScroll = () => {
  scrolled.value = window.scrollY > 50;
};

const toggleMobileMenu = () => {
  mobileMenuOpen.value = !mobileMenuOpen.value;
};

const items = ref(0); // Elementos del carrito

onMounted(() => {
  items.value = totalItems();
  window.addEventListener('scroll', handleScroll);
  window.addEventListener('cart-updated', () => {
    items.value = totalItems();
  });
});
onUnmounted(() => window.removeEventListener('scroll', handleScroll));
</script>

<template>
  <nav
    class="fixed top-0 left-0 w-full z-50 px-6 md:px-12 transition-all duration-500 flex justify-between items-center"
    :class="scrolled ? 'py-5 bg-[#111111]/95 backdrop-blur-md shadow-lg shadow-black/20' : 'py-7 bg-transparent'"
  >

    <div class="text-2xl md:text-3xl font-black italic tracking-tighter uppercase shrink-0 text-white">
      Street <span class="font-light">Urban</span>
    </div>

    <!-- Desktop Menu -->
    <div class="hidden lg:flex space-x-12 text-xs font-semibold tracking-widest uppercase text-gray-300">
      <Link :href="route('shop.home')" class="hover:text-white transition-colors relative group">
        Inicio
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
      </Link>
      <Link :href="route('shop.tienda')" class="hover:text-white transition-colors relative group">
        Tienda
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
      </Link>
      <a href="#" class="hover:text-white transition-colors relative group">
        Ofertas
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
      </a>
      <a href="#" class="hover:text-white transition-colors relative group">
        Nosotros
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
      </a>
      <a href="#" class="hover:text-white transition-colors relative group">
        Contacto
        <span class="absolute bottom-0 left-0 w-0 h-0.5 bg-white group-hover:w-full transition-all duration-300"></span>
      </a>
    </div>

    <!-- Right Section -->
    <div class="flex items-center space-x-4 text-sm text-white">
      <!-- Search Button -->
      <button class="p-2 hover:bg-white/10 rounded-lg transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
        </svg>
      </button>

      <!-- Cart Button -->
      <Link :href="route('shop.carrito')" class="hidden sm:flex items-center space-x-2 p-2 hover:bg-white/10 rounded-lg transition-all">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
        </svg>
        <span class="text-xs font-semibold tracking-wide">{{ items }}</span>
      </Link>

      <!-- Admin/Login Buttons -->
      <div class="hidden sm:flex items-center space-x-3">
        <Link
          v-if="page.props.auth?.user"
          :href="route('admin.dashboard')"
          class="px-4 py-2 border border-white/40 text-white text-xs font-semibold uppercase tracking-widest hover:bg-white/10 hover:border-white/70 transition-all duration-300 group relative overflow-hidden"
        >
          <span class="relative z-10">Panel Admin</span>
          <div class="absolute inset-0 bg-white/5 transform scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></div>
        </Link>
        <template v-else>
          <Link
            :href="route('login')"
            class="px-4 py-2 border border-white/40 text-white text-xs font-semibold uppercase tracking-widest hover:bg-white/10 hover:border-white/70 transition-all duration-300 group relative overflow-hidden"
          >
            <span class="relative z-10">Ingresar</span>
            <div class="absolute inset-0 bg-white/5 transform scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-300"></div>
          </Link>
        </template>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="toggleMobileMenu" class="lg:hidden p-2">
        <svg v-if="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
        </svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
      </button>
    </div>
  </nav>

  <!-- Mobile Menu -->
  <transition name="slide">
    <div v-if="mobileMenuOpen" class="fixed top-16 left-0 w-full bg-[#111111]/98 backdrop-blur-md z-40 border-b border-white/10 lg:hidden">
      <div class="px-6 py-8 space-y-6">
        <Link :href="route('shop.home')" class="block text-sm font-semibold tracking-widest uppercase text-gray-300 hover:text-white transition-colors">Inicio</Link>
        <Link :href="route('shop.tienda')" class="block text-sm font-semibold tracking-widest uppercase text-gray-300 hover:text-white transition-colors">Tienda</Link>
        <a href="#" class="block text-sm font-semibold tracking-widest uppercase text-gray-300 hover:text-white transition-colors">Ofertas</a>
        <a href="#" class="block text-sm font-semibold tracking-widest uppercase text-gray-300 hover:text-white transition-colors">Nosotros</a>
        <a href="#" class="block text-sm font-semibold tracking-widest uppercase text-gray-300 hover:text-white transition-colors">Contacto</a>
      </div>
    </div>
  </transition>
</template>

<style scoped>
.slide-enter-active, .slide-leave-active {
  transition: all 0.3s ease;
}

.slide-enter-from {
  opacity: 0;
  transform: translateY(-10px);
}

.slide-leave-to {
  opacity: 0;
  transform: translateY(-10px);
}
</style>
