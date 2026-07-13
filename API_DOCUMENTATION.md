# Documentación de APIs - Street Urban Ecommerce

Este documento describe todas las APIs REST implementadas para el sistema de ecommerce urbano.

## Base URL
```
http://localhost:8000/api
```

## Entidades y Endpoints

### 1. CATEGORÍAS (`/api/categories`)

#### Listar categorías con búsqueda
```http
GET /api/categories?search=camisetas&active=true&per_page=15
```

**Parámetros:**
- `search`: Busca en nombre y descripción
- `active`: Filtro por estado (true/false)
- `per_page`: Items por página (default: 15)
- `page`: Número de página

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Camisetas",
      "description": "Camisetas urbanas y deportivas",
      "slug": "camisetas",
      "active": true,
      "created_at": "2026-07-13T00:00:00.000000Z",
      "updated_at": "2026-07-13T00:00:00.000000Z"
    }
  ],
  "links": {},
  "meta": {}
}
```

#### Crear categoría
```http
POST /api/categories
Content-Type: application/json

{
  "name": "Nueva Categoría",
  "description": "Descripción",
  "slug": "nueva-categoria",
  "active": true
}
```

#### Actualizar categoría
```http
PATCH /api/categories/{id}
```

#### Eliminar categoría
```http
DELETE /api/categories/{id}
```

---

### 2. PRODUCTOS (`/api/products`)

#### Listar productos con filtros complejos
```http
GET /api/products?search=camiseta&category_id=1&min_price=20&max_price=100&in_stock=true&sort_by=price&sort_order=asc&per_page=15
```

**Parámetros:**
- `search`: Busca en nombre, descripción y SKU
- `category_id`: Filtro por categoría
- `min_price`: Precio mínimo
- `max_price`: Precio máximo
- `in_stock`: Solo productos con stock (true/false)
- `active`: Estado del producto
- `sort_by`: Campo para ordenar (created_at, price, name)
- `sort_order`: Dirección (asc/desc)
- `per_page`: Items por página

**Respuesta:**
```json
{
  "data": [
    {
      "id": 1,
      "name": "Camiseta Urban Básica",
      "description": "Producto de calidad superior con diseño urbano",
      "sku": "CAMISETA-URBAN-BÁSICA",
      "price": "29.99",
      "cost": "11.99",
      "stock": 50,
      "category_id": 1,
      "image_url": "https://via.placeholder.com/300",
      "active": true,
      "created_at": "2026-07-13T00:00:00.000000Z",
      "updated_at": "2026-07-13T00:00:00.000000Z",
      "category": {
        "id": 1,
        "name": "Camisetas"
      }
    }
  ]
}
```

#### Crear producto
```http
POST /api/products
Content-Type: application/json

{
  "name": "Nueva Camiseta",
  "description": "Descripción detallada",
  "sku": "NUEVA-CAMISETA-001",
  "price": 39.99,
  "cost": 15.99,
  "stock": 100,
  "category_id": 1,
  "image_url": "https://example.com/image.jpg",
  "active": true
}
```

#### Actualización masiva de stock
```http
POST /api/products/bulk-update-stock
Content-Type: application/json

{
  "updates": [
    {"product_id": 1, "quantity": 10},
    {"product_id": 2, "quantity": -5},
    {"product_id": 3, "quantity": 25}
  ]
}
```

---

### 3. ÓRDENES (`/api/orders`)

#### Listar órdenes con filtros
```http
GET /api/orders?user_id=1&status=pending&min_total=50&max_total=500&date_from=2026-07-01&date_to=2026-07-31&sort_by=created_at&sort_order=desc&per_page=15
```

**Parámetros:**
- `user_id`: Filtro por usuario
- `status`: pending, confirmed, shipped, delivered, cancelled
- `order_number`: Búsqueda por número de orden
- `min_total`: Monto mínimo
- `max_total`: Monto máximo
- `date_from`: Fecha inicial
- `date_to`: Fecha final
- `sort_by`: Campo para ordenar
- `sort_order`: Dirección

#### Crear orden (Transacción)
```http
POST /api/orders
Content-Type: application/json

{
  "user_id": 1,
  "order_number": "ORD-001234",
  "status": "pending",
  "items": [
    {
      "product_id": 1,
      "quantity": 2
    },
    {
      "product_id": 3,
      "quantity": 1
    }
  ],
  "tax": 10.50,
  "shipping": 5.00,
  "shipping_address": "Calle Principal 123, Ciudad",
  "billing_address": "Calle Principal 123, Ciudad",
  "payment_method": "credit_card"
}
```

**Características:**
- ✅ Descuenta automáticamente el stock
- ✅ Valida disponibilidad de productos
- ✅ Calcula totales automáticamente
- ✅ Transacción ACID

**Respuesta (201 Created):**
```json
{
  "id": 1,
  "user_id": 1,
  "order_number": "ORD-001234",
  "status": "pending",
  "total": "74.50",
  "tax": "10.50",
  "shipping": "5.00",
  "items": [
    {
      "id": 1,
      "order_id": 1,
      "product_id": 1,
      "quantity": 2,
      "unit_price": "29.99",
      "subtotal": "59.98"
    }
  ]
}
```

#### Actualización masiva de estado
```http
POST /api/orders/bulk-update-status
Content-Type: application/json

{
  "updates": [
    {"order_id": 1, "status": "shipped"},
    {"order_id": 2, "status": "confirmed"},
    {"order_id": 3, "status": "delivered"}
  ]
}
```

#### Actualizar orden
```http
PATCH /api/orders/{id}
Content-Type: application/json

{
  "status": "shipped",
  "shipping_address": "Nueva dirección"
}
```

#### Eliminar orden (Restaura stock)
```http
DELETE /api/orders/{id}
```

---

### 4. ITEMS DE ÓRDENES (`/api/order-items`)

#### Listar items
```http
GET /api/order-items?order_id=1&product_id=3&per_page=15
```

#### Crear item
```http
POST /api/order-items
Content-Type: application/json

{
  "order_id": 1,
  "product_id": 2,
  "quantity": 3,
  "unit_price": 29.99,
  "subtotal": 89.97
}
```

#### Actualizar item
```http
PATCH /api/order-items/{id}
```

#### Eliminar item
```http
DELETE /api/order-items/{id}
```

---

## Códigos HTTP

- `200`: OK - Petición exitosa
- `201`: Created - Recurso creado
- `204`: No Content - Éxito sin contenido
- `400`: Bad Request - Datos inválidos
- `404`: Not Found - Recurso no encontrado
- `422`: Unprocessable Entity - Error de validación
- `500`: Internal Server Error

---

## Características Implementadas

### ✅ CRUD Completo
- Create (POST)
- Read (GET)
- Update (PATCH)
- Delete (DELETE)

### ✅ Búsqueda y Filtros Complejos
- Búsqueda multi-campo
- Filtros por rango de precios
- Filtros por estado/categoría
- Filtros por fecha
- Ordenamiento personalizado

### ✅ Gestión de Transacciones
- Transacciones ACID en órdenes
- Descuento automático de stock
- Restauración de stock en cancelación
- Validación de disponibilidad

### ✅ Operaciones Masivas
- Actualización masiva de stock
- Actualización masiva de estado
- Soporte transaccional

### ✅ Paginación
- Por defecto 15 items
- Personalizable con `per_page`
- Navegable con `page`

### ✅ Validación
- Validación de datos de entrada
- Validación de relaciones
- Mensajes de error descriptivos

---

## Ejemplos de Uso

### Flujo Completo: Crear Orden

1. **Consultar productos disponibles**
```bash
curl -X GET "http://localhost:8000/api/products?category_id=1&in_stock=true"
```

2. **Crear la orden**
```bash
curl -X POST "http://localhost:8000/api/orders" \
  -H "Content-Type: application/json" \
  -d '{
    "user_id": 1,
    "order_number": "ORD-001234",
    "items": [
      {"product_id": 1, "quantity": 2}
    ],
    "tax": 10.50,
    "shipping": 5.00
  }'
```

3. **Actualizar estado**
```bash
curl -X PATCH "http://localhost:8000/api/orders/1" \
  -H "Content-Type: application/json" \
  -d '{"status": "shipped"}'
```

---

## Estándares Implementados

- ✅ REST API principles
- ✅ JSON response format
- ✅ Proper HTTP status codes
- ✅ Resource-based routing
- ✅ Pagination support
- ✅ Input validation
- ✅ Transaction management
- ✅ Error handling

---

## Base de Datos

### Tablas Creadas

1. **categories** - Categorías de productos
2. **products** - Catálogo de productos
3. **orders** - Órdenes de clientes
4. **order_items** - Detalles de órdenes
5. **users** - Información de usuarios

### Relaciones

- Category (1) → Products (M)
- Product (1) → OrderItems (M)
- Order (1) → OrderItems (M)
- User (1) → Orders (M)

---

## Datos de Prueba

Se incluyen seeders con datos iniciales:
- 4 categorías
- 9 productos
- 3 órdenes de ejemplo

Ejecutar seeders:
```bash
php artisan db:seed
```

---

## Requisitos

- PHP 8.1+
- Laravel 10+
- MySQL 5.7+
- Composer

---

Última actualización: 2026-07-13
