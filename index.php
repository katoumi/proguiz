<?php
session_start();
include 'navbar.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Proguiz | Learn, Practice, and Master</title>
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body class="fade-in">

  <!-- Navbar -->
  <nav class="navbar">
    <div class="logo">💡Proguiz</div>
    <ul class="nav-links">
      <li><a href="index.php" class="active">Home</a></li>
      <li><a href="sets.html">Topics</a></li>
      <li><a href="flashcards.html">Flashcards</a></li>
      <li><a href="quiz.php">Quiz</a></li>
      <li><a href="results.html">Results</a></li>
      <li><a href="about.html">About</a></li>
      <li><a href="team.html">Who We Are</a></li>
      <li><a href="info.html">Info</a></li>
      <?php if (!isset($_SESSION['username'])): ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php else: ?>
        <li><a href="logout.php" class="logout-link">Logout</a></li>
      <?php endif; ?>
    </ul>
    <a href="contact.html" class="contact-btn">Contact Us</a>
  </nav>

  <!-- Hero Section -->
  <section class="hero">
    <div class="hero-content">
      <?php if (isset($_SESSION['username'])): ?>
        <h1>Welcome back, <span class="highlight"><?php echo htmlspecialchars($_SESSION['username']); ?></span>!</h1>
        <p>Continue your learning journey with interactive programming flashcards and quizzes.</p>
        <a href="sets.html" class="primary-btn">Continue Learning</a>
      <?php else: ?>
        <h1>
          Enhance your mind:<br>
          <span class="highlight">Enjoy Studying</span> with Interactive Flashcards
        </h1>
        <p>
          Explore an efficient way to review and retain information using our interactive flashcards focused on programming. 
          Choose a topic, practice, and boost your coding knowledge!
        </p>
        <a href="sets.html" class="primary-btn">Start Learning</a>
      <?php endif; ?>
    </div>
  </section>

  <script>
    // Fade-in on page load
    document.addEventListener("DOMContentLoaded", () => {
      document.body.classList.add("fade-in");
    });

    // Fade-out for internal links
    document.querySelectorAll('a[href]').forEach(link => {
      const url = link.getAttribute('href');
      if (url && !url.startsWith("http") && !url.startsWith("#") && !url.startsWith("mailto")) {
        link.addEventListener("click", e => {
          e.preventDefault();
          document.body.classList.remove("fade-in");
          document.body.style.opacity = "0";
          setTimeout(() => window.location.href = url, 300);
        });
      }
    });
  </script>
</body>
</html>
