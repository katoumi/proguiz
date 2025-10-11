<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "proguiz";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$topic = $_GET['topic'] ?? '';

if ($topic) {
  $stmt = $conn->prepare("SELECT id, question, option_a, option_b, option_c, option_d, correct_option FROM quiz_questions WHERE topic = ?");
  $stmt->bind_param("s", $topic);
  $stmt->execute();
  $result = $stmt->get_result();

  $questions = [];
  while ($row = $result->fetch_assoc()) {
    $questions[] = $row;
  }

  echo json_encode($questions);
} else {
  echo json_encode([]);
}

$conn->close();
?>
