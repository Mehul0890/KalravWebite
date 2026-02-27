<?php
$pageTitle = 'Notices';
require_once 'includes/header.php';
$notices = $conn->query("SELECT * FROM notices ORDER BY is_pinned DESC, created_at DESC");
?>

<div class="page-hero">
    <div class="container">
        <h1>Notice Board</h1>
        <p>Stay informed with the latest school announcements</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Notices</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="grid-2" style="gap:40px;align-items:start;">
            <div>
                <div class="section-badge" style="display:inline-block;margin-bottom:15px;">📌 Pinned Notices</div>
                <div class="notice-board">
                    <?php
                    $conn->data_seek ?? null;
                    $notices->data_seek(0);
                    $hasPinned = false;
                    while ($n = $notices->fetch_assoc()):
                        if (!$n['is_pinned']) continue;
                        $hasPinned = true;
                    ?>
                    <div class="notice-item pinned">
                        <div class="notice-pin">📌</div>
                        <div class="notice-title"><?php echo htmlspecialchars($n['title']); ?></div>
                        <div class="notice-content"><?php echo htmlspecialchars($n['content']); ?></div>
                        <div class="notice-date"><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($n['created_at'])); ?></div>
                    </div>
                    <?php endwhile;
                    if (!$hasPinned): ?>
                    <div class="notice-item"><div class="notice-title">No pinned notices.</div></div>
                    <?php endif; ?>
                </div>
            </div>
            <div>
                <div class="section-badge" style="display:inline-block;margin-bottom:15px;">📋 All Notices</div>
                <div class="notice-board">
                    <?php
                    $notices->data_seek(0);
                    $hasOther = false;
                    while ($n = $notices->fetch_assoc()):
                        if ($n['is_pinned']) continue;
                        $hasOther = true;
                    ?>
                    <div class="notice-item">
                        <div class="notice-title"><?php echo htmlspecialchars($n['title']); ?></div>
                        <div class="notice-content"><?php echo htmlspecialchars($n['content']); ?></div>
                        <div class="notice-date"><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($n['created_at'])); ?></div>
                    </div>
                    <?php endwhile;
                    if (!$hasOther): ?>
                    <div class="notice-item"><div class="notice-title">No other notices.</div></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
