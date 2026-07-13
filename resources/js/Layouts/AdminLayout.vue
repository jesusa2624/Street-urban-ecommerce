<template>
  <div class="flex h-screen bg-[#0a0a0a] text-white">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#111111] border-r border-gray-800 shadow-2xl">
      <div class="p-6 border-b border-gray-800">
        <h1 class="text-2xl font-black uppercase tracking-tighter">Street<span class="font-light"> Urban</span></h1>
        <p class="text-xs text-gray-500 mt-1">Admin Panel</p>
      </div>

      <nav class="p-4 space-y-2">
        <Link
          :href="route('admin.dashboard')"
          class="block px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-gray-300 hover:text-white border border-transparent hover:border-gray-700"
          :class="route().current('admin.dashboard') ? 'bg-white/10 text-white border-gray-700' : ''"
        >
          <span class="text-lg">📊</span> Dashboard
        </Link>

        <Link
          :href="route('admin.customers.index')"
          class="block px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-gray-300 hover:text-white border border-transparent hover:border-gray-700"
          :class="route().current('admin.customers.*') ? 'bg-white/10 text-white border-gray-700' : ''"
        >
          <span class="text-lg">👥</span> Clientes
        </Link>

        <Link
          :href="route('admin.products.index')"
          class="block px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-gray-300 hover:text-white border border-transparent hover:border-gray-700"
          :class="route().current('admin.products.*') ? 'bg-white/10 text-white border-gray-700' : ''"
        >
          <span class="text-lg">📦</span> Productos
        </Link>

        <hr class="border-gray-800 my-4" />

        <Link
          :href="route('shop.home')"
          class="block px-4 py-3 rounded-lg hover:bg-white/10 transition-all duration-300 text-gray-300 hover:text-white border border-transparent hover:border-gray-700"
        >
          <span class="text-lg">🏪</span> Ir a Tienda
        </Link>

        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="w-full text-left px-4 py-3 rounded-lg transition-all duration-300 mt-4 hover:bg-red-600/20 text-red-400 hover:text-red-300 border border-red-800/50 hover:border-red-700"
        >
          <span class="text-lg">🚪</span> Cerrar Sesión
        </Link>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto flex flex-col">
      <!-- Header -->
      <header class="bg-gradient-to-r from-[#111111] to-[#1a1a1a] border-b border-gray-800 shadow-lg">
        <div class="px-8 py-6">
          <h2 class="text-3xl font-bold text-white">
            <slot name="header">Panel Administrativo</slot>
          </h2>
          <p class="text-gray-400 text-sm mt-1">Gestiona tu ecommerce</p>
        </div>
      </header>

      <!-- Content -->
      <main class="flex-1 p-8 overflow-auto">
        <slot />
      </main>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<style scoped>
::-webkit-scrollbar {
  width: 8px;
  height: 8px;
}

::-webkit-scrollbar-track {
  background: rgba(255, 255, 255, 0.05);
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.2);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.3);
}
</style>
