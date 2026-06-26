<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';

const props = defineProps({
  product: {
    type: Object,
    required: true
  }
});

const imageLoaded = ref(false);
const imageError = ref(false);
const isFavorite = ref(false);

const toggleFavorite = () => {
  isFavorite.value = !isFavorite.value;
};

const handleImageLoad = () => {
  imageLoaded.value = true;
};

const handleImageError = () => {
  imageError.value = true;
};

// Generamos badges y descuentos ficticios para potenciar el diseño visual streetwear
const hasSale = computed(() => props.product.id % 3 === 0);
const isNew = computed(() => props.product.id === 2 || props.product.id === 5 || props.product.id === 11);
const isLimited = computed(() => props.product.price > 100 && !hasSale.value);

const originalPrice = computed(() => {
  if (hasSale.value) {
    return Math.round(props.product.price * 1.33);
  }
  return null;
});

const discountPercentage = computed(() => {
  if (hasSale.value && originalPrice.value) {
    return Math.round(((originalPrice.value - props.product.price) / originalPrice.value) * 100);
  }
  return null;
});

const productImage = computed(() => {
  if (imageError.value) {
    return null;
  }
  return props.product.image;
});
</script>

<template>
  <div class="group relative flex flex-col overflow-hidden bg-[#121212] border border-white/5 rounded-2xl transition-all duration-500 hover:border-white/20 hover:shadow-[0_12px_30px_rgba(0,0,0,0.8)]">
    
    <!-- Contenedor de la Imagen (Área Interactiva Superior) -->
    <div class="relative aspect-square overflow-hidden bg-[#181818] w-full rounded-t-2xl">

      <!-- Skeleton Loader mientras carga -->
      <div v-if="!imageLoaded && !imageError" class="absolute inset-0 bg-gradient-to-r from-gray-800 via-gray-700 to-gray-800 animate-pulse"></div>

      <!-- Placeholder cuando hay error en la imagen -->
      <div v-if="imageError" class="absolute inset-0 bg-gradient-to-br from-gray-800 to-gray-900 flex flex-col items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 text-gray-600 mb-2">
          <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 15.75l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-15-4.35l5.159-5.159a2.25 2.25 0 0 1 3.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 0 1 3.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 0 0 1.5-1.5V6a1.5 1.5 0 0 0-1.5-1.5H3.75A1.5 1.5 0 0 0 2.25 6v12a1.5 1.5 0 0 0 1.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0z" />
        </svg>
        <p class="text-xs text-gray-500 text-center px-2">Imagen no disponible</p>
      </div>

      <!-- Imagen con zoom suave y transición de opacidad -->
      <img
        v-if="productImage"
        :src="productImage"
        :alt="product.name"
        @load="handleImageLoad"
        @error="handleImageError"
        class="h-full w-full object-cover object-center transition-transform duration-700 ease-out group-hover:scale-105 group-hover:opacity-85"
        :class="imageLoaded ? 'opacity-100' : 'opacity-0'"
        loading="lazy"
      />

      <!-- Capa de degradado sutil de fondo para la imagen -->
      <div class="absolute inset-0 bg-gradient-to-t from-black/40 via-transparent to-black/10 opacity-60 pointer-events-none"></div>

      <!-- BADGES STREETWEAR (Esquina Superior Izquierda) -->
      <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10 pointer-events-none">
        <!-- Badge de Descuento -->
        <span v-if="hasSale" class="bg-red-600 text-white text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md shadow-md font-mono">
          -{{ discountPercentage }}% OFF
        </span>
        <!-- Badge de Lanzamiento Nuevo -->
        <span v-if="isNew" class="bg-white text-black text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md shadow-md">
          NEW DROP
        </span>
        <!-- Badge de Edición Limitada -->
        <span v-if="isLimited" class="bg-black text-yellow-400 border border-yellow-400/30 text-[10px] font-black uppercase tracking-widest px-2.5 py-1 rounded-md shadow-md">
          LIMITED
        </span>
      </div>

      <!-- BOTÓN WISHLIST (Esquina Superior Derecha) -->
      <button 
        @click.stop.prevent="toggleFavorite"
        class="absolute top-3 right-3 z-20 p-2 bg-black/60 backdrop-blur-md rounded-full border border-white/10 text-white/70 hover:text-white hover:border-white/30 hover:scale-105 transition-all duration-300"
        aria-label="Añadir a Favoritos"
      >
        <svg 
          xmlns="http://www.w3.org/2000/svg" 
          :fill="isFavorite ? 'currentColor' : 'none'" 
          viewBox="0 0 24 24" 
          stroke-width="1.8" 
          stroke="currentColor" 
          class="w-4 h-4 transition-colors duration-300"
          :class="{ 'text-red-500': isFavorite }"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
      </button>

      <!-- ACCIÓN RÁPIDA: DESLIZAR DESDE ABAJO (Solo sobre la imagen) -->
      <div class="absolute bottom-0 inset-x-0 p-3 bg-gradient-to-t from-black/90 via-black/75 to-transparent translate-y-full group-hover:translate-y-0 transition-transform duration-300 ease-out z-10">
        <button class="w-full bg-white text-black py-2.5 px-4 text-xs font-black uppercase tracking-widest hover:bg-black hover:text-white hover:border-white border border-white rounded-lg transition-all duration-300 flex items-center justify-center gap-2">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 10.5V6a3.75 3.75 0 1 0-7.5 0v4.5m11.356-1.993 1.263 12c.07.665-.45 1.243-1.119 1.243H4.25a1.125 1.125 0 0 1-1.12-1.243l1.264-12A1.125 1.125 0 0 1 5.513 7.5h12.974c.576 0 1.059.435 1.119 1.007ZM8.625 10.5a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm7.5 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Z" />
          </svg>
          Añadir al Carrito
        </button>
      </div>
    </div>

    <!-- Detalles del Producto (Sección Inferior) -->
    <div class="flex flex-1 flex-col p-4 justify-between bg-[#121212] border-t border-white/5 rounded-b-2xl">
      <div class="space-y-1.5">
        <!-- Nombre y Enlace al Producto -->
        <h3 class="text-xs font-black uppercase tracking-widest text-gray-400 group-hover:text-white transition-colors duration-300">
          <Link :href="`/shop/products/${product.id}`" class="hover:underline block">
            {{ product.name }}
          </Link>
        </h3>
        
        <!-- Descripción Breve -->
        <p class="text-xs text-gray-500 font-light line-clamp-1 leading-relaxed">
          {{ product.description }}
        </p>
      </div>

      <!-- Fila de Precios y Tallas -->
      <div class="mt-4 pt-3 border-t border-white/5 flex flex-col gap-3">
        <!-- Visualización de Precios -->
        <div class="flex items-baseline justify-between">
          <div class="flex items-baseline gap-2">
            <!-- Precio Actual -->
            <span class="text-base font-black text-white font-mono">
              ${{ product.price }}
            </span>
            <!-- Precio Anterior (Tachado si hay descuento) -->
            <span v-if="hasSale" class="text-xs text-gray-500 line-through font-mono">
              ${{ originalPrice }}
            </span>
          </div>
          <!-- Código del Producto / Identificador sutil de Stock -->
          <span class="text-[9px] text-gray-600 font-mono tracking-widest uppercase">
            REF-00{{ product.id }}
          </span>
        </div>

        <!-- Indicador de Tallas Disponibles (Estilo Streetwear) -->
        <div class="flex items-center justify-between text-[10px] text-gray-500 font-mono border-t border-white/5 pt-2.5">
          <span class="tracking-widest text-gray-600">SIZES:</span>
          <div class="flex gap-1">
            <span class="border border-white/10 hover:border-white/40 hover:text-white transition-colors px-1 py-0.5 min-w-[16px] text-center cursor-default">S</span>
            <span class="border border-white/10 hover:border-white/40 hover:text-white transition-colors px-1 py-0.5 min-w-[16px] text-center cursor-default">M</span>
            <span class="border border-white/10 hover:border-white/40 hover:text-white transition-colors px-1 py-0.5 min-w-[16px] text-center cursor-default">L</span>
            <span class="border border-white/10 hover:border-white/40 hover:text-white transition-colors px-1 py-0.5 min-w-[16px] text-center cursor-default">XL</span>
          </div>
        </div>
      </div>
    </div>

  </div>
</template>
