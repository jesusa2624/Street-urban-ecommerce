<script setup>
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
import { add } from '@/cart';

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

// Añade productos al carrito y actualiza el contador
const addToCart = () => {
  add(props.product);
  window.dispatchEvent(new Event('cart-updated'));
  console.log('Producto agregado');
};

</script>

<template>
  <div class="group relative flex flex-col overflow-hidden bg-[#1a1a1a] border border-gray-800 rounded-lg transition-all duration-300 hover:shadow-lg hover:border-gray-700">

    <!-- Contenedor de la Imagen (Área Interactiva Superior) -->
    <div class="relative aspect-square overflow-hidden bg-[#0f0f0f] w-full">

      <!-- Skeleton Loader mientras carga -->
      <div v-if="!imageLoaded && !imageError" class="absolute inset-0 bg-gray-700 animate-pulse"></div>

      <!-- Placeholder cuando hay error en la imagen -->
      <div v-if="imageError" class="absolute inset-0 bg-gray-800 flex flex-col items-center justify-center">
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor" class="w-12 h-12 text-gray-400 mb-2">
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
        class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-110"
        :class="imageLoaded ? 'opacity-100' : 'opacity-0'"
        loading="lazy"
      />

      <!-- BADGES (Esquina Superior Izquierda) -->
      <div class="absolute top-4 left-4 flex flex-col gap-2 z-10 pointer-events-none">
        <span v-if="hasSale" class="bg-red-500 text-white text-xs font-bold px-3 py-1 rounded-full">
          -{{ discountPercentage }}%
        </span>
        <span v-if="isNew" class="bg-black text-white text-xs font-bold px-3 py-1 rounded-full">
          Nuevo
        </span>
      </div>

      <!-- BOTÓN WISHLIST (Esquina Superior Derecha) -->
      <button
        @click.stop.prevent="toggleFavorite"
        class="absolute top-4 right-4 z-20 p-2 bg-white rounded-full shadow-md hover:shadow-lg transition-all"
        aria-label="Añadir a Favoritos"
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          :fill="isFavorite ? 'currentColor' : 'none'"
          viewBox="0 0 24 24"
          stroke-width="2"
          stroke="currentColor"
          class="w-5 h-5 transition-colors"
          :class="{ 'text-red-500': isFavorite, 'text-gray-400': !isFavorite }"
        >
          <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
        </svg>
      </button>
    </div>

    <!-- Detalles del Producto (Sección Inferior) -->
    <div class="flex flex-1 flex-col p-4 justify-between">
      <!-- Marca y Categoría -->
      <div class="flex items-center justify-between mb-2">
        <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">{{ product.brand }}</span>
        <span v-if="!product.stock" class="text-xs font-bold text-red-500 uppercase tracking-wider">
          Agotado
        </span>
        <span v-else class="text-xs font-bold text-green-500 uppercase tracking-wider">
          En stock
        </span>
      </div>

      <!-- Nombre y Enlace al Producto -->
      <div>
        <h3 class="text-sm font-semibold text-white">
          <Link :href="`/shop/products/${product.id}`" class="hover:text-gray-300 transition-colors">
            {{ product.name }}
          </Link>
        </h3>
        <p class="text-xs text-gray-400 mt-1 line-clamp-2">
          {{ product.description }}
        </p>
      </div>

      <!-- Rating y Vendidos -->
      <div class="mt-3 pt-3 border-t border-gray-700 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <!-- Estrellas -->
          <div class="flex gap-0.5">
            <span v-for="i in 5" :key="i" class="text-xs">
              <span v-if="i <= Math.floor(product.rating)" class="text-yellow-400">★</span>
              <span v-else class="text-gray-600">★</span>
            </span>
          </div>
          <span class="text-xs text-gray-400">{{ product.rating }}</span>
        </div>
        <span class="text-xs text-gray-500">{{ product.sold }} vendidos</span>
      </div>

      <!-- Precio y Carrito -->
      <div class="mt-3 pt-3 border-t border-gray-700 flex items-end justify-between">
        <div class="flex flex-col">
          <div class="flex items-baseline gap-2">
            <span class="text-lg font-bold text-white">
              S/ {{ product.price }}
            </span>
            <span v-if="hasSale" class="text-xs text-gray-500 line-through">
              S/ {{ originalPrice }}
            </span>
          </div>
        </div>
        <button @click="addToCart" :disabled="!product.stock" class="p-2 bg-white text-black rounded-lg hover:bg-gray-200 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
          <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
          </svg>
        </button>
      </div>
    </div>

  </div>
</template>
