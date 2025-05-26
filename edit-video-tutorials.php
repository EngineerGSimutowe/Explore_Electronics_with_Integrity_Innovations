<?php
require_once 'db_connect.php';

// Fetch video tutorials from database
$stmt = $pdo->query("SELECT * FROM video_tutorials");
$videos = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Video Tutorials - Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/videos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
    .video-card {
      position: relative;
    }
    .video-actions {
      position: absolute;
      top: 10px;
      right: 10px;
      display: none;
      z-index: 100;
    }
    .video-card:hover .video-actions {
      display: flex;
      gap: 5px;
    }
    .video-actions button {
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
    .video-embed {
      position: relative;
      width: 100%;
      padding-top: 56.25%;
      border-radius: 8px;
      overflow: hidden;
      margin-bottom: 10px;
      z-index: 1;
    }
    .video-embed iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
      z-index: 1;
    }
  </style>
</head>
<body class="page-transition">
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
          <a href="#" id="addContentBtn"><i class="fas fa-plus"></i> Add Video</a>
          <a href="video-tutorials.php"><i class="fas fa-eye"></i> View Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <main class="video-tutorials-wrapper">
    <div class="container">
      <h1>Edit Video Tutorials</h1>

      <div class="search-container">
        <input type="text" id="youtubeSearchInput" placeholder="Search YouTube videos..." />
        <button id="youtubeSearchBtn">Search</button>
      </div>

      <div class="video-grid">
        <?php foreach ($videos as $video): ?>
        <div class="video-card">
          <div class="video-actions">
            <button class="edit-btn" data-id="<?php echo $video['id']; ?>" 
                    data-url="<?php echo htmlspecialchars($video['embed_url']); ?>" 
                    data-title="<?php echo htmlspecialchars($video['title']); ?>" 
                    data-description="<?php echo htmlspecialchars($video['description']); ?>">
              Edit
            </button>
            <button class="remove-btn" data-id="<?php echo $video['id']; ?>">Remove</button>
          </div>
          <div class="video-embed">
            <iframe src="<?php echo htmlspecialchars($video['embed_url']); ?>" allowfullscreen></iframe>
          </div>
          <h2><?php echo htmlspecialchars($video['title']); ?></h2>
          <p><?php echo htmlspecialchars($video['description']); ?></p>
        </div>
        <?php endforeach; ?>
      </div>

      <div class="youtube-results" id="youtubeResults"></div>
    </div>
  </main>

  <!-- Modal for editing -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Edit Video</h2>
      <form id="editForm">
        <input type="hidden" id="editId">
        <div class="form-group">
          <label for="editUrl">Embedded Video URL:</label>
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
      <h2>Add New Video</h2>
      <form id="addForm">
        <div class="form-group">
          <label for="addUrl">Embedded Video URL:</label>
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
    // Fade transition on navigation
    document.addEventListener('DOMContentLoaded', () => {
      document.body.classList.add('page-transition');

      const navLinks = document.querySelectorAll('.nav a');
      navLinks.forEach(link => {
        link.addEventListener('click', function (e) {
          const href = this.getAttribute('href');
          if (href && href.endsWith('.html')) {
            e.preventDefault();
            document.body.classList.add('fade-out');
            setTimeout(() => {
              window.location.href = href;
            }, 500);
          }
        });
      });

      // YouTube Search (Live)
      document.getElementById('youtubeSearchBtn').addEventListener('click', () => {
        const query = document.getElementById('youtubeSearchInput').value.trim();
        if (query) {
          window.open(`https://www.youtube.com/results?search_query=${encodeURIComponent(query)}`, '_blank');
        }
      });

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

      // Remove video
      removeBtns.forEach(btn => {
        btn.addEventListener('click', async (e) => {
          e.stopPropagation();
          const id = btn.dataset.id;
          if (confirm('Are you sure you want to remove this video?')) {
            try {
              const response = await fetch('manage_content.php', {
                method: 'POST',
                headers: {
                  'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `action=remove_video&id=${id}`
              });
              const result = await response.text();
              if (result === 'success') {
                btn.closest('.video-card').remove();
              } else {
                alert('Error removing video');
              }
            } catch (error) {
              console.error('Error:', error);
              alert('Error removing video');
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
            body: `action=update_video&id=${id}&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
          });
          const result = await response.text();
          if (result === 'success') {
            location.reload();
          } else {
            alert('Error updating video');
          }
        } catch (error) {
          console.error('Error:', error);
          alert('Error updating video');
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
            body: `action=add_video&url=${encodeURIComponent(url)}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}`
          });
          const result = await response.text();
          if (result === 'success') {
            location.reload();
          } else {
            alert('Error adding video');
          }
        } catch (error) {
          console.error('Error:', error);
          alert('Error adding video');
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