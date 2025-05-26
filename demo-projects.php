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
  <title>Demo Projects - Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/videos.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
  <style>
    .modal {
      display: none;
      position: fixed;
      z-index: 999;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.8);
    }

    .modal-content {
      background-color: #2c2d61;
      margin: 10% auto;
      padding: 20px;
      border-radius: 10px;
      max-width: 600px;
      color: #fff;
      text-align: left;
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: #fff;
    }

    .view-more-btn {
      margin-top: 10px;
      background-color: #1a1263;
      color: white;
      padding: 8px 16px;
      border: none;
      border-radius: 25px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .view-more-btn:hover {
      background-color: #3c3f89;
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
    @media (max-width: 768px) {
        .modal-content {
            width: 90%;
            margin: 20% auto;
        }
        
        .video-card iframe {
            height: 180px;
        }
    }

    @media (max-width: 480px) {
        .modal-content {
            padding: 15px;
        }
        
        .view-more-btn {
            width: 100%;
        }
    }

    @media (max-width: 240px) {
        .video-card h2 {
            font-size: 1.1rem;
        }
        
        .modal-content h2 {
            font-size: 1.2rem;
        }
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
          <a href="edit-demo-projects.php"><i class="fas fa-edit"></i> Edit Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <main class="video-tutorials-wrapper">
    <div class="container">
      <h1>Embedded Demo Projects</h1>

      <div class="video-grid">
        <?php foreach ($projects as $project): ?>
        <div class="video-card">
          <div class="video-embed">
            <iframe src="<?php echo htmlspecialchars($project['youtube_url']); ?>" allowfullscreen></iframe>
          </div>
          <h2><?php echo htmlspecialchars($project['title']); ?></h2>
          <p><?php echo htmlspecialchars($project['description']); ?></p>
          <button class="view-more-btn" onclick="openModal('modal<?php echo $project['id']; ?>')">View More</button>
        </div>

        <!-- Modal for this project -->
        <div id="modal<?php echo $project['id']; ?>" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal('modal<?php echo $project['id']; ?>')">&times;</span>
            <h2><?php echo htmlspecialchars($project['title']); ?></h2>
            <p><?php echo htmlspecialchars($project['details']); ?></p>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <script>
    function openModal(id) {
      document.getElementById(id).style.display = 'block';
    }

    function closeModal(id) {
      document.getElementById(id).style.display = 'none';
    }

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