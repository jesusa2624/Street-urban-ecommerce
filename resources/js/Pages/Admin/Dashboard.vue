<template>
  <AdminLayout>
    <div class="space-y-8">
      <!-- Welcome Section -->
      <div class="space-y-2 mb-8">
        <h3 class="text-4xl font-black text-white tracking-tight">Panel de Control</h3>
        <p class="text-gray-400">Acceso rápido a las secciones principales</p>
      </div>

      <!-- Stats Grid -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Clientes Card -->
        <Link
          :href="route('admin.customers.index')"
          class="group relative overflow-hidden rounded-2xl transition-all duration-300"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 via-blue-600/5 to-transparent"></div>
          <div class="relative p-8 border border-blue-500/30 hover:border-blue-500/60 transition-all duration-300 rounded-2xl bg-gradient-to-br from-[#1a1a1a] to-[#0f0f0f] group-hover:from-[#1f1f2e] group-hover:to-[#0f0f0f]">
            <!-- Top accent line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-blue-500 via-blue-400 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            <!-- Icon -->
            <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center mb-6 group-hover:shadow-lg group-hover:shadow-blue-500/30 transition-all duration-300">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 10a3 3 0 11-6 0 3 3 0 016 0zM6 20h12a6 6 0 00-6-6 6 6 0 00-6 6z" />
              </svg>
            </div>

            <!-- Content -->
            <div>
              <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-blue-300 transition-colors">Clientes</h3>
              <p class="text-gray-400 group-hover:text-gray-300 transition-colors text-sm">Gestiona y supervisa tus clientes</p>
              <div class="mt-6 flex items-center gap-2 text-blue-400 group-hover:text-blue-300 transition-colors text-sm font-semibold">
                <span>Acceder</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
            </div>
          </div>
        </Link>

        <!-- Productos Card -->
        <Link
          :href="route('admin.products.index')"
          class="group relative overflow-hidden rounded-2xl transition-all duration-300"
        >
          <div class="absolute inset-0 bg-gradient-to-br from-cyan-600/20 via-cyan-600/5 to-transparent"></div>
          <div class="relative p-8 border border-cyan-500/30 hover:border-cyan-500/60 transition-all duration-300 rounded-2xl bg-gradient-to-br from-[#1a1a1a] to-[#0f0f0f] group-hover:from-[#1f2e2e] group-hover:to-[#0f0f0f]">
            <!-- Top accent line -->
            <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cyan-500 via-cyan-400 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>

            <!-- Icon -->
            <div class="w-14 h-14 bg-gradient-to-br from-cyan-500 to-cyan-600 rounded-xl flex items-center justify-center mb-6 group-hover:shadow-lg group-hover:shadow-cyan-500/30 transition-all duration-300">
              <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m0 0l8 4m-8-4v10l8 4m0-10l8 4m0 0v10l-8 4" />
              </svg>
            </div>

            <!-- Content -->
            <div>
              <h3 class="text-2xl font-bold text-white mb-2 group-hover:text-cyan-300 transition-colors">Productos</h3>
              <p class="text-gray-400 group-hover:text-gray-300 transition-colors text-sm">Administra tu catálogo completo</p>
              <div class="mt-6 flex items-center gap-2 text-cyan-400 group-hover:text-cyan-300 transition-colors text-sm font-semibold">
                <span>Acceder</span>
                <svg class="w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
              </div>
            </div>
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
