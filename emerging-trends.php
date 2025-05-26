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
  <title>Emerging Trends | Integrity Innovations</title>
  <link rel="stylesheet" href="css/styles.css" />
  <link rel="stylesheet" href="css/emerging-trends.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"/>
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
          <a href="edit-emerging-trends.php"><i class="fas fa-edit"></i> Edit Mode</a>
        </div>
      </div>
    </nav>
    <button class="menu-toggle" id="menu-toggle">☰</button>
  </header>

  <section class="hero">
    <div class="container">
      <h2>Emerging Trends</h2>
      <p>Stay ahead with the latest innovations in EEE research and development</p>
    </div>
  </section>

  <section class="card-grid container">
    <h3>Hot Topics in EEE (2024–2025)</h3>
    <?php foreach ($trends as $trend): ?>
    <div class="card" onclick="window.location.href='<?php echo htmlspecialchars($trend['content_url']); ?>'">
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