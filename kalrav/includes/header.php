<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/db.php';
$contact = getContactInfo($conn);
$schoolName = $contact['school_name'] ?? 'Kalrav Vidhya Mandir';
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) . ' | ' : ''; ?><?php echo htmlspecialchars($schoolName); ?></title>
    <meta name="description" content="<?php echo htmlspecialchars($schoolName); ?> - Quality education in Gujarat, India. Nurturing minds and building futures.">
    <link rel="stylesheet" href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/', strlen($_SERVER['DOCUMENT_ROOT']))-1); ?>assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/x-icon" href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/', strlen($_SERVER['DOCUMENT_ROOT']))-1); ?>assets/images/favicon.ico">
</head>
<body>

<!-- Top Bar -->
<div class="top-bar">
    <div class="container">
        <div class="top-contact">
            <span><i class="fas fa-phone"></i><?php echo htmlspecialchars($contact['phone'] ?? '+91 79 1234 5678'); ?></span>
            <span><i class="fas fa-envelope"></i><?php echo htmlspecialchars($contact['email'] ?? 'info@kalravvidyamandir.edu.in'); ?></span>
        </div>
        <div class="top-social">
            <?php if (!empty($contact['facebook_url'])): ?>
            <a href="<?php echo htmlspecialchars($contact['facebook_url']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
            <?php endif; ?>
            <?php if (!empty($contact['instagram_url'])): ?>
            <a href="<?php echo htmlspecialchars($contact['instagram_url']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
            <?php endif; ?>
            <?php if (!empty($contact['youtube_url'])): ?>
            <a href="<?php echo htmlspecialchars($contact['youtube_url']); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
            <?php endif; ?>
            <a href="admin/login.php"><i class="fas fa-lock"></i></a>
        </div>
    </div>
</div>

<!-- Main Header -->
<header class="main-header">
    <div class="container">
        <div class="header-inner">
            <a href="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/', strlen($_SERVER['DOCUMENT_ROOT']))-1); ?>index.php" class="logo-area">
                <div class="logo-icon">K</div>
                <div class="logo-text">
                    <h1><?php echo htmlspecialchars($schoolName); ?></h1>
                    <span>Gujarat, India | Est. 2000</span>
                </div>
            </a>

            <button class="nav-toggle" aria-label="Toggle navigation">
                <span></span><span></span><span></span>
            </button>

            <nav class="main-nav">
                <?php
                $base = str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/', strlen($_SERVER['DOCUMENT_ROOT']))-1);
                ?>
                <a href="<?php echo $base; ?>index.php" class="<?php echo $currentPage=='index.php'?'active':''; ?>">Home</a>
                <a href="<?php echo $base; ?>about.php" class="<?php echo $currentPage=='about.php'?'active':''; ?>">About</a>
                <a href="<?php echo $base; ?>academics.php" class="<?php echo $currentPage=='academics.php'?'active':''; ?>">Academics</a>
                <a href="<?php echo $base; ?>gallery.php" class="<?php echo $currentPage=='gallery.php'?'active':''; ?>">Gallery</a>
                <a href="<?php echo $base; ?>contact.php" class="<?php echo $currentPage=='contact.php'?'active':''; ?>">Contact</a>
                <?php
                $callLink = $conn->query("SELECT call_form_link FROM banners WHERE is_active=1 AND call_form_link!='' LIMIT 1");
                $callRow = $callLink ? $callLink->fetch_assoc() : null;
                $formLink = $callRow ? $callRow['call_form_link'] : '#';
                ?>
                <a href="<?php echo htmlspecialchars($formLink); ?>" target="_blank" class="nav-cta"><i class="fas fa-phone-alt"></i> Get a Call</a>
            </nav>
        </div>
    </div>
</header>
