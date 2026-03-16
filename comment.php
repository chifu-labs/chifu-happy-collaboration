<?php
// =============================================
// COMMENT HANDLER — AJAX POST ENDPOINT
// =============================================

header('Content-Type: application/json');
require_once 'database.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
  exit;
}

$name    = trim($_POST['name']    ?? '');
$comment = trim($_POST['comment'] ?? '');

// Validation
if (empty($name) || empty($comment)) {
  echo json_encode(['success' => false, 'error' => 'Name and comment are required.']);
  exit;
}
if (strlen($name) > 100) {
  echo json_encode(['success' => false, 'error' => 'Name too long (max 100 chars).']);
  exit;
}
if (strlen($comment) > 1000) {
  echo json_encode(['success' => false, 'error' => 'Comment too long (max 1000 chars).']);
  exit;
}

// Sanitize
$name    = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
$comment = htmlspecialchars($comment, ENT_QUOTES, 'UTF-8');

try {
  $stmt = $pdo->prepare("INSERT INTO comments (name, comment, created_at) VALUES (:name, :comment, NOW())");
  $stmt->execute([':name' => $name, ':comment' => $comment]);

  echo json_encode([
    'success' => true,
    'name'    => $name,
    'comment' => $comment,
    'date'    => date('M d, Y')
  ]);
} catch (PDOException $e) {
  echo json_encode(['success' => false, 'error' => 'Could not save comment.']);
}
