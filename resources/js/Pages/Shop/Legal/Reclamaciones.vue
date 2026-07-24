<script setup>
import { ref } from 'vue';
import { Head } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/Shop/ShopLayout.vue';
import ArticleLayout from '@/Layouts/Shop/ArticleLayout.vue';

const now = new Date();
const curDate = now.toLocaleDateString('es-PE', {
  weekday: 'long', 
  year: 'numeric', 
  month: 'long', 
  day: 'numeric'
});

const form = ref({
  claimantName: "",
  claimantAddress: "",
  claimantNationalId: "",
  claimantEmail: "",
  claimantPhone: "",

  purchasedItem: "",
  claimedAmount: null,

  claimType: "Reclamo",
  claimDetails: "",
  claimRequest: "",

  acceptPrivacy: false,
});

const successMessage = ref('');

const submitForm = () => {
  // Tarea: añadir la lógica para enviar el formulario al backend
  successMessage.value = 'Gracias por contactarnos. Te responderemos pronto.';
};
</script>

<template>
  <Head title="Libro de reclamaciones" />
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
          <h1
            class="text-3xl md:text-4xl lg:text-5xl font-black uppercase tracking-tight italic leading-tight mb-4 max-w-4xl">
            Libro <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">de
              reclamaciones</span>
          </h1>
          <div class="h-1.5 w-24 bg-gradient-to-r from-white via-white to-gray-600 rounded-full"></div>
        </div>
      </div>
    </section>

    <ArticleLayout>
      <h2>Hoja de reclamación</h2>

      <p><strong>De conformidad con lo establecido en el Código de Protección y Defensa del Consumidor, STREET URBAN cuenta con un LIBRO DE RECLAMACIONES VIRTUAL a disposición de los USUARIOS y CLIENTES.</strong></p>

      <p><strong>La formulación del presente reclamo no impide acudir a otras vías de solución de controversias ni es requisito previo para interponer una denuncia ante el Indecopi.</strong></p>

      <p><strong>STREET URBAN</strong> debe dar respuesta al reclamo o queja en un plazo no mayor a <strong>quince (15) días hábiles,</strong> el cual es improrrogable.</p>

      <p>
        Nombre del responsable: <strong>STREET URBAN</strong><br />
        RUC: <strong>RUC_DEL_RESPONSABLE;</strong> dirección: <strong>Lima</strong><br />
        Fecha de la solicitud: <strong>{{ curDate }}</strong>
      </p>

      <hr />

      <form @submit.prevent="submitForm" autocomplete="off" class="space-y-8">
        <!-- 1. IDENTIFICACIÓN DEL CONSUMIDOR -->
        <section class="space-y-6">
          <h2>1. Identificación del consumidor reclamante</h2>

          <div>
            <label for="claimantName" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Nombres y apellidos completos
            </label>

            <input id="claimantName" v-model="form.claimantName" type="text" required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>

          <div>
            <label for="claimantAddress" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Domicilio
            </label>

            <input id="claimantAddress" v-model="form.claimantAddress" type="text" required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>

          <div>
            <label for="claimantNationalId" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Documento de identidad
            </label>

            <input id="claimantNationalId" v-model="form.claimantNationalId" type="text" required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>

          <div>
            <label for="claimantEmail" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Correo electrónico
            </label>

            <input id="claimantEmail" v-model="form.claimantEmail" type="email" required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>

          <div>
            <label for="claimantPhone" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Teléfono
            </label>

            <input id="claimantPhone" v-model="form.claimantPhone" type="tel"
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>
        </section>

        <!-- 2. IDENTIFICACIÓN DEL BIEN -->
        <section class="space-y-6">
          <h2>2. Identificación del bien contratado</h2>

          <div>
            <label for="purchasedItem" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Identificación del bien adquirido
            </label>

            <input id="purchasedItem" v-model="form.purchasedItem" type="text" required
              placeholder="Ej.: Pantalón hombre marca Diskovish talla 32"
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>

          <div>
            <label for="claimedAmount" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Monto a reclamar (S/)
            </label>

            <input id="claimedAmount" v-model="form.claimedAmount" type="number" min="0" step="0.01" required
              placeholder="0.00"
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none" />
          </div>
        </section>

        <!-- 3. DETALLE -->
        <section class="space-y-6">
          <h2>3. Detalle de la reclamación y pedido del consumidor</h2>

          <div class="space-y-2">
            <p>
              <strong>Queja:</strong>
              Disconformidad no relacionada a los productos o servicios, o malestar
              respecto a la atención al público.
              <br />
              <strong>Reclamo:</strong>
              Disconformidad relacionada a los productos o servicios.
            </p>
          </div>

          <div>
            <label class="block text-sm uppercase tracking-widest text-gray-400 mb-3">
              Tipo
            </label>

            <div class="flex gap-6">
              <label class="flex items-center gap-2 cursor-pointer">
                <input v-model="form.claimType" type="radio" value="Queja" required />
                <span>Queja</span>
              </label>

              <label class="flex items-center gap-2 cursor-pointer">
                <input v-model="form.claimType" type="radio" value="Reclamo" />
                <span>Reclamo</span>
              </label>
            </div>
          </div>

          <div>
            <label for="claimDetails" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Detalle
            </label>

            <textarea id="claimDetails" v-model="form.claimDetails" rows="5" required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none resize-none"></textarea>
          </div>

          <div>
            <label for="claimRequest" class="block text-sm uppercase tracking-widest text-gray-400 mb-2">
              Pedido
            </label>

            <textarea id="claimRequest" v-model="form.claimRequest" rows="5" required
              class="w-full bg-[#0a0a0a] border border-gray-800 p-4 focus:border-white outline-none resize-none"></textarea>
          </div>
        </section>

        <!-- Aceptación -->
        <div class="flex items-start gap-3">
          <input id="privacy" v-model="form.acceptPrivacy" type="checkbox" required class="mt-1" />

          <label for="privacy" class="leading-relaxed text-gray-400">
            Autorizo que
            <strong class="text-white">STREET URBAN</strong>
            trate mis datos personales conforme a su <a href="/politica-de-privacidad" target="_blank" class="underline text-white hover:text-gray-300">
            Política de privacidad</a>, con la finalidad de atender la reclamación correspondiente.
          </label>
        </div>

        <!-- Cloudflare Turnstile -->
        <div id="turnstile-container"></div>

        <button type="submit"
          class="w-full py-4 bg-white text-black font-black uppercase tracking-widest hover:bg-gray-200 transition-all">
          Enviar reclamación
        </button>
      </form>

      <div
        v-if="successMessage"
        class="mt-6 p-4 border border-gray-800 bg-[#0a0a0a] text-gray-300 text-sm"
      >
        {{ successMessage }}
      </div>
    </ArticleLayout>
  </ShopLayout>
</template>