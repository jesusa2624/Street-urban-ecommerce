<template>
  <AdminLayout>
    <template #header>Editar Cliente</template>

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

          <div class="mb-6">
            <label class="block text-sm font-semibold mb-2">Email *</label>
            <input
              v-model="formData.email"
              type="email"
              class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
              required
            />
            <span v-if="validationErrors.email" class="text-red-600 text-sm">{{ validationErrors.email[0] }}</span>
          </div>

          <div class="flex gap-4">
            <button
              type="submit"
              :disabled="loading"
              class="px-6 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition disabled:opacity-50"
            >
              {{ loading ? 'Guardando...' : 'Guardar Cambios' }}
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

const props = defineProps({
  customer: Object,
});

const loading = ref(false);
const validationErrors = ref({});

const formData = ref({
  name: props.customer.name,
  email: props.customer.email,
});

const handleSubmit = () => {
  loading.value = true;
  validationErrors.value = {};

  router.patch(route('admin.customers.update', props.customer.id), formData.value, {
    onError: (errors) => {
      validationErrors.value = errors;
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
