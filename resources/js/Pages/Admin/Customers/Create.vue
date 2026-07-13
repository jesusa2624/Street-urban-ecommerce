<template>
  <AdminLayout>
    <template #header>Crear Cliente</template>

    <div class="max-w-2xl">
      <div class="bg-[#111111] border border-gray-800 rounded-lg shadow-xl p-8">
        <form @submit.prevent="handleSubmit">
          <div class="mb-5">
            <label class="block text-sm font-semibold mb-2 text-gray-300">Nombre *</label>
            <input
              v-model="formData.name"
              type="text"
              class="w-full px-4 py-2.5 bg-[#1a1a1a] border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-white placeholder-gray-600 transition"
              placeholder="Nombre completo"
              required
            />
            <span v-if="validationErrors.name" class="text-red-400 text-sm mt-1">{{ validationErrors.name[0] }}</span>
          </div>

          <div class="mb-5">
            <label class="block text-sm font-semibold mb-2 text-gray-300">Email *</label>
            <input
              v-model="formData.email"
              type="email"
              class="w-full px-4 py-2.5 bg-[#1a1a1a] border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-white placeholder-gray-600 transition"
              placeholder="correo@ejemplo.com"
              required
            />
            <span v-if="validationErrors.email" class="text-red-400 text-sm mt-1">{{ validationErrors.email[0] }}</span>
          </div>

          <div class="mb-5">
            <label class="block text-sm font-semibold mb-2 text-gray-300">Contraseña *</label>
            <input
              v-model="formData.password"
              type="password"
              class="w-full px-4 py-2.5 bg-[#1a1a1a] border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-white placeholder-gray-600 transition"
              placeholder="••••••••"
              required
            />
            <span v-if="validationErrors.password" class="text-red-400 text-sm mt-1">{{ validationErrors.password[0] }}</span>
          </div>

          <div class="mb-6">
            <label class="block text-sm font-semibold mb-2 text-gray-300">Confirmar Contraseña *</label>
            <input
              v-model="formData.password_confirmation"
              type="password"
              class="w-full px-4 py-2.5 bg-[#1a1a1a] border border-gray-700 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 focus:border-transparent text-white placeholder-gray-600 transition"
              placeholder="••••••••"
              required
            />
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              :disabled="loading"
              class="px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white rounded-lg transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed font-semibold uppercase tracking-wide"
            >
              {{ loading ? 'Guardando...' : 'Crear Cliente' }}
            </button>
            <Link
              :href="route('admin.customers.index')"
              class="px-6 py-2.5 bg-gray-700 hover:bg-gray-600 text-white rounded-lg transition duration-200 font-semibold uppercase tracking-wide"
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
