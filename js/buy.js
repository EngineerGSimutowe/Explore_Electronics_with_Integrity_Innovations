const products = [
  { id: 1, name: "Arduino UNO", price: 120, image: "images/ArduinoUNO.png" },
  { id: 2, name: "Buck Converter", price: 40, image: "images/BuckConverter.png" },
  { id: 3, name: "Ultrasonic Sensor", price: 50, image: "images/UltrasonicSensor.png" },
  { id: 4, name: "4 Channel Relay", price: 60, image: "images/4ChannelRelay.png" },
  { id: 5, name: "ESP8266", price: 90, image: "images/ESP8266.png" },
  { id: 6, name: "MQ3 Sensor", price: 35, image: "images/MQ3Sensor.png" },
  { id: 7, name: "PIR Sensor", price: 45, image: "images/PIRSensor.png" },
  { id: 8, name: "9V Power Supply", price: 25, image: "images/9VPowerSupply.png" },
];

let cart = JSON.parse(localStorage.getItem("cart")) || [];

const productList = document.getElementById("product-list");
const cartItemsContainer = document.getElementById("cart-items");
const subtotalEl = document.getElementById("subtotal");
const deliveryEl = document.getElementById("delivery");
const discountEl = document.getElementById("discount");
const totalEl = document.getElementById("total");
const toggleCartBtn = document.getElementById("toggle-cart");
const cartDiv = document.getElementById("cart");

function renderProducts() {
  productList.innerHTML = products.map(p => `
    <div class="product-card">
      <img src="${p.image}" alt="${p.name}" />
      <h4>${p.name}</h4>
      <p>ZMW ${p.price.toFixed(2)}</p>
      <button onclick="addToCart(${p.id})">Add to Cart</button>
    </div>
  `).join('');
}

function renderCart() {
  cartItemsContainer.innerHTML = cart.map(item => `
    <li class="cart-item">
      <img src="${item.image}" alt="${item.name}" />
      <span>${item.name}</span>
      <div class="quantity-controls">
        <button onclick="changeQty(${item.id}, -1)">-</button>
        <span>${item.quantity}</span>
        <button onclick="changeQty(${item.id}, 1)">+</button>
      </div>
      <span>ZMW ${(item.price * item.quantity).toFixed(2)}</span>
      <button class="remove-btn" onclick="removeItem(${item.id})">Remove</button>
    </li>
  `).join('');

  const subtotal = cart.reduce((sum, i) => sum + i.price * i.quantity, 0);
  const delivery = subtotal > 0 ? 20 : 0;
  const discount = subtotal > 200 ? 25 : 0;
  const total = subtotal + delivery - discount;

  subtotalEl.textContent = subtotal.toFixed(2);
  deliveryEl.textContent = delivery.toFixed(2);
  discountEl.textContent = discount.toFixed(2);
  totalEl.textContent = total.toFixed(2);

  localStorage.setItem("cart", JSON.stringify(cart));
}

function addToCart(id) {
  const item = cart.find(i => i.id === id);
  if (item) {
    item.quantity++;
  } else {
    const product = products.find(p => p.id === id);
    cart.push({ ...product, quantity: 1 });
  }
  renderCart();
}

function changeQty(id, delta) {
  const item = cart.find(i => i.id === id);
  if (!item) return;
  item.quantity += delta;
  if (item.quantity <= 0) cart = cart.filter(i => i.id !== id);
  renderCart();
}

function removeItem(id) {
  cart = cart.filter(i => i.id !== id);
  renderCart();
}

function closeCart() {
  cartDiv.style.display = "none";
  document.body.classList.remove("modal-open");
}

toggleCartBtn.addEventListener("click", () => {
  const visible = cartDiv.style.display === "block";
  cartDiv.style.display = visible ? "none" : "block";
  document.body.classList.toggle("modal-open", !visible);
});

window.addEventListener("resize", () => {
  if (window.innerWidth >= 768) cartDiv.style.display = "block";
});

renderProducts();
renderCart();
