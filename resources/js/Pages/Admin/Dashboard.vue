<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Welcome Section -->
      <div class="border-b border-gray-800 pb-8">
        <h3 class="text-3xl font-bold mb-2">Bienvenido al Panel de Control</h3>
        <p class="text-gray-400">Gestiona tu ecommerce desde aquí</p>
      </div>

      <!-- Cards Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Clientes Card -->
        <Link
          :href="route('admin.customers.index')"
          class="group relative p-8 bg-gradient-to-br from-[#1a1a1a] to-[#0f0f0f] border border-gray-800 rounded-xl hover:border-gray-700 transition-all duration-300 cursor-pointer overflow-hidden"
        >
          <!-- Gradient overlay on hover -->
          <div class="absolute inset-0 bg-gradient-to-br from-blue-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

          <div class="relative z-10">
            <div class="text-5xl mb-4">👥</div>
            <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-400 transition-colors">Clientes</h3>
            <p class="text-gray-400 group-hover:text-gray-300 transition-colors">Gestiona los clientes del sistema</p>
            <p class="text-xs text-gray-600 mt-4">Click para acceder →</p>
          </div>
        </Link>

        <!-- Productos Card -->
        <Link
          :href="route('admin.products.index')"
          class="group relative p-8 bg-gradient-to-br from-[#1a1a1a] to-[#0f0f0f] border border-gray-800 rounded-xl hover:border-gray-700 transition-all duration-300 cursor-pointer overflow-hidden"
        >
          <!-- Gradient overlay on hover -->
          <div class="absolute inset-0 bg-gradient-to-br from-green-600/10 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

          <div class="relative z-10">
            <div class="text-5xl mb-4">📦</div>
            <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-green-400 transition-colors">Productos</h3>
            <p class="text-gray-400 group-hover:text-gray-300 transition-colors">Gestiona el catálogo de productos</p>
            <p class="text-xs text-gray-600 mt-4">Click para acceder →</p>
          </div>
        </Link>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
