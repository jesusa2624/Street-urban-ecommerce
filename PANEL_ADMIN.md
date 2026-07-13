# 🎛️ Panel Administrativo - Street Urban

## 📖 ¿Qué es?

Panel administrativo completo para gestionar el catálogo de productos del ecommerce. Incluye **CRUD completo** (Create, Read, Update, Delete).

---

## ✨ Funcionalidades

✅ **Listar productos** - Ver todos los productos con búsqueda  
✅ **Crear producto** - Agregar nuevos productos  
✅ **Editar producto** - Modificar datos existentes  
✅ **Eliminar producto** - Remover productos  

---

## 🚀 Acceso al Panel

1. **Inicia sesión** en http://127.0.0.1:8000
2. **Ve a:** http://127.0.0.1:8000/admin/dashboard
3. **Haz click en "Productos"**

---

## 📋 Cómo usar

### 1️⃣ **Ver Productos**
- URL: `/admin/products`
- Muestra tabla con todos los productos
- Incluye búsqueda por nombre o SKU

### 2️⃣ **Crear Producto**
- Click en "+ Nuevo Producto"
- Completa el formulario:
  - Nombre (requerido)
  - SKU (requerido)
  - Descripción
  - Categoría (requerido)
  - Precio (requerido)
  - Costo
  - Stock (requerido)
  - URL de imagen
  - Activo (checkbox)
- Click en "Crear Producto"

### 3️⃣ **Editar Producto**
- Haz click en "Editar" en la tabla
- Modifica los campos que necesites
- Click en "Guardar Cambios"

### 4️⃣ **Eliminar Producto**
- Haz click en "Eliminar" en la tabla
- Confirma la acción

---

## 🔧 Tecnologías

- **Frontend:** Vue.js 3 + Inertia.js
- **Backend:** Laravel
- **Estilos:** Tailwind CSS
- **API:** REST (consume nuestras APIs)

---

## 📁 Estructura

```
app/Http/Controllers/Admin/
└── ProductAdminController.php    ← Lógica del CRUD

resources/js/Pages/Admin/
├── Dashboard.vue                  ← Panel principal
└── Products/
    ├── Index.vue                  ← Listar productos
    ├── Create.vue                 ← Crear producto
    └── Edit.vue                   ← Editar producto
```

---

## 🔗 Integración con APIs

El panel **consume las APIs REST** que creamos:

- `GET /api/products` - Obtener productos
- `POST /api/products` - Crear
- `PATCH /api/products/{id}` - Actualizar
- `DELETE /api/products/{id}` - Eliminar

---

## ✅ Requisitos

- Estar autenticado
- El servidor Laravel debe estar corriendo
- Las APIs REST deben estar disponibles

---

## 📝 Datos de prueba

Ya tienes productos de prueba cargados:
- Camisetas
- Pantalones
- Accesorios
- Calzado

Puedes editarlos o crear nuevos.

---

**Estado:** ✅ Completo y funcional
