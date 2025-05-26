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
  <title>Research | Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css">
  <link rel="stylesheet" href="css/research.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
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
          <a href="edit-research.php"><i class="fas fa-edit"></i> Edit Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <section class="hero">
    <div class="container">
      <h2>Research Hub</h2>
      <p>Dive into cutting-edge research in Electrical and Electronics Engineering</p>
    </div>
  </section>

  <section class="card-grid container">
    <h3>Research Categories</h3>
    <?php foreach ($categories as $category): ?>
    <div class="card">
      <h4><?php echo htmlspecialchars($category['title']); ?></h4>
      <p><?php echo htmlspecialchars($category['description']); ?></p>
    </div>
    <?php endforeach; ?>
  </section>

  <section class="card-grid container">
    <h3>Featured Research Papers</h3>
    <?php foreach ($papers as $paper): ?>
    <div class="card">
      <h4><?php echo htmlspecialchars($paper['title']); ?></h4>
      <p><?php echo htmlspecialchars($paper['publication_info']); ?></p>
      <button onclick="alert('Modal with abstract and link coming soon')">View More</button>
    </div>
    <?php endforeach; ?>
  </section>

  <section class="card-grid container">
    <h3>Contribute to the Community</h3>
    <div class="card">
      <h4>Share your Groundbreaking Innovations and Research Papers</h4>
      <p>Contribute to the research community by sharing your research papers, innovations, and relevant research projects.</p>
      <button onclick="alert('You must be signed in to upload files')">Contribute</button>
    </div>
  </section>

  <section class="container">
    <h3>Research Resources</h3>
    <ul>
      <li><a href="#">IEEE Xplore Digital Library</a></li>
      <li><a href="#">ScienceDirect - EEE Journals</a></li>
      <li><a href="#">Research Proposal Template (PDF)</a></li>
    </ul>
  </section>

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