<template>
  <AdminLayout>
    <template #header>Gestionar Clientes</template>

    <div class="flex justify-between items-center mb-6">
      <h2 class="text-xl font-bold">Clientes</h2>
      <Link
        :href="route('admin.customers.create')"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
      >
        + Nuevo Cliente
      </Link>
    </div>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
      <table class="w-full">
        <thead class="bg-gray-50 border-b">
          <tr>
            <th class="px-6 py-3 text-left text-sm font-semibold">ID</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Nombre</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Fecha</th>
            <th class="px-6 py-3 text-left text-sm font-semibold">Acciones</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <tr v-for="customer in customers.data" :key="customer.id" class="hover:bg-gray-50">
            <td class="px-6 py-4">{{ customer.id }}</td>
            <td class="px-6 py-4">{{ customer.name }}</td>
            <td class="px-6 py-4">{{ customer.email }}</td>
            <td class="px-6 py-4 text-sm text-gray-500">
              {{ new Date(customer.created_at).toLocaleDateString() }}
            </td>
            <td class="px-6 py-4 space-x-2">
              <Link
                :href="route('admin.customers.edit', customer.id)"
                class="text-blue-600 hover:text-blue-800 font-semibold"
              >
                Editar
              </Link>
              <button
                @click="deleteCustomer(customer.id)"
                class="text-red-600 hover:text-red-800 font-semibold"
              >
                Eliminar
              </button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

defineProps({
  customers: Object,
});

const deleteCustomer = (id) => {
  if (confirm('¿Eliminar este cliente?')) {
    router.delete(route('admin.customers.destroy', id));
  }
};
</script>
