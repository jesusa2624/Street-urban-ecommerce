<template>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Panel de Administración
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 text-gray-900">
            <h3 class="text-2xl font-bold mb-6">Bienvenido al Panel de Admin</h3>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
              <!-- Opción Productos -->
              <Link
                :href="route('admin.products.index')"
                class="p-6 bg-blue-50 hover:bg-blue-100 border-2 border-blue-300 rounded-lg cursor-pointer transition"
              >
                <h4 class="text-xl font-bold text-blue-900 mb-2">📦 Productos</h4>
                <p class="text-gray-700">Gestiona el catálogo de productos</p>
              </Link>

              <!-- Próximamente -->
              <div class="p-6 bg-gray-50 border-2 border-gray-300 rounded-lg opacity-50">
                <h4 class="text-xl font-bold text-gray-900 mb-2">📋 Órdenes</h4>
                <p class="text-gray-700">Próximamente...</p>
              </div>

              <div class="p-6 bg-gray-50 border-2 border-gray-300 rounded-lg opacity-50">
                <h4 class="text-xl font-bold text-gray-900 mb-2">🏷️ Categorías</h4>
                <p class="text-gray-700">Próximamente...</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Link } from '@inertiajs/vue3';
</script>
