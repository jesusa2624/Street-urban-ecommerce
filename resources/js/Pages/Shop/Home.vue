<script setup>
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/Shop/ShopLayout.vue';
import ProductCard from '@/Components/Shop/ProductCard.vue';

defineProps({
  products: Array
});

const visible = ref(false);

onMounted(() => {
  requestAnimationFrame(() => { visible.value = true; });
});
</script>

<template>
  <Head title="Home" />
  <ShopLayout>
    <!-- Hero -->
    <section class="relative w-full h-[80vh] flex items-center justify-center overflow-hidden">
      <img
        src="/image/shop/hero-bg.jpg"
        alt="Hero Background"
        class="absolute inset-0 w-full h-full object-cover scale-105 transition-transform duration-1000"
      >
      <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-[#111111]"></div>

      <div class="relative z-10 text-center px-4 max-w-4xl">
        <h1
          class="text-5xl md:text-7xl font-black uppercase tracking-tighter mb-6 text-white italic transition-all duration-1000"
          :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          Street <span class="text-white/50">Urban</span>
        </h1>
        <p
          class="text-lg md:text-xl text-gray-300 mb-10 font-light tracking-wide max-w-2xl mx-auto transition-all duration-1000 delay-200"
          :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          Define tu estilo. Domina las calles con nuestra nueva colección de temporada.
        </p>
        <div
          class="flex flex-col sm:flex-row items-center justify-center gap-4 transition-all duration-1000 delay-500"
          :class="visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-8'"
        >
          <a
            href="#productos"
            class="w-full sm:w-auto px-10 py-4 bg-white text-black font-bold uppercase tracking-widest hover:bg-gray-200 transition-all duration-300 text-sm"
          >
            Comprar Ahora
          </a>
          <a
            href="#"
            class="w-full sm:w-auto px-10 py-4 border border-white/30 text-white font-bold uppercase tracking-widest hover:bg-white/10 transition-all duration-300 text-sm"
          >
            Nueva Colección
          </a>
        </div>
      </div>
    </section>

    <!-- Product Grid -->
    <section id="productos" class="py-24 px-4 md:px-8 lg:px-16 max-w-[1600px] mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
        <div>
          <h2 class="text-3xl md:text-4xl font-bold uppercase tracking-tighter italic">
            Nuestros <span class="text-white/40">Must-Haves</span>
          </h2>
          <div class="h-1 w-20 bg-white mt-4"></div>
        </div>
        <p class="text-gray-400 text-sm uppercase tracking-widest">
          {{ products.length }} Productos Disponibles
        </p>
      </div>

      <div v-if="products.length > 0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
        <ProductCard
          v-for="product in products"
          :key="product.id"
          :product="product"
        />
      </div>

      <div v-else class="py-20 text-center">
        <p class="text-gray-500 text-xl italic">No hay productos disponibles en este momento.</p>
      </div>
    </section>
  </ShopLayout>
</template>
