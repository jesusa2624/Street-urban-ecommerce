const CART_KEY = 'shopping_cart';

window.dispatchEvent(new Event('cart-updated'));

export function getItems() {
  return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
}

export function saveItems(items) {
  localStorage.setItem(CART_KEY, JSON.stringify(items));
}

// Cada línea del carrito se identifica por producto + color + talla, no solo por el
// producto: dos colores (o dos tallas) del mismo modelo pueden tener precio y stock
// distintos, así que no pueden mezclarse en una sola línea.
export function add(product) {
  const items = getItems();
  const productId = product.productId ?? product.id;
  const lineId = (product.colorNombre || product.talla)
    ? `${productId}::${product.colorNombre || 'x'}::${product.talla || 'x'}`
    : `${productId}`;

  const existing = items.find(item => item.id === lineId);

  if (existing) {
    existing.cantidad += product.cantidad || 1;
  } else {
    items.push({
      id: lineId,
      productId,
      name: product.name,
      price: product.price,
      image: product.image,
      colorId: product.colorId || null,
      colorNombre: product.colorNombre || null,
      talla: product.talla || null,
      cantidad: product.cantidad || 1
    });
  }

  saveItems(items);
  window.dispatchEvent(new Event('cart-updated'));
}

export function totalItems() {
  return getItems().reduce((total, item) => total + item.cantidad, 0);
}

export function updateQuantity(productId, delta) {
  const items = getItems();
  const item = items.find(i => i.id === productId);

  if (item) {
    item.cantidad += delta;
    // Si la cantidad llega a 0 o menos, eliminamos el producto
    if (item.cantidad <= 0) {
      const filtered = items.filter(i => i.id !== productId);
      saveItems(filtered);
    } else {
      saveItems(items);
    }
    window.dispatchEvent(new Event('cart-updated'));
  }
}

export function setQuantity(lineId, cantidad) {
  const items = getItems();
  const item = items.find(i => i.id === lineId);

  if (item) {
    item.cantidad = cantidad;
    saveItems(items);
    window.dispatchEvent(new Event('cart-updated'));
  }
}

export function removeItem(lineId) {
  saveItems(getItems().filter(i => i.id !== lineId));
  window.dispatchEvent(new Event('cart-updated'));
}

