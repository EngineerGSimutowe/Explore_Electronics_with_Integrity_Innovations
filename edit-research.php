<?php
require_once 'db_connect.php';

// Fetch research categories and papers from database
$categories = $pdo->query("SELECT * FROM research_categories")->fetchAll(PDO::FETCH_ASSOC);
$papers = $pdo->query("SELECT * FROM research_papers")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Research | Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/research.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <style>
    .card {
      position: relative;
    }
    .card-actions {
      position: absolute;
      top: 10px;
      right: 10px;
      display: none;
      gap: 5px;
    }
    .card:hover .card-actions {
      display: flex;
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
    .tab-buttons {
      display: flex;
      margin-bottom: 20px;
      border-bottom: 1px solid #ddd;
    }
    .tab-button {
      padding: 10px 20px;
      background: none;
      border: none;
      cursor: pointer;
      font-size: 16px;
    }
    .tab-button.active {
      border-bottom: 3px solid #0055aa;
      font-weight: bold;
    }
    .tab-content {
      display: none;
    }
    .tab-content.active {
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
          <a href="research.php"><i class="fas fa-eye"></i> View Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <section class="hero">
    <div class="container">
      <h2>Edit Research Hub</h2>
      <p>Manage research content for Electrical and Electronics Engineering</p>
    </div>
  </section>

  <div class="container">
    <div class="tab-buttons">
      <button class="tab-button active" data-tab="categories">Categories</button>
      <button class="tab-button" data-tab="papers">Research Papers</button>
    </div>

    <div id="categories" class="tab-content active">
      <section class="card-grid">
        <h3>Research Categories</h3>
        <?php foreach ($categories as $category): ?>
        <div class="card">
          <div class="card-actions">
            <button class="edit-btn" 
                    data-id="<?php echo $category['id']; ?>"
                    data-title="<?php echo htmlspecialchars($category['title']); ?>"
                    data-description="<?php echo htmlspecialchars($category['description']); ?>">
              Edit
            </button>
            <button class="remove-btn" data-id="<?php echo $category['id']; ?>" data-type="category">Remove</button>
          </div>
          <h4><?php echo htmlspecialchars($category['title']); ?></h4>
          <p><?php echo htmlspecialchars($category['description']); ?></p>
        </div>
        <?php endforeach; ?>
      </section>
    </div>

    <div id="papers" class="tab-content">
      <section class="card-grid">
        <h3>Featured Research Papers</h3>
        <?php foreach ($papers as $paper): ?>
        <div class="card">
          <div class="card-actions">
            <button class="edit-btn" 
                    data-id="<?php echo $paper['id']; ?>"
                    data-title="<?php echo htmlspecialchars($paper['title']); ?>"
                    data-publication="<?php echo htmlspecialchars($paper['publication_info']); ?>"
                    data-abstract="<?php echo htmlspecialchars($paper['abstract']); ?>"
                    data-link="<?php echo htmlspecialchars($paper['link']); ?>">
              Edit
            </button>
            <button class="remove-btn" data-id="<?php echo $paper['id']; ?>" data-type="paper">Remove</button>
          </div>
          <h4><?php echo htmlspecialchars($paper['title']); ?></h4>
          <p><?php echo htmlspecialchars($paper['publication_info']); ?></p>
          <button>View More</button>
        </div>
        <?php endforeach; ?>
      </section>
    </div>
  </div>

  <!-- Modal for editing -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 id="editModalTitle">Edit Content</h2>
      <form id="editForm">
        <input type="hidden" id="editId">
        <input type="hidden" id="editType">
        <div class="form-group">
          <label for="editTitle">Title:</label>
          <input type="text" id="editTitle" required>
        </div>
        <div class="form-group" id="editPublicationGroup">
          <label for="editPublication">Publication Info:</label>
          <input type="text" id="editPublication">
        </div>
        <div class="form-group">
          <label for="editDescription">Description/Abstract:</label>
          <textarea id="editDescription" required></textarea>
        </div>
        <div class="form-group" id="editLinkGroup">
          <label for="editLink">Link:</label>
          <input type="text" id="editLink">
        </div>
        <button type="submit">Update</button>
      </form>
    </div>
  </div>

  <!-- Modal for adding -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 id="addModalTitle">Add New Content</h2>
      <form id="addForm">
        <input type="hidden" id="addType">
        <div class="form-group">
          <label for="addTitle">Title:</label>
          <input type="text" id="addTitle" required>
        </div>
        <div class="form-group" id="addPublicationGroup">
          <label for="addPublication">Publication Info:</label>
          <input type="text" id="addPublication">
        </div>
        <div class="form-group">
          <label for="addDescription">Description/Abstract:</label>
          <textarea id="addDescription" required></textarea>
        </div>
        <div class="form-group" id="addLinkGroup">
          <label for="addLink">Link:</label>
          <input type="text" id="addLink">
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

    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.addEventListener('click', () => {
            // Remove active class from all buttons and content
            tabButtons.forEach(btn => btn.classList.remove('active'));
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.remove('active');
            });
            
            // Add active class to clicked button and corresponding content
            button.classList.add('active');
            const tabId = button.getAttribute('data-tab');
            document.getElementById(tabId).classList.add('active');
        });
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
            const type = btn.closest('.tab-content').id === 'categories' ? 'category' : 'paper';
            
            document.getElementById('editId').value = btn.dataset.id;
            document.getElementById('editType').value = type;
            document.getElementById('editTitle').value = btn.dataset.title;
            
            if (type === 'category') {
                document.getElementById('editModalTitle').textContent = 'Edit Research Category';
                document.getElementById('editDescription').value = btn.dataset.description;
                document.getElementById('editPublicationGroup').style.display = 'none';
                document.getElementById('editLinkGroup').style.display = 'none';
            } else {
                document.getElementById('editModalTitle').textContent = 'Edit Research Paper';
                document.getElementById('editDescription').value = btn.dataset.abstract;
                document.getElementById('editPublication').value = btn.dataset.publication;
                document.getElementById('editLink').value = btn.dataset.link;
                document.getElementById('editPublicationGroup').style.display = 'block';
                document.getElementById('editLinkGroup').style.display = 'block';
            }
            
            editModal.style.display = 'block';
        });
    });

    // Open add modal
    addContentBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const activeTab = document.querySelector('.tab-button.active').getAttribute('data-tab');
        const type = activeTab === 'categories' ? 'category' : 'paper';
        
        document.getElementById('addType').value = type;
        
        if (type === 'category') {
            document.getElementById('addModalTitle').textContent = 'Add Research Category';
            document.getElementById('addPublicationGroup').style.display = 'none';
            document.getElementById('addLinkGroup').style.display = 'none';
        } else {
            document.getElementById('addModalTitle').textContent = 'Add Research Paper';
            document.getElementById('addPublicationGroup').style.display = 'block';
            document.getElementById('addLinkGroup').style.display = 'block';
        }
        
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
            const type = btn.dataset.type;
            
            if (confirm('Are you sure you want to remove this item?')) {
                try {
                    const response = await fetch('manage_content.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `action=remove_${type}&id=${id}`
                    });
                    const result = await response.text();
                    if (result === 'success') {
                        btn.closest('.card').remove();
                    } else {
                        alert('Error removing item');
                    }
                } catch (error) {
                    console.error('Error:', error);
                    alert('Error removing item');
                }
            }
        });
    });

    // Edit form submission
    document.getElementById('editForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const id = document.getElementById('editId').value;
        const type = document.getElementById('editType').value;
        const title = document.getElementById('editTitle').value;
        const description = document.getElementById('editDescription').value;
        
        let body = `action=update_${type}&id=${id}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`;
        
        if (type === 'paper') {
            const publication = document.getElementById('editPublication').value;
            const link = document.getElementById('editLink').value;
            body += `&publication=${encodeURIComponent(publication)}&link=${encodeURIComponent(link)}`;
        }

        try {
            const response = await fetch('manage_content.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: body
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
        const type = document.getElementById('addType').value;
        const title = document.getElementById('addTitle').value;
        const description = document.getElementById('addDescription').value;
        
        let body = `action=add_${type}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`;
        
        if (type === 'paper') {
            const publication = document.getElementById('addPublication').value;
            const link = document.getElementById('addLink').value;
            body += `&publication=${encodeURIComponent(publication)}&link=${encodeURIComponent(link)}`;
        }

        try {
            const response = await fetch('manage_content.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: body
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