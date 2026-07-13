<template>
  <AdminLayout>
    <template #header>Gestionar Clientes</template>

    <!-- Mensaje de éxito -->
    <transition name="slide-down">
      <div v-if="$page.props.flash?.success" class="mb-6 p-4 bg-gradient-to-r from-green-600/20 to-emerald-600/20 border border-green-500/30 text-green-400 rounded-xl flex items-center gap-3">
        <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
        </svg>
        <span>{{ $page.props.flash.success }}</span>
      </div>
    </transition>

    <!-- Header con botón -->
    <div class="flex justify-between items-center mb-8">
      <div>
        <h2 class="text-2xl font-bold text-white">Mis Clientes</h2>
        <p class="text-gray-400 text-sm mt-1">Administra todos tus clientes registrados</p>
      </div>
      <Link
        :href="route('admin.customers.create')"
        class="px-6 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-xl hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-300 font-semibold flex items-center gap-2 group"
      >
        <svg class="w-5 h-5 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
        </svg>
        Nuevo Cliente
      </Link>
    </div>

    <!-- Tabla -->
    <div class="bg-gradient-to-b from-[#111111] to-[#0a0a0a] border border-gray-800/50 rounded-2xl shadow-2xl overflow-hidden">
      <table class="w-full">
        <thead>
          <tr class="bg-gradient-to-r from-[#0f0f0f] to-[#0a0a0a] border-b border-gray-800/50">
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">ID</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Nombre</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Email</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Registro</th>
            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-400 uppercase tracking-widest">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800/30">
          <tr v-for="customer in customers.data" :key="customer.id" class="hover:bg-blue-600/5 transition duration-300 group">
            <td class="px-6 py-4 text-sm text-gray-500 font-mono">{{ customer.id }}</td>
            <td class="px-6 py-4 text-sm font-semibold text-white group-hover:text-blue-400 transition-colors">{{ customer.name }}</td>
            <td class="px-6 py-4 text-sm text-gray-400">{{ customer.email }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">
              {{ formatDate(customer.created_at) }}
            </td>
            <td class="px-6 py-4 space-x-2 flex">
              <Link
                :href="route('admin.customers.edit', customer.id)"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-gradient-to-r from-amber-600/20 to-amber-500/10 text-amber-400 text-xs rounded-lg hover:from-amber-600/40 hover:to-amber-500/20 transition duration-200 font-semibold border border-amber-600/30 hover:border-amber-600/60"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar
              </Link>
              <button
                @click="deleteCustomer(customer.id)"
                class="inline-flex items-center gap-2 px-3.5 py-1.5 bg-gradient-to-r from-red-600/20 to-red-500/10 text-red-400 text-xs rounded-lg hover:from-red-600/40 hover:to-red-500/20 transition duration-200 font-semibold border border-red-600/30 hover:border-red-600/60"
              >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Eliminar
              </button>
            </td>
          </tr>
          <tr v-if="customers.data.length === 0">
            <td colspan="5" class="px-6 py-16 text-center">
              <div class="space-y-3">
                <svg class="w-12 h-12 text-gray-600 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                </svg>
                <p class="text-gray-500 font-medium">No hay clientes registrados</p>
                <p class="text-gray-600 text-sm">Crea tu primer cliente para comenzar</p>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Paginación -->
    <div v-if="customers.links" class="mt-6 flex justify-center gap-2">
      <Link
        v-for="link in customers.links"
        :key="link.label"
        :href="link.url || '#'"
        :class="[
          'px-3 py-2 rounded text-sm transition',
          link.active
            ? 'bg-blue-600 text-white'
            : link.url
              ? 'bg-gray-200 hover:bg-gray-300'
              : 'bg-gray-100 text-gray-500 cursor-not-allowed',
        ]"
        v-html="link.label"
      />
    </div>
  </AdminLayout>
</template>

<script setup>
import { usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
  customers: Object,
});

const page = usePage();

const formatDate = (dateString) => {
  const date = new Date(dateString);
  return date.toLocaleDateString('es-ES', {
    year: 'numeric',
    month: '2-digit',
    day: '2-digit',
  });
};

const deleteCustomer = (id) => {
  if (confirm('¿Está seguro de que desea eliminar este cliente? Esta acción no se puede deshacer.')) {
    router.delete(route('admin.customers.destroy', id));
  }
};
</script>
