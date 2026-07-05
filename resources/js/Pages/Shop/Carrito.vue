<script setup>
import { ref, computed, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/Shop/ShopLayout.vue';
import { getItems, saveItems, updateQuantity } from '@/cart';

const cartItems = ref([]);

const visible = ref(false);

// Calcula total y subtotal
const subtotal = computed(() => {
  return cartItems.value.reduce((acc, item) => acc + (item.price * item.cantidad), 0);
});

// Quita elementos del carrito
const removeItem = (id) => {
  cartItems.value = cartItems.value.filter(item => item.id !== id);
  saveItems(cartItems.value);
  window.dispatchEvent(new Event('cart-updated'));
};

// Actualiza las cantidades de cada elemento
const changeQuantity = (id, delta) => {
  updateQuantity(id, delta);
  // Actualiza los datos locales tras la actualización
  cartItems.value = getItems();
};

// Comprueba si no hay elementos en el carrito
const isCartEmpty = computed(() => cartItems.value.length === 0);

onMounted(() => {
  cartItems.value = getItems();

  requestAnimationFrame(() => {
    visible.value = true;
  });
});
</script>

<template>
  <Head title="Carrito" />
  <ShopLayout>
    <div class="pt-20"></div>

    <!-- Título de la página -->
    <section class="relative py-16 px-4 md:px-8 lg:px-16 overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-transparent to-transparent"></div>
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>

      <div class="relative max-w-full mx-auto">
        <div>
          <!-- Título Principal -->
          <h1 class="text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-tight italic leading-tight mb-4 max-w-4xl">
            Tu <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Carrito</span>
          </h1>
          <div class="h-1.5 w-24 bg-gradient-to-r from-white via-white to-gray-600 rounded-full"></div>
        </div>
      </div>
    </section>

    <section class="px-4 md:px-8 lg:px-16 max-w-[1400px] mx-auto pb-24">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
        <!-- Productos del carrito -->
        <div class="lg:col-span-2 space-y-6">
          <!-- Si el carrito está vacío -->
          <div v-if="cartItems.length === 0" class="py-20 text-center border border-dashed border-gray-800 rounded-2xl">
            <p>Tu carrito está vacío.</p>
            <Link :href="route('shop.tienda')" class="mt-4 inline-block text-white border-b border-white hover:opacity-70">Ver productos</Link>
          </div>

          <!-- Recorre los productos -->
          <div v-else class="space-y-6">
            <div v-for="item in cartItems" :key="item.id" class="flex gap-6 p-4 border border-gray-800 rounded-xl hover:border-gray-600 transition-colors">
              <img :src="item.image" :alt="item.name" class="w-20 h-20 object-cover rounded-lg bg-gray-900" />
              <div class="flex-1 flex justify-between items-center">
                <div>
                  <h3 class="font-bold text-lg uppercase">{{ item.name }}</h3>
                  
                  <div class="flex items-center gap-3 mt-2">
                    <button @click="changeQuantity(item.id, -1)" class="w-8 h-8 flex items-center justify-center border border-gray-700 hover:border-white transition-colors">&minus;</button>
                    <span class="font-mono w-8 text-center">{{ item.cantidad }}</span>
                    <button  @click="changeQuantity(item.id, 1)" class="w-8 h-8 flex items-center justify-center border border-gray-700 hover:border-white transition-colors">+</button>
                  </div>
                </div>

                <div class="text-right">
                  <p class="font-mono mb-2">S/ {{ (item.price * item.cantidad).toFixed(2) }}</p>
                  <button @click="removeItem(item.id)" class="text-xs text-red-500/70 hover:text-red-500 uppercase tracking-widest">
                    Eliminar
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Barra lateral derecha -->
        <div class="lg:col-span-1">
          <div class="sticky top-28 bg-[#0a0a0a] p-8 border border-gray-800 rounded-2xl">
            <h2 class="text-xl font-black uppercase mb-6 italic">Resumen</h2>
            <div class="space-y-4 mb-8">
              <div class="flex justify-between text-gray-400">
                <span>Subtotal</span>
                <span class="font-mono">S/ {{ subtotal.toFixed(2) }}</span>
              </div>
              <div class="h-px bg-gray-800"></div>
              <div class="flex justify-between text-2xl font-black uppercase">
                <span>Total</span>
                <span class="font-mono">S/ {{ subtotal.toFixed(2) }}</span>
              </div>
            </div>
            <button 
              :disabled="isCartEmpty"
              :class="[
                'w-full py-4 font-black uppercase tracking-widest transition-all',
                isCartEmpty 
                  ? 'bg-gray-800 text-gray-500 cursor-not-allowed' 
                  : 'bg-white text-black hover:bg-gray-200'
              ]"
            >
              Finalizar Pedido
            </button>
          </div>
        </div>
      </div>
    </section>
  </ShopLayout>
</template>
