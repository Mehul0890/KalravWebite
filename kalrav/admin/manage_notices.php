<?php
require_once 'auth_check.php';
$adminTitle = 'Manage Notices';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_notice'])) {
        $title = sanitize($conn, $_POST['title']);
        $content = sanitize($conn, $_POST['content']);
        $pinned = isset($_POST['is_pinned']) ? 1 : 0;
        $stmt = $conn->prepare("INSERT INTO notices (title, content, is_pinned) VALUES (?,?,?)");
        $stmt->bind_param("ssi", $title, $content, $pinned);
        $stmt->execute() ? ($msg='Notice added!') && ($msgType='success') : ($msg='Error adding notice.') && ($msgType='error');
    }
    if (isset($_POST['delete_notice'])) {
        $id = (int)$_POST['notice_id'];
        $conn->query("DELETE FROM notices WHERE id=$id");
        $msg = 'Notice deleted.'; $msgType = 'success';
    }
    if (isset($_POST['toggle_pin'])) {
        $id = (int)$_POST['notice_id'];
        $conn->query("UPDATE notices SET is_pinned = NOT is_pinned WHERE id=$id");
        $msg = 'Notice updated.'; $msgType = 'success';
    }
}

$notices = $conn->query("SELECT * FROM notices ORDER BY is_pinned DESC, created_at DESC");
require_once 'admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<div class="admin-form-card">
    <h2><i class="fas fa-plus" style="color:#FFC107;"></i> Add New Notice</h2>
    <form method="POST">
        <div class="form-group">
            <label>Notice Title *</label>
            <input type="text" name="title" required placeholder="e.g. Admission Open 2025-26">
        </div>
        <div class="form-group">
            <label>Content</label>
            <textarea name="content" rows="4" placeholder="Write notice content here..."></textarea>
        </div>
        <div class="form-group">
            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                <input type="checkbox" name="is_pinned" style="width:16px;height:16px;">
                📌 Pin this notice (show at top)
            </label>
        </div>
        <button type="submit" name="add_notice" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Add Notice</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2>All Notices</h2><span style="font-size:13px;color:#888;"><?php echo $notices->num_rows; ?> total</span></div>
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Content</th><th>Pinned</th><th>Date</th><th>Actions</th></tr></thead>
        <tbody>
            <?php if ($notices->num_rows > 0):
                while ($n = $notices->fetch_assoc()): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($n['title']); ?></strong></td>
                <td style="max-width:250px;"><?php echo htmlspecialchars(substr($n['content'],0,80)); ?>...</td>
                <td><?php echo $n['is_pinned'] ? '<span class="badge badge-warning">📌 Yes</span>' : '<span class="badge" style="background:#f0f0f0;color:#666;">No</span>'; ?></td>
                <td><?php echo date('d M Y', strtotime($n['created_at'])); ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="notice_id" value="<?php echo $n['id']; ?>">
                        <button type="submit" name="toggle_pin" class="admin-btn admin-btn-info admin-btn-sm"><?php echo $n['is_pinned']?'Unpin':'Pin'; ?></button>
                    </form>
                    <form method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                        <input type="hidden" name="notice_id" value="<?php echo $n['id']; ?>">
                        <button type="submit" name="delete_notice" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php endwhile; else: ?><tr><td colspan="5" style="text-align:center;padding:20px;color:#888;">No notices yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

</div><script src="../assets/js/script.js"></script></body></html>
