<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
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
            class="w-full sm:w-auto px-10 py-4 bg-[#ff8c42] text-black font-bold uppercase tracking-widest hover:bg-[#ffb380] transition-all duration-300 text-sm rounded-lg"
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
        <div class="h-px bg-gradient-to-r from-transparent via-[#ff8c42]/30 to-transparent"></div>
      </div>
      <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter mb-12 italic">
        Explora por <span class="text-white/50">Categoría</span>
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Ropa -->
        <Link :href="`${route('shop.tienda')}?category=Ropa`" class="group relative h-80 rounded-2xl overflow-hidden block">
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
        </Link>

        <!-- Calzado -->
        <Link :href="`${route('shop.tienda')}?category=Calzados`" class="group relative h-80 rounded-2xl overflow-hidden block">
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
        </Link>

        <!-- Accesorios -->
        <Link :href="`${route('shop.tienda')}?category=Accesorios`" class="group relative h-80 rounded-2xl overflow-hidden block">
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
        </Link>

        <!-- Sombrería -->
        <Link :href="`${route('shop.tienda')}?category=Sombrería`" class="group relative h-80 rounded-2xl overflow-hidden block">
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
        </Link>
      </div>
    </section>

    <!-- Product Grid -->
    <section id="productos" class="py-24 px-4 md:px-8 lg:px-16 max-w-[1600px] mx-auto">
      <div class="flex flex-col md:flex-row justify-between items-end mb-16 gap-4">
        <div>
          <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tighter italic">
            Colección <span class="text-white/50">Featured</span>
          </h2>
          <div class="h-1.5 w-32 bg-gradient-to-r from-[#ff8c42] to-white/20 mt-6"></div>
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
    <section class="relative py-32 px-4 md:px-8 border-t border-gray-800 overflow-hidden">
      <!-- Animated background -->
      <div class="absolute inset-0">
        <div class="absolute top-1/2 right-0 w-96 h-96 bg-[#ff8c42]/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-white/5 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
      </div>

      <div class="relative max-w-3xl mx-auto text-center">
        <p class="text-sm uppercase tracking-[0.3em] text-[#ff8c42] font-semibold mb-4">
          Sé el primero
        </p>
        <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tight italic mb-6">
          Recibe nuestros <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#ff8c42] to-white">Drops</span> Primero
        </h2>
        <p class="text-gray-400 mb-10 text-lg leading-relaxed">Suscríbete y obtén acceso exclusivo a nuevos lanzamientos, ofertas especiales y contenido detrás de cámaras.</p>

        <form class="flex flex-col sm:flex-row gap-3 mb-8 max-w-lg mx-auto">
          <input
            type="email"
            placeholder="tu@email.com"
            required
            class="flex-1 px-6 py-4 bg-white/10 border border-gray-700 rounded-lg text-white placeholder-gray-500 focus:border-[#ff8c42] focus:outline-none transition-colors"
          />
          <button
            type="submit"
            class="px-8 py-4 bg-[#ff8c42] text-black font-bold uppercase text-sm rounded-lg hover:bg-[#ffb380] transition-colors whitespace-nowrap"
          >
            Suscribir
          </button>
        </form>

        <div class="flex justify-center gap-6 pt-8 border-t border-gray-800">
          <a href="#" class="w-12 h-12 rounded-lg border border-gray-800 flex items-center justify-center hover:border-[#ff8c42] hover:bg-[#ff8c42]/10 transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-[#ff8c42] group-hover:scale-110 transition-transform">
              <path d="M8.29 20v-7.21H5.5V9.25h2.79V7.69c0-2.86 1.72-4.43 4.51-4.43 1.31 0 2.43.1 2.75.14v3.09h-1.89c-1.4 0-1.74.67-1.74 1.64v2.16h3.44l-.46 3.54h-2.98V20z"/>
            </svg>
          </a>
          <a href="#" class="w-12 h-12 rounded-lg border border-gray-800 flex items-center justify-center hover:border-[#ff8c42] hover:bg-[#ff8c42]/10 transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-[#ff8c42] group-hover:scale-110 transition-transform">
              <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2s9 5 20 5a9.5 9.5 0 00-9-5.5c4.75 2.25 7-7 7-7"/>
            </svg>
          </a>
          <a href="#" class="w-12 h-12 rounded-lg border border-gray-800 flex items-center justify-center hover:border-[#ff8c42] hover:bg-[#ff8c42]/10 transition-all group">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5 text-[#ff8c42] group-hover:scale-110 transition-transform">
              <rect x="2" y="2" width="20" height="20" rx="5" ry="5" fill="none" stroke="currentColor" stroke-width="2"/>
              <path d="M16 11.37A4 4 0 1112.63 8" stroke="currentColor" stroke-width="2" fill="none"/>
              <circle cx="17.5" cy="6.5" r="1.5" fill="currentColor"/>
            </svg>
          </a>
        </div>
      </div>
    </section>
  </ShopLayout>
</template>
