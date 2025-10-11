<?php
session_start();
?>

<nav class="navbar">
  <div class="logo">💡Proguiz</div>
  <ul class="nav-links">
    <li><a href="index.html">Home</a></li>
    <li><a href="sets.html">Topics</a></li>
    <li><a href="info.html">Info</a></li>

    <?php if (isset($_SESSION['username'])): ?>
      <li><a href="#">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></a></li>
      <li><a href="logout.php" class="contact-btn">Logout</a></li>
    <?php else: ?>
      <li><a href="login.html">Login</a></li>
      <li><a href="register.html" class="contact-btn">Register</a></li>
    <?php endif; ?>
  </ul>
</nav>
