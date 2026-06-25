# Instalacion de Vue 3 + Inertia.js en Laravel

## Requisitos previos

- PHP ^8.3
- Composer
- Node.js y npm

## Pasos de instalacion

### 1. Crear proyecto Laravel

```bash
composer create-project laravel/laravel Street-urban-ecommerce
```

### 2. Instalar Breeze (Inertia + Vue)

```bash
composer require laravel/breeze --dev
```

### 3. Ejecutar el instalador de Breeze

```bash
php artisan breeze:install inertia
```

> Esto instala automaticamente todo lo necesario:
> - **Backend:** `inertiajs/inertia-laravel`
> - **Frontend:** `vue`, `@vitejs/plugin-vue`, `@inertiajs/vue3`, `tailwindcss`
> - **Routing SPA:** `tightenco/ziggy`
> - Crea layouts, componentes y paginas de ejemplo en `resources/js/`
> - Configura `vite.config.js` con el plugin de Vue
> - Genera el layout blade en `resources/views/app.blade.php`

### 4. Instalar dependencias npm

```bash
npm install
```

### 5. Compilar assets

```bash
npm run build
```

## Archivos clave generados

| Archivo | Proposito |
|---------|-----------|
| `resources/js/app.js` | Punto de entrada: configura Inertia + Vue |
| `resources/js/Pages/` | Paginas Vue del SPA |
| `resources/js/Components/` | Componentes Vue reutilizables |
| `resources/js/Layouts/` | Layouts de la aplicacion |
| `resources/views/app.blade.php` | Template principal con `@inertia` y `@vite` |
| `vite.config.js` | Configuracion de Vite con plugin Vue |

## Comandos para desarrollo

```bash
# Servidor Laravel
php artisan serve

# Servidor Vite (hot reload)
npm run dev

# Ambos a la vez
composer run dev
```

## Paquetes instalados

### Backend (Composer)
- `inertiajs/inertia-laravel` ^2.0
- `tightenco/ziggy` ^2.0 (rutas de Laravel en JS)
- `laravel/breeze` ^2.4 (scaffolding)

### Frontend (npm)
- `vue` ^3.4.0
- `@vitejs/plugin-vue` ^6.0.0
- `@inertiajs/vue3` ^2.0.0
- `vite` ^8.0.0
- `tailwindcss` ^3.2.1
- `axios` ^1.18.1
