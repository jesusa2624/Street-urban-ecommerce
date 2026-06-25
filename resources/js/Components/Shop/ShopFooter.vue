<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
  <footer class="bg-[#0a0a0a] text-white py-16 border-t border-white/5">
    <div class="max-w-[1600px] mx-auto px-4 md:px-8 lg:px-16 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
      
      <!-- Brand Section -->
      <div class="space-y-6">
        <h2 class="text-2xl font-black uppercase tracking-tighter italic">
          Street <span class="text-white/50">Urban</span>
        </h2>
        <p class="text-gray-400 text-sm leading-relaxed">
          Llevamos la cultura urbana a otro nivel. Calidad premium, diseño disruptivo y la esencia de la calle en cada prenda.
        </p>
        <div class="flex gap-4">
          <a href="#" class="text-gray-400 hover:text-white transition-colors"><span class="sr-only">Instagram</span><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.049 1.265.059 2.156.059 4.849 0 2.693-.01 3.584-.059 4.849-.07 3.252-1.691 4.771-4.919 4.919-1.265.049-2.156.059-4.849.059-2.693 0-3.584-.01-4.849-.059-3.252-.148-4.771-1.691-4.919-4.919-.049-1.265-.059-2.156-.059-4.849 0-2.693.01-3.584.059-4.849.07-3.252 1.691-4.771 4.919-4.919 1.265-.049 2.156-.059 4.849-.059zM12 0C8.741 0 8.333 0.012 7.053 0.07 3.73 0.148 2.19 1.691 2.042 4.919C2.01 5.833 1.98 6.747 1.98 12.667c0 5.92 0.02 6.834 0.042 7.747 0.07 3.252 1.691 4.771 4.919 4.919 1.265.049 2.156.059 4.849.059 2.693 0 3.584-.01-4.849-.059 3.252-.148 4.771-1.691 4.919-4.919 1.265-.049 2.156-.059 4.849-.059 2.693 0 3.584-.01-4.849-.059 3.252-.148 4.771-1.691 4.919-4.919 1.265-.049 2.156-.059 4.849-.059z"/></svg></a>
          <a href="#" class="text-gray-400 hover:text-white transition-colors"><span class="sr-only">Twitter</span><svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23 3a10.9 10.9 0 0 1-2.05 6.458C19.5 8.92 19 9.5 18.5 10h-4.5V4.5a2.5 2.5 0 0 0-2.5-2.5 2.5 2.5 0 0 0-2.5 2.5V10h-4.5C5.5 10 5 9.5 4.5 8.92 4.05 8.458 3 3a10.9 10.9 0 0 1 10 0z"/></svg></a>
        </div>
      </div>

      <!-- Links Section -->
      <div>
        <h3 class="text-sm font-bold uppercase tracking-widest mb-6 text-white">Explorar</h3>
        <ul class="space-y-4">
          <li><Link href="/shop" class="text-gray-400 hover:text-white transition-colors text-sm">Todos los Productos</Link></li>
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Novedades</Link></li>
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Más Vendidos</Link></li>
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Ofertas</Link></li>
        </ul>
      </div>

      <!-- Support Section -->
      <div>
        <h3 class="text-sm font-bold uppercase tracking-widest mb-6 text-white">Ayuda</h3>
        <ul class="space-y-4">
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Envíos y Entregas</Link></li>
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Cambios y Devoluciones</Link></li>
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Guía de Tallas</Link></li>
          <li><Link href="#" class="text-gray-400 hover:text-white transition-colors text-sm">Contacto</Link></li>
        </ul>
      </div>

      <!-- Newsletter Section -->
      <div>
        <h3 class="text-sm font-bold uppercase tracking-widest mb-6 text-white">Newsletter</h3>
        <p class="text-gray-400 text-sm mb-6">Únete para recibir lanzamientos exclusivos.</p>
        <form @submit.prevent class="flex gap-2">
          <input 
            type="email" 
            placeholder="Email" 
            class="bg-transparent border border-white/20 px-4 py-2 text-sm focus:outline-none focus:border-white transition-colors w-full"
          />
          <button class="bg-white text-black px-4 py-2 text-xs font-bold uppercase hover:bg-gray-200 transition-colors">
            OK
          </button>
        </form>
      </div>
    </div>

    <div class="max-w-[1600px] mx-auto px-4 md:px-8 lg:px-16 mt-16 pt-8 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-gray-500">
      <p>&copy; 2026 Street Urban. All rights reserved.</p>
      <div class="flex gap-6">
        <a href="#" class="hover:text-white transition-colors">Términos de Servicio</a>
        <a href="#" class="hover:text-white transition-colors">Política de Privacidad</a>
        <a href="#" class="hover:text-white transition-colors">Cookies</a>
      </div>
    </div>
  </footer>
</template>
