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
  <title>Edit Products - Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/buy.css">
  <style>
    .product-card {
      position: relative;
    }
    .product-actions {
      position: absolute;
      top: 10px;
      right: 10px;
      display: none;
      gap: 5px;
    }
    .product-card:hover .product-actions {
      display: flex;
    }
    .product-actions button {
      padding: 5px 10px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
    .edit-btn {
      background-color: #4CAF50;
      color: white;
    }
    .remove-btn {
      background-color: #f44336;
      color: white;
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1000;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 80%;
      max-width: 500px;
      border-radius: 8px;
    }
    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }
    .form-group {
      margin-bottom: 15px;
    }
    .form-group label {
      display: block;
      margin-bottom: 5px;
    }
    .form-group input {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    #addForm button, #editForm button {
      background-color: #0055aa;
      color: white;
      padding: 10px 15px;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }
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
            <a href="#" id="addProductBtn"><i class="fas fa-plus"></i> Add Product</a>
            <a href="buy.php"><i class="fas fa-eye"></i> View Mode</a>
          </div>
        </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <div class="store-container">
    <div id="product-list" class="product-list">
      <?php foreach ($products as $product): ?>
      <div class="product-card">
        <div class="product-actions">
          <button class="edit-btn" 
                  data-id="<?php echo $product['id']; ?>"
                  data-name="<?php echo htmlspecialchars($product['name']); ?>"
                  data-price="<?php echo $product['price']; ?>"
                  data-image="<?php echo htmlspecialchars($product['image_path']); ?>">
            Edit
          </button>
          <button class="remove-btn" data-id="<?php echo $product['id']; ?>">Remove</button>
        </div>
        <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" />
        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
        <p>ZMW <?php echo number_format($product['price'], 2); ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Modal for editing -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Edit Product</h2>
      <form id="editForm">
        <input type="hidden" id="editId">
        <div class="form-group">
          <label for="editName">Product Name:</label>
          <input type="text" id="editName" required>
        </div>
        <div class="form-group">
          <label for="editPrice">Price (ZMW):</label>
          <input type="number" id="editPrice" step="0.01" required>
        </div>
        <div class="form-group">
          <label for="editImage">Image Path:</label>
          <input type="text" id="editImage" required>
        </div>
        <button type="submit">Update</button>
      </form>
    </div>
  </div>

  <!-- Modal for adding -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Add New Product</h2>
      <form id="addForm">
        <div class="form-group">
          <label for="addName">Product Name:</label>
          <input type="text" id="addName" required>
        </div>
        <div class="form-group">
          <label for="addPrice">Price (ZMW):</label>
          <input type="number" id="addPrice" step="0.01" required>
        </div>
        <div class="form-group">
          <label for="addImage">Image Path:</label>
          <input type="text" id="addImage" required>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

  <script>
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

        // Modal functionality
        const editModal = document.getElementById('editModal');
        const addModal = document.getElementById('addModal');
        const editBtns = document.querySelectorAll('.edit-btn');
        const removeBtns = document.querySelectorAll('.remove-btn');
        const addProductBtn = document.getElementById('addProductBtn');
        const closeBtns = document.querySelectorAll('.close');

        // Open edit modal
        editBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                document.getElementById('editId').value = btn.dataset.id;
                document.getElementById('editName').value = btn.dataset.name;
                document.getElementById('editPrice').value = btn.dataset.price;
                document.getElementById('editImage').value = btn.dataset.image;
                editModal.style.display = 'block';
            });
        });

        // Open add modal
        addProductBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addModal.style.display = 'block';
        });

        // Close modals
        closeBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                editModal.style.display = 'none';
                addModal.style.display = 'none';
            });
        });

        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === editModal) {
                editModal.style.display = 'none';
            }
            if (e.target === addModal) {
                addModal.style.display = 'none';
            }
        });

        // Remove product
        removeBtns.forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                if (confirm('Are you sure you want to remove this product?')) {
                    try {
                        const response = await fetch('manage_content.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=remove_product&id=${id}`
                        });
                        const result = await response.text();
                        if (result === 'success') {
                            btn.closest('.product-card').remove();
                        } else {
                            alert('Error removing product');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error removing product');
                    }
                }
            });
        });

        // Edit form submission
        document.getElementById('editForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const name = document.getElementById('editName').value;
            const price = document.getElementById('editPrice').value;
            const image = document.getElementById('editImage').value;

            try {
                const response = await fetch('manage_content.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_product&id=${id}&name=${encodeURIComponent(name)}&price=${price}&image=${encodeURIComponent(image)}`
                });
                const result = await response.text();
                if (result === 'success') {
                    location.reload();
                } else {
                    alert('Error updating product');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error updating product');
            }
        });

        // Add form submission
        document.getElementById('addForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const name = document.getElementById('addName').value;
            const price = document.getElementById('addPrice').value;
            const image = document.getElementById('addImage').value;

            try {
                const response = await fetch('manage_content.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=add_product&name=${encodeURIComponent(name)}&price=${price}&image=${encodeURIComponent(image)}`
                });
                const result = await response.text();
                if (result === 'success') {
                    location.reload();
                } else {
                    alert('Error adding product');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error adding product');
            }
        });
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