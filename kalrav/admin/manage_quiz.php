<?php
require_once 'auth_check.php';
$adminTitle = 'Manage Quiz';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_quiz'])) {
        $title = sanitize($conn, $_POST['title']);
        $desc = sanitize($conn, $_POST['description']);
        $type = sanitize($conn, $_POST['quiz_type']);
        $stmt = $conn->prepare("INSERT INTO quizzes (title, description, quiz_type, is_active) VALUES (?,?,?,1)");
        $stmt->bind_param("sss", $title, $desc, $type);
        $stmt->execute() ? ($msg='Quiz created!') && ($msgType='success') : ($msg='Error.') && ($msgType='error');
    }
    if (isset($_POST['add_question'])) {
        $qid = (int)$_POST['quiz_id'];
        $question = sanitize($conn, $_POST['question']);
        $oa = sanitize($conn, $_POST['option_a']);
        $ob = sanitize($conn, $_POST['option_b']);
        $oc = sanitize($conn, $_POST['option_c'] ?? '');
        $od = sanitize($conn, $_POST['option_d'] ?? '');
        $correct = sanitize($conn, $_POST['correct_answer']);
        $stmt = $conn->prepare("INSERT INTO quiz_questions (quiz_id, question, option_a, option_b, option_c, option_d, correct_answer) VALUES (?,?,?,?,?,?,?)");
        $stmt->bind_param("issssss", $qid, $question, $oa, $ob, $oc, $od, $correct);
        $stmt->execute() ? ($msg='Question added!') && ($msgType='success') : ($msg='Error.') && ($msgType='error');
    }
    if (isset($_POST['delete_quiz'])) {
        $id = (int)$_POST['quiz_id'];
        $conn->query("DELETE FROM quizzes WHERE id=$id");
        $msg = 'Quiz deleted.'; $msgType = 'success';
    }
    if (isset($_POST['delete_question'])) {
        $id = (int)$_POST['question_id'];
        $conn->query("DELETE FROM quiz_questions WHERE id=$id");
        $msg = 'Question deleted.'; $msgType = 'success';
    }
    if (isset($_POST['toggle_quiz'])) {
        $id = (int)$_POST['quiz_id'];
        $conn->query("UPDATE quizzes SET is_active = NOT is_active WHERE id=$id");
        $msg = 'Quiz status updated.'; $msgType = 'success';
    }
}

$selectedQuiz = isset($_GET['quiz_id']) ? (int)$_GET['quiz_id'] : 0;
$quizzes = $conn->query("SELECT q.*, (SELECT COUNT(*) FROM quiz_questions WHERE quiz_id=q.id) as q_count FROM quizzes q ORDER BY created_at DESC");
$questions = [];
$currentQuiz = null;
if ($selectedQuiz) {
    $cq = $conn->query("SELECT * FROM quizzes WHERE id=$selectedQuiz");
    $currentQuiz = $cq->fetch_assoc();
    $qRes = $conn->query("SELECT * FROM quiz_questions WHERE quiz_id=$selectedQuiz ORDER BY id ASC");
    while ($q = $qRes->fetch_assoc()) $questions[] = $q;
}
require_once 'admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<div class="grid-2" style="gap:25px;align-items:start;">
    <!-- Left: Quiz List & Create -->
    <div>
        <div class="admin-form-card">
            <h2><i class="fas fa-plus-circle" style="color:#FFC107;"></i> Create New Quiz</h2>
            <form method="POST">
                <div class="form-group">
                    <label>Quiz Title *</label>
                    <input type="text" name="title" required placeholder="e.g. General Knowledge Quiz">
                </div>
                <div class="form-group">
                    <label>Quiz Type *</label>
                    <select name="quiz_type" style="width:100%;padding:12px 16px;border:2px solid #e9ecef;border-radius:12px;font-family:inherit;font-size:14px;background:#f8f9fa;">
                        <option>Multiple Choice</option>
                        <option>True/False</option>
                        <option>Vocabulary Quiz</option>
                        <option>Picture Quiz</option>
                        <option>Quiz Competition</option>
                        <option>Matching Quiz</option>
                        <option>Video Quiz</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" rows="2" placeholder="Brief quiz description..."></textarea>
                </div>
                <button type="submit" name="add_quiz" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Create Quiz</button>
            </form>
        </div>

        <div class="admin-card">
            <div class="admin-card-header"><h2>All Quizzes</h2></div>
            <table class="admin-table">
                <thead><tr><th>Title</th><th>Type</th><th>Qs</th><th>Status</th><th>Actions</th></tr></thead>
                <tbody>
                    <?php if ($quizzes->num_rows > 0):
                        while ($q = $quizzes->fetch_assoc()): ?>
                    <tr>
                        <td><strong><?php echo htmlspecialchars($q['title']); ?></strong></td>
                        <td><span style="font-size:11px;background:#fff3cd;color:#FF8F00;padding:2px 8px;border-radius:50px;"><?php echo htmlspecialchars($q['quiz_type']); ?></span></td>
                        <td><?php echo $q['q_count']; ?></td>
                        <td><span class="badge <?php echo $q['is_active']?'badge-success':'badge-danger'; ?>"><?php echo $q['is_active']?'Active':'Inactive'; ?></span></td>
                        <td style="white-space:nowrap;">
                            <a href="?quiz_id=<?php echo $q['id']; ?>" class="admin-btn admin-btn-info admin-btn-sm">+ Questions</a>
                            <form method="POST" style="display:inline;">
                                <input type="hidden" name="quiz_id" value="<?php echo $q['id']; ?>">
                                <button type="submit" name="toggle_quiz" class="admin-btn admin-btn-info admin-btn-sm"><?php echo $q['is_active']?'Hide':'Show'; ?></button>
                            </form>
                            <form method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                                <input type="hidden" name="quiz_id" value="<?php echo $q['id']; ?>">
                                <button type="submit" name="delete_quiz" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endwhile; else: ?><tr><td colspan="5" style="text-align:center;padding:20px;color:#888;">No quizzes yet.</td></tr><?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Right: Add Questions -->
    <div>
        <?php if ($selectedQuiz && $currentQuiz): ?>
        <div class="admin-form-card">
            <h2><i class="fas fa-question" style="color:#FFC107;"></i> Add Question to "<?php echo htmlspecialchars($currentQuiz['title']); ?>"</h2>
            <form method="POST">
                <input type="hidden" name="quiz_id" value="<?php echo $selectedQuiz; ?>">
                <div class="form-group">
                    <label>Question *</label>
                    <textarea name="question" rows="2" required placeholder="Write the question here..."></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Option A *</label>
                        <input type="text" name="option_a" required placeholder="Option A">
                    </div>
                    <div class="form-group">
                        <label>Option B *</label>
                        <input type="text" name="option_b" required placeholder="Option B">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Option C (optional)</label>
                        <input type="text" name="option_c" placeholder="Option C">
                    </div>
                    <div class="form-group">
                        <label>Option D (optional)</label>
                        <input type="text" name="option_d" placeholder="Option D">
                    </div>
                </div>
                <div class="form-group">
                    <label>Correct Answer *</label>
                    <select name="correct_answer" style="width:100%;padding:12px 16px;border:2px solid #e9ecef;border-radius:12px;font-family:inherit;font-size:14px;background:#f8f9fa;">
                        <option value="A">A</option>
                        <option value="B">B</option>
                        <option value="C">C</option>
                        <option value="D">D</option>
                    </select>
                </div>
                <button type="submit" name="add_question" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Add Question</button>
            </form>
        </div>

        <?php if (!empty($questions)): ?>
        <div class="admin-card">
            <div class="admin-card-header"><h2>Questions (<?php echo count($questions); ?>)</h2></div>
            <table class="admin-table">
                <thead><tr><th>#</th><th>Question</th><th>Correct</th><th>Del</th></tr></thead>
                <tbody>
                    <?php foreach ($questions as $i => $q): ?>
                    <tr>
                        <td><?php echo $i+1; ?></td>
                        <td><?php echo htmlspecialchars(substr($q['question'],0,60)); ?>...</td>
                        <td><span class="badge badge-success"><?php echo $q['correct_answer']; ?></span></td>
                        <td>
                            <form method="POST" onsubmit="return confirmDelete()">
                                <input type="hidden" name="question_id" value="<?php echo $q['id']; ?>">
                                <input type="hidden" name="quiz_id" value="<?php echo $selectedQuiz; ?>">
                                <button type="submit" name="delete_question" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <?php endif;
        else: ?>
        <div class="admin-form-card" style="text-align:center;padding:40px;">
            <div style="font-size:50px;margin-bottom:15px;">📝</div>
            <h3>Select a Quiz</h3>
            <p style="color:#666;font-size:14px;">Click "+ Questions" on any quiz to add questions to it.</p>
        </div>
        <?php endif; ?>
    </div>
</div>

</div><script src="../assets/js/script.js"></script></body></html>
