<template>
  <AdminLayout>
    <template #header>Crear Cliente</template>

    <div class="max-w-2xl">
      <div class="bg-white rounded-lg shadow p-6">
        <form @submit.prevent="handleSubmit">
          <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Nombre *</label>
            <input
              v-model="formData.name"
              type="text"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="validationErrors.name" class="text-red-600 text-sm">{{ validationErrors.name[0] }}</span>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Email *</label>
            <input
              v-model="formData.email"
              type="email"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="validationErrors.email" class="text-red-600 text-sm">{{ validationErrors.email[0] }}</span>
          </div>

          <div class="mb-4">
            <label class="block text-sm font-semibold mb-2">Contraseña *</label>
            <input
              v-model="formData.password"
              type="password"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="validationErrors.password" class="text-red-600 text-sm">{{ validationErrors.password[0] }}</span>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Confirmar Contraseña *</label>
            <input
              v-model="formData.password_confirmation"
              type="password"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              :disabled="loading"
              class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700 transition disabled:opacity-50"
            >
              {{ loading ? 'Guardando...' : 'Crear Cliente' }}
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
import { ref } from 'vue';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link, router } from '@inertiajs/vue3';

const loading = ref(false);
const validationErrors = ref({});

const formData = ref({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
});

const handleSubmit = async () => {
  loading.value = true;
  validationErrors.value = {};

  router.post(route('admin.customers.store'), formData.value, {
    onError: (errors) => {
      validationErrors.value = errors;
      console.error('Errores de validación:', errors);
    },
    onSuccess: () => {
      router.visit(route('admin.customers.index'));
    },
    onFinish: () => {
      loading.value = false;
    },
  });
};
</script>
