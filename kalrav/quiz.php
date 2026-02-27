<?php
$pageTitle = 'Quiz';
require_once 'includes/header.php';

$quizzes = $conn->query("SELECT q.*, (SELECT COUNT(*) FROM quiz_questions WHERE quiz_id=q.id) as q_count FROM quizzes q WHERE q.is_active=1 ORDER BY q.created_at DESC");

$typeBadges = [
    'Multiple Choice' => 'quiz-type-mc',
    'True/False' => 'quiz-type-tf',
    'Vocabulary Quiz' => 'quiz-type-voc',
    'Picture Quiz' => 'quiz-type-pic',
    'Quiz Competition' => 'quiz-type-mc',
    'Matching Quiz' => 'quiz-type-tf',
    'Video Quiz' => 'quiz-type-pic',
];
$typeIcons = [
    'Multiple Choice'=>'📝','True/False'=>'✅','Vocabulary Quiz'=>'📖',
    'Picture Quiz'=>'🖼️','Quiz Competition'=>'🏆','Matching Quiz'=>'🔗','Video Quiz'=>'🎥',
];
?>

<div class="page-hero">
    <div class="container">
        <h1>Quiz Corner</h1>
        <p>Test your knowledge with our interactive quizzes</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Quiz</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Interactive Learning</div>
            <h2>Choose a Quiz</h2>
            <p>Select any quiz below to start. Your score will be shown at the end!</p>
            <div class="section-divider"></div>
        </div>

        <div class="grid-3">
            <?php if ($quizzes && $quizzes->num_rows > 0):
                while ($quiz = $quizzes->fetch_assoc()):
                    $badgeClass = $typeBadges[$quiz['quiz_type']] ?? 'quiz-type-mc';
                    $icon = $typeIcons[$quiz['quiz_type']] ?? '📝';
            ?>
            <div class="quiz-card" onclick="openQuiz(<?php echo $quiz['id']; ?>)">
                <div style="font-size:45px;margin-bottom:12px;"><?php echo $icon; ?></div>
                <div class="quiz-type-badge <?php echo $badgeClass; ?>"><?php echo htmlspecialchars($quiz['quiz_type']); ?></div>
                <h3><?php echo htmlspecialchars($quiz['title']); ?></h3>
                <p><?php echo htmlspecialchars($quiz['description']); ?></p>
                <div class="quiz-meta">
                    <span><i class="fas fa-question-circle" style="color:#FFC107;"></i> <?php echo $quiz['q_count']; ?> Questions</span>
                    <span><i class="fas fa-clock" style="color:#FFC107;"></i> ~<?php echo max(1, ceil($quiz['q_count'] * 0.5)); ?> min</span>
                </div>
                <div style="margin-top:15px;">
                    <button class="btn-primary" style="font-size:13px;padding:9px 20px;"><i class="fas fa-play"></i> Start Quiz</button>
                </div>
            </div>
            <?php endwhile; else: ?>
            <div style="grid-column:1/-1;text-align:center;padding:50px;color:#666;">
                <div style="font-size:60px;margin-bottom:15px;">📝</div>
                <h3>No quizzes available right now.</h3>
                <p>Check back soon or ask your teacher!</p>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Quiz Modal -->
<div class="quiz-modal" id="quiz-modal">
    <div class="quiz-modal-inner">
        <button class="quiz-modal-close" onclick="closeQuiz()">×</button>
        <h2 id="quiz-title" style="margin-bottom:20px;font-size:20px;color:#1a1a2e;padding-right:30px;"></h2>
        <div id="quiz-container">
            <div style="text-align:center;padding:40px;color:#666;">Loading...</div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
