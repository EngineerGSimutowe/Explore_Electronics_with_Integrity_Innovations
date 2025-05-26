<?php
require_once 'db_connect.php';

// Fetch demo projects from database
$projects = $pdo->query("SELECT * FROM demo_projects")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Demo Projects - Integrity Innovations</title>
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
      gap: 5px;
    }
    .video-card:hover .video-actions {
      display: flex;
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
    }
    .video-embed iframe {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      border: none;
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
          <a href="#" id="addProjectBtn"><i class="fas fa-plus"></i> Add Project</a>
          <a href="demo-projects.php"><i class="fas fa-eye"></i> View Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <main class="video-tutorials-wrapper">
    <div class="container">
      <h1>Edit Demo Projects</h1>

      <div class="video-grid">
        <?php foreach ($projects as $project): ?>
        <div class="video-card">
          <div class="video-actions">
            <button class="edit-btn" 
                    data-id="<?php echo $project['id']; ?>"
                    data-title="<?php echo htmlspecialchars($project['title']); ?>"
                    data-description="<?php echo htmlspecialchars($project['description']); ?>"
                    data-youtube="<?php echo htmlspecialchars($project['youtube_url']); ?>"
                    data-details="<?php echo htmlspecialchars($project['details']); ?>">
              Edit
            </button>
            <button class="remove-btn" data-id="<?php echo $project['id']; ?>">Remove</button>
          </div>
          <div class="video-embed">
            <iframe src="<?php echo htmlspecialchars($project['youtube_url']); ?>" allowfullscreen></iframe>
          </div>
          <h2><?php echo htmlspecialchars($project['title']); ?></h2>
          <p><?php echo htmlspecialchars($project['description']); ?></p>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <!-- Modal for editing -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Edit Project</h2>
      <form id="editForm">
        <input type="hidden" id="editId">
        <div class="form-group">
          <label for="editTitle">Title:</label>
          <input type="text" id="editTitle" required>
        </div>
        <div class="form-group">
          <label for="editDescription">Short Description:</label>
          <textarea id="editDescription" required></textarea>
        </div>
        <div class="form-group">
          <label for="editYoutube">YouTube URL:</label>
          <input type="text" id="editYoutube" required>
        </div>
        <div class="form-group">
          <label for="editDetails">Project Details:</label>
          <textarea id="editDetails" required></textarea>
        </div>
        <button type="submit">Update</button>
      </form>
    </div>
  </div>

  <!-- Modal for adding -->
  <div id="addModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Add New Project</h2>
      <form id="addForm">
        <div class="form-group">
          <label for="addTitle">Title:</label>
          <input type="text" id="addTitle" required>
        </div>
        <div class="form-group">
          <label for="addDescription">Short Description:</label>
          <textarea id="addDescription" required></textarea>
        </div>
        <div class="form-group">
          <label for="addYoutube">YouTube URL:</label>
          <input type="text" id="addYoutube" required>
        </div>
        <div class="form-group">
          <label for="addDetails">Project Details:</label>
          <textarea id="addDetails" required></textarea>
        </div>
        <button type="submit">Submit</button>
      </form>
    </div>
  </div>

  <script>
    // Fade transition on navigation
    document.addEventListener('DOMContentLoaded', () => {
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
        const addProjectBtn = document.getElementById('addProjectBtn');
        const closeBtns = document.querySelectorAll('.close');

                // Open edit modal
        editBtns.forEach(btn => {
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                document.getElementById('editId').value = btn.dataset.id;
                document.getElementById('editTitle').value = btn.dataset.title;
                document.getElementById('editDescription').value = btn.dataset.description;
                document.getElementById('editYoutube').value = btn.dataset.youtube;
                document.getElementById('editDetails').value = btn.dataset.details;
                editModal.style.display = 'block';
            });
        });

        // Open add modal
        addProjectBtn.addEventListener('click', (e) => {
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

        // Remove project
        removeBtns.forEach(btn => {
            btn.addEventListener('click', async (e) => {
                e.stopPropagation();
                const id = btn.dataset.id;
                if (confirm('Are you sure you want to remove this project?')) {
                    try {
                        const response = await fetch('manage_content.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded',
                            },
                            body: `action=remove_project&id=${id}`
                        });
                        const result = await response.text();
                        if (result === 'success') {
                            btn.closest('.video-card').remove();
                        } else {
                            alert('Error removing project');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Error removing project');
                    }
                }
            });
        });

        // Edit form submission
        document.getElementById('editForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const id = document.getElementById('editId').value;
            const title = document.getElementById('editTitle').value;
            const description = document.getElementById('editDescription').value;
            const youtube = document.getElementById('editYoutube').value;
            const details = document.getElementById('editDetails').value;

            try {
                const response = await fetch('manage_content.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=update_project&id=${id}&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&youtube=${encodeURIComponent(youtube)}&details=${encodeURIComponent(details)}`
                });
                const result = await response.text();
                if (result === 'success') {
                    location.reload();
                } else {
                    alert('Error updating project');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error updating project');
            }
        });

        // Add form submission
        document.getElementById('addForm').addEventListener('submit', async (e) => {
            e.preventDefault();
            const title = document.getElementById('addTitle').value;
            const description = document.getElementById('addDescription').value;
            const youtube = document.getElementById('addYoutube').value;
            const details = document.getElementById('addDetails').value;

            try {
                const response = await fetch('manage_content.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `action=add_project&title=${encodeURIComponent(title)}&description=${encodeURIComponent(description)}&youtube=${encodeURIComponent(youtube)}&details=${encodeURIComponent(details)}`
                });
                const result = await response.text();
                if (result === 'success') {
                    location.reload();
                } else {
                    alert('Error adding project');
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error adding project');
            }
        });
    });
  </script>
