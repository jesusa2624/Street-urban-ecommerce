<script setup>
import { ref, onMounted } from 'vue';
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/Shop/ShopLayout.vue';
import { getItems } from '@/cart';

const cartItems = ref([]);

const visible = ref(false);

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
    <!-- Hero -->
    <section>
      <div v-if="cartItems.length === 0">
        Tu carrito está vacío.
      </div>

      <div v-else>
        <div v-for="item in cartItems" :key="item.id">
          <h2>{{ item.name }}</h2>
          <p>S/ {{ item.price }}</p>
          <p>Cantidad: {{ item.cantidad }}</p>
        </div>
      </div>
    </section>
  </ShopLayout>
</template>
