<?php
require_once 'db_connect.php';

// Fetch emerging trends from database
$stmt = $pdo->query("SELECT * FROM emerging_trends");
$trends = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Emerging Trends | Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/emerging-trends.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
    .card {
      position: relative;
    }
    .card-actions {
      position: absolute;
      top: 10px;
      right: 10px;
      display: none;
    }
    .card:hover .card-actions {
      display: flex;
      gap: 5px;
    }
    .card-actions button {
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
    .form-group input, .form-group textarea {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    .form-group textarea {
      height: 100px;
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
<body>
  <header class="header">
    <a href="index.html" class="logo">
      <img src="IntegrityLogo.png" alt="Integrity Logo" />
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
          <a href="#" id="addContentBtn"><i class="fas fa-plus"></i> Add Content</a>
          <a href="emerging-trends.php"><i class="fas fa-eye"></i> View Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <section class="hero">
    <div class="container">
      <h2>Edit Emerging Trends</h2>
      <p>Manage the content for emerging trends</p>
    </div>
  </section>

  <section class="card-grid container">
    <h3>Hot Topics in EEE (2024–2025)</h3>
    <?php foreach ($trends as $trend): ?>
    <div class="card">
      <div class="card-actions">
        <button class="edit-btn" data-id="<?php echo $trend['id']; ?>" 
                data-url="<?php echo htmlspecialchars($trend['content_url']); ?>" 
                data-title="<?php echo htmlspecialchars($trend['title']); ?>" 
                data-description="<?php echo htmlspecialchars($trend['description']); ?>">
          Edit
        </button>
        <button class="remove-btn" data-id="<?php echo $trend['id']; ?>">Remove</button>
      </div>
      <h4><?php echo htmlspecialchars($trend['title']); ?></h4>
      <p><?php echo htmlspecialchars($trend['description']); ?></p>
    </div>
    <?php endforeach; ?>
  </section>

  <section class="container">
    <h3>Resources & Reports</h3>
    <ul>
      <li><a href="https://www.weforum.org/publications/top-10-emerging-technologies-2024/">World Economic Forum – Top Tech Trends</a></li>
      <li><a href="https://innovate.ieee.org/top-tech-2024/">IEEE Emerging Technologies Special Report</a></li>
      <li><a href="https://www.gartner.com/en/articles/hype-cycle-for-emerging-technologies">Gartner Hype Cycle for Emerging Tech</a></li>
    </ul>
  </section>

  <!-- Modal for editing -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Edit Content</h2>
      <form id="editForm">
        <input type="hidden" id="editId">
        <div class="form-group">
          <label for="editUrl">Content URL:</label>
          <input type="text" id="editUrl" required>
        </div>
        <div class="form-group">
          <label for="editTitle">Title:</label>
          <input type="text" id="editTitle" required>
        </div>
        <div class="form-group">
          <label for="editDescription">Description:</label>
          <textarea id="editDescription" required></textarea>
        </div>
        <button type="submit">Update</button>
      </form>
    </div>
  </div>

  <!-- Modal for adding -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Add New Content</h2>
      <form id="addForm">
        <div class="form-group">
          <label for="addUrl">Content URL:</label>
          <input type="text" id="addUrl" required>
        </div>
        <div class="form-group">
          <label for="addTitle">Title:</label>
          <input type="text" id="addTitle" required>
        </div>
        <div class="form-group">
          <label for="addDescription">Description:</label>
          <textarea id="addDescription" required></textarea>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

<script>
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
    const addContentBtn = document.getElementById('addContentBtn');
    const closeBtns = document.querySelectorAll('.close');

    // Open edit modal
    editBtns.forEach(btn => {
      btn.addEventListener('click', (e) => {
        e.stopPropagation();
        document.getElementById('editId').value = btn.dataset.id;
        document.getElementById('editUrl').value = btn.dataset.url;
        document.getElementById('editTitle').value = btn.dataset.title;
        document.getElementById('editDescription').value = btn.dataset.description;
        editModal.style.display = 'block';
      });
    });

    // Open add modal
    addContentBtn.addEventListener('click', (e) => {
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

    // Remove content
    removeBtns.forEach(btn => {
      btn.addEventListener('click', async (e) => {
        e.stopPropagation();
        const id = btn.dataset.id;
        if (confirm('Are you sure you want to remove this content?')) {
          try {
            const response = await fetch('manage_content.php', {
              method: 'POST',
              headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
              },
              body: `action=remove_trend&id=${id}`
            });
            const result = await response.text();
            if (result === 'success') {
              btn.closest('.card').remove();
            } else {
              alert('Error removing content');
            }
          } catch (error) {
            console.error('Error:', error);
            alert('Error removing content');
          }
        }
      });
    });

    // Edit form submission
    document.getElementById('editForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const id = document.getElementById('editId').value;
      const url = document.getElementById('editUrl').value;
      const title = document.getElementById('editTitle').value;
      const description = document.getElementById('editDescription').value;

      try {
        const response = await fetch('manage_content.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `action=update_trend&id=${id}&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
        });
        const result = await response.text();
        if (result === 'success') {
          location.reload();
        } else {
          alert('Error updating content');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error updating content');
      }
    });

    // Add form submission
    document.getElementById('addForm').addEventListener('submit', async (e) => {
      e.preventDefault();
      const url = document.getElementById('addUrl').value;
      const title = document.getElementById('addTitle').value;
      const description = document.getElementById('addDescription').value;

      try {
        const response = await fetch('manage_content.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
          },
          body: `action=add_trend&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
        });
        const result = await response.text();
        if (result === 'success') {
          location.reload();
        } else {
          alert('Error adding content');
        }
      } catch (error) {
        console.error('Error:', error);
        alert('Error adding content');
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