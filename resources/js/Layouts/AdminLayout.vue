<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white shadow-lg">
      <div class="p-6 border-b border-gray-700">
        <h1 class="text-2xl font-bold">Admin Panel</h1>
      </div>

      <nav class="p-4 space-y-2">
        <Link
          :href="route('admin.dashboard')"
          class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors"
          :class="route().current('admin.dashboard') ? 'bg-gray-800' : ''"
        >
          📊 Dashboard
        </Link>

        <Link
          :href="route('admin.customers.index')"
          class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors"
          :class="route().current('admin.customers.*') ? 'bg-gray-800' : ''"
        >
          👥 Clientes
        </Link>

        <Link
          :href="route('admin.products.index')"
          class="block px-4 py-3 rounded-lg hover:bg-gray-800 transition-colors"
          :class="route().current('admin.products.*') ? 'bg-gray-800' : ''"
        >
          📦 Productos
        </Link>

        <hr class="border-gray-700 my-4" />

        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="w-full text-left px-4 py-3 rounded-lg hover:bg-red-700 transition-colors bg-red-600 mt-4"
        >
          🚪 Cerrar Sesión
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto">
      <!-- Header -->
      <header class="bg-white shadow">
        <div class="px-8 py-4">
          <h2 class="text-2xl font-bold text-gray-900">
            <slot name="header">Panel Administrativo</slot>
          </h2>
        </div>
      </header>

      <!-- Content -->
      <main class="p-8">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>
