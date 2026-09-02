<template>
  <AdminLayout>
    <template #breadcrumb>Dashboard</template>
    <template #header>Dashboard</template>

    <div class="space-y-6">
      <!-- Metric Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
        <div
          v-for="metric in metrics"
          :key="metric.label"
          class="bg-white rounded-2xl border border-gray-100 p-6 flex items-center justify-between shadow-sm"
        >
          <div>
            <p class="text-sm text-gray-400 font-medium">{{ metric.label }}</p>
            <p class="text-3xl font-black text-gray-900 mt-1">{{ metric.value }}</p>
            <p class="text-xs text-green-500 font-semibold mt-2">
              <i class="fa-solid fa-arrow-up text-[10px] mr-1"></i>{{ metric.change }} vs mes anterior
            </p>
          </div>
          <div :class="['w-14 h-14 rounded-xl flex items-center justify-center text-xl', metric.iconBg, metric.iconColor]">
            <i :class="['fa-solid', metric.icon]"></i>
          </div>
        </div>
      </div>

      <!-- Chart + Sidebar widgets -->
      <div class="grid grid-cols-1 xl:grid-cols-3 gap-5">
        <!-- Weekly sales chart -->
        <div class="xl:col-span-2 bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h3 class="text-lg font-bold text-gray-900">Ventas Semanales</h3>
              <p class="text-xs text-gray-400">Últimos 7 días</p>
            </div>
            <button class="text-xs font-semibold text-gray-500 bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 flex items-center gap-2">
              Últimos 7 días
              <i class="fa-solid fa-chevron-down text-[10px]"></i>
            </button>
          </div>

          <div class="flex items-end justify-between gap-3 h-48">
            <div v-for="day in weeklySales" :key="day.label" class="flex-1 flex flex-col items-center justify-end gap-2 h-full">
              <div class="w-full flex items-end justify-center gap-1 h-full">
                <div
                  class="w-1/2 rounded-t-md bg-[#ff8c42]"
                  :style="{ height: (day.sales / maxSales * 100) + '%' }"
                ></div>
                <div
                  class="w-1/2 rounded-t-md bg-gray-200"
                  :style="{ height: (day.returns / maxSales * 100) + '%' }"
                ></div>
              </div>
              <span class="text-[11px] text-gray-400">{{ day.label }}</span>
            </div>
          </div>

          <div class="flex items-center gap-6 mt-6 text-xs text-gray-500">
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-[#ff8c42]"></span>Ventas</span>
            <span class="flex items-center gap-1.5"><span class="w-2.5 h-2.5 rounded-full bg-gray-200"></span>Devoluciones</span>
          </div>
        </div>

        <!-- Quick actions + Top products -->
        <div class="space-y-5">
          <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Acciones Rápidas</h3>
            <div class="space-y-2.5">
              <button class="w-full bg-[#ff8c42] hover:bg-[#ff7a24] text-white text-sm font-bold py-3 rounded-xl transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-plus text-xs"></i> Nueva Venta
              </button>
              <Link
                :href="route('admin.products.index')"
                class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2"
              >
                <i class="fa-solid fa-cubes text-xs"></i> Ver Productos
              </Link>
              <button class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2">
                <i class="fa-solid fa-receipt text-xs"></i> Ver Órdenes
              </button>
              <Link
                :href="route('admin.customers.index')"
                class="w-full bg-gray-50 hover:bg-gray-100 text-gray-700 text-sm font-semibold py-3 rounded-xl transition flex items-center justify-center gap-2"
              >
                <i class="fa-solid fa-people-group text-xs"></i> Ver Clientes
              </Link>
            </div>
          </div>

          <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
            <h3 class="text-sm font-bold text-gray-900 mb-4">Productos Top</h3>
            <div class="space-y-4">
              <div v-for="product in topProducts" :key="product.name">
                <div class="flex items-center justify-between text-xs mb-1.5">
                  <span class="font-semibold text-gray-700">{{ product.name }}</span>
                  <span class="text-gray-400">{{ product.percent }}%</span>
                </div>
                <div class="h-1.5 w-full bg-gray-100 rounded-full overflow-hidden">
                  <div :class="['h-full rounded-full', product.color]" :style="{ width: product.percent + '%' }"></div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Recent orders -->
      <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm">
        <div class="flex items-center justify-between mb-4">
          <h3 class="text-lg font-bold text-gray-900">Órdenes Recientes</h3>
          <button class="text-xs font-semibold text-[#ff8c42] hover:text-[#ff7a24]">Ver todas <i class="fa-solid fa-arrow-right text-[10px] ml-1"></i></button>
        </div>

        <div class="divide-y divide-gray-100">
          <div v-for="order in recentOrders" :key="order.id" class="flex items-center justify-between py-3.5">
            <div>
              <p class="text-sm font-semibold text-gray-800">{{ order.customer }}</p>
              <p class="text-xs text-gray-400">{{ order.product }}</p>
            </div>
            <div class="flex items-center gap-4">
              <span class="text-sm font-bold text-gray-900">S/ {{ order.amount.toFixed(2) }}</span>
              <span
                :class="[
                  'text-xs font-semibold px-2.5 py-1 rounded-full',
                  order.status === 'Completado' ? 'bg-green-100 text-green-600' :
                  order.status === 'Pendiente' ? 'bg-yellow-100 text-yellow-600' :
                  'bg-blue-100 text-blue-600',
                ]"
              >
                {{ order.status }}
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

<script setup>
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const metrics = [
  { label: 'Ventas Totales', value: 'S/ 12,500', change: '+12%', icon: 'fa-sack-dollar', iconBg: 'bg-blue-50', iconColor: 'text-blue-500' },
  { label: 'Órdenes', value: '156', change: '+8%', icon: 'fa-receipt', iconBg: 'bg-orange-50', iconColor: 'text-[#ff8c42]' },
  { label: 'Clientes', value: '42', change: '+5%', icon: 'fa-people-group', iconBg: 'bg-purple-50', iconColor: 'text-purple-500' },
  { label: 'Productos', value: '128', change: '+3%', icon: 'fa-cubes', iconBg: 'bg-green-50', iconColor: 'text-green-500' },
];

const weeklySales = [
  { label: 'Lun', sales: 53, returns: 14 },
  { label: 'Mar', sales: 71, returns: 34 },
  { label: 'Mié', sales: 40, returns: 25 },
  { label: 'Jue', sales: 62, returns: 45 },
  { label: 'Vie', sales: 68, returns: 55 },
  { label: 'Sáb', sales: 65, returns: 50 },
  { label: 'Dom', sales: 58, returns: 42 },
];

const maxSales = computed(() => Math.max(...weeklySales.map(d => Math.max(d.sales, d.returns))));

const topProducts = [
  { name: 'Zapatillas Running', percent: 95, color: 'bg-[#ff8c42]' },
  { name: 'Polera Hoodie', percent: 78, color: 'bg-blue-400' },
  { name: 'Sneakers White', percent: 65, color: 'bg-green-400' },
];

const recentOrders = [
  { id: 1, customer: 'Juan Pérez', product: 'Zapatillas Running Pro', amount: 250.00, status: 'Completado' },
  { id: 2, customer: 'María García', product: 'Polera Hoodie Oversize', amount: 45.00, status: 'Pendiente' },
  { id: 3, customer: 'Carlos Ruiz', product: 'Sneakers White Luxe', amount: 140.00, status: 'Completado' },
  { id: 4, customer: 'Ana Torres', product: 'Chaqueta Bomber Black', amount: 110.00, status: 'Enviado' },
];
</script>
