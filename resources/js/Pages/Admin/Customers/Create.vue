<template>
  <AdminLayout>
    <template #header>Crear Cliente</template>

    <div class="max-w-2xl">
      <div v-if="processing" class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
        Guardando...
      </div>

      <div class="bg-white rounded-lg shadow p-6">
        <form @submit.prevent="submit" @keydown="form.clearErrors()">
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

          <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Email *</label>
            <input
              v-model="form.email"
              type="email"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="errors.email" class="text-red-600 text-sm">{{ errors.email }}</span>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Contraseña *</label>
            <input
              v-model="form.password"
              type="password"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="errors.password" class="text-red-600 text-sm">{{ errors.password }}</span>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Confirmar Contraseña *</label>
            <input
              v-model="form.password_confirmation"
              type="password"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition"
            >
              Crear Cliente
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

const { data: form, errors, post, processing } = useForm({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const submit = () => {
  post(route('admin.customers.store'), {
    onError: (errors) => {
      console.log('Errores:', errors);
    },
  });
};
</script>
