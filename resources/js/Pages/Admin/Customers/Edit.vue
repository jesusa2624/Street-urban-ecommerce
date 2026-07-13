<template>
  <AdminLayout>
    <template #header>Editar Cliente</template>

    <div class="max-w-2xl">
      <div class="bg-white rounded-lg shadow p-6">
        <form @submit.prevent="submit">
          <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Nombre *</label>
            <input
              v-model="form.name"
              type="text"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="errors.name" class="text-red-600 text-sm">{{ errors.name }}</span>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Email *</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition"
            >
              Guardar Cambios
            </button>
            <Link
              :href="route('admin.customers.index')"
              class="px-6 py-2 bg-gray-600 text-white rounded hover:bg-gray-700 transition"
            >
              Cancelar
            </Link>
          </div>
        </form>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, useForm } from '@inertiajs/vue3';

const props = defineProps({
  customer: Object,
});

const { data: form, errors, patch } = useForm({
  name: props.customer.name,
  email: props.customer.email,
});

const submit = () => {
  patch(route('admin.customers.update', props.customer.id));
};
</script>
