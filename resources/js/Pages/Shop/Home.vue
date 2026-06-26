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

    <!-- Categories Preview -->
    <section class="py-32 px-4 md:px-8 lg:px-16 max-w-[1600px] mx-auto">
      <div class="space-y-2 mb-12">
        <div class="h-px bg-gradient-to-r from-transparent via-gray-700 to-transparent"></div>
      </div>
      <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter mb-12 italic">
        Explora por <span class="text-white/50">Categoría</span>
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Ropa -->
        <a href="#" class="group relative h-80 rounded-2xl overflow-hidden">
          <img
            src="/image/shop/ropa.jpeg"
            alt="Ropa"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-all duration-300"></div>
          <div class="absolute bottom-0 left-0 right-0 p-6">
            <h3 class="text-2xl font-black uppercase tracking-tight text-white">Ropa</h3>
            <p class="text-sm text-gray-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Ver colección</p>
          </div>
        </a>

        <!-- Calzado -->
        <a href="#" class="group relative h-80 rounded-2xl overflow-hidden">
          <img
            src="/image/shop/calzados.jpeg"
            alt="Calzado"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-all duration-300"></div>
          <div class="absolute bottom-0 left-0 right-0 p-6">
            <h3 class="text-2xl font-black uppercase tracking-tight text-white">Calzado</h3>
            <p class="text-sm text-gray-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Ver colección</p>
          </div>
        </a>

        <!-- Accesorios -->
        <a href="#" class="group relative h-80 rounded-2xl overflow-hidden">
          <img
            src="/image/shop/accesorio.jpeg"
            alt="Accesorios"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-all duration-300"></div>
          <div class="absolute bottom-0 left-0 right-0 p-6">
            <h3 class="text-2xl font-black uppercase tracking-tight text-white">Accesorios</h3>
            <p class="text-sm text-gray-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Ver colección</p>
          </div>
        </a>

        <!-- Sombrería -->
        <a href="#" class="group relative h-80 rounded-2xl overflow-hidden">
          <img
            src="/image/shop/gorro.jpeg"
            alt="Sombrería"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
          />
          <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent group-hover:from-black/90 transition-all duration-300"></div>
          <div class="absolute bottom-0 left-0 right-0 p-6">
            <h3 class="text-2xl font-black uppercase tracking-tight text-white">Sombrería</h3>
            <p class="text-sm text-gray-300 mt-2 opacity-0 group-hover:opacity-100 transition-opacity">Ver colección</p>
          </div>
        </a>
      </div>
    </section>

    <!-- Product Grid -->
    <section id="productos" class="py-24 px-4 md:px-8 lg:px-16 max-w-[1600px] mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
        <div>
          <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter italic">
            Colección <span class="text-white/50">Featured</span>
          </h2>
          <div class="h-1.5 w-32 bg-gradient-to-r from-white to-white/20 mt-6"></div>
        </div>
        <p class="text-gray-400 text-xs uppercase tracking-widest font-mono border border-white/10 px-4 py-2 rounded">
          {{ products.length }} Items en Stock
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

    <!-- Footer CTA - Newsletter -->
    <section class="py-24 px-4 md:px-8 border-t border-gray-800 bg-[#0a0a0a]">
      <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-black uppercase tracking-tight mb-4">
          Recibe nuestros <span class="text-gray-500">Drops</span> Primero
        </h2>
        <p class="text-gray-400 mb-8">Suscríbete y obtén acceso exclusivo a nuevos lanzamientos y ofertas especiales</p>

        <form class="flex gap-3 mb-6">
          <input
            type="email"
            placeholder="tu@email.com"
            class="flex-1 px-4 py-3 bg-white text-black rounded-lg focus:outline-none"
          />
          <button
            type="submit"
            class="px-8 py-3 bg-white text-black font-bold uppercase text-sm rounded-lg hover:bg-gray-200 transition-colors"
          >
            Suscribir
          </button>
        </form>

        <div class="flex justify-center gap-6 pt-6 border-t border-gray-800">
          <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">Instagram</a>
          <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">Twitter</a>
          <a href="#" class="text-gray-400 hover:text-white transition-colors text-sm font-medium">TikTok</a>
        </div>
      </div>
    </section>
  </ShopLayout>
</template>
