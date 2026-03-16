<?php
// =============================================
// LIKE / DISLIKE HANDLER — AJAX POST ENDPOINT
// =============================================

header('Content-Type: application/json');
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['error' => 'Invalid request.']);
  exit;
}

$type = trim($_POST['type'] ?? '');

if (!in_array($type, ['like', 'dislike'])) {
  echo json_encode(['error' => 'Invalid type.']);
  exit;
}

try {
  if ($type === 'like') {
    $pdo->exec("UPDATE reactions SET likes = likes + 1 WHERE id = 1");
  } else {
    $pdo->exec("UPDATE reactions SET dislikes = dislikes + 1 WHERE id = 1");
  }

  $row = $pdo->query("SELECT likes, dislikes FROM reactions WHERE id = 1")->fetch();
  echo json_encode(['likes' => $row['likes'], 'dislikes' => $row['dislikes']]);

} catch (PDOException $e) {
  echo json_encode(['error' => 'Database error.']);
}
