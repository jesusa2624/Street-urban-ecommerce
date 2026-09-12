<template>
  <Head title="Clientes" />
  <AdminLayout>
    <template #breadcrumb>Clientes</template>
    <template #header>Clientes</template>

    <div class="space-y-6">
      <div v-if="page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ page.props.flash.success }}
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-lg font-bold text-gray-900">Clientes Registrados</h3>
            <p class="text-xs text-gray-400">Cuentas con acceso a la tienda y clientes registrados en el mostrador</p>
          </div>
          <button
            @click="showModal = true"
            class="bg-[#ff8c42] hover:bg-[#ff7a24] text-white text-sm font-bold py-2.5 px-5 rounded-xl transition flex items-center gap-2"
          >
            <i class="fa-solid fa-plus text-xs"></i> Nuevo Cliente
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

        <div v-if="clientesFiltrados.length > 0" class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="border-b border-gray-200">
              <tr>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Cliente</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Email</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Teléfono</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Cuenta</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Registro</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="cliente in clientesPaginados" :key="cliente.id" class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                <td class="py-3 px-4 text-gray-900 font-medium">{{ cliente.name }}</td>
                <td class="py-3 px-4 text-gray-600">{{ cliente.email || '—' }}</td>
                <td class="py-3 px-4 text-gray-600">{{ cliente.phone || '—' }}</td>
                <td class="py-3 px-4 text-center">
                  <span
                    :class="[
                      'text-xs font-semibold px-2.5 py-1 rounded-full whitespace-nowrap',
                      cliente.activa ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400',
                    ]"
                  >
                    {{ cliente.activa ? 'Activa' : 'Solo registro' }}
                  </span>
                </td>
                <td class="py-3 px-4 text-center text-gray-500">{{ cliente.registrado }}</td>
                <td class="py-3 px-4">
                  <div class="flex items-center justify-center gap-2">
                    <button
                      @click="verHistorial(cliente)"
                      title="Historial de Compras"
                      class="w-8 h-8 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-500 hover:text-purple-600 flex items-center justify-center transition-colors"
                    >
                      <i class="fa-solid fa-receipt text-xs"></i>
                    </button>
                    <Link
                      :href="route('admin.customers.edit', cliente.id)"
                      title="Editar"
                      class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-500 hover:text-blue-600 flex items-center justify-center transition-colors"
                    >
                      <i class="fa-solid fa-pen text-xs"></i>
                    </Link>
                    <button
                      @click="eliminar(cliente)"
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

          <Pagination v-model="paginaActual" :total-items="clientesFiltrados.length" :per-page="perPage" />
        </div>

        <div v-else-if="customers.length === 0" class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-people-group text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Aún no hay clientes registrados.</p>
        </div>

        <div v-else class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-filter-circle-xmark text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Ningún cliente coincide con tu búsqueda.</p>
        </div>
      </div>
    </div>

    <ConfirmModal
      v-if="clientePendienteEliminar"
      title="Eliminar Cliente"
      :message="`¿Eliminar a ${clientePendienteEliminar.name}? Esta acción no se puede deshacer.`"
      confirm-text="Sí, Eliminar"
      cancel-text="Cancelar"
      variant="danger"
      :loading="eliminando"
      @confirm="confirmarEliminacion"
      @close="clientePendienteEliminar = null"
    />

    <RegistrarClienteModal v-if="showModal" @close="showModal = false" />

    <HistorialClienteModal
      v-if="clienteHistorial"
      :cliente="clienteHistorial"
      @close="clienteHistorial = null"
    />
  </AdminLayout>
</template>

<script setup>
import { Head, Link, router, usePage } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import SearchInput from '@/Components/Admin/SearchInput.vue';
import Pagination from '@/Components/Admin/Pagination.vue';
import ConfirmModal from '@/Components/Admin/ConfirmModal.vue';
import RegistrarClienteModal from './RegistrarClienteModal.vue';
import HistorialClienteModal from './HistorialClienteModal.vue';
import { ref, computed, watch } from 'vue';

const showModal = ref(false);
const clienteHistorial = ref(null);

const verHistorial = (cliente) => {
  clienteHistorial.value = cliente;
};

const props = defineProps({
  customers: Array,
});

const page = usePage();
const filtroTexto = ref('');

const clientesFiltrados = computed(() => {
  const texto = filtroTexto.value.trim().toLowerCase();
  if (!texto) return props.customers;

  return props.customers.filter((c) =>
    c.name.toLowerCase().includes(texto) ||
    (c.email || '').toLowerCase().includes(texto) ||
    (c.phone || '').toLowerCase().includes(texto)
  );
});

const perPage = 15;
const paginaActual = ref(1);

watch(filtroTexto, () => {
  paginaActual.value = 1;
});

watch(() => clientesFiltrados.value.length, (total) => {
  const totalPaginas = Math.max(1, Math.ceil(total / perPage));
  if (paginaActual.value > totalPaginas) paginaActual.value = totalPaginas;
});

const clientesPaginados = computed(() => {
  const inicio = (paginaActual.value - 1) * perPage;
  return clientesFiltrados.value.slice(inicio, inicio + perPage);
});

const clientePendienteEliminar = ref(null);
const eliminando = ref(false);

const eliminar = (cliente) => {
  clientePendienteEliminar.value = cliente;
};

const confirmarEliminacion = () => {
  eliminando.value = true;

  router.delete(route('admin.customers.destroy', clientePendienteEliminar.value.id), {
    onFinish: () => {
      eliminando.value = false;
      clientePendienteEliminar.value = null;
    },
  });
};
</script>
