<?php
require_once 'auth_check.php';
$adminTitle = 'Manage Banners';
$msg = '';
$msgType = '';

// Handle actions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_banner'])) {
        $title = sanitize($conn, $_POST['title']);
        $subtitle = sanitize($conn, $_POST['subtitle']);
        $call_link = sanitize($conn, $_POST['call_form_link']);
        $sort = (int)($_POST['sort_order'] ?? 0);
        $imgPath = '';

        if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $newName = 'banner_' . time() . '.' . $ext;
                $uploadDir = '../uploads/banner/';
                if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
                if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $uploadDir . $newName)) {
                    $imgPath = $newName;
                }
            }
        }

        $stmt = $conn->prepare("INSERT INTO banners (title, subtitle, image_path, call_form_link, sort_order, is_active) VALUES (?,?,?,?,?,1)");
        $stmt->bind_param("ssssi", $title, $subtitle, $imgPath, $call_link, $sort);
        if ($stmt->execute()) { $msg = 'Banner added successfully!'; $msgType = 'success'; }
        else { $msg = 'Error adding banner.'; $msgType = 'error'; }
    }
    if (isset($_POST['delete_banner'])) {
        $id = (int)$_POST['banner_id'];
        $conn->query("DELETE FROM banners WHERE id=$id");
        $msg = 'Banner deleted.'; $msgType = 'success';
    }
    if (isset($_POST['toggle_banner'])) {
        $id = (int)$_POST['banner_id'];
        $conn->query("UPDATE banners SET is_active = NOT is_active WHERE id=$id");
        $msg = 'Banner status updated.'; $msgType = 'success';
    }
    if (isset($_POST['update_call_link'])) {
        $id = (int)$_POST['banner_id'];
        $link = sanitize($conn, $_POST['call_link']);
        $conn->query("UPDATE banners SET call_form_link='$link' WHERE id=$id");
        $msg = 'Call link updated!'; $msgType = 'success';
    }
}

$banners = $conn->query("SELECT * FROM banners ORDER BY sort_order ASC, created_at DESC");
require_once 'admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<div class="admin-form-card">
    <h2><i class="fas fa-plus-circle" style="color:#FFC107;"></i> Add New Banner</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label>Banner Title *</label>
                <input type="text" name="title" placeholder="e.g. Welcome to Kalrav Vidhya Mandir" required class="form-group input">
            </div>
            <div class="form-group">
                <label>Subtitle</label>
                <input type="text" name="subtitle" placeholder="e.g. Nurturing minds, building futures" class="form-group input">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Banner Image (optional)</label>
                <input type="file" name="banner_image" accept="image/*" style="padding:8px;">
            </div>
            <div class="form-group">
                <label>Google Form Link (Get a Call)</label>
                <input type="url" name="call_form_link" placeholder="https://forms.google.com/...">
            </div>
        </div>
        <div class="form-group" style="max-width:200px;">
            <label>Sort Order</label>
            <input type="number" name="sort_order" value="0" min="0">
        </div>
        <button type="submit" name="add_banner" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Add Banner</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2>All Banners</h2><span style="font-size:13px;color:#888;"><?php echo $banners->num_rows; ?> total</span></div>
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Subtitle</th><th>Call Link</th><th>Status</th><th>Actions</th></tr></thead>
        <tbody>
            <?php if ($banners->num_rows > 0):
                while ($b = $banners->fetch_assoc()): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($b['title']); ?></strong></td>
                <td><?php echo htmlspecialchars(substr($b['subtitle'],0,40)); ?>...</td>
                <td>
                    <form method="POST" style="display:flex;gap:5px;align-items:center;">
                        <input type="hidden" name="banner_id" value="<?php echo $b['id']; ?>">
                        <input type="url" name="call_link" value="<?php echo htmlspecialchars($b['call_form_link']); ?>" style="padding:5px 8px;border:1px solid #ddd;border-radius:6px;font-size:12px;width:180px;">
                        <button type="submit" name="update_call_link" class="admin-btn admin-btn-info admin-btn-sm">Save</button>
                    </form>
                </td>
                <td><span class="badge <?php echo $b['is_active']?'badge-success':'badge-danger'; ?>"><?php echo $b['is_active']?'Active':'Hidden'; ?></span></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="banner_id" value="<?php echo $b['id']; ?>">
                        <button type="submit" name="toggle_banner" class="admin-btn admin-btn-info admin-btn-sm"><?php echo $b['is_active']?'Hide':'Show'; ?></button>
                    </form>
                    <form method="POST" style="display:inline;" onsubmit="return confirmDelete()">
                        <input type="hidden" name="banner_id" value="<?php echo $b['id']; ?>">
                        <button type="submit" name="delete_banner" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php endwhile; else: ?><tr><td colspan="5" style="text-align:center;padding:20px;color:#888;">No banners yet. Add one above.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

</div><script src="../assets/js/script.js"></script></body></html>
