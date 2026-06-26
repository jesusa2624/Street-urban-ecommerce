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
    <section class="py-24 px-4 md:px-8 lg:px-16 max-w-[1600px] mx-auto border-t border-white/10">
      <h2 class="text-2xl md:text-3xl font-black uppercase tracking-tighter mb-12 italic">
        Explora por <span class="text-white/50">Categoría</span>
      </h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Ropa -->
        <a href="#" class="group relative h-80 rounded-2xl overflow-hidden">
          <img
            src="https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=600"
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
            src="https://images.pexels.com/photos/1926769/pexels-photo-1926769.jpeg?auto=compress&cs=tinysrgb&w=600&q=80&crop=entropy&cs=tinysrgb"
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
            src="https://images.pexels.com/photos/1884581/pexels-photo-1884581.jpeg?auto=compress&cs=tinysrgb&w=600"
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
            src="https://images.pexels.com/photos/3973661/pexels-photo-3973661.jpeg?auto=compress&cs=tinysrgb&w=600"
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

    <!-- Footer CTA -->
    <section class="py-20 px-4 md:px-8 border-t border-white/10">
      <div class="max-w-[1600px] mx-auto flex flex-col md:flex-row justify-between items-center gap-8">
        <div>
          <h3 class="text-2xl md:text-3xl font-black uppercase tracking-tight mb-2">
            Síguenos para nuevos <span class="text-white/50">drops</span>
          </h3>
          <p class="text-gray-400 text-sm">Noticias de nuevas colecciones antes que nadie</p>
        </div>
        <div class="flex gap-4">
          <a href="#" class="p-3 border border-white/20 hover:bg-white/10 rounded-lg transition-all">
            <span class="text-white text-sm font-semibold">Instagram</span>
          </a>
          <a href="#" class="p-3 border border-white/20 hover:bg-white/10 rounded-lg transition-all">
            <span class="text-white text-sm font-semibold">Twitter</span>
          </a>
        </div>
      </div>
    </section>
  </ShopLayout>
</template>
