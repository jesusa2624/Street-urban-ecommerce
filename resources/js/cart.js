const CART_KEY = 'shopping_cart';

window.dispatchEvent(new Event('cart-updated'));

export function getItems() {
  return JSON.parse(localStorage.getItem(CART_KEY) || '[]');
}

export function saveItems(items) {
  localStorage.setItem(CART_KEY, JSON.stringify(items));
}

export function add(product) {
  const items = getItems();

  const existing = items.find(item => item.id === product.id);

  if (existing) {
    existing.cantidad++;
  } else {
    items.push({
      id: product.id,
      name: product.name,
      price: product.price,
      image: product.image,
      cantidad: 1
    });
  }

  saveItems(items);
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

