# APIs REST - Street Urban Ecommerce

## 📖 ¿Qué se hizo?

Se desarrolló un conjunto completo de **APIs REST** para gestionar un ecommerce urbano con búsqueda avanzada y filtros.

---

## 🚀 Cómo ejecutar

```bash
# 1. Instalar dependencias
composer install

# 2. Configurar base de datos
php artisan migrate
php artisan db:seed

# 3. Iniciar servidor
php artisan serve
```

Abre: `http://127.0.0.1:8000`

---

## 🌐 URLs de las APIs

| API | URL |
|-----|-----|
| Categorías | `/api/categories` |
| Productos | `/api/products` |
| Órdenes | `/api/orders` |
| Items | `/api/order-items` |

---

## 📝 Ejemplos rápidos

**Ver todas las categorías:**
```
http://127.0.0.1:8000/api/categories
```

**Ver todos los productos:**
```
http://127.0.0.1:8000/api/products
```

**Buscar camisetas:**
```
http://127.0.0.1:8000/api/products?search=camiseta
```

**Filtrar por precio (20-100):**
```
http://127.0.0.1:8000/api/products?min_price=20&max_price=100
```

**Ver órdenes pendientes:**
```
http://127.0.0.1:8000/api/orders?status=pending
```

---

## ✨ Características

✅ **CRUD completo** - Crear, leer, actualizar, eliminar  
✅ **Búsqueda multi-campo** - Buscar en varios atributos  
✅ **Filtros avanzados** - Por precio, categoría, estado, fecha  
✅ **Paginación** - 15 items por página  
✅ **Transacciones** - Integridad de datos en órdenes  
✅ **Validación** - Datos correctos y seguros  

---

## 📊 Base de datos

- **categories** - Categorías de productos
- **products** - Catálogo (9 productos de prueba)
- **orders** - Órdenes (3 ejemplos)
- **order_items** - Detalles de órdenes
- **users** - Usuarios

---

## 🔧 Crear datos con Postman

**Descargar:** https://www.postman.com/downloads/

**Crear producto:**
- Método: `POST`
- URL: `http://127.0.0.1:8000/api/products`
- Body (JSON):
```json
{
  "name": "Camiseta Nueva",
  "sku": "CAMISETA-001",
  "price": 39.99,
  "cost": 15.00,
  "stock": 50,
  "category_id": 1,
  "active": true
}
```

**Crear orden:**
- Método: `POST`
- URL: `http://127.0.0.1:8000/api/orders`
- Body (JSON):
```json
{
  "user_id": 1,
  "order_number": "ORD-001",
  "items": [{"product_id": 1, "quantity": 2}],
  "tax": 5,
  "shipping": 3
}
```

---

## 📁 Archivos importantes

```
app/Http/Controllers/Api/      ← Controladores de APIs
app/Models/                      ← Modelos de datos
database/migrations/             ← Estructura de BD
database/seeders/                ← Datos iniciales
routes/api.php                   ← Rutas de APIs
```

---

## ✅ Códigos HTTP

- `200` - OK
- `201` - Creado
- `204` - Sin contenido
- `400` - Error en datos
- `404` - No encontrado

---

**Estado:** ✅ Completo  
**Tecnología:** Laravel + MySQL  
**Funcional:** Sí
