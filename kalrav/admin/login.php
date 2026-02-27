<?php
session_start();
require_once '../includes/db.php';

if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    
    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM admins WHERE username=?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: dashboard.php');
            exit;
        } else {
            $error = 'Invalid username or password. Please try again.';
        }
    } else {
        $error = 'Please enter both username and password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login – Kalrav Vidhya Mandir</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
<div class="admin-login-page">
    <div class="login-card">
        <div class="login-logo">
            <div class="login-logo-icon">K</div>
            <h2>Kalrav Vidhya Mandir</h2>
            <p>Admin Panel — Secure Login</p>
        </div>
        <?php if ($error): ?>
        <div class="alert alert-error"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label><i class="fas fa-user" style="color:#FFC107;margin-right:6px;"></i> Username</label>
                <input type="text" name="username" placeholder="Enter admin username" required autocomplete="username" value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label><i class="fas fa-lock" style="color:#FFC107;margin-right:6px;"></i> Password</label>
                <input type="password" name="password" placeholder="Enter password" required autocomplete="current-password">
            </div>
            <button type="submit" class="btn-primary" style="width:100%;justify-content:center;margin-top:5px;font-size:15px;padding:14px;">
                <i class="fas fa-sign-in-alt"></i> Login to Admin Panel
            </button>
        </form>
        <div style="text-align:center;margin-top:20px;">
            <a href="../index.php" style="color:#888;font-size:13px;text-decoration:none;"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</div>
</body>
</html>
