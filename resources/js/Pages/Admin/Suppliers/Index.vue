<template>
  <Head title="Proveedores" />
  <AdminLayout>
    <template #breadcrumb>Proveedores</template>
    <template #header>Proveedores</template>

    <div class="space-y-6">
      <div v-if="page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ page.props.flash.success }}
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-lg font-bold text-gray-900">Proveedores Registrados</h3>
            <p class="text-xs text-gray-400">Tiendas/proveedores a los que les compras mercadería</p>
          </div>
          <button
            @click="showModal = true"
            class="bg-[#ff8c42] hover:bg-[#ff7a24] text-white text-sm font-bold py-2.5 px-5 rounded-xl transition flex items-center gap-2"
          >
            <i class="fa-solid fa-plus text-xs"></i> Nuevo Proveedor
          </button>
        </div>

        <!-- Filtros -->
        <div class="flex flex-wrap items-center gap-3 mb-5">
          <SearchInput v-model="filtroTexto" placeholder="Buscar por nombre, email o teléfono..." class="w-full sm:w-72" />
          <button
            v-if="filtroTexto"
            @click="filtroTexto = ''"
            class="text-sm font-semibold text-gray-400 hover:text-gray-600 px-3 py-2"
          >
            <i class="fa-solid fa-xmark text-xs"></i> Limpiar
          </button>
        </div>

        <div v-if="proveedoresFiltrados.length > 0" class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="border-b border-gray-200">
              <tr>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Proveedor</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Email</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Teléfono</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Registro</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="proveedor in proveedoresPaginados" :key="proveedor.id" class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                <td class="py-3 px-4 text-gray-900 font-medium">{{ proveedor.name }}</td>
                <td class="py-3 px-4 text-gray-600">{{ proveedor.email || '—' }}</td>
                <td class="py-3 px-4 text-gray-600">{{ proveedor.phone || '—' }}</td>
                <td class="py-3 px-4 text-center text-gray-500">{{ proveedor.registrado }}</td>
                <td class="py-3 px-4">
                  <div class="flex items-center justify-center gap-2">
                    <button
                      @click="verHistorial(proveedor)"
                      title="Historial de Compras"
                      class="w-8 h-8 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-500 hover:text-purple-600 flex items-center justify-center transition-colors"
                    >
                      <i class="fa-solid fa-receipt text-xs"></i>
                    </button>
                    <Link
                      :href="route('admin.suppliers.edit', proveedor.id)"
                      title="Editar"
                      class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-500 hover:text-blue-600 flex items-center justify-center transition-colors"
                    >
                      <i class="fa-solid fa-pen text-xs"></i>
                    </Link>
                    <button
                      @click="eliminar(proveedor)"
                      title="Eliminar"
                      class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-600 flex items-center justify-center transition-colors"
                    >
                      <i class="fa-solid fa-trash text-xs"></i>
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>

          <Pagination v-model="paginaActual" :total-items="proveedoresFiltrados.length" :per-page="perPage" />
        </div>

        <div v-else-if="suppliers.length === 0" class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-truck-fast text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Aún no hay proveedores registrados.</p>
        </div>

        <div v-else class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-filter-circle-xmark text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Ningún proveedor coincide con tu búsqueda.</p>
        </div>
      </div>
    </div>

    <ConfirmModal
      v-if="proveedorPendienteEliminar"
      title="Eliminar Proveedor"
      :message="`¿Eliminar a ${proveedorPendienteEliminar.name}? Esta acción no se puede deshacer.`"
      confirm-text="Sí, Eliminar"
      cancel-text="Cancelar"
      variant="danger"
      :loading="eliminando"
      @confirm="confirmarEliminacion"
      @close="proveedorPendienteEliminar = null"
    />

    <RegistrarProveedorModal v-if="showModal" @close="showModal = false" />

    <HistorialProveedorModal
      v-if="proveedorHistorial"
      :proveedor="proveedorHistorial"
      @close="proveedorHistorial = null"
    />
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SearchInput from '@/Components/Admin/SearchInput.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue';
import RegistrarProveedorModal from './RegistrarProveedorModal.vue';
import HistorialProveedorModal from './HistorialProveedorModal.vue';
import { ref, computed, watch } from 'vue';

const props = defineProps({
  suppliers: Array,
});

const page = usePage();
const filtroTexto = ref('');
const showModal = ref(false);
const proveedorHistorial = ref(null);

const verHistorial = (proveedor) => {
  proveedorHistorial.value = proveedor;
};

const proveedoresFiltrados = computed(() => {
  const texto = filtroTexto.value.trim().toLowerCase();
  if (!texto) return props.suppliers;

  return props.suppliers.filter((s) =>
    s.name.toLowerCase().includes(texto) ||
    (s.email || '').toLowerCase().includes(texto) ||
    (s.phone || '').toLowerCase().includes(texto)
  );
});

const perPage = 15;
const paginaActual = ref(1);

watch(filtroTexto, () => {
  paginaActual.value = 1;
});

watch(() => proveedoresFiltrados.value.length, (total) => {
  const totalPaginas = Math.max(1, Math.ceil(total / perPage));
  if (paginaActual.value > totalPaginas) paginaActual.value = totalPaginas;
});

const proveedoresPaginados = computed(() => {
  const inicio = (paginaActual.value - 1) * perPage;
  return proveedoresFiltrados.value.slice(inicio, inicio + perPage);
});

const proveedorPendienteEliminar = ref(null);
const eliminando = ref(false);

const eliminar = (proveedor) => {
  proveedorPendienteEliminar.value = proveedor;
};

const confirmarEliminacion = () => {
  eliminando.value = true;

  router.delete(route('admin.suppliers.destroy', proveedorPendienteEliminar.value.id), {
    onFinish: () => {
      eliminando.value = false;
      proveedorPendienteEliminar.value = null;
    },
  });
};
</script>
