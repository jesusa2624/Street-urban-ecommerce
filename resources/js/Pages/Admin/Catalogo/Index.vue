<template>
  <AdminLayout>
    <template #breadcrumb>Catálogo</template>
    <template #header>Catálogo de Productos</template>

    <div class="space-y-6">
      <!-- FLASH SUCCESS -->
      <div v-if="page.props.flash?.success" class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
        <i class="fa-solid fa-circle-check"></i> {{ page.props.flash.success }}
      </div>
      <div v-if="page.props.errors?.error" class="bg-red-50 border border-red-200 text-red-600 rounded-xl px-4 py-3 text-sm font-medium flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation"></i> {{ page.props.errors.error }}
      </div>

      <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-6">
          <div>
            <h3 class="text-lg font-bold text-gray-900">Modelos Registrados</h3>
            <p class="text-xs text-gray-400">Categoría, marca y modelo de cada producto — la identidad base del catálogo</p>
          </div>
          <button
            @click="abrirCrear"
            class="bg-[#ff8c42] hover:bg-[#ff7a24] text-white text-sm font-bold py-2.5 px-5 rounded-xl transition flex items-center gap-2"
          >
            <i class="fa-solid fa-plus text-xs"></i> Registrar Modelo
          </button>
        </div>

        <!-- Filtros -->
        <div class="flex flex-wrap items-center gap-3 mb-5">
          <SearchInput v-model="filtroTexto" placeholder="Buscar por modelo o marca..." class="w-full sm:w-64" />
          <SelectDropdown v-model="filtroCategoria" :options="opcionesCategoria" class="min-w-[190px]" />
          <SelectDropdown v-model="filtroMarca" :options="opcionesMarca" class="min-w-[170px]" />
          <button
            v-if="filtroTexto || filtroCategoria || filtroMarca"
            @click="filtroTexto = ''; filtroCategoria = ''; filtroMarca = ''"
            class="text-sm font-semibold text-gray-400 hover:text-gray-600 px-3 py-2"
          >
            <i class="fa-solid fa-xmark text-xs"></i> Limpiar
          </button>
        </div>

        <div v-if="productosFiltrados.length > 0" class="overflow-x-auto">
          <table class="w-full text-sm">
            <thead class="border-b border-gray-200">
              <tr>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Categoría</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Marca</th>
                <th class="text-left py-3 px-4 font-semibold text-gray-500">Modelo</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Variantes</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Stock Total</th>
                <th class="text-right py-3 px-4 font-semibold text-gray-500">P.Venta</th>
                <th class="text-center py-3 px-4 font-semibold text-gray-500">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <template v-for="p in productosFiltrados" :key="p.id">
                <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                  <td class="py-3 px-4 text-gray-600">{{ p.categoria }}</td>
                  <td class="py-3 px-4 text-gray-600">{{ p.marca }}</td>
                  <td class="py-3 px-4 text-gray-900 font-medium">{{ p.nombre }}</td>
                  <td class="py-3 px-4 text-center">
                    <button
                      @click="toggleVariantes(p.id)"
                      class="inline-flex items-center gap-1.5 text-gray-600 hover:text-[#ff8c42] transition-colors"
                      title="Ver variantes"
                    >
                      {{ p.variantes }}
                      <i :class="['fa-solid text-xs', expandedProductId === p.id ? 'fa-chevron-up' : 'fa-layer-group']"></i>
                    </button>
                  </td>
                  <td class="py-3 px-4 text-center">
                    <span :class="['text-xs font-bold px-2.5 py-1 rounded-full', p.stock === 0 ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-600']">
                      {{ p.stock === 0 ? 'Sin stock' : p.stock }}
                    </span>
                  </td>
                  <td class="py-3 px-4 text-right text-gray-900">
                    S/ {{ p.precioVenta.toFixed(2) }}<span v-if="p.precioVentaMax"> - {{ p.precioVentaMax.toFixed(2) }}</span>
                  </td>
                  <td class="py-3 px-4">
                    <div class="flex items-center justify-center gap-2">
                      <button
                        @click="abrirColores(p)"
                        title="Colores"
                        class="w-8 h-8 rounded-lg bg-purple-50 hover:bg-purple-100 text-purple-500 hover:text-purple-600 flex items-center justify-center transition-colors"
                      >
                        <i class="fa-solid fa-palette text-xs"></i>
                      </button>
                      <button
                        @click="abrirEditar(p)"
                        title="Editar"
                        class="w-8 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-500 hover:text-blue-600 flex items-center justify-center transition-colors"
                      >
                        <i class="fa-solid fa-pen text-xs"></i>
                      </button>
                      <button
                        @click="eliminar(p)"
                        title="Eliminar"
                        class="w-8 h-8 rounded-lg bg-red-50 hover:bg-red-100 text-red-500 hover:text-red-600 flex items-center justify-center transition-colors"
                      >
                        <i class="fa-solid fa-trash text-xs"></i>
                      </button>
                    </div>
                  </td>
                </tr>

                <tr v-if="expandedProductId === p.id" class="bg-gray-50">
                  <td colspan="7" class="px-6 py-4">
                    <div v-if="loadingVariantes" class="text-xs text-gray-400 py-2">Cargando variantes...</div>
                    <div v-else-if="(variantesCache[p.id] || []).length === 0" class="text-xs text-gray-400 py-2">
                      Este modelo aún no tiene variantes (talla/color) registradas — se crean automáticamente al registrar una compra.
                    </div>
                    <table v-else class="w-full text-xs">
                      <thead>
                        <tr class="text-gray-400">
                          <th class="text-left py-1.5 pr-4 font-semibold">Talla</th>
                          <th class="text-left py-1.5 pr-4 font-semibold">Color</th>
                          <th class="text-center py-1.5 pr-4 font-semibold">Stock</th>
                          <th class="text-right py-1.5 font-semibold">Costo Ref.</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="v in variantesCache[p.id]" :key="v.id" class="border-t border-gray-100">
                          <td class="py-2 pr-4 text-gray-900 font-medium">{{ v.talla }}</td>
                          <td class="py-2 pr-4">
                            <div class="flex items-center gap-1.5">
                              <div class="w-3.5 h-3.5 rounded-full border border-gray-200" :style="{ backgroundColor: v.colorHex || '#e5e7eb' }"></div>
                              <span class="text-gray-600">{{ v.color }}</span>
                            </div>
                          </td>
                          <td class="py-2 pr-4 text-center">
                            <span :class="['text-xs font-bold px-2 py-0.5 rounded-full', v.stock === 0 ? 'bg-red-100 text-red-500' : 'bg-green-100 text-green-600']">
                              {{ v.stock === 0 ? 'Sin stock' : v.stock }}
                            </span>
                          </td>
                          <td class="py-2 text-right text-gray-900">S/ {{ v.costo.toFixed(2) }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </td>
                </tr>
              </template>
            </tbody>
          </table>
        </div>

        <div v-else-if="productos.length === 0" class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-book text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Aún no hay modelos registrados en el catálogo.</p>
        </div>

        <div v-else class="bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200 p-12 text-center">
          <i class="fa-solid fa-filter-circle-xmark text-4xl text-gray-300 mb-3"></i>
          <p class="text-gray-500">Ningún modelo coincide con estos filtros.</p>
        </div>
      </div>
    </div>

    <RegistrarModeloModal
      v-if="showModal"
      :categorias-existentes="categorias"
      :marcas-existentes="marcas"
      :editando="editando"
      @close="cerrarModal"
    />

    <GestionarColoresModal
      v-if="productoColores"
      :producto="productoColores"
      @close="cerrarColores"
    />
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import RegistrarModeloModal from './RegistrarModeloModal.vue';
import GestionarColoresModal from './GestionarColoresModal.vue';
import SearchInput from '@/Components/Admin/SearchInput.vue';
import SelectDropdown from '@/Components/Admin/SelectDropdown.vue';
import { ref, computed } from 'vue';
import { usePage, router } from '@inertiajs/vue3';

const props = defineProps({
  productos: Array,
  categorias: Array,
  marcas: Array,
});

const page = usePage();

const filtroTexto = ref('');
const filtroCategoria = ref('');
const filtroMarca = ref('');

const opcionesCategoria = computed(() => [
  { value: '', label: 'Todas las categorías' },
  ...props.categorias.map(c => ({ value: c, label: c })),
]);

const opcionesMarca = computed(() => [
  { value: '', label: 'Todas las marcas' },
  ...props.marcas.map(m => ({ value: m, label: m })),
]);

const productosFiltrados = computed(() => {
  const texto = filtroTexto.value.trim().toLowerCase();

  return props.productos.filter((p) => {
    if (filtroCategoria.value && p.categoria !== filtroCategoria.value) return false;
    if (filtroMarca.value && p.marca !== filtroMarca.value) return false;
    if (texto && !p.nombre.toLowerCase().includes(texto) && !p.marca.toLowerCase().includes(texto)) return false;
    return true;
  });
});

const showModal = ref(false);
const editando = ref(null);

const abrirCrear = () => {
  editando.value = null;
  showModal.value = true;
};

const abrirEditar = (producto) => {
  editando.value = { id: producto.id, nombre: producto.nombre, marca: producto.marca, categoria: producto.categoria, descripcion: producto.descripcion };
  showModal.value = true;
};

const cerrarModal = () => {
  showModal.value = false;
  editando.value = null;
};

const productoColores = ref(null);

const abrirColores = (producto) => {
  productoColores.value = producto;
};

const cerrarColores = () => {
  productoColores.value = null;
  // Puede haber cambiado el color de alguna variante ya cargada en caché.
  variantesCache.value = {};
};

const eliminar = (producto) => {
  if (!confirm(`¿Eliminar "${producto.nombre}" (${producto.marca}) del catálogo?`)) return;
  router.delete(route('admin.catalogo.destroy', producto.id));
};

const expandedProductId = ref(null);
const variantesCache = ref({});
const loadingVariantes = ref(false);

const toggleVariantes = async (productId) => {
  if (expandedProductId.value === productId) {
    expandedProductId.value = null;
    return;
  }

  expandedProductId.value = productId;

  if (variantesCache.value[productId]) {
    return;
  }

  loadingVariantes.value = true;
  try {
    const res = await fetch(`/admin/catalogo/${productId}/variantes`);
    variantesCache.value[productId] = await res.json();
  } catch (e) {
    variantesCache.value[productId] = [];
  } finally {
    loadingVariantes.value = false;
  }
};
</script>
