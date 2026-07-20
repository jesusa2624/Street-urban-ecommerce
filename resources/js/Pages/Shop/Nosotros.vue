<script setup>
import { Head, Link } from '@inertiajs/vue3';
import ShopLayout from '@/Layouts/Shop/ShopLayout.vue';
</script>

<template>
  <Head title="Nosotros" />

  <ShopLayout>
    <!-- Padding para el navbar fijo -->
    <div class="pt-20"></div>

    <!-- Hero -->
    <section class="relative py-24 px-4 md:px-8 lg:px-16 overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-b from-white/5 via-transparent to-transparent"></div>
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-white/5 rounded-full blur-3xl"></div>

      <div class="relative max-w-[1400px] mx-auto">
        <div class="max-w-4xl">
          <p class="text-sm uppercase tracking-[0.3em] text-gray-400 mb-6">
            Conoce nuestra historia
          </p>

          <h1 class="text-4xl md:text-6xl lg:text-7xl font-black uppercase tracking-tight italic leading-tight">
            Más que una
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">
              tienda
            </span>
          </h1>

          <div class="h-1.5 w-24 bg-gradient-to-r from-white via-white to-gray-600 rounded-full mt-6"></div>

          <p class="text-lg md:text-xl text-gray-400 mt-8 max-w-2xl leading-relaxed">
            Una propuesta pensada para quienes encuentran en su estilo una forma de expresarse.
          </p>
        </div>
      </div>
    </section>

    <!-- Historia -->
    <section class="px-4 md:px-8 lg:px-16 max-w-[1400px] mx-auto py-24">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div class="relative h-[420px] overflow-hidden rounded-2xl">
          <img
            src="/image/shop/nosotros-img.jpg"
            alt="Street Urban"
            class="w-full h-full object-cover"
          >

          <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent"></div>
        </div>

        <div>
          <h2 class="text-3xl md:text-4xl font-black uppercase italic mb-6">
            Nuestra <span class="text-gray-500">Historia</span>
          </h2>

          <div class="h-1.5 w-24 bg-gradient-to-r from-white to-gray-600 rounded-full mb-8"></div>

          <div class="space-y-6 text-gray-400 text-lg leading-relaxed">
            <p>
              Street Urban representa una forma de entender la moda y el estilo personal.
              Cada persona tiene una identidad propia y creemos que la ropa es una de las
              formas más directas de expresarla.
            </p>

            <p>
              Nuestra propuesta reúne productos pensados para acompañar diferentes estilos,
              momentos y formas de vivir la ciudad.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Filosofía -->
    <section class="px-4 md:px-8 lg:px-16 py-24 border-y border-gray-800 bg-[#0a0a0a]">
      <div class="max-w-[1400px] mx-auto">
        <div class="mb-16">
          <h2 class="text-3xl md:text-5xl font-black uppercase tracking-tight italic">
            Nuestra <span class="text-gray-500">Filosofía</span>
          </h2>

          <div class="h-1.5 w-24 bg-gradient-to-r from-white to-gray-600 rounded-full mt-6"></div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
          <div class="border-t border-gray-700 pt-6">
            <span class="text-gray-600 text-sm font-mono">01</span>

            <h3 class="text-2xl font-black uppercase italic mt-4 mb-4">
              Estilo
            </h3>

            <p class="text-gray-400 leading-relaxed">
              Una forma de vestir también puede ser una forma de hablar.
            </p>
          </div>

          <div class="border-t border-gray-700 pt-6">
            <span class="text-gray-600 text-sm font-mono">02</span>

            <h3 class="text-2xl font-black uppercase italic mt-4 mb-4">
              Identidad
            </h3>

            <p class="text-gray-400 leading-relaxed">
              Creemos en la libertad de construir una imagen propia.
            </p>
          </div>

          <div class="border-t border-gray-700 pt-6">
            <span class="text-gray-600 text-sm font-mono">03</span>

            <h3 class="text-2xl font-black uppercase italic mt-4 mb-4">
              Actitud
            </h3>

            <p class="text-gray-400 leading-relaxed">
              Cada detalle cuenta cuando se trata de definir quién eres.
            </p>
          </div>
        </div>
      </div>
    </section>

    <!-- Manifiesto -->
    <section class="relative py-32 px-4 md:px-8 lg:px-16 overflow-hidden">
      <div class="absolute inset-0 bg-gradient-to-r from-white/5 via-transparent to-transparent"></div>

      <div class="relative max-w-[1400px] mx-auto">
        <div class="max-w-5xl">
          <p class="text-4xl md:text-6xl lg:text-7xl font-black uppercase italic tracking-tight leading-tight">
            Define tu estilo.
            <br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">
              Domina las calles.
            </span>
          </p>
        </div>
      </div>
    </section>

    <!-- CTA -->
    <section class="px-4 md:px-8 lg:px-16 py-24 border-t border-gray-800">
      <div class="max-w-2xl mx-auto text-center">
        <h2 class="text-3xl md:text-4xl font-black uppercase italic mb-6">
          Encuentra tu <span class="text-gray-500">estilo</span>
        </h2>

        <p class="text-gray-400 text-lg mb-8">
          Explora nuestra colección y encuentra aquello que representa tu forma de vivir la ciudad.
        </p>

        <Link
          :href="route('shop.tienda')"
          class="inline-block px-10 py-4 bg-white text-black font-black uppercase tracking-widest hover:bg-gray-200 transition-all"
        >
          Explorar Colección
        </Link>
      </div>
    </section>
  </ShopLayout>
</template>
