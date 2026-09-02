<template>
  <AdminLayout>
    <template #breadcrumb>Compras / Historial</template>
    <template #header>Historial de Compras</template>

    <div class="space-y-6">
      <!-- Tabs -->
      <div class="flex gap-2 border-b border-gray-200">
        <Link
          :href="route('admin.purchases.index')"
          class="px-4 py-2.5 text-sm font-semibold text-gray-400 hover:text-gray-600 border-b-2 border-transparent"
        >
          Inventario
        </Link>
        <Link
          :href="route('admin.purchases.historial')"
          class="px-4 py-2.5 text-sm font-semibold text-[#ff8c42] border-b-2 border-[#ff8c42]"
        >
          Historial de Compras
        </Link>
        <Link
          :href="route('admin.purchases.reportes')"
          class="px-4 py-2.5 text-sm font-semibold text-gray-400 hover:text-gray-600 border-b-2 border-transparent"
        >
          Reportes
        </Link>
      </div>

      <!-- Stats -->
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <p class="text-sm text-gray-400 font-medium">Total de Compras Registradas</p>
          <p class="text-3xl font-black text-gray-900 mt-1">{{ stats.totalCompras }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <p class="text-sm text-gray-400 font-medium">Total Invertido</p>
          <p class="text-3xl font-black text-[#ff8c42] mt-1">S/ {{ stats.totalGastado.toFixed(2) }}</p>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <p class="text-sm text-gray-400 font-medium">Promedio por Compra</p>
          <p class="text-3xl font-black text-gray-900 mt-1">S/ {{ stats.promedioCompra.toFixed(2) }}</p>
        </div>
      </div>

      <!-- List -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="mb-5">
          <SearchInput
            v-model="filtroTexto"
            placeholder="Buscar por producto, proveedor, factura o N° de compra..."
            class="w-full sm:w-80"
          />
        </div>

        <div v-if="comprasFiltradas.length > 0" class="space-y-3">
          <div
            v-for="compra in comprasFiltradas"
            :key="compra.id"
            class="border border-gray-100 rounded-xl overflow-hidden"
          >
            <button
              @click="toggleExpand(compra.id)"
              class="w-full flex items-center justify-between px-5 py-4 hover:bg-gray-50 transition-colors text-left"
            >
              <div class="flex items-center gap-4 min-w-0">
                <span class="font-mono text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded flex-shrink-0">{{ compra.numero }}</span>
                <div class="min-w-0">
                  <p class="text-sm font-semibold text-gray-900 truncate">{{ tituloCompra(compra) }}</p>
                  <p class="text-xs text-gray-400">
                    {{ compra.fecha }} · {{ compra.totalPrendas }} prenda{{ compra.totalPrendas === 1 ? '' : 's' }}
                    <span v-if="compra.proveedor"> · {{ compra.proveedor }}</span>
                    <span v-if="compra.factura"> · Factura {{ compra.factura }}</span>
                    <span v-if="compra.registradoPor"> · Registrado por {{ compra.registradoPor }}</span>
                  </p>
                </div>
              </div>
              <div class="flex items-center gap-4 flex-shrink-0">
                <span class="text-lg font-bold text-gray-900">S/ {{ compra.total.toFixed(2) }}</span>
                <i :class="['fa-solid', expandedId === compra.id ? 'fa-chevron-up' : 'fa-chevron-down', 'text-gray-400 text-xs']"></i>
              </div>
            </button>

            <div v-if="expandedId === compra.id" class="border-t border-gray-100 bg-gray-50 px-5 py-4">
              <p v-if="compra.notas" class="text-xs text-gray-500 italic mb-3">"{{ compra.notas }}"</p>

              <table class="w-full text-xs">
                <thead>
                  <tr class="text-gray-400">
                    <th class="text-left py-1.5 pr-4 font-semibold">Producto</th>
                    <th class="text-left py-1.5 pr-4 font-semibold">Marca</th>
                    <th class="text-left py-1.5 pr-4 font-semibold">Talla</th>
                    <th class="text-left py-1.5 pr-4 font-semibold">Color</th>
                    <th class="text-center py-1.5 pr-4 font-semibold">Cant.</th>
                    <th class="text-right py-1.5 pr-4 font-semibold">Costo Unit.</th>
                    <th class="text-right py-1.5 font-semibold">Subtotal</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(item, idx) in compra.items" :key="idx" class="border-t border-gray-100">
                    <td class="py-2 pr-4 text-gray-900 font-medium">{{ item.producto }}</td>
                    <td class="py-2 pr-4 text-gray-600">{{ item.marca }}</td>
                    <td class="py-2 pr-4 text-gray-600">{{ item.talla }}</td>
                    <td class="py-2 pr-4">
                      <div class="flex items-center gap-1.5">
                        <div class="w-3.5 h-3.5 rounded-full border border-gray-200" :style="{ backgroundColor: item.colorHex || '#e5e7eb' }"></div>
                        <span class="text-gray-600">{{ item.color }}</span>
                      </div>
                    </td>
                    <td class="py-2 pr-4 text-center text-gray-900">{{ item.cantidad }}</td>
                    <td class="py-2 pr-4 text-right text-gray-900">S/ {{ item.costoUnitario.toFixed(2) }}</td>
                    <td class="py-2 text-right text-gray-900 font-semibold">S/ {{ item.subtotal.toFixed(2) }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>

        <div v-else-if="compras.length === 0" class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-receipt text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Aún no hay compras registradas.</p>
        </div>

        <div v-else class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-filter-circle-xmark text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Ninguna compra coincide con tu búsqueda.</p>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SearchInput from '@/Components/Admin/SearchInput.vue';
import { Link } from '@inertiajs/vue3';
import { ref, computed } from 'vue';

const props = defineProps({
  compras: Array,
  stats: Object,
});

const filtroTexto = ref('');
const expandedId = ref(null);

const toggleExpand = (id) => {
  expandedId.value = expandedId.value === id ? null : id;
};

const tituloCompra = (compra) => {
  const nombresUnicos = [...new Set(compra.items.map(i => i.producto))];
  if (nombresUnicos.length === 1) return nombresUnicos[0];
  return `${nombresUnicos[0]} + ${nombresUnicos.length - 1} más`;
};

const comprasFiltradas = computed(() => {
  const texto = filtroTexto.value.trim().toLowerCase();
  if (!texto) return props.compras;

  return props.compras.filter((c) =>
    (c.proveedor || '').toLowerCase().includes(texto) ||
    (c.factura || '').toLowerCase().includes(texto) ||
    c.numero.toLowerCase().includes(texto) ||
    c.items.some(i => i.producto.toLowerCase().includes(texto))
  );
});
</script>
