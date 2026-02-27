<?php
require_once 'auth_check.php';
$adminTitle = 'Contact Info';
$msg = ''; $msgType = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_contact'])) {
    $name = sanitize($conn, $_POST['school_name']);
    $addr = sanitize($conn, $_POST['address']);
    $phone = sanitize($conn, $_POST['phone']);
    $email = sanitize($conn, $_POST['email']);
    $map = $conn->real_escape_string($_POST['google_map_embed'] ?? '');
    $fb = sanitize($conn, $_POST['facebook_url']);
    $ig = sanitize($conn, $_POST['instagram_url']);
    $yt = sanitize($conn, $_POST['youtube_url']);

    $check = $conn->query("SELECT id FROM contact_info LIMIT 1")->fetch_assoc();
    if ($check) {
        $conn->query("UPDATE contact_info SET school_name='$name', address='$addr', phone='$phone', email='$email', google_map_embed='$map', facebook_url='$fb', instagram_url='$ig', youtube_url='$yt' WHERE id={$check['id']}");
    } else {
        $conn->query("INSERT INTO contact_info (school_name, address, phone, email, google_map_embed, facebook_url, instagram_url, youtube_url) VALUES ('$name','$addr','$phone','$email','$map','$fb','$ig','$yt')");
    }
    $msg = 'Contact information updated successfully!'; $msgType = 'success';
}

$contact = getContactInfo($conn);
require_once 'admin_header.php';
?>

<?php if ($msg): ?><div class="alert alert-<?php echo $msgType; ?>"><?php echo htmlspecialchars($msg); ?></div><?php endif; ?>

<div class="admin-form-card">
    <h2><i class="fas fa-address-book" style="color:#FFC107;"></i> Update Contact Information</h2>
    <form method="POST">
        <div class="form-row">
            <div class="form-group">
                <label>School Name</label>
                <input type="text" name="school_name" value="<?php echo htmlspecialchars($contact['school_name'] ?? ''); ?>" placeholder="School name">
            </div>
            <div class="form-group">
                <label>Phone Number</label>
                <input type="text" name="phone" value="<?php echo htmlspecialchars($contact['phone'] ?? ''); ?>" placeholder="+91 ...">
            </div>
        </div>
        <div class="form-group">
            <label>Email Address</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($contact['email'] ?? ''); ?>" placeholder="info@school.com">
        </div>
        <div class="form-group">
            <label>Full Address</label>
            <textarea name="address" rows="3" placeholder="Complete school address..."><?php echo htmlspecialchars($contact['address'] ?? ''); ?></textarea>
        </div>
        <div class="form-group">
            <label>Google Maps Embed Code <small style="color:#888;">(paste full iframe from Google Maps → Share → Embed)</small></label>
            <textarea name="google_map_embed" rows="4" placeholder='&lt;iframe src="https://maps.google.com/..." ...&gt;&lt;/iframe&gt;'><?php echo htmlspecialchars($contact['google_map_embed'] ?? ''); ?></textarea>
        </div>
        <div style="font-weight:600;font-size:14px;margin:15px 0 10px;color:#1a1a2e;">🔗 Social Media Links (optional)</div>
        <div class="form-row">
            <div class="form-group">
                <label><i class="fab fa-facebook" style="color:#1877f2;"></i> Facebook URL</label>
                <input type="url" name="facebook_url" value="<?php echo htmlspecialchars($contact['facebook_url'] ?? ''); ?>" placeholder="https://facebook.com/...">
            </div>
            <div class="form-group">
                <label><i class="fab fa-instagram" style="color:#e4405f;"></i> Instagram URL</label>
                <input type="url" name="instagram_url" value="<?php echo htmlspecialchars($contact['instagram_url'] ?? ''); ?>" placeholder="https://instagram.com/...">
            </div>
        </div>
        <div class="form-group" style="max-width:50%;">
            <label><i class="fab fa-youtube" style="color:#ff0000;"></i> YouTube URL</label>
            <input type="url" name="youtube_url" value="<?php echo htmlspecialchars($contact['youtube_url'] ?? ''); ?>" placeholder="https://youtube.com/...">
        </div>
        <button type="submit" name="update_contact" class="admin-btn admin-btn-primary"><i class="fas fa-save"></i> Save Changes</button>
    </form>
</div>

<!-- Preview -->
<div class="admin-card">
    <div class="admin-card-header"><h2>Current Contact Info Preview</h2></div>
    <div style="padding:25px;">
        <div class="contact-strip-grid" style="grid-template-columns:repeat(2,1fr);">
            <div class="contact-item" style="background:#f8f9fa;border-radius:12px;padding:20px;">
                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div><h4>Address</h4><p><?php echo htmlspecialchars($contact['address'] ?? 'Not set'); ?></p></div>
            </div>
            <div class="contact-item" style="background:#f8f9fa;border-radius:12px;padding:20px;">
                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                <div><h4>Phone</h4><p><?php echo htmlspecialchars($contact['phone'] ?? 'Not set'); ?></p></div>
            </div>
            <div class="contact-item" style="background:#f8f9fa;border-radius:12px;padding:20px;">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <div><h4>Email</h4><p><?php echo htmlspecialchars($contact['email'] ?? 'Not set'); ?></p></div>
            </div>
            <div class="contact-item" style="background:#f8f9fa;border-radius:12px;padding:20px;">
                <div class="contact-icon"><i class="fab fa-facebook-f"></i></div>
                <div><h4>Social Media</h4><p><?php echo !empty($contact['facebook_url'])||!empty($contact['instagram_url']) ? 'Configured' : 'Not set'; ?></p></div>
            </div>
        </div>
    </div>
</div>

</div><script src="../assets/js/script.js"></script></body></html>
