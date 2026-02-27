<?php
require_once 'auth_check.php';
$adminTitle = 'Dashboard';
require_once 'admin_header.php';

$counts = [
    'banners' => $conn->query("SELECT COUNT(*) as c FROM banners WHERE is_active=1")->fetch_assoc()['c'],
    'gallery' => $conn->query("SELECT COUNT(*) as c FROM gallery")->fetch_assoc()['c'],
    'notices' => $conn->query("SELECT COUNT(*) as c FROM notices")->fetch_assoc()['c'],
    'events' => $conn->query("SELECT COUNT(*) as c FROM events")->fetch_assoc()['c'],
    'quizzes' => $conn->query("SELECT COUNT(*) as c FROM quizzes WHERE is_active=1")->fetch_assoc()['c'],
    'questions' => $conn->query("SELECT COUNT(*) as c FROM quiz_questions")->fetch_assoc()['c'],
];
$recentNotices = $conn->query("SELECT * FROM notices ORDER BY created_at DESC LIMIT 5");
$recentEvents = $conn->query("SELECT * FROM events ORDER BY created_at DESC LIMIT 5");
?>

<div class="dash-stats">
    <div class="dash-stat-card">
        <div class="stat-icon yellow"><i class="fas fa-image"></i></div>
        <div class="stat-info"><h3><?php echo $counts['banners']; ?></h3><p>Active Banners</p></div>
    </div>
    <div class="dash-stat-card">
        <div class="stat-icon blue"><i class="fas fa-photo-video"></i></div>
        <div class="stat-info"><h3><?php echo $counts['gallery']; ?></h3><p>Gallery Images</p></div>
    </div>
    <div class="dash-stat-card">
        <div class="stat-icon green"><i class="fas fa-bullhorn"></i></div>
        <div class="stat-info"><h3><?php echo $counts['notices']; ?></h3><p>Notices</p></div>
    </div>
    <div class="dash-stat-card">
        <div class="stat-icon pink"><i class="fas fa-calendar"></i></div>
        <div class="stat-info"><h3><?php echo $counts['events']; ?></h3><p>Events</p></div>
    </div>
</div>

<div class="dash-stats">
    <div class="dash-stat-card">
        <div class="stat-icon yellow"><i class="fas fa-question-circle"></i></div>
        <div class="stat-info"><h3><?php echo $counts['quizzes']; ?></h3><p>Active Quizzes</p></div>
    </div>
    <div class="dash-stat-card">
        <div class="stat-icon blue"><i class="fas fa-list"></i></div>
        <div class="stat-info"><h3><?php echo $counts['questions']; ?></h3><p>Quiz Questions</p></div>
    </div>
    <div class="dash-stat-card">
        <div class="stat-icon green"><i class="fas fa-users"></i></div>
        <div class="stat-info"><h3>1200+</h3><p>Students</p></div>
    </div>
    <div class="dash-stat-card">
        <div class="stat-icon pink"><i class="fas fa-chalkboard-teacher"></i></div>
        <div class="stat-info"><h3>80+</h3><p>Teachers</p></div>
    </div>
</div>

<!-- Quick Actions -->
<div class="admin-card" style="margin-bottom:25px;">
    <div class="admin-card-header"><h2>⚡ Quick Actions</h2></div>
    <div style="padding:20px;display:flex;gap:12px;flex-wrap:wrap;">
        <a href="manage_banner.php" class="admin-btn admin-btn-primary"><i class="fas fa-image"></i> Add Banner</a>
        <a href="manage_gallery.php" class="admin-btn admin-btn-primary"><i class="fas fa-upload"></i> Upload Gallery</a>
        <a href="manage_notices.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus"></i> Add Notice</a>
        <a href="manage_events.php" class="admin-btn admin-btn-primary"><i class="fas fa-calendar-plus"></i> Add Event</a>
        <a href="manage_quiz.php" class="admin-btn admin-btn-primary"><i class="fas fa-plus-circle"></i> Add Quiz</a>
        <a href="manage_contact.php" class="admin-btn admin-btn-primary"><i class="fas fa-edit"></i> Edit Contact</a>
    </div>
</div>

<div class="grid-2" style="gap:25px;">
    <!-- Recent Notices -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Recent Notices</h2>
            <a href="manage_notices.php" class="admin-btn admin-btn-info admin-btn-sm">View All</a>
        </div>
        <table class="admin-table">
            <thead><tr><th>Title</th><th>Pinned</th><th>Date</th></tr></thead>
            <tbody>
                <?php if ($recentNotices && $recentNotices->num_rows > 0):
                    while ($n = $recentNotices->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars(substr($n['title'],0,35)); ?><?php echo strlen($n['title'])>35?'...':''; ?></td>
                    <td><?php echo $n['is_pinned'] ? '<span class="badge badge-warning">📌 Yes</span>' : '<span class="badge" style="background:#f0f0f0;color:#666;">No</span>'; ?></td>
                    <td><?php echo date('d M', strtotime($n['created_at'])); ?></td>
                </tr>
                <?php endwhile; else: ?><tr><td colspan="3" style="text-align:center;color:#888;">No notices</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- Recent Events -->
    <div class="admin-card">
        <div class="admin-card-header">
            <h2>Upcoming Events</h2>
            <a href="manage_events.php" class="admin-btn admin-btn-info admin-btn-sm">View All</a>
        </div>
        <table class="admin-table">
            <thead><tr><th>Event</th><th>Date</th><th>Featured</th></tr></thead>
            <tbody>
                <?php if ($recentEvents && $recentEvents->num_rows > 0):
                    while ($e = $recentEvents->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars(substr($e['title'],0,30)); ?>...</td>
                    <td><?php echo date('d M Y', strtotime($e['event_date'])); ?></td>
                    <td><?php echo $e['is_featured'] ? '<span class="badge badge-success">⭐ Yes</span>' : '<span class="badge" style="background:#f0f0f0;color:#666;">No</span>'; ?></td>
                </tr>
                <?php endwhile; else: ?><tr><td colspan="3" style="text-align:center;color:#888;">No events</td></tr><?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

</div><!-- end admin-main -->
<script src="../assets/js/script.js"></script>
</body></html>
