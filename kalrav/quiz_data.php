<?php
require_once 'includes/db.php';
header('Content-Type: application/json');

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if (!$id) { echo json_encode(['error' => 'Invalid']); exit; }

$quizStmt = $conn->prepare("SELECT * FROM quizzes WHERE id=? AND is_active=1");
$quizStmt->bind_param("i", $id);
$quizStmt->execute();
$quiz = $quizStmt->get_result()->fetch_assoc();
if (!$quiz) { echo json_encode(['error' => 'Not found']); exit; }

$qStmt = $conn->prepare("SELECT * FROM quiz_questions WHERE quiz_id=? ORDER BY id ASC");
$qStmt->bind_param("i", $id);
$qStmt->execute();
$qRes = $qStmt->get_result();
$questions = [];
while ($q = $qRes->fetch_assoc()) $questions[] = $q;

echo json_encode(['title' => $quiz['title'], 'type' => $quiz['quiz_type'], 'questions' => $questions]);
