<template>
  <div class="flex h-screen bg-gradient-to-br from-[#0a0a0a] via-[#0f0f0f] to-[#1a1a1a] text-white">
    <!-- Sidebar -->
    <aside class="w-72 bg-gradient-to-b from-[#111111] via-[#0f0f0f] to-[#0a0a0a] border-r border-white/10 shadow-2xl flex flex-col">
      <!-- Logo Section -->
      <div class="p-8 border-b border-white/10">
        <div class="space-y-3">
          <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-cyan-500 rounded-lg flex items-center justify-center font-bold text-white shadow-lg">
              S
            </div>
            <div>
              <h1 class="text-2xl font-black tracking-tight">Street</h1>
              <p class="text-xs text-gray-500 font-light">Urban Admin</p>
            </div>
          </div>
        </div>
      </div>

      <!-- Navigation -->
      <nav class="flex-1 px-4 py-6 space-y-2">
        <Link
          :href="route('admin.dashboard')"
          class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 text-gray-300 hover:text-white"
          :class="route().current('admin.dashboard')
            ? 'bg-gradient-to-r from-blue-600/30 to-cyan-600/20 text-white border border-blue-500/30'
            : 'hover:bg-white/5 border border-transparent'"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-3m0 0l7-4 7 4M5 9v10a1 1 0 001 1h12a1 1 0 001-1V9M9 5l3-3m0 0l3 3m-3-3v10" />
          </svg>
          <span class="font-semibold">Dashboard</span>
        </Link>

        <Link
          :href="route('admin.customers.index')"
          class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 text-gray-300 hover:text-white"
          :class="route().current('admin.customers.*')
            ? 'bg-gradient-to-r from-blue-600/30 to-cyan-600/20 text-white border border-blue-500/30'
            : 'hover:bg-white/5 border border-transparent'"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 12H9m4 5H9m6 0h.01M12 12a8 8 0 100-16 8 8 0 000 16z" />
          </svg>
          <span class="font-semibold">Clientes</span>
        </Link>

        <Link
          :href="route('admin.products.index')"
          class="group flex items-center gap-3 px-4 py-3.5 rounded-xl transition-all duration-300 text-gray-300 hover:text-white"
          :class="route().current('admin.products.*')
            ? 'bg-gradient-to-r from-blue-600/30 to-cyan-600/20 text-white border border-blue-500/30'
            : 'hover:bg-white/5 border border-transparent'"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0 0v10l-8 4" />
          </svg>
          <span class="font-semibold">Productos</span>
        </Link>
      </nav>

      <!-- Bottom Section -->
      <div class="px-4 py-6 border-t border-white/10 space-y-2">
        <Link
          :href="route('shop.home')"
          class="flex items-center gap-3 px-4 py-3 rounded-xl hover:bg-white/5 transition-all duration-300 text-gray-400 hover:text-white"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span class="text-sm font-medium">Ir a Tienda</span>
        </Link>

        <Link
          :href="route('logout')"
          method="post"
          as="button"
          class="w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-300 text-red-400 hover:text-red-300 hover:bg-red-600/10 border border-red-900/30 hover:border-red-700/50"
        >
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
          </svg>
          <span class="text-sm font-medium">Cerrar Sesión</span>
        </Link>
      </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 overflow-auto flex flex-col">
      <!-- Header -->
      <header class="bg-gradient-to-r from-[#111111] via-[#0f0f0f] to-[#1a1a1a] border-b border-white/10 backdrop-blur-sm">
        <div class="px-8 py-6">
          <h2 class="text-4xl font-black tracking-tight text-white">
            <slot name="header">Panel Administrativo</slot>
          </h2>
          <p class="text-gray-400 text-sm mt-2">Controla tu ecommerce desde aquí</p>
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
  background: rgba(255, 255, 255, 0.03);
}

::-webkit-scrollbar-thumb {
  background: rgba(255, 255, 255, 0.15);
  border-radius: 4px;
}

::-webkit-scrollbar-thumb:hover {
  background: rgba(255, 255, 255, 0.25);
}
</style>
