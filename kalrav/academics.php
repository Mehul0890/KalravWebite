<?php
$pageTitle = 'Academics';
require_once 'includes/header.php';
?>

<div class="page-hero">
    <div class="container">
        <h1>Academics</h1>
        <p>Comprehensive education from primary to higher secondary level</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Academics</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Our Programs</div>
            <h2>Academic Structure</h2>
            <p>We follow the CBSE curriculum enhanced with our own enrichment programs.</p>
            <div class="section-divider"></div>
        </div>
        <div class="grid-2" style="gap:30px;margin-bottom:30px;">
            <?php
            $programs = [
                ['title'=>'Primary School (Std 1–5)','icon'=>'🎒','color'=>'#FFF3CD',
                 'desc'=>'The foundation years where we instill a love for learning through activity-based education, storytelling, art, and play.',
                 'subjects'=>['Mathematics','English','Gujarati','Hindi','Environmental Science','Arts & Crafts']],
                ['title'=>'Middle School (Std 6–8)','icon'=>'📚','color'=>'#E3F2FD',
                 'desc'=>'Transitional years that build subject depth, critical thinking, and independent learning skills.',
                 'subjects'=>['Mathematics','Science','Social Studies','English','Hindi/Sanskrit','Computer Science']],
                ['title'=>'Secondary School (Std 9–10)','icon'=>'🔬','color'=>'#E8F5E9',
                 'desc'=>'Board examination preparation with intensive coaching, doubt-clearing sessions, and mock tests.',
                 'subjects'=>['Mathematics','Science','Social Science','English','Second Language','Information Technology']],
                ['title'=>'Higher Secondary (Std 11–12)','icon'=>'🎓','color'=>'#FCE4EC',
                 'desc'=>'Specialized streams of Science and Commerce with career guidance and competitive exam preparation.',
                 'subjects'=>['Physics/Accountancy','Chemistry/Business Studies','Biology/Economics','Mathematics','English','Computer Science']],
            ];
            foreach ($programs as $p): ?>
            <div class="card">
                <div class="card-body" style="padding:25px;">
                    <div style="display:flex;align-items:center;gap:15px;margin-bottom:15px;">
                        <div style="width:55px;height:55px;background:<?php echo $p['color']; ?>;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:26px;flex-shrink:0;"><?php echo $p['icon']; ?></div>
                        <h3 style="margin:0;font-size:17px;"><?php echo $p['title']; ?></h3>
                    </div>
                    <p style="color:#666;font-size:14px;line-height:1.6;margin-bottom:15px;"><?php echo $p['desc']; ?></p>
                    <div style="display:flex;flex-wrap:wrap;gap:6px;">
                        <?php foreach ($p['subjects'] as $s): ?>
                        <span style="background:#f0f2f5;padding:4px 12px;border-radius:50px;font-size:12px;font-weight:500;color:#444;"><?php echo $s; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Subjects We Offer</div>
            <h2>Core & Elective Subjects</h2>
            <div class="section-divider"></div>
        </div>
        <div class="subject-grid">
            <?php
            $subjects = [
                ['icon'=>'🔢','name'=>'Mathematics','desc'=>'From arithmetic to calculus — building strong number skills.'],
                ['icon'=>'🔬','name'=>'Science','desc'=>'Physics, Chemistry, and Biology with practical lab sessions.'],
                ['icon'=>'📖','name'=>'English','desc'=>'Language mastery, literature, and communication skills.'],
                ['icon'=>'💻','name'=>'Computer Science','desc'=>'Programming, AI basics, and digital literacy.'],
                ['icon'=>'🌍','name'=>'Social Studies','desc'=>'History, Geography, Civics, and Economics.'],
                ['icon'=>'🎭','name'=>'Arts & Culture','desc'=>'Drawing, music, dance, and performing arts.'],
                ['icon'=>'🏃','name'=>'Physical Education','desc'=>'Sports, yoga, fitness, and health education.'],
                ['icon'=>'🕉️','name'=>'Hindi/Sanskrit','desc'=>'Indian language education and literature.'],
                ['icon'=>'🗣️','name'=>'Gujarati','desc'=>'Mother tongue literacy and literature.'],
            ];
            foreach ($subjects as $s): ?>
            <div class="subject-card">
                <span class="subject-icon"><?php echo $s['icon']; ?></span>
                <h3><?php echo $s['name']; ?></h3>
                <p><?php echo $s['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">Beyond Textbooks</div>
            <h2>Co-Curricular Activities</h2>
            <div class="section-divider"></div>
        </div>
        <div class="grid-4">
            <?php
            $activities = [
                ['icon'=>'🎨','name'=>'Fine Arts Club'],['icon'=>'🎵','name'=>'Music Band'],
                ['icon'=>'🏏','name'=>'Cricket Team'],['icon'=>'🎭','name'=>'Drama Club'],
                ['icon'=>'📰','name'=>'School Magazine'],['icon'=>'🌱','name'=>'Eco Club'],
                ['icon'=>'🤝','name'=>'Student Council'],['icon'=>'🏆','name'=>'Debate Society'],
            ];
            foreach ($activities as $a): ?>
            <div class="feature-card" style="padding:22px;">
                <div class="feature-icon" style="font-size:30px;"><?php echo $a['icon']; ?></div>
                <h3 style="font-size:15px;"><?php echo $a['name']; ?></h3>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Discover Our Academic Excellence</h2>
        <p>Ready to give your child the best academic foundation? Apply now.</p>
        <a href="admissions.php" class="btn-dark"><i class="fas fa-file-alt"></i> Apply for Admission</a>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
