<?php
require_once 'auth_check.php';
$adminTitle = 'Manage Gallery';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_gallery'])) {
        $title = sanitize($conn, $_POST['title']);
        $cat = sanitize($conn, $_POST['category']);
        $year = sanitize($conn, $_POST['year']);

        if (isset($_FILES['gallery_image']) && $_FILES['gallery_image']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['gallery_image']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','gif','webp'])) {
                $newName = 'gallery_' . time() . '_' . rand(100,999) . '.' . $ext;
                $dir = '../uploads/gallery/';
                if (!is_dir($dir)) mkdir($dir, 0755, true);
                if (move_uploaded_file($_FILES['gallery_image']['tmp_name'], $dir . $newName)) {
                    $stmt = $conn->prepare("INSERT INTO gallery (title, category, year, image_path) VALUES (?,?,?,?)");
                    $stmt->bind_param("ssss", $title, $cat, $year, $newName);
                    $stmt->execute() ? ($msg='Image uploaded!') && ($msgType='success') : ($msg='Upload failed.') && ($msgType='error');
                }
            } else { $msg = 'Only JPG, PNG, GIF, WEBP allowed.'; $msgType = 'error'; }
        } else {
            // Add without image
            $empty = '';
            $stmt = $conn->prepare("INSERT INTO gallery (title, category, year, image_path) VALUES (?,?,?,?)");
            $stmt->bind_param("ssss", $title, $cat, $year, $empty);
            $stmt->execute() ? ($msg='Gallery item added (no image)!') && ($msgType='success') : null;
        }
    }
    if (isset($_POST['delete_gallery'])) {
        $id = (int)$_POST['gallery_id'];
        $img = $conn->query("SELECT image_path FROM gallery WHERE id=$id")->fetch_assoc();
        if ($img && !empty($img['image_path'])) @unlink('../uploads/gallery/' . $img['image_path']);
        $conn->query("DELETE FROM gallery WHERE id=$id");
        $msg = 'Deleted.'; $msgType = 'success';
    }
}

$gallery = $conn->query("SELECT * FROM gallery ORDER BY created_at DESC");
require_once 'admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<div class="admin-form-card">
    <h2><i class="fas fa-upload" style="color:#FFC107;"></i> Upload Gallery Image</h2>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group">
                <label>Title *</label>
                <input type="text" name="title" required placeholder="e.g. Diwali Celebration 2024">
            </div>
            <div class="form-group">
                <label>Category *</label>
                <select name="category" style="width:100%;padding:12px 16px;border:2px solid #e9ecef;border-radius:12px;font-family:inherit;font-size:14px;background:#f8f9fa;">
                    <option value="Indian Festivals">Indian Festivals</option>
                    <option value="Other Activities">Other Activities</option>
                    <option value="Annual Day">Annual Day</option>
                </select>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group">
                <label>Year (for Annual Day)</label>
                <input type="text" name="year" placeholder="e.g. 2024">
            </div>
            <div class="form-group">
                <label>Image File (JPG/PNG/GIF/WEBP)</label>
                <input type="file" name="gallery_image" accept="image/*" style="padding:8px;">
            </div>
        </div>
        <button type="submit" name="add_gallery" class="admin-btn admin-btn-primary"><i class="fas fa-upload"></i> Upload to Gallery</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2>Gallery Images</h2><span style="font-size:13px;color:#888;"><?php echo $gallery->num_rows; ?> images</span></div>
    <table class="admin-table">
        <thead><tr><th>Preview</th><th>Title</th><th>Category</th><th>Year</th><th>Date Added</th><th>Action</th></tr></thead>
        <tbody>
            <?php if ($gallery->num_rows > 0):
                while ($g = $gallery->fetch_assoc()): ?>
            <tr>
                <td>
                    <?php if (!empty($g['image_path']) && file_exists('../uploads/gallery/'.$g['image_path'])): ?>
                    <img src="../uploads/gallery/<?php echo htmlspecialchars($g['image_path']); ?>" style="width:60px;height:45px;object-fit:cover;border-radius:6px;">
                    <?php else: ?>
                    <div style="width:60px;height:45px;background:linear-gradient(135deg,#FFC107,#FF8F00);border-radius:6px;display:flex;align-items:center;justify-content:center;font-size:22px;">🖼️</div>
                    <?php endif; ?>
                </td>
                <td><?php echo htmlspecialchars($g['title']); ?></td>
                <td><span class="badge" style="background:#fff3cd;color:#FF8F00;"><?php echo htmlspecialchars($g['category']); ?></span></td>
                <td><?php echo htmlspecialchars($g['year'] ?? '—'); ?></td>
                <td><?php echo date('d M Y', strtotime($g['created_at'])); ?></td>
                <td>
                    <form method="POST" onsubmit="return confirmDelete()">
                        <input type="hidden" name="gallery_id" value="<?php echo $g['id']; ?>">
                        <button type="submit" name="delete_gallery" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; else: ?><tr><td colspan="6" style="text-align:center;padding:20px;color:#888;">No images yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

</div><script src="../assets/js/script.js"></script></body></html>
