<?php
session_start();

// Database connection
$conn = new mysqli("localhost", "root", "", "proguiz");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user["password"])) {
            $_SESSION["username"] = $user["username"];
            header("Location: index.php");
            exit;
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login | Proguiz</title>
  <style>
    * { box-sizing: border-box; margin: 0; padding: 0; font-family: 'Poppins', sans-serif; }
    body {
      background: linear-gradient(135deg, #0a0a1a, #1e1e2f);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      color: #fff;
    }
    .auth-box {
      background: #1e1f33;
      padding: 40px;
      border-radius: 16px;
      width: 350px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.5);
      text-align: center;
      animation: fadeIn 0.4s ease;
    }
    h2 {
      color: #a29bfe;
      margin-bottom: 20px;
      font-weight: 600;
    }
    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: none;
      border-radius: 8px;
      background: #2a2a45;
      color: #fff;
      transition: 0.2s;
    }
    input:focus {
      background: #343457;
      outline: none;
    }
    button {
      width: 100%;
      padding: 12px;
      margin-top: 10px;
      background: #6c5ce7;
      color: #fff;
      border: none;
      border-radius: 8px;
      font-weight: 600;
      cursor: pointer;
      transition: 0.3s;
    }
    button:hover { background: #7b68ee; transform: translateY(-2px); }
    p { margin-top: 15px; font-size: 14px; }
    a { color: #a29bfe; text-decoration: none; }
    a:hover { text-decoration: underline; }
    .error {
      background: rgba(255, 0, 0, 0.15);
      padding: 10px;
      border-radius: 8px;
      color: #ff7675;
      margin-bottom: 10px;
    }
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
  </style>
</head>
<body>
  <div class="auth-box">
    <h2>Login to Proguiz</h2>
    <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
    <form method="POST" action="">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
    <p>Don’t have an account? <a href="register.php">Register here</a></p>
  </div>
</body>
</html>
<script>
  // Fade-in on page load
  document.addEventListener("DOMContentLoaded", () => {
    document.body.classList.add("fade-in");
  });

  // Fade-out on internal navigation
  document.querySelectorAll('a[href]').forEach(link => {
    const url = link.getAttribute('href');

    // apply only to local links
    if (url && !url.startsWith("http") && !url.startsWith("#") && !url.startsWith("mailto")) {
      link.addEventListener("click", e => {
        e.preventDefault();
        document.body.classList.remove("fade-in");
        document.body.style.opacity = "0";
        setTimeout(() => {
          window.location.href = url;
        }, 300); // must be slightly shorter than CSS transition
      });
    }
  });