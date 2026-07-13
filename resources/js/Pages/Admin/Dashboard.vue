<template>
  <AdminLayout>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <!-- Clientes Card -->
      <Link
        :href="route('admin.customers.index')"
        class="p-6 bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-300 rounded-lg hover:shadow-lg transition cursor-pointer"
      >
        <div class="text-4xl mb-3">👥</div>
        <h3 class="text-xl font-bold text-blue-900 mb-2">Clientes</h3>
        <p class="text-gray-700">Gestiona los clientes del sistema</p>
      </Link>

      <!-- Productos Card -->
      <Link
        :href="route('admin.products.index')"
        class="p-6 bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-300 rounded-lg hover:shadow-lg transition cursor-pointer"
      >
        <div class="text-4xl mb-3">📦</div>
        <h3 class="text-xl font-bold text-green-900 mb-2">Productos</h3>
        <p class="text-gray-700">Gestiona el catálogo de productos</p>
      </Link>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
