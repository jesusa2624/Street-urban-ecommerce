<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/Shop/ShopLayout.vue';

const form = ref({
  name: '',
  email: '',
  message: '',
});

const successMessage = ref('');

const submitForm = () => {
  // Tarea: añadir la lógica para enviar el formulario al backend
  successMessage.value = 'Gracias por contactarnos. Te responderemos pronto.';
  form.value.name = '';
  form.value.email = '';
  form.value.message = '';
};
</script>

<template>
  <Head title="Contacto" />
  <ShopLayout>
    <div class="pt-20"></div>

    <!-- Título de la página -->
    <section class="relative py-16 px-4 md:px-8 lg:px-16 overflow-hidden">
      <!-- Background Gradient -->
      <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-transparent to-transparent"></div>
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>

      <div class="relative max-w-full mx-auto">
        <div>
          <!-- Título Principal -->
          <h1 class="text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-tight italic leading-tight mb-4 max-w-4xl">
            Contacta <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">con nosotros</span>
          </h1>
          <div class="h-1.5 w-24 bg-gradient-to-r from-white via-white to-gray-600 rounded-full"></div>
        </div>
      </div>
    </section>

    <section class="px-4 mt-16 md:px-8 lg:px-16 max-w-[1400px] mx-auto pb-24">
      <div class="max-w-4xl mx-auto">
        <p class="text-gray-400 mb-10">
          <strong>¿Tienes algo que decirnos?</strong>
          Ya sea una consulta, una propuesta o simplemente quieras saber más sobre nosotros,
          estamos aquí para escucharte.
        </p>

        <form @submit.prevent="submitForm" autocomplete="off" class="space-y-6">
          <div>
            <label
              for="name"
              class="block text-sm uppercase tracking-widest text-gray-400 mb-2"
            >
              Nombre
            </label>

            <input
              id="name"
              v-model="form.name"
              type="text"
              required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none"
            />
          </div>

          <div>
            <label
              for="email"
              class="block text-sm uppercase tracking-widest text-gray-400 mb-2"
            >
              Correo electrónico
            </label>

            <input
              id="email"
              v-model="form.email"
              type="email"
              required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none"
            />
          </div>

          <div>
            <label
              for="message"
              class="block text-sm uppercase tracking-widest text-gray-400 mb-2"
            >
              Mensaje
            </label>

            <textarea
              id="message"
              v-model="form.message"
              rows="5"
              required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none resize-none"
            ></textarea>
          </div>

          <button
            type="submit"
            class="w-full py-4 bg-white text-black font-black uppercase tracking-widest hover:bg-gray-200 transition-all"
          >
            Enviar Mensaje
          </button>
        </form>

        <div
          v-if="successMessage"
          class="mt-6 p-4 border border-gray-800 bg-[#0a0a0a] text-gray-300 text-sm"
        >
          {{ successMessage }}
        </div>
      </div>
    </section>
  </ShopLayout>
</template>
