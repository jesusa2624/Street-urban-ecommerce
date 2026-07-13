# 🛍️ Street Urban Ecommerce - Panel Administrativo

## Proyecto Académico IDL2
**Caso Práctico: Desarrollo de APIs REST y CRUD Administrativo**

---

## 📋 Resumen del Proyecto

Se ha desarrollado un sistema completo de ecommerce urbano que incluye:

### ✅ **APIs REST Completas**
- 4 APIs REST con CRUD completo
- Búsqueda y filtros avanzados
- Gestión transaccional
- Validación de datos

### ✅ **Panel Administrativo Profesional**
- CRUD de clientes completo
- Diseño dark mode moderno
- Interfaz intuitiva y responsive
- Gestión de usuarios

---

## 🚀 Inicio Rápido

### 1. **Instalar Dependencias**

```bash
cd /Users/gzus/Desktop/PROYECTOS/Street-urban-ecommerce

# Instalar dependencias PHP
composer install

# Instalar dependencias Node.js
npm install
```

### 2. **Configurar Base de Datos**

```bash
# Configurar archivo .env
cp .env.example .env

# Generar clave de aplicación
php artisan key:generate

# Ejecutar migraciones
php artisan migrate

# Poblar datos de prueba
php artisan db:seed
```

### 3. **Ejecutar el Proyecto**

```bash
# En una terminal - Servidor Laravel
php artisan serve

# En otra terminal - Compilar assets (Vue.js)
npm run dev
```

---

## 🔐 Credenciales de Acceso

### Usuario de Prueba

```
📧 Email:      jesus@gmail.com
🔑 Contraseña: password
```

---

## 🌐 URLs de Acceso

### Panel Administrativo
```
http://127.0.0.1:8000/admin/dashboard
```

### Secciones Principales

| Sección | URL | Descripción |
|---------|-----|-------------|
| **Dashboard** | `http://127.0.0.1:8000/admin/dashboard` | Panel principal |
| **Clientes** | `http://127.0.0.1:8000/admin/customers` | Gestión de clientes |
| **Productos** | `http://127.0.0.1:8000/admin/products` | Gestión de productos |
| **Tienda** | `http://127.0.0.1:8000/` | Vista pública |

---

## 📚 APIs REST

### Base URL
```
http://127.0.0.1:8000/api
```

### Endpoints Principales

#### Categorías
```
GET    /api/categories                 - Listar categorías
POST   /api/categories                 - Crear categoría
PATCH  /api/categories/{id}            - Actualizar categoría
DELETE /api/categories/{id}            - Eliminar categoría
```

#### Productos
```
GET    /api/products                   - Listar productos (con filtros)
POST   /api/products                   - Crear producto
PATCH  /api/products/{id}              - Actualizar producto
DELETE /api/products/{id}              - Eliminar producto
POST   /api/products/bulk-update-stock - Actualización masiva de stock
```

#### Órdenes
```
GET    /api/orders                     - Listar órdenes (con filtros)
POST   /api/orders                     - Crear orden
PATCH  /api/orders/{id}                - Actualizar orden
DELETE /api/orders/{id}                - Eliminar orden
POST   /api/orders/bulk-update-status  - Actualización masiva de estado
```

### Ejemplo de Búsqueda de Productos

```
GET /api/products?search=camiseta&min_price=20&max_price=100&in_stock=true
```

---

## 🎯 Funcionalidades Implementadas

### ✨ **CRUD de Clientes**
- ✅ Listar clientes (ordenados por más recientes)
- ✅ Crear nuevo cliente
- ✅ Editar información del cliente
- ✅ Eliminar cliente
- ✅ Validación de datos
- ✅ Mensajes de éxito/error

### 🎨 **Diseño y UX**
- ✅ Dark mode profesional
- ✅ Iconos SVG personalizados
- ✅ Efectos hover elegantes
- ✅ Transiciones suaves
- ✅ Responsive design
- ✅ Interfaz intuitiva

### 🔒 **Seguridad**
- ✅ Autenticación de usuarios
- ✅ Validación de entrada
- ✅ Protección contra inyección SQL (Eloquent ORM)
- ✅ Encriptación de contraseñas

---

## 📁 Estructura del Proyecto

```
Street-urban-ecommerce/
├── app/
│   ├── Http/Controllers/
│   │   ├── Admin/
│   │   │   ├── CustomerAdminController.php
│   │   │   └── ProductAdminController.php
│   │   └── Api/
│   │       ├── CategoryController.php
│   │       ├── ProductController.php
│   │       ├── OrderController.php
│   │       └── OrderItemController.php
│   └── Models/
│       ├── User.php
│       ├── Category.php
│       ├── Product.php
│       ├── Order.php
│       └── OrderItem.php
├── resources/
│   └── js/
│       ├── Layouts/
│       │   └── AdminLayout.vue
│       └── Pages/
│           └── Admin/
│               ├── Dashboard.vue
│               └── Customers/
│                   ├── Index.vue
│                   ├── Create.vue
│                   └── Edit.vue
├── routes/
│   ├── api.php
│   └── web.php
└── database/
    ├── migrations/
    └── seeders/
```

---

## 🗄️ Base de Datos

### Tablas Creadas
- **users** - Usuarios y clientes del sistema
- **categories** - Categorías de productos
- **products** - Catálogo de productos
- **orders** - Órdenes de compra
- **order_items** - Detalles de órdenes

### Datos de Prueba Incluidos
- **4 Categorías:** Camisetas, Pantalones, Accesorios, Calzado
- **9 Productos:** Variedad con precios y stock
- **3 Órdenes:** Ejemplos con diferentes estados
- **11 Usuarios:** Cliente de prueba y seeders

---

## 🧪 Cómo Probar

### 1. **Entrar al Panel Admin**

1. Abre `http://127.0.0.1:8000`
2. Haz click en botón **"INGRESAR"** (navbar)
3. Ingresa credenciales:
   - Email: `jesus@gmail.com`
   - Contraseña: `password`
4. Verás el botón **"Panel Admin"** en el navbar
5. Haz click para acceder

### 2. **Probar CRUD de Clientes**

En el panel admin:
- Ve a **Clientes**
- Haz click en **"Nuevo Cliente"**
- Completa el formulario
- **Crear** - Los nuevos aparecen arriba
- **Editar** - Modifica nombre y email
- **Eliminar** - Confirma y se borra

### 3. **Probar APIs REST**

```bash
# Ver todos los productos
curl http://127.0.0.1:8000/api/products

# Buscar camisetas
curl "http://127.0.0.1:8000/api/products?search=camiseta"

# Filtrar por precio
curl "http://127.0.0.1:8000/api/products?min_price=30&max_price=100"

# Crear cliente (POST)
curl -X POST http://127.0.0.1:8000/api/customers \
  -H "Content-Type: application/json" \
  -d '{"name":"Nuevo Cliente","email":"nuevo@test.com","password":"password123"}'
```

---

## 📊 Tecnologías Utilizadas

### Backend
- **Laravel 10** - Framework PHP
- **MySQL** - Base de datos
- **Eloquent ORM** - Mapeo de base de datos

### Frontend
- **Vue.js 3** - Framework JavaScript
- **Inertia.js** - Conecta Laravel con Vue
- **Tailwind CSS** - Estilos CSS

### Tools
- **Composer** - Gestor de dependencias PHP
- **npm** - Gestor de dependencias Node.js
- **Vite** - Compilador de assets

---

## ✅ Checklist de Funcionalidades

### APIs REST
- ✅ CRUD Categories (Create, Read, Update, Delete)
- ✅ CRUD Products (Create, Read, Update, Delete)
- ✅ CRUD Orders (Create, Read, Update, Delete)
- ✅ CRUD OrderItems (Create, Read, Update, Delete)
- ✅ Búsqueda multi-campo
- ✅ Filtros avanzados
- ✅ Paginación
- ✅ Validación de datos
- ✅ Transacciones ACID
- ✅ Operaciones masivas

### Panel Administrativo
- ✅ Dashboard con resumen
- ✅ CRUD Clientes (Create, Read, Update, Delete)
- ✅ Listar clientes ordenados por fecha (nuevos arriba)
- ✅ Crear nuevo cliente con validación
- ✅ Editar información del cliente
- ✅ Eliminar cliente con confirmación
- ✅ Mensajes de éxito/error
- ✅ Diseño dark mode profesional
- ✅ Iconos SVG personalizados
- ✅ Responsive design

### Seguridad
- ✅ Autenticación de usuarios
- ✅ Validación de entrada
- ✅ Protección CSRF
- ✅ Encriptación de contraseñas

---

## 🐛 Solución de Problemas

### "No se conecta a la BD"
```bash
# Verifica las credenciales en .env
php artisan migrate
```

### "Las migraciones fallan"
```bash
# Limpiar cache y reintentar
php artisan cache:clear
php artisan migrate:fresh --seed
```

### "Los assets de Vue no se compilan"
```bash
# Asegúrate de tener npm instalado
npm install
npm run dev
```

### "Puerto 8000 ya está en uso"
```bash
# Usa otro puerto
php artisan serve --port=8001
```

---

## 📞 Contacto

**Estudiante:** Jesús  
**Email:** jesus@gmail.com  
**Institución:** Instituto Continental  
**Asignatura:** IDL2 - Desarrollo de Sistemas de Información

---

## 📝 Documentación Adicional

Para más detalles técnicos, ver:
- `API_DOCUMENTATION.md` - Documentación completa de APIs
- `README_APIS_SIMPLE.md` - Guía rápida de APIs
- `PANEL_ADMIN.md` - Guía del panel administrativo

---

**Última actualización:** 2026-07-13  
**Estado:** ✅ Completo y funcional
