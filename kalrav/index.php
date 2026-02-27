<?php
$pageTitle = 'Home';
require_once 'includes/header.php';

// Banners
$banners = $conn->query("SELECT * FROM banners WHERE is_active=1 ORDER BY sort_order ASC");
$bannerRows = [];
while ($b = $banners->fetch_assoc()) $bannerRows[] = $b;

// Events
$events = $conn->query("SELECT * FROM events ORDER BY event_date DESC LIMIT 3");

// Notices
$notices = $conn->query("SELECT * FROM notices ORDER BY is_pinned DESC, created_at DESC LIMIT 5");

// Contact
$contact = getContactInfo($conn);
?>

<!-- Hero Banner -->
<section class="hero-section">
    <div class="container">
        <div class="banner-slider">
            <?php if (empty($bannerRows)): ?>
            <div class="banner-slide active">
                <div class="banner-content">
                    <div class="banner-text">
                        <div class="banner-badge">🎓 Welcome to Kalrav Vidhya Mandir</div>
                        <h1>Nurturing <span>Minds</span>,<br>Building Futures</h1>
                        <p>A premier educational institution in Gujarat dedicated to holistic development, academic excellence, and cultural values.</p>
                        <div class="banner-buttons">
                            <a href="admissions.php" class="btn-primary"><i class="fas fa-graduation-cap"></i> Apply Now</a>
                            <a href="about.php" class="btn-outline"><i class="fas fa-info-circle"></i> Learn More</a>
                        </div>
                        <div class="banner-stats">
                            <div class="stat-card"><span class="num">1200+</span><span class="label">Students</span></div>
                            <div class="stat-card"><span class="num">80+</span><span class="label">Teachers</span></div>
                            <div class="stat-card"><span class="num">25+</span><span class="label">Years</span></div>
                        </div>
                    </div>
                    <div class="banner-image-area">
                        <div class="banner-placeholder">🏫<p>Kalrav Vidhya Mandir</p></div>
                    </div>
                </div>
            </div>
            <?php else: foreach ($bannerRows as $idx => $banner): ?>
            <div class="banner-slide <?php echo $idx === 0 ? 'active' : ''; ?>">
                <div class="banner-content">
                    <div class="banner-text">
                        <div class="banner-badge">🎓 <?php echo htmlspecialchars($schoolName); ?></div>
                        <h1><?php $parts = explode(',', $banner['title'], 2); echo htmlspecialchars($parts[0]); if (!empty($parts[1])): ?>, <span><?php echo htmlspecialchars($parts[1]); ?></span><?php endif; ?></h1>
                        <p><?php echo htmlspecialchars($banner['subtitle']); ?></p>
                        <div class="banner-buttons">
                            <?php if (!empty($banner['call_form_link'])): ?>
                            <a href="<?php echo htmlspecialchars($banner['call_form_link']); ?>" target="_blank" class="btn-primary"><i class="fas fa-phone-alt"></i> Get a Call</a>
                            <?php endif; ?>
                            <a href="about.php" class="btn-outline"><i class="fas fa-info-circle"></i> Learn More</a>
                        </div>
                        <div class="banner-stats">
                            <div class="stat-card"><span class="num">1200+</span><span class="label">Students</span></div>
                            <div class="stat-card"><span class="num">80+</span><span class="label">Teachers</span></div>
                            <div class="stat-card"><span class="num">25+</span><span class="label">Years</span></div>
                        </div>
                    </div>
                    <div class="banner-image-area">
                        <?php if (!empty($banner['image_path']) && file_exists('uploads/banner/' . $banner['image_path'])): ?>
                        <div class="banner-img-frame">
                            <img src="uploads/banner/<?php echo htmlspecialchars($banner['image_path']); ?>" alt="<?php echo htmlspecialchars($banner['title']); ?>">
                        </div>
                        <?php else: ?>
                        <div class="banner-placeholder">🏫<p><?php echo htmlspecialchars($schoolName); ?></p></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; endif; ?>
        </div>
        <?php if (count($bannerRows) > 1): ?>
        <div class="banner-nav">
            <?php foreach ($bannerRows as $idx => $b): ?>
            <button class="banner-dot <?php echo $idx===0?'active':''; ?>" data-index="<?php echo $idx; ?>"></button>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</section>

<!-- Features / Why Choose Us -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Why Kalrav Vidhya Mandir</div>
            <h2>Excellence in Every Dimension</h2>
            <p>We provide a nurturing environment where students grow academically, morally, and culturally.</p>
            <div class="section-divider"></div>
        </div>
        <div class="grid-4">
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>Quality Curriculum</h3>
                <p>CBSE-aligned curriculum with focus on conceptual learning and practical application.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🏆</div>
                <h3>Award-Winning Faculty</h3>
                <p>Experienced and dedicated teachers committed to every student's success.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🎨</div>
                <h3>Arts & Culture</h3>
                <p>Rich cultural programs celebrating Indian heritage, festivals, and traditions.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">⚽</div>
                <h3>Sports Excellence</h3>
                <p>Modern sports facilities with professional coaching for all major sports.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💻</div>
                <h3>Digital Learning</h3>
                <p>Smart classrooms and computer labs for 21st-century skill development.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🔬</div>
                <h3>Science Labs</h3>
                <p>Well-equipped Physics, Chemistry, and Biology labs for hands-on learning.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🚌</div>
                <h3>Safe Transport</h3>
                <p>GPS-tracked school buses covering all major routes in the city.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">🧘</div>
                <h3>Yoga & Wellness</h3>
                <p>Daily yoga sessions and wellness programs for mind-body balance.</p>
            </div>
        </div>
    </div>
</section>

<!-- Academics Preview + Notice Board -->
<section class="section section-alt">
    <div class="container">
        <div class="grid-2" style="gap:40px;align-items:start;">
            <div>
                <div class="section-header" style="text-align:left;">
                    <div class="section-badge">Academics</div>
                    <h2>Our Academic Programs</h2>
                    <p>From primary to higher secondary, we offer comprehensive education at every level.</p>
                    <div class="section-divider" style="margin:15px 0 0;"></div>
                </div>
                <div style="margin-top:25px;">
                    <div class="card" style="margin-bottom:15px;">
                        <div class="card-body" style="display:flex;align-items:center;gap:15px;">
                            <div style="width:50px;height:50px;background:linear-gradient(135deg,#FFC107,#FF8F00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">🎒</div>
                            <div>
                                <h3 style="margin:0 0 4px;">Primary School (Std 1-5)</h3>
                                <p style="margin:0;font-size:13px;color:#666;">Foundation years with play-based and activity-based learning.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:15px;">
                        <div class="card-body" style="display:flex;align-items:center;gap:15px;">
                            <div style="width:50px;height:50px;background:linear-gradient(135deg,#FFC107,#FF8F00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">📖</div>
                            <div>
                                <h3 style="margin:0 0 4px;">Middle School (Std 6-8)</h3>
                                <p style="margin:0;font-size:13px;color:#666;">Core subject mastery with introduction to advanced concepts.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card" style="margin-bottom:15px;">
                        <div class="card-body" style="display:flex;align-items:center;gap:15px;">
                            <div style="width:50px;height:50px;background:linear-gradient(135deg,#FFC107,#FF8F00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">🔬</div>
                            <div>
                                <h3 style="margin:0 0 4px;">Secondary School (Std 9-10)</h3>
                                <p style="margin:0;font-size:13px;color:#666;">Board exam preparation with expert guidance and coaching.</p>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-body" style="display:flex;align-items:center;gap:15px;">
                            <div style="width:50px;height:50px;background:linear-gradient(135deg,#FFC107,#FF8F00);border-radius:10px;display:flex;align-items:center;justify-content:center;font-size:22px;flex-shrink:0;">🎓</div>
                            <div>
                                <h3 style="margin:0 0 4px;">Higher Secondary (Std 11-12)</h3>
                                <p style="margin:0;font-size:13px;color:#666;">Science & Commerce streams with career counseling.</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div style="margin-top:20px;">
                    <a href="academics.php" class="btn-primary"><i class="fas fa-arrow-right"></i> Explore Academics</a>
                </div>
            </div>

            <!-- Notice Board -->
            <div>
                <div class="section-header" style="text-align:left;">
                    <div class="section-badge">Latest Updates</div>
                    <h2>Notice Board</h2>
                    <div class="section-divider" style="margin:15px 0 0;"></div>
                </div>
                <div style="margin-top:25px;">
                <div class="notice-board">
                    <?php if ($notices && $notices->num_rows > 0):
                        while ($n = $notices->fetch_assoc()): ?>
                    <div class="notice-item <?php echo $n['is_pinned'] ? 'pinned' : ''; ?>">
                        <?php if ($n['is_pinned']): ?><div class="notice-pin">📌</div><?php endif; ?>
                        <div class="notice-title"><?php echo htmlspecialchars($n['title']); ?></div>
                        <div class="notice-content"><?php echo htmlspecialchars(substr($n['content'], 0, 120)); ?><?php echo strlen($n['content']) > 120 ? '...' : ''; ?></div>
                        <div class="notice-date"><i class="fas fa-calendar"></i> <?php echo date('d M Y', strtotime($n['created_at'])); ?></div>
                    </div>
                    <?php endwhile; else: ?>
                    <div class="notice-item"><div class="notice-title">No notices available</div></div>
                    <?php endif; ?>
                </div>
                <div style="margin-top:15px;text-align:right;">
                    <a href="notices.php" class="btn-primary" style="font-size:13px;padding:10px 22px;"><i class="fas fa-list"></i> All Notices</a>
                </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Events Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Events & Activities</div>
            <h2>Upcoming & Recent Events</h2>
            <p>Stay updated with all the exciting events and activities at our school.</p>
            <div class="section-divider"></div>
        </div>
        <div class="grid-3">
            <?php if ($events && $events->num_rows > 0):
                while ($ev = $events->fetch_assoc()):
                    $d = new DateTime($ev['event_date']);
            ?>
            <div class="event-card">
                <div class="event-date-block">
                    <span class="day"><?php echo $d->format('d'); ?></span>
                    <span class="month"><?php echo $d->format('M'); ?></span>
                    <span class="year"><?php echo $d->format('Y'); ?></span>
                </div>
                <div class="event-info">
                    <?php if ($ev['is_featured']): ?><div class="event-featured-badge">⭐ Featured</div><?php endif; ?>
                    <h3><?php echo htmlspecialchars($ev['title']); ?></h3>
                    <p><?php echo htmlspecialchars(substr($ev['description'], 0, 100)); ?>...</p>
                </div>
            </div>
            <?php endwhile; else: ?>
            <div style="grid-column:1/-1;text-align:center;padding:30px;color:#666;">No events available.</div>
            <?php endif; ?>
        </div>
        <div style="text-align:center;margin-top:30px;">
            <a href="events.php" class="btn-primary"><i class="fas fa-calendar-alt"></i> View All Events</a>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <h2>🎓 Admissions Open 2025-26</h2>
        <p>Give your child the best education. Limited seats available. Apply now!</p>
        <?php
        $callBanner = $conn->query("SELECT call_form_link FROM banners WHERE is_active=1 AND call_form_link!='' LIMIT 1");
        $cb = $callBanner ? $callBanner->fetch_assoc() : null;
        $cfLink = $cb ? $cb['call_form_link'] : 'admissions.php';
        ?>
        <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo htmlspecialchars($cfLink); ?>" target="_blank" class="btn-dark"><i class="fas fa-phone-alt"></i> Request a Call Back</a>
            <a href="admissions.php" class="btn-white"><i class="fas fa-file-alt"></i> Apply for Admission</a>
        </div>
    </div>
</section>

<!-- Contact Strip -->
<section class="contact-strip">
    <div class="container">
        <div class="contact-strip-grid">
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-map-marker-alt"></i></div>
                <div>
                    <h4>Our Location</h4>
                    <p><?php echo htmlspecialchars($contact['address'] ?? 'Ahmedabad, Gujarat'); ?></p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-phone"></i></div>
                <div>
                    <h4>Call Us</h4>
                    <p><?php echo htmlspecialchars($contact['phone'] ?? '+91 79 1234 5678'); ?></p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-envelope"></i></div>
                <div>
                    <h4>Email Us</h4>
                    <p><?php echo htmlspecialchars($contact['email'] ?? 'info@kalravvidyamandir.edu.in'); ?></p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon"><i class="fas fa-clock"></i></div>
                <div>
                    <h4>School Hours</h4>
                    <p>Mon – Sat: 8:00 AM – 4:00 PM</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
