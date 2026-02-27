<?php
$pageTitle = 'Contact';
require_once 'includes/header.php';
$contact = getContactInfo($conn);
$msg = '';
$msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['send_message'])) {
    $name = sanitize($conn, $_POST['name'] ?? '');
    $email = sanitize($conn, $_POST['email'] ?? '');
    $phone = sanitize($conn, $_POST['phone'] ?? '');
    $subject = sanitize($conn, $_POST['subject'] ?? '');
    $message = sanitize($conn, $_POST['message'] ?? '');
    if ($name && $email && $message) {
        // For demo: just show success (in real setup, use mail() or store in DB)
        $msg = "Thank you, {$name}! Your message has been received. We will get back to you soon.";
        $msgType = 'success';
    } else {
        $msg = 'Please fill in all required fields.';
        $msgType = 'error';
    }
}
?>

<div class="page-hero">
    <div class="container">
        <h1>Contact Us</h1>
        <p>We'd love to hear from you. Reach out to us anytime.</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Contact</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- Contact Info Cards -->
        <div class="grid-4" style="margin-bottom:50px;">
            <div class="feature-card">
                <div class="feature-icon">📍</div>
                <h3>Address</h3>
                <p style="font-size:13px;"><?php echo htmlspecialchars($contact['address'] ?? 'Ahmedabad, Gujarat, India'); ?></p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📞</div>
                <h3>Phone</h3>
                <p style="font-size:13px;"><a href="tel:<?php echo htmlspecialchars($contact['phone'] ?? ''); ?>" style="color:#FF8F00;text-decoration:none;"><?php echo htmlspecialchars($contact['phone'] ?? '+91 79 1234 5678'); ?></a></p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📧</div>
                <h3>Email</h3>
                <p style="font-size:13px;"><a href="mailto:<?php echo htmlspecialchars($contact['email'] ?? ''); ?>" style="color:#FF8F00;text-decoration:none;"><?php echo htmlspecialchars($contact['email'] ?? 'info@kalravvidyamandir.edu.in'); ?></a></p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⏰</div>
                <h3>School Hours</h3>
                <p style="font-size:13px;">Mon – Sat<br>8:00 AM – 4:00 PM</p>
            </div>
        </div>

        <div class="grid-2" style="gap:40px;align-items:start;">
            <!-- Contact Form -->
            <div>
                <div class="contact-form-wrap">
                    <h2 style="font-family:'Playfair Display',serif;font-size:26px;margin-bottom:5px;">Send Us a Message</h2>
                    <p style="color:#666;font-size:14px;margin-bottom:25px;">We typically respond within 1 business day.</p>
                    <?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>
                    <form method="POST">
                        <div class="form-row">
                            <div class="form-group">
                                <label>Full Name *</label>
                                <input type="text" name="name" placeholder="Your full name" required>
                            </div>
                            <div class="form-group">
                                <label>Phone Number</label>
                                <input type="tel" name="phone" placeholder="+91 XXXXX XXXXX">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Email Address *</label>
                            <input type="email" name="email" placeholder="your@email.com" required>
                        </div>
                        <div class="form-group">
                            <label>Subject</label>
                            <input type="text" name="subject" placeholder="What is this regarding?">
                        </div>
                        <div class="form-group">
                            <label>Message *</label>
                            <textarea name="message" placeholder="Write your message here..." required></textarea>
                        </div>
                        <button type="submit" name="send_message" class="btn-primary" style="width:100%;justify-content:center;">
                            <i class="fas fa-paper-plane"></i> Send Message
                        </button>
                    </form>
                </div>
            </div>

            <!-- Map -->
            <div>
                <div class="contact-form-wrap" style="padding:0;overflow:hidden;">
                    <div style="padding:20px 25px 15px;border-bottom:1px solid #eee;">
                        <h3 style="font-size:18px;font-weight:700;">Find Us on Map</h3>
                        <p style="color:#666;font-size:13px;margin-top:4px;"><?php echo htmlspecialchars($contact['address'] ?? ''); ?></p>
                    </div>
                    <?php if (!empty($contact['google_map_embed'])): ?>
                    <div style="line-height:0;">
                        <?php echo $contact['google_map_embed']; ?>
                    </div>
                    <?php else: ?>
                    <div style="height:300px;background:linear-gradient(135deg,#fff3cd,#FFC107);display:flex;align-items:center;justify-content:center;font-size:60px;">🗺️</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
