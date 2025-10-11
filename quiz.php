<?php
session_start();
$username = $_SESSION['username'] ?? 'Guest';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Quiz | Proguiz</title>
  <link rel="stylesheet" href="css/style.css" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

  <button id="sound-test">🔊 Test Sound</button>

  <!-- NAVBAR -->
  <nav class="navbar">
    <div class="logo">Proguiz</div>
    <ul class="nav-links">
      <li><a href="index.php">Home</a></li>
      <li><a href="sets.html">Topics</a></li>
      <li><a href="flashcards.html">Flashcards</a></li>
      <li><a href="quiz.php" class="active">Quiz</a></li>
      <li><a href="info.html">Info</a></li>

      <?php if ($username === 'Guest'): ?>
        <li><a href="login.php">Login</a></li>
        <li><a href="register.php">Register</a></li>
      <?php else: ?>
        <li><a href="logout.php" class="logout-btn">Logout (<?php echo htmlspecialchars($username); ?>)</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <!-- QUIZ SECTION -->
  <section class="quiz-section">
    <div class="quiz-card">
      <h1 id="quizTitle">Welcome, <?php echo htmlspecialchars($username); ?> — Ready for your Quiz?</h1>

      <div class="progress-bar">
        <div id="progressFill"></div>
      </div>
      <p id="progressText">Question 1 of ?</p>

      <div class="quiz-content">
        <p id="question">Loading question...</p>
        <div id="options" class="options-container"></div>
      </div>

      <div class="quiz-controls">
        <button id="confirm-btn" class="primary-btn" disabled>Confirm Answer</button>
        <button id="next-btn" class="primary-btn" style="display: none;">Next Question</button>
      </div>

      <button id="back-btn" class="secondary-btn" onclick="smoothNavigate('sets.html')">Back to Topics</button>
    </div>
  </section>

  <div id="quiz-summary" class="quiz-summary" style="display: none; text-align: center;">
    <h2 id="summary-title">Quiz Complete!</h2>
    <p id="summary-score"></p>
    <button id="view-results" class="primary-btn">View Past Results</button>
    <button id="retry-quiz" class="secondary-btn">Retry Quiz</button>
  </div>

  <!-- Scripts -->
  <script>
    // Pass PHP username to JS
    const loggedInUser = "<?php echo htmlspecialchars($username); ?>";
    localStorage.setItem("username", loggedInUser);
  </script>
  <script src="js/data.js"></script>
  <script src="js/script.js"></script>

  <!-- Fade transition -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      document.body.classList.add("fade-in");
    });
    function smoothNavigate(url) {
      document.body.classList.remove("fade-in");
      document.body.style.opacity = "0";
      setTimeout(() => window.location.href = url, 300);
    }
  </script>
</body>
</html>
