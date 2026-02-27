<?php
$contact = getContactInfo($conn);
?>
<!-- Footer -->
<footer class="main-footer">
    <div class="container">
        <div class="footer-grid">
            <div class="footer-brand">
                <h3><?php echo htmlspecialchars($contact['school_name'] ?? 'Kalrav Vidhya Mandir'); ?></h3>
                <p>Dedicated to providing quality education and shaping the future leaders of India. Our holistic approach nurtures academic excellence, moral values, and cultural pride.</p>
                <div class="footer-social">
                    <?php if (!empty($contact['facebook_url'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['facebook_url']); ?>" target="_blank"><i class="fab fa-facebook-f"></i></a>
                    <?php else: ?><a href="#"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                    <?php if (!empty($contact['instagram_url'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['instagram_url']); ?>" target="_blank"><i class="fab fa-instagram"></i></a>
                    <?php else: ?><a href="#"><i class="fab fa-instagram"></i></a><?php endif; ?>
                    <?php if (!empty($contact['youtube_url'])): ?>
                    <a href="<?php echo htmlspecialchars($contact['youtube_url']); ?>" target="_blank"><i class="fab fa-youtube"></i></a>
                    <?php else: ?><a href="#"><i class="fab fa-youtube"></i></a><?php endif; ?>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
            <div class="footer-col">
                <h4>Quick Links</h4>
                <ul class="footer-links">
                    <li><a href="index.php"><i class="fas fa-chevron-right"></i> Home</a></li>
                    <li><a href="about.php"><i class="fas fa-chevron-right"></i> About Us</a></li>
                    <li><a href="academics.php"><i class="fas fa-chevron-right"></i> Academics</a></li>
                    <li><a href="gallery.php"><i class="fas fa-chevron-right"></i> Gallery</a></li>
                    <li><a href="notices.php"><i class="fas fa-chevron-right"></i> Notices</a></li>
                    <li><a href="events.php"><i class="fas fa-chevron-right"></i> Events</a></li>
                    <li><a href="admissions.php"><i class="fas fa-chevron-right"></i> Admissions</a></li>
                    <li><a href="quiz.php"><i class="fas fa-chevron-right"></i> Quiz</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Academics</h4>
                <ul class="footer-links">
                    <li><a href="academics.php"><i class="fas fa-chevron-right"></i> Primary School</a></li>
                    <li><a href="academics.php"><i class="fas fa-chevron-right"></i> Middle School</a></li>
                    <li><a href="academics.php"><i class="fas fa-chevron-right"></i> High School</a></li>
                    <li><a href="academics.php"><i class="fas fa-chevron-right"></i> Science Stream</a></li>
                    <li><a href="academics.php"><i class="fas fa-chevron-right"></i> Commerce Stream</a></li>
                    <li><a href="admissions.php"><i class="fas fa-chevron-right"></i> Admission Process</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h4>Contact Info</h4>
                <div class="footer-contact-item">
                    <i class="fas fa-map-marker-alt"></i>
                    <span><?php echo htmlspecialchars($contact['address'] ?? 'Ahmedabad, Gujarat, India'); ?></span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-phone"></i>
                    <span><?php echo htmlspecialchars($contact['phone'] ?? '+91 79 1234 5678'); ?></span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-envelope"></i>
                    <span><?php echo htmlspecialchars($contact['email'] ?? 'info@kalravvidyamandir.edu.in'); ?></span>
                </div>
                <div class="footer-contact-item">
                    <i class="fas fa-clock"></i>
                    <span>Mon - Sat: 8:00 AM – 4:00 PM</span>
                </div>
            </div>
        </div>
    </div>
    <div style="background:rgba(0,0,0,0.2);">
        <div class="container">
            <div class="footer-bottom">
                <span>&copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($contact['school_name'] ?? 'Kalrav Vidhya Mandir'); ?>. All rights reserved.</span>
                <span>Made with ❤️ in Gujarat, India</span>
            </div>
        </div>
    </div>
</footer>

<script src="<?php echo str_repeat('../', substr_count($_SERVER['PHP_SELF'], '/', strlen($_SERVER['DOCUMENT_ROOT']))-1); ?>assets/js/script.js"></script>
</body>
</html>
