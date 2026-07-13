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
    <div v-if="$page.props.flash?.success" class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
      {{ $page.props.flash.success }}
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-100 border-b">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Fecha Registro</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr v-for="customer in customers.data" :key="customer.id" class="hover:bg-gray-50 transition">
            <td class="px-6 py-4 text-sm">{{ customer.id }}</td>
            <td class="px-6 py-4 font-medium">{{ customer.name }}</td>
            <td class="px-6 py-4 text-sm">{{ customer.email }}</td>
            <td class="px-6 py-4 text-sm text-gray-600">
              {{ formatDate(customer.created_at) }}
            </td>
            <td class="px-6 py-4 space-x-3">
              <Link
                :href="route('admin.customers.edit', customer.id)"
                class="inline-block px-3 py-1 bg-yellow-500 text-white text-sm rounded hover:bg-yellow-600 transition font-semibold"
              >
                ✏️ Editar
              </Link>
              <button
                @click="deleteCustomer(customer.id)"
                class="inline-block px-3 py-1 bg-red-500 text-white text-sm rounded hover:bg-red-600 transition font-semibold"
              >
                🗑️ Eliminar
              </button>
            </td>
          </tr>
          <tr v-if="customers.data.length === 0">
            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
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
