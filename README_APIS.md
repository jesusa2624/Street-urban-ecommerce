# 📦 APIs REST - Street Urban Ecommerce

## 📋 Contenido

Este documento describe las **APIs REST** implementadas para el proyecto de ecommerce **Street Urban**. Las APIs permiten gestionar categorías, productos, órdenes y detalles de pedidos con búsqueda avanzada y filtros complejos.

---

## 🚀 Inicio Rápido

### 1. **Instalar dependencias**
```bash
composer install
npm install
```

### 2. **Configurar la base de datos**
```bash
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan db:seed
```

### 3. **Iniciar el servidor**
```bash
php artisan serve
```

El servidor estará disponible en: `http://127.0.0.1:8000`

---

## 🌐 Acceso a las APIs

### URLs Base

| Tipo | URL |
|------|-----|
| **Categorías** | `http://127.0.0.1:8000/api/categories` |
| **Productos** | `http://127.0.0.1:8000/api/products` |
| **Órdenes** | `http://127.0.0.1:8000/api/orders` |
| **Items de Órdenes** | `http://127.0.0.1:8000/api/order-items` |

### ✅ Prueba Inmediata en el Navegador

Copia y pega estas URLs en tu navegador:

1. **Ver todas las categorías:**
```
http://127.0.0.1:8000/api/categories
```

2. **Ver todos los productos:**
```
http://127.0.0.1:8000/api/products
```

3. **Ver todas las órdenes:**
```
http://127.0.0.1:8000/api/orders
```

---

## 🔍 Búsqueda y Filtros

### Búsqueda en Productos

**Buscar por nombre o descripción:**
```
http://127.0.0.1:8000/api/products?search=camiseta
```

**Filtrar por rango de precio:**
```
http://127.0.0.1:8000/api/products?min_price=20&max_price=100
```

**Filtrar por categoría:**
```
http://127.0.0.1:8000/api/products?category_id=1
```

**Solo productos en stock:**
```
http://127.0.0.1:8000/api/products?in_stock=true
```

**Combinado (búsqueda + filtros + ordenamiento):**
```
http://127.0.0.1:8000/api/products?search=camiseta&min_price=20&max_price=100&sort_by=price&sort_order=asc&per_page=10
```

### Búsqueda en Órdenes

**Buscar por número de orden:**
```
http://127.0.0.1:8000/api/orders?order_number=ORD-001
```

**Filtrar por estado:**
```
http://127.0.0.1:8000/api/orders?status=pending
```

**Filtrar por usuario:**
```
http://127.0.0.1:8000/api/orders?user_id=1
```

**Filtrar por rango de fechas:**
```
http://127.0.0.1:8000/api/orders?date_from=2026-07-01&date_to=2026-07-31
```

---

## 📡 Crear Datos con Postman

### Descargar Postman
https://www.postman.com/downloads/

### Crear un Producto

1. **Nueva petición:** `POST`
2. **URL:** `http://127.0.0.1:8000/api/products`
3. **Body (JSON):**
```json
{
  "name": "Camiseta Nueva",
  "description": "Camiseta de algodón 100%",
  "sku": "CAMISETA-001",
  "price": 39.99,
  "cost": 15.00,
  "stock": 50,
  "category_id": 1,
  "image_url": "https://via.placeholder.com/300",
  "active": true
}
```

### Crear una Orden

1. **Nueva petición:** `POST`
2. **URL:** `http://127.0.0.1:8000/api/orders`
3. **Body (JSON):**
```json
{
  "user_id": 1,
  "order_number": "ORD-12345",
  "status": "pending",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 2,
      "quantity": 1
    }
  ],
  "tax": 10.50,
  "shipping": 5.00,
  "shipping_address": "Calle Principal 123",
  "billing_address": "Calle Principal 123",
  "payment_method": "credit_card"
}
```

---

## 📊 Características Implementadas

### ✅ CRUD Completo
Cada entidad soporta las 4 operaciones fundamentales:
- **GET** - Listar y buscar
- **POST** - Crear
- **PATCH** - Actualizar
- **DELETE** - Eliminar

### ✅ Búsqueda Multi-campo
- Productos: búsqueda en nombre, descripción, SKU
- Órdenes: búsqueda por número de orden
- Categorías: búsqueda en nombre y descripción

### ✅ Filtros Avanzados
- **Productos:** precio (min/max), categoría, stock, estado
- **Órdenes:** estado, usuario, fecha, monto
- **Categorías:** estado activo/inactivo

### ✅ Paginación
Todos los endpoints soportan paginación:
```
?page=1&per_page=15
```

### ✅ Ordenamiento
Control total sobre cómo se ordenan los resultados:
```
?sort_by=price&sort_order=asc
```

### ✅ Transacciones ACID
Las órdenes se crean con transacciones:
- ✓ Descuenta stock automáticamente
- ✓ Valida disponibilidad de productos
- ✓ Calcula totales
- ✓ Rollback si hay error

### ✅ Operaciones Masivas
- Actualizar stock de múltiples productos
- Cambiar estado de múltiples órdenes

---

## 📁 Estructura del Código

```
app/Http/Controllers/Api/
├── CategoryController.php      ← API Categorías
├── ProductController.php       ← API Productos
├── OrderController.php         ← API Órdenes
└── OrderItemController.php     ← API Items de Órdenes

app/Models/
├── Category.php                ← Modelo Categoría
├── Product.php                 ← Modelo Producto
├── Order.php                   ← Modelo Orden
└── OrderItem.php               ← Modelo Item de Orden

database/migrations/
├── create_categories_table.php
├── create_products_table.php
├── create_orders_table.php
└── create_order_items_table.php

database/seeders/
├── CategorySeeder.php          ← Datos iniciales Categorías
├── ProductSeeder.php           ← Datos iniciales Productos
└── OrderSeeder.php             ← Datos iniciales Órdenes

routes/
└── api.php                     ← Definición de rutas API
```

---

## 🗄️ Base de Datos

### Tablas Creadas

| Tabla | Descripción |
|-------|-------------|
| **categories** | Categorías de productos |
| **products** | Catálogo de productos |
| **orders** | Órdenes de compra |
| **order_items** | Detalles de cada orden |
| **users** | Usuarios del sistema |

### Relaciones

```
Category (1) ──→ (M) Products
Product (1) ──→ (M) OrderItems
Order (1) ──→ (M) OrderItems
User (1) ──→ (M) Orders
```

---

## 📝 Ejemplos de Consultas

### 1️⃣ Productos caros en Stock
```
http://127.0.0.1:8000/api/products?min_price=50&in_stock=true
```

### 2️⃣ Camisetas de la categoría 1
```
http://127.0.0.1:8000/api/products?category_id=1&search=camiseta
```

### 3️⃣ Órdenes pendientes del usuario 1
```
http://127.0.0.1:8000/api/orders?user_id=1&status=pending
```

### 4️⃣ Órdenes entregadas en julio
```
http://127.0.0.1:8000/api/orders?status=delivered&date_from=2026-07-01&date_to=2026-07-31
```

### 5️⃣ Productos ordenados por precio (menor a mayor)
```
http://127.0.0.1:8000/api/products?sort_by=price&sort_order=asc
```

---

## 🔧 Comandos Útiles

```bash
# Limpiar cache de rutas
php artisan route:clear

# Ejecutar migraciones
php artisan migrate

# Poblar base de datos con datos de prueba
php artisan db:seed

# Ver todas las rutas
php artisan route:list

# Reiniciar base de datos
php artisan migrate:refresh --seed
```

---

## 📚 Estándares Implementados

✅ **REST API Principles**
- Resource-based URLs
- HTTP methods (GET, POST, PATCH, DELETE)
- Stateless architecture

✅ **JSON Response Format**
- Respuestas consistentes
- Datos paginados
- Mensajes de error descriptivos

✅ **HTTP Status Codes**
- 200 - OK
- 201 - Created
- 204 - No Content
- 400 - Bad Request
- 404 - Not Found
- 422 - Validation Error

✅ **Validación de Entrada**
- Validación de datos
- Mensajes de error claros
- Reglas de negocio

✅ **Gestión de Transacciones**
- ACID compliance
- Rollback automático en errores

✅ **Seguridad**
- Validación de datos
- Protección contra inyección SQL (Eloquent ORM)
- Encriptación de contraseñas

---

## 🎯 Datos de Prueba Incluidos

Se proporcionan seeders con datos iniciales:

- **4 Categorías:** Camisetas, Pantalones, Accesorios, Calzado
- **9 Productos:** Variedad de prendas urbanas con precios realistas
- **3 Órdenes:** Ejemplos de compras con diferentes estados

---

## ❓ Preguntas Frecuentes

### ¿Cómo pruebo una API?
Opción 1: Copia una URL en el navegador
Opción 2: Usa Postman (recomendado para POST/PATCH/DELETE)

### ¿Cómo actualizo un producto?
```
PATCH http://127.0.0.1:8000/api/products/1
```

### ¿Cómo borro una orden?
```
DELETE http://127.0.0.1:8000/api/orders/1
```

### ¿Las órdenes restauran stock al eliminarse?
Sí, automáticamente. Las transacciones garantizan integridad.

---

## 📞 Soporte

Para más información ver: `API_DOCUMENTATION.md`

---

**Proyecto:** Street Urban Ecommerce  
**Tipo:** APIs REST con Laravel  
**Estado:** ✅ Completo y funcional  
**Fecha:** 2026-07-13
