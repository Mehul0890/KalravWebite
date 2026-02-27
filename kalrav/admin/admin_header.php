<?php
$currentAdminPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($adminTitle) ? htmlspecialchars($adminTitle) . ' – ' : ''; ?>Admin Panel | Kalrav Vidhya Mandir</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="admin-body">

<aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
        <div style="display:flex;align-items:center;gap:10px;">
            <div style="width:38px;height:38px;background:linear-gradient(135deg,#FFC107,#FF8F00);border-radius:50%;display:flex;align-items:center;justify-content:center;font-weight:800;color:#1a1a2e;font-size:16px;">K</div>
            <div>
                <h2>Kalrav Admin</h2>
                <span>Logged in as <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
            </div>
        </div>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="<?php echo $currentAdminPage==='dashboard.php'?'active':''; ?>">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
        <hr class="sidebar-divider">
        <a href="manage_banner.php" class="<?php echo $currentAdminPage==='manage_banner.php'?'active':''; ?>">
            <i class="fas fa-image"></i> Manage Banners
        </a>
        <a href="manage_gallery.php" class="<?php echo $currentAdminPage==='manage_gallery.php'?'active':''; ?>">
            <i class="fas fa-photo-video"></i> Manage Gallery
        </a>
        <a href="manage_notices.php" class="<?php echo $currentAdminPage==='manage_notices.php'?'active':''; ?>">
            <i class="fas fa-bullhorn"></i> Manage Notices
        </a>
        <a href="manage_events.php" class="<?php echo $currentAdminPage==='manage_events.php'?'active':''; ?>">
            <i class="fas fa-calendar-alt"></i> Manage Events
        </a>
        <a href="manage_quiz.php" class="<?php echo $currentAdminPage==='manage_quiz.php'?'active':''; ?>">
            <i class="fas fa-question-circle"></i> Manage Quiz
        </a>
        <a href="manage_contact.php" class="<?php echo $currentAdminPage==='manage_contact.php'?'active':''; ?>">
            <i class="fas fa-address-book"></i> Contact Info
        </a>
        <hr class="sidebar-divider">
        <a href="../index.php" target="_blank">
            <i class="fas fa-external-link-alt"></i> View Website
        </a>
        <a href="logout.php" style="color:rgba(255,100,100,0.8);">
            <i class="fas fa-sign-out-alt"></i> Logout
        </a>
    </nav>
</aside>

<div class="admin-main">
    <div class="admin-topbar">
        <div style="display:flex;align-items:center;gap:15px;">
            <button onclick="toggleSidebar()" style="border:none;background:none;cursor:pointer;font-size:20px;color:#333;display:none;" id="sidebarBtn"><i class="fas fa-bars"></i></button>
            <h1><?php echo isset($adminTitle) ? htmlspecialchars($adminTitle) : 'Dashboard'; ?></h1>
        </div>
        <div class="admin-user">
            <div class="admin-avatar">A</div>
            <span><?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?></span>
            <a href="logout.php" style="color:#c62828;text-decoration:none;margin-left:10px;font-size:13px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </div>
