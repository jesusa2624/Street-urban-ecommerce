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
