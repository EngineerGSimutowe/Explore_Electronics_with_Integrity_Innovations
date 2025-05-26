<?php
require_once 'db_connect.php';

// Fetch products from database
$products = $pdo->query("SELECT * FROM products")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Buy - Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/buy.css">
  <style>
    .profile-dropdown {
      position: relative;
      display: inline-block;
    }
    .profile-btn {
      background: none;
      border: none;
      color: white;
      font-size: 1.5rem;
      cursor: pointer;
    }
    .dropdown-content {
      display: none;
      position: absolute;
      right: 0;
      background-color: #f9f9f9;
      min-width: 160px;
      box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
      z-index: 1;
      border-radius: 4px;
    }
    .dropdown-content a {
      color: black;
      padding: 12px 16px;
      text-decoration: none;
      display: block;
    }
    .dropdown-content a:hover {
      background-color: #f1f1f1;
    }
    .profile-dropdown:hover .dropdown-content {
      display: block;
    }
    .payment-buttons {
      display: flex;
      gap: 10px;
      margin-top: 15px;
    }
    .payment-buttons button {
      padding: 10px 15px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }
    #save-cart-btn {
      background-color: #4CAF50;
      color: white;
    }
    #checkout-btn {
      background-color: #2196F3;
      color: white;
    }
  </style>
</head>
<body class="page-transition">
  <header class="header">
    <a href="index.html" class="logo">
        <img src="IntegrityLogo.png" alt="Integrity Logo">
        <span>Integrity Innovations</span>
    </a>
    <nav class="nav">
        <a href="index.html">Home</a>
        <a href="about.html">About</a>
        <a href="explore.html">Explore</a>
        <a href="buy.php">Buy</a>
        <a href="contact.html">Contact</a>
        <div class="profile-dropdown">
          <button class="profile-btn"><i class="fas fa-user-circle"></i></button>
          <div class="dropdown-content">
            <a href="edit-buy.php"><i class="fas fa-edit"></i> Edit Mode</a>
          </div>
        </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <button id="toggle-cart" class="toggle-cart">🛒 Cart</button>
  <div class="store-container">
    <div id="product-list" class="product-list">
      <?php foreach ($products as $product): ?>
      <div class="product-card">
        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
        <p>ZMW <?php echo number_format($product['price'], 2); ?></p>
        <button onclick="addToCart(<?php echo $product['id']; ?>, '<?php echo htmlspecialchars($product['name']); ?>', <?php echo $product['price']; ?>, '<?php echo htmlspecialchars($product['image_path']); ?>')">Add to Cart</button>
      </div>
      <?php endforeach; ?>
    </div>
    <div id="cart" class="cart">
      <div class="close-cart" onclick="closeCart()">×</div>
      <h2>🛒 Cart Items</h2>
      <ul id="cart-items"></ul>
      <div class="summary">
        <h3>Summary:</h3>
        <p>Subtotal: ZMW <span id="subtotal">0.00</span></p>
        <p>Delivery: ZMW <span id="delivery">0.00</span></p>
        <p class="discount">Discount: ZMW <span id="discount">0.00</span></p>
        <p><strong>Estimated Total:</strong><strong> ZMW <span id="total">0.00</span></strong></p>
      </div>
      <div class="payment">
        <p>Pay with:</p>
        <img src="images/airtel.png" alt="Airtel Money" width="60" />
        <img src="images/visa.png" alt="VISA" width="60" />
        <div class="payment-buttons">
          <button id="save-cart-btn">Save Cart</button>
          <button id="checkout-btn">Checkout</button>
        </div>
      </div>
    </div>
  </div>

  <script>
    let cart = JSON.parse(localStorage.getItem("cart")) || [];

    document.addEventListener('DOMContentLoaded', () => {
        // Apply fade-in on load
        document.body.classList.add('page-transition');
    
        // Select all nav links
        const navLinks = document.querySelectorAll('.nav a');
    
        navLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
    
                // If it's an internal link
                if (href && href.endsWith('.html')) {
                    e.preventDefault();
                    document.body.classList.add('fade-out');
    
                    // Wait for transition to complete before navigating
                    setTimeout(() => {
                        window.location.href = href;
                    }, 500); // must match the CSS transition duration
                }
            });
        });

        // Initialize cart
        renderCart();
    });
    
    document.addEventListener('DOMContentLoaded', () => {
        const menuToggle = document.getElementById('menu-toggle');
        const navMenu = document.querySelector('.nav');
        
        menuToggle.addEventListener('click', () => {
            navMenu.classList.toggle('active');
            menuToggle.textContent = navMenu.classList.contains('active') ? '✕' : '☰';
        });
        
        // Close menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!menuToggle.contains(e.target) && !navMenu.contains(e.target)) {
                navMenu.classList.remove('active');
                menuToggle.textContent = '☰';
            }
        });
    });

    // Cart functions
    function addToCart(id, name, price, image) {
        const item = cart.find(i => i.id === id);
        if (item) {
            item.quantity++;
        } else {
            cart.push({ id, name, price, image, quantity: 1 });
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

    function renderCart() {
        const cartItemsContainer = document.getElementById('cart-items');
        const subtotalEl = document.getElementById('subtotal');
        const deliveryEl = document.getElementById('delivery');
        const discountEl = document.getElementById('discount');
        const totalEl = document.getElementById('total');
        const toggleCartBtn = document.getElementById('toggle-cart');
        const cartDiv = document.getElementById('cart');

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
        
        // Update cart indicator
        toggleCartBtn.textContent = cart.length > 0 ? `🛒 ${cart.length} Items` : '🛒 Cart';
    }

    function closeCart() {
        document.getElementById('cart').style.display = "none";
        document.body.classList.remove("modal-open");
    }

    // Save cart to database
    document.getElementById('save-cart-btn').addEventListener('click', async () => {
        try {
            const response = await fetch('manage_content.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=save_cart&cart_data=${encodeURIComponent(JSON.stringify(cart))}`
            });
            const result = await response.text();
            if (result === 'success') {
                alert('Cart saved successfully!');
            } else {
                alert('Error saving cart');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error saving cart');
        }
    });

    // Checkout button (placeholder)
    document.getElementById('checkout-btn').addEventListener('click', () => {
        alert('Checkout functionality will be implemented in the future');
    });

    // Toggle cart visibility
    document.getElementById('toggle-cart').addEventListener('click', () => {
        const visible = document.getElementById('cart').style.display === "block";
        document.getElementById('cart').style.display = visible ? "none" : "block";
        document.body.classList.toggle("modal-open", !visible);
    });

    window.addEventListener("resize", () => {
        if (window.innerWidth >= 768) document.getElementById('cart').style.display = "block";
    });
  </script>
<footer>
  <div class="footer-content">
    <p>&copy; 2025 Integrity Innovations. All rights reserved.</p>
    <div class="social-icons">
      <a href="https://web.facebook.com/gsintegrityelectronics" target="_blank" aria-label="Facebook">
        <img src="images/facebook.png" alt="Facebook" class="social-icon" />
      </a>
      <a href="https://www.instagram.com/gs_integrity_electronics/" target="_blank" aria-label="Instagram">
        <img src="images/instagram.png" alt="Instagram" class="social-icon" />
      </a>
    </div>
  </div>
</footer>
</body>
</html>