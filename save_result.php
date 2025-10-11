<?php
session_start();
include 'config.php'; // make sure this connects to your 'proguiz' database

// Ensure user is logged in
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';

// Receive POST data
$topic = $_POST['topic'] ?? '';
$score = $_POST['score'] ?? 0;
$total = $_POST['total'] ?? 0;


if ($topic && $total > 0) {
    $stmt = $conn->prepare("INSERT INTO quiz_results (username, topic, score, total, date_taken) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssii", $username, $topic, $score, $total);

    if ($stmt->execute()) {
        echo "Result saved for $username";
    } else {
        echo "Error saving result: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Invalid data received.";
}

$conn->close();
?>
