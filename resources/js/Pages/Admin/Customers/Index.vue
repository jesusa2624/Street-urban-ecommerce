<template>
  <AdminLayout>
    <template #header>Gestionar Clientes</template>

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold">Clientes</h2>
      <Link
        :href="route('admin.customers.create')"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition font-semibold"
      >
        + Nuevo Cliente
      </Link>
    </div>

    <!-- Mensaje de éxito -->
    <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-900/30 border border-green-700 text-green-400 rounded-lg">
      ✓ {{ $page.props.flash.success }}
    </div>

    <div class="bg-[#111111] border border-gray-800 rounded-lg shadow-xl overflow-hidden">
      <table class="w-full">
        <thead class="bg-[#0a0a0a] border-b border-gray-800">
          <tr>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 uppercase tracking-wider">ID</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 uppercase tracking-wider">Nombre</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 uppercase tracking-wider">Email</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 uppercase tracking-wider">Fecha Registro</th>
            <th class="px-6 py-4 text-left text-sm font-bold text-gray-300 uppercase tracking-wider">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y divide-gray-800">
          <tr v-for="customer in customers.data" :key="customer.id" class="hover:bg-white/5 transition duration-200">
            <td class="px-6 py-4 text-sm text-gray-400">{{ customer.id }}</td>
            <td class="px-6 py-4 font-medium text-white">{{ customer.name }}</td>
            <td class="px-6 py-4 text-sm text-gray-300">{{ customer.email }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">
              {{ formatDate(customer.created_at) }}
            </td>
            <td class="px-6 py-4 space-x-2">
              <Link
                :href="route('admin.customers.edit', customer.id)"
                class="inline-block px-3 py-1.5 bg-yellow-600/20 text-yellow-400 text-sm rounded hover:bg-yellow-600/40 transition duration-200 font-semibold border border-yellow-600/30 hover:border-yellow-600"
              >
                ✏️ Editar
              </Link>
              <button
                @click="deleteCustomer(customer.id)"
                class="inline-block px-3 py-1.5 bg-red-600/20 text-red-400 text-sm rounded hover:bg-red-600/40 transition duration-200 font-semibold border border-red-600/30 hover:border-red-600"
              >
                🗑️ Eliminar
              </button>
            </td>
          </tr>
          <tr v-if="customers.data.length === 0">
            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
              No hay clientes registrados
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
