<?php
$pageTitle = 'Admissions';
require_once 'includes/header.php';
$contact = getContactInfo($conn);
$callLink = $conn->query("SELECT call_form_link FROM banners WHERE is_active=1 AND call_form_link!='' LIMIT 1");
$cr = $callLink ? $callLink->fetch_assoc() : null;
$formLink = $cr ? $cr['call_form_link'] : '#';
?>

<div class="page-hero">
    <div class="container">
        <h1>Admissions 2025-26</h1>
        <p>Begin your child's journey of excellence at Kalrav Vidhya Mandir</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Admissions</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header">
            <div class="section-badge">How to Apply</div>
            <h2>Admission Process</h2>
            <p>Simple, transparent, and student-focused admission process.</p>
            <div class="section-divider"></div>
        </div>
        <div class="grid-4" style="margin-top:40px;">
            <?php
            $steps = [
                ['num'=>1,'title'=>'Inquiry','desc'=>'Visit school or call us to know about available seats, fee structure, and programs.','icon'=>'📞'],
                ['num'=>2,'title'=>'Fill Form','desc'=>'Fill the admission form online or pick it up from the school office.','icon'=>'📝'],
                ['num'=>3,'title'=>'Assessment','desc'=>'Students appear for a simple entrance assessment (if applicable for the grade).','icon'=>'📊'],
                ['num'=>4,'title'=>'Confirmation','desc'=>'Receive admission confirmation letter and complete the enrollment formalities.','icon'=>'✅'],
            ];
            foreach ($steps as $step): ?>
            <div class="step-card">
                <div class="step-number"><?php echo $step['num']; ?></div>
                <div style="font-size:40px;margin:15px 0 10px;"><?php echo $step['icon']; ?></div>
                <h3 style="font-size:16px;font-weight:700;margin-bottom:8px;"><?php echo $step['title']; ?></h3>
                <p style="color:#666;font-size:13px;line-height:1.6;"><?php echo $step['desc']; ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-alt">
    <div class="container">
        <div class="grid-2" style="gap:40px;align-items:start;">
            <div>
                <div class="section-badge" style="display:inline-block;margin-bottom:15px;">Eligibility</div>
                <h2 style="font-family:'Playfair Display',serif;font-size:30px;margin-bottom:15px;">Who Can Apply?</h2>
                <div class="card">
                    <div class="card-body">
                        <table style="width:100%;border-collapse:collapse;">
                            <thead>
                                <tr style="background:#fff3cd;">
                                    <th style="padding:10px;text-align:left;font-size:13px;color:#666;">Grade</th>
                                    <th style="padding:10px;text-align:left;font-size:13px;color:#666;">Age Criteria</th>
                                    <th style="padding:10px;text-align:left;font-size:13px;color:#666;">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $grades = [
                                    ['Std 1','5-6 years','Open'],['Std 2-5','6-10 years','Open'],
                                    ['Std 6-8','11-13 years','Open'],['Std 9-10','14-15 years','Limited'],
                                    ['Std 11-12','16-17 years','Open'],
                                ];
                                foreach ($grades as $g): ?>
                                <tr style="border-bottom:1px solid #f0f0f0;">
                                    <td style="padding:10px;font-weight:600;font-size:14px;"><?php echo $g[0]; ?></td>
                                    <td style="padding:10px;color:#666;font-size:13px;"><?php echo $g[1]; ?></td>
                                    <td style="padding:10px;"><span class="badge <?php echo $g[2]==='Open'?'badge-success':'badge-warning'; ?>"><?php echo $g[2]; ?></span></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div>
                <div class="section-badge" style="display:inline-block;margin-bottom:15px;">Documents Required</div>
                <h2 style="font-family:'Playfair Display',serif;font-size:30px;margin-bottom:15px;">What to Bring</h2>
                <div class="card">
                    <div class="card-body">
                        <ul class="value-list">
                            <li>Birth Certificate (original + 1 photocopy)</li>
                            <li>Previous school Transfer Certificate</li>
                            <li>Last year's progress report / marksheet</li>
                            <li>4 passport-size photographs of student</li>
                            <li>Aadhar Card of student and parent</li>
                            <li>Caste Certificate (if applicable)</li>
                            <li>Medical fitness certificate</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="cta-section">
    <div class="container">
        <h2>Ready to Apply?</h2>
        <p>Take the first step towards your child's bright future. Limited seats available!</p>
        <div style="display:flex;gap:15px;justify-content:center;flex-wrap:wrap;">
            <a href="<?php echo htmlspecialchars($formLink); ?>" target="_blank" class="btn-dark"><i class="fas fa-phone-alt"></i> Request a Call Back</a>
            <a href="contact.php" class="btn-white"><i class="fas fa-envelope"></i> Contact Us</a>
        </div>
    </div>
</section>

<?php require_once 'includes/footer.php'; ?>
