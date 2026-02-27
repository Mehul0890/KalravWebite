<?php
$pageTitle = 'Events';
require_once 'includes/header.php';
$events = $conn->query("SELECT * FROM events ORDER BY event_date DESC");
?>

<div class="page-hero">
    <div class="container">
        <h1>Events & Activities</h1>
        <p>Celebrating learning, culture, and achievement together</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Events</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">School Life</div>
            <h2>Our Events</h2>
            <p>From science fairs to cultural celebrations — there's always something exciting happening at Kalrav.</p>
            <div class="section-divider"></div>
        </div>
        <div style="display:grid;gap:20px;">
            <?php if ($events && $events->num_rows > 0):
                while ($ev = $events->fetch_assoc()):
                    $d = new DateTime($ev['event_date']);
            ?>
            <div class="event-card" style="max-width:800px;margin:0 auto;width:100%;">
                <div class="event-date-block">
                    <span class="day"><?php echo $d->format('d'); ?></span>
                    <span class="month"><?php echo $d->format('M'); ?></span>
                    <span class="year"><?php echo $d->format('Y'); ?></span>
                </div>
                <div class="event-info" style="padding:22px;">
                    <?php if ($ev['is_featured']): ?><div class="event-featured-badge">⭐ Featured Event</div><?php endif; ?>
                    <h3 style="font-size:18px;"><?php echo htmlspecialchars($ev['title']); ?></h3>
                    <p style="font-size:14px;"><?php echo htmlspecialchars($ev['description']); ?></p>
                    <div style="margin-top:10px;font-size:13px;color:#888;"><i class="fas fa-calendar" style="color:#FFC107;margin-right:5px;"></i><?php echo $d->format('l, d F Y'); ?></div>
                </div>
            </div>
            <?php endwhile; else: ?>
            <div style="text-align:center;padding:50px;color:#666;">
                <div style="font-size:60px;margin-bottom:15px;">📅</div>
                <h3>No events found.</h3>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
