<script setup>
import { Link } from '@inertiajs/vue3';

defineProps({
  product: Object
});
</script>

<template>
  <div class="group relative flex flex-col overflow-hidden bg-[#1a1a1a] rounded-none transition-all duration-300 hover:shadow-[0_0_20px_rgba(255,255,255,0.05)]">
    <!-- Imagen del Producto -->
    <div class="aspect-square overflow-hidden bg-gray-800">
      <img
        :src="product.image"
        :alt="product.name"
        class="h-full w-full object-cover object-center transition-transform duration-500 group-hover:scale-110"
      />
      <!-- Overlay de acción rápida al hacer hover -->
      <div class="absolute inset-0 flex items-end justify-center p-4 opacity-0 transition-opacity duration-300 group-hover:opacity-100 bg-black/20">
        <button class="w-full bg-white text-black py-2 text-sm font-bold uppercase tracking-widest hover:bg-gray-200 transition-colors">
          Añadir al carrito
        </button>
      </div>
    </div>

    <!-- Detalles del Producto -->
    <div class="flex flex-1 flex-col p-4 space-y-1">
      <div class="flex justify-between items-start">
        <div>
          <h3 class="text-sm font-medium text-gray-200 uppercase tracking-wider">
            <Link :href="`/shop/products/${product.id}`">
              {{ product.name }}
            </Link>
          </h3>
          <p class="mt-1 text-xs text-gray-500 line-clamp-1">
            {{ product.description }}
          </p>
        </div>
        <p class="text-sm font-bold text-white">
          ${{ product.price }}
        </p>
      </div>
    </div>
  </div>
</template>
