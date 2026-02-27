<?php
require_once 'auth_check.php';
$adminTitle = 'Manage Events';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_event'])) {
        $title = sanitize($conn, $_POST['title']);
        $desc = sanitize($conn, $_POST['description']);
        $date = sanitize($conn, $_POST['event_date']);
        $feat = isset($_POST['is_featured']) ? 1 : 0;
        $stmt = $conn->prepare("INSERT INTO events (title, description, event_date, is_featured) VALUES (?,?,?,?)");
        $stmt->bind_param("sssi", $title, $desc, $date, $feat);
        $stmt->execute() ? ($msg='Event added!') && ($msgType='success') : ($msg='Error.') && ($msgType='error');
    }
    if (isset($_POST['delete_event'])) {
        $id = (int)$_POST['event_id'];
        $conn->query("DELETE FROM events WHERE id=$id");
        $msg = 'Event deleted.'; $msgType = 'success';
    }
}

$events = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
require_once 'admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<div class="admin-form-card">
    <h2><i class="fas fa-calendar-plus" style="color:#FFC107;"></i> Add New Event</h2>
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>Event Title *</label>
                <input type="text" name="title" required placeholder="e.g. Annual Day 2025">
            </div>
            <div class="form-group">
                <label>Event Date *</label>
                <input type="date" name="event_date" required>
            </div>
        </div>
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="3" placeholder="Brief description of the event..."></textarea>
        </div>
        <div class="form-group">
            <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                <input type="checkbox" name="is_featured" style="width:16px;height:16px;">
                ⭐ Mark as Featured Event
            </label>
        </div>
        <button type="submit" name="add_event" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Add Event</button>
    </form>
</div>

<div class="admin-card">
    <div class="admin-card-header"><h2>All Events</h2></div>
    <table class="admin-table">
        <thead><tr><th>Title</th><th>Date</th><th>Description</th><th>Featured</th><th>Action</th></tr></thead>
        <tbody>
            <?php if ($events->num_rows > 0):
                while ($e = $events->fetch_assoc()): ?>
            <tr>
                <td><strong><?php echo htmlspecialchars($e['title']); ?></strong></td>
                <td><?php echo date('d M Y', strtotime($e['event_date'])); ?></td>
                <td><?php echo htmlspecialchars(substr($e['description'],0,60)); ?>...</td>
                <td><?php echo $e['is_featured'] ? '<span class="badge badge-success">⭐ Yes</span>' : 'No'; ?></td>
                <td>
                    <form method="POST" onsubmit="return confirmDelete()">
                        <input type="hidden" name="event_id" value="<?php echo $e['id']; ?>">
                        <button type="submit" name="delete_event" class="admin-btn admin-btn-danger admin-btn-sm"><i class="fas fa-trash"></i> Delete</button>
                    </form>
                </td>
            </tr>
            <?php endwhile; else: ?><tr><td colspan="5" style="text-align:center;padding:20px;color:#888;">No events yet.</td></tr><?php endif; ?>
        </tbody>
    </table>
</div>

</div><script src="../assets/js/script.js"></script></body></html>
