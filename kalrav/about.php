<?php
$pageTitle = 'About Us';
require_once 'includes/header.php';
?>

<div class="page-hero">
    <div class="container">
        <h1>About Us</h1>
        <p>Learn about our journey, vision, and the values that guide us</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>About</span></div>
    </div>
</div>

<!-- About School -->
<section class="section">
    <div class="container">
        <div class="grid-2" style="align-items:center;gap:50px;">
            <div>
                <div class="about-img-placeholder">🏫</div>
            </div>
            <div>
                <div class="section-badge">Our Story</div>
                <h2 style="font-family:'Playfair Display',serif;font-size:34px;margin:10px 0 15px;color:#1a1a2e;">A Legacy of Excellence in Education</h2>
                <p style="color:#666;line-height:1.8;margin-bottom:15px;">Kalrav Vidhya Mandir was established with the vision to provide quality, value-based education to children of Gujarat. Over the years, we have grown into one of the most trusted educational institutions in the region.</p>
                <p style="color:#666;line-height:1.8;margin-bottom:20px;">Our institution believes in nurturing the complete personality of each student — academically, physically, morally, and spiritually. We take pride in our rich cultural traditions and modern teaching methodologies.</p>
                <ul class="value-list">
                    <li>CBSE-affiliated curriculum with modern pedagogy</li>
                    <li>State-of-the-art infrastructure and facilities</li>
                    <li>Experienced and qualified teaching staff</li>
                    <li>Strong emphasis on Indian values and culture</li>
                    <li>Regular parent-teacher engagement programs</li>
                    <li>Awards for academic and co-curricular excellence</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<!-- Mission & Vision -->
<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Mission & Vision</div>
            <h2>What Drives Us</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid-3">
            <div class="feature-card">
                <div class="feature-icon">🎯</div>
                <h3>Our Mission</h3>
                <p>To provide affordable, quality education that develops intellect, character, and compassion in every student — preparing them for a bright future.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">👁️</div>
                <h3>Our Vision</h3>
                <p>To be the leading educational institution in Gujarat, recognized for academic excellence, innovation, and holistic student development.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">💎</div>
                <h3>Our Values</h3>
                <p>Integrity, excellence, respect, creativity, and a deep reverence for Indian culture and heritage guide everything we do.</p>
            </div>
        </div>
    </div>
</section>

<!-- School Stats -->
<section class="section section-dark">
    <div class="container">
        <div class="section-header">
            <div class="section-badge" style="background:rgba(255,193,7,0.2);border-color:rgba(255,193,7,0.4);">Our Achievements</div>
            <h2>Numbers That Speak</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid-4">
            <?php
            $stats = [
                ['num'=>'1200+','label'=>'Happy Students','icon'=>'👨‍🎓'],
                ['num'=>'80+','label'=>'Qualified Teachers','icon'=>'👩‍🏫'],
                ['num'=>'25+','label'=>'Years of Excellence','icon'=>'🏆'],
                ['num'=>'98%','label'=>'Board Pass Rate','icon'=>'📊'],
            ];
            foreach ($stats as $s): ?>
            <div class="stat-card" style="background:rgba(255,255,255,0.05);border-color:rgba(255,193,7,0.2);padding:30px;text-align:center;">
                <div style="font-size:40px;margin-bottom:12px;"><?php echo $s['icon']; ?></div>
                <div class="num" style="font-size:36px;font-weight:800;color:#FFC107;display:block;"><?php echo $s['num']; ?></div>
                <div class="label" style="color:rgba(255,255,255,0.7);margin-top:6px;font-size:14px;"><?php echo $s['label']; ?></div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Faculty Section -->
<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Our Team</div>
            <h2>Meet Our Leadership</h2>
            <p>Dedicated educators and administrators committed to your child's growth.</p>
            <div class="section-divider"></div>
        </div>
        <div class="grid-3">
            <?php
            $faculty = [
                ['name'=>'Dr. Ramesh Patel','role'=>'Principal','icon'=>'👨‍💼','desc'=>'25 years of experience in education. PhD in Educational Administration.'],
                ['name'=>'Mrs. Sunita Shah','role'=>'Vice Principal','icon'=>'👩‍💼','desc'=>'20 years experience. Specializes in curriculum development and student welfare.'],
                ['name'=>'Mr. Vikram Mehta','role'=>'Head of Academics','icon'=>'👨‍🏫','desc'=>'Expert in CBSE curriculum with 18 years of teaching excellence.'],
            ];
            foreach ($faculty as $f): ?>
            <div class="feature-card" style="text-align:left;display:flex;align-items:center;gap:15px;padding:22px;">
                <div class="feature-icon" style="font-size:36px;margin:0;flex-shrink:0;"><?php echo $f['icon']; ?></div>
                <div>
                    <h3 style="margin:0 0 4px;"><?php echo $f['name']; ?></h3>
                    <div style="color:#FF8F00;font-size:13px;font-weight:600;margin-bottom:6px;"><?php echo $f['role']; ?></div>
                    <p style="font-size:13px;"><?php echo $f['desc']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <div class="container">
        <h2>Join the Kalrav Family</h2>
        <p>Be part of our journey towards excellence. Admissions open for 2025-26.</p>
        <a href="admissions.php" class="btn-dark"><i class="fas fa-graduation-cap"></i> Apply Now</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
