<template>
  <Head title="Boleta de Venta" />
  <div class="min-h-screen bg-[#f4f5f7] py-10 px-4">
    <div class="max-w-md mx-auto">
      <div class="flex items-center justify-between mb-4 print:hidden">
        <Link :href="route('admin.sales.index')" class="text-sm font-semibold text-gray-500 hover:text-gray-700 flex items-center gap-1.5">
          <i class="fa-solid fa-arrow-left text-xs"></i> Volver al Historial
        </Link>
        <button
          @click="imprimir"
          class="bg-[#ff8c42] hover:bg-[#ff7a24] text-white text-sm font-bold py-2 px-4 rounded-xl transition flex items-center gap-2"
        >
          <i class="fa-solid fa-print text-xs"></i> Imprimir Boleta
        </button>
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-8 print:shadow-none print:border-0 print:rounded-none">
        <div class="text-center mb-6">
          <div class="w-12 h-12 bg-[#ff8c42] rounded-lg flex items-center justify-center font-black text-white mx-auto mb-2">S</div>
          <h1 class="text-lg font-black tracking-tight">{{ business.name }}</h1>
          <p v-if="business.ruc" class="text-[11px] text-gray-400">RUC {{ business.ruc }}</p>
          <p v-if="business.address" class="text-[11px] text-gray-400">{{ business.address }}</p>
          <p class="text-xs text-gray-400 mt-1">Boleta de Venta</p>
          <span v-if="venta.cancelada" class="inline-block mt-2 text-xs font-bold px-3 py-1 rounded-full bg-red-50 text-red-500">
            <i class="fa-solid fa-ban text-[10px] mr-1"></i>VENTA CANCELADA
          </span>
        </div>

        <div class="border-t border-dashed border-gray-200 my-4"></div>

        <div class="space-y-1 text-sm mb-4">
          <div class="flex justify-between">
            <span class="text-gray-400">N° de Venta</span>
            <span class="font-mono font-semibold text-gray-900">{{ venta.numero }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-400">Fecha</span>
            <span class="text-gray-900">{{ venta.fecha }}</span>
          </div>
          <div class="flex justify-between">
            <span class="text-gray-400">Cliente</span>
            <span class="text-gray-900">{{ venta.cliente || 'Sin cliente registrado' }}</span>
          </div>
          <div v-if="venta.registradoPor" class="flex justify-between">
            <span class="text-gray-400">Atendido por</span>
            <span class="text-gray-900">{{ venta.registradoPor }}</span>
          </div>
        </div>

        <div class="border-t border-dashed border-gray-200 my-4"></div>

        <table class="w-full text-xs mb-4">
          <thead>
            <tr class="text-gray-400 border-b border-gray-100">
              <th class="text-left py-1.5 font-semibold">Prenda</th>
              <th class="text-center py-1.5 font-semibold">Cant.</th>
              <th class="text-right py-1.5 font-semibold">P. Unit.</th>
              <th class="text-right py-1.5 font-semibold">Subtotal</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, idx) in venta.items" :key="idx" class="border-b border-gray-50">
              <td class="py-2 pr-2">
                <p class="text-gray-900 font-medium">{{ item.producto }}</p>
                <p class="text-gray-400">{{ item.marca }} · {{ item.talla }} · {{ item.color }}</p>
              </td>
              <td class="py-2 text-center text-gray-900">{{ item.cantidad }}</td>
              <td class="py-2 text-right text-gray-900">S/ {{ item.precioUnitario.toFixed(2) }}</td>
              <td class="py-2 text-right text-gray-900 font-semibold">S/ {{ item.subtotal.toFixed(2) }}</td>
            </tr>
          </tbody>
        </table>

        <div class="border-t border-dashed border-gray-200 my-4"></div>

        <div class="flex justify-between items-center mb-1">
          <span class="text-sm font-semibold text-gray-500">Total</span>
          <span class="text-2xl font-black text-gray-900">S/ {{ venta.total.toFixed(2) }}</span>
        </div>

        <p v-if="venta.notas" class="text-xs text-gray-400 italic mt-3">"{{ venta.notas }}"</p>

        <p class="text-center text-xs text-gray-400 mt-8">¡Gracias por tu compra!</p>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Head, Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

defineProps({
  venta: Object,
});

const page = usePage();
const business = computed(() => page.props.business);

const imprimir = () => window.print();
</script>
