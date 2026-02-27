<?php
// Run this once: http://localhost/kalrav/setup_password.php
// It will update the admin password to @Adminkalrav9900
require_once 'includes/db.php';

$username = '@Kalrav550';
$password = '@Adminkalrav9900';
$hash = password_hash($password, PASSWORD_DEFAULT);

// Check if admin exists
$check = $conn->query("SELECT id FROM admins WHERE username='@Kalrav550'")->fetch_assoc();
if ($check) {
    $stmt = $conn->prepare("UPDATE admins SET password=? WHERE username=?");
    $stmt->bind_param("ss", $hash, $username);
} else {
    $stmt = $conn->prepare("INSERT INTO admins (username, password) VALUES (?,?)");
    $stmt->bind_param("ss", $username, $hash);
}

if ($stmt->execute()) {
    echo '<div style="font-family:sans-serif;max-width:500px;margin:80px auto;background:#e8f5e9;padding:30px;border-radius:12px;border:1px solid #a5d6a7;">';
    echo '<h2>✅ Admin Password Set Successfully!</h2>';
    echo '<p><strong>Username:</strong> @Kalrav550</p>';
    echo '<p><strong>Password:</strong> @Adminkalrav9900</p>';
    echo '<p><a href="admin/login.php" style="background:#FFC107;color:#1a1a2e;padding:10px 25px;border-radius:8px;text-decoration:none;font-weight:700;">Go to Admin Login →</a></p>';
    echo '<p style="color:#888;font-size:12px;margin-top:15px;">⚠️ Delete this file after setup for security.</p>';
    echo '</div>';
} else {
    echo '<div style="font-family:sans-serif;max-width:500px;margin:80px auto;background:#ffebee;padding:30px;border-radius:12px;">';
    echo '<h2>❌ Error</h2><p>' . $conn->error . '</p>';
    echo '</div>';
}
?>
