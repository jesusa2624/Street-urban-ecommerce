<script setup>
import { ref, computed } from 'vue';

const props = defineProps({
  options: { type: Array, required: true }, // [{ value, label }]
  placeholder: { type: String, default: 'Selecciona...' },
});

const model = defineModel({ type: String, default: '' });

const isOpen = ref(false);

const currentLabel = computed(() => {
  const found = props.options.find(o => o.value === model.value);
  return found ? found.label : props.placeholder;
});

const seleccionar = (value) => {
  model.value = value;
  isOpen.value = false;
};

const cerrarConRetraso = () => {
  setTimeout(() => {
    isOpen.value = false;
  }, 150);
};
</script>

<template>
  <div class="relative">
    <button
      type="button"
      @click="isOpen = !isOpen"
      @blur="cerrarConRetraso"
      class="w-full flex items-center justify-between gap-2 bg-white border border-gray-200 rounded-lg text-sm px-3 py-2 text-gray-600 hover:border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#ff8c42] transition-colors"
    >
      <span class="truncate">{{ currentLabel }}</span>
      <i class="fa-solid fa-chevron-down text-gray-400 text-xs flex-shrink-0"></i>
    </button>

    <div
      v-if="isOpen"
      class="absolute z-20 mt-1 w-full bg-white border border-gray-200 rounded-lg shadow-lg overflow-hidden max-h-56 overflow-y-auto"
    >
      <button
        v-for="(op, idx) in options"
        :key="op.value"
        type="button"
        @mousedown.prevent="seleccionar(op.value)"
        :class="[
          'w-full text-left px-4 py-2.5 text-sm hover:bg-gray-50',
          idx > 0 ? 'border-t border-gray-50' : '',
          model === op.value ? 'text-[#ff8c42] font-semibold' : 'text-gray-600',
        ]"
      >
        {{ op.label }}
      </button>
    </div>
  </div>
</template>
