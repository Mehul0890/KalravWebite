<?php
$pageTitle = 'Gallery';
require_once 'includes/header.php';

// Get gallery items grouped by category
$galleryData = [];
$cats = ['Indian Festivals', 'Other Activities', 'Annual Day'];
foreach ($cats as $cat) {
    $stmt = $conn->prepare("SELECT * FROM gallery WHERE category=? ORDER BY created_at DESC");
    $stmt->bind_param("s", $cat);
    $stmt->execute();
    $res = $stmt->get_result();
    $galleryData[$cat] = [];
    while ($row = $res->fetch_assoc()) $galleryData[$cat][] = $row;
    $stmt->close();
}

// Get all years for Annual Day
$years = $conn->query("SELECT DISTINCT year FROM gallery WHERE category='Annual Day' ORDER BY year DESC");
$annualYears = [];
while ($y = $years->fetch_assoc()) $annualYears[] = $y['year'];

// Dummy images for placeholders
$festivalEmojis = ['🪔','🌈','🎆','🎉','🏮','🎊'];
$activityEmojis = ['🔬','🏃','🎨','🎵','📚','🏆'];
$annualEmojis = ['🎭','🎤','🎪','🏅','🌟','🎬'];
?>

<div class="page-hero">
    <div class="container">
        <h1>Photo Gallery</h1>
        <p>Capturing memorable moments of our students and school life</p>
        <div class="breadcrumb"><a href="index.php">Home</a><span>›</span><span>Gallery</span></div>
    </div>
</div>

<section class="section">
    <div class="container">
        <!-- Filter Tabs -->
        <div class="filter-tabs">
            <button class="filter-tab active" data-filter="all">All Photos</button>
            <button class="filter-tab" data-filter="Indian Festivals">🪔 Indian Festivals</button>
            <button class="filter-tab" data-filter="Other Activities">🎨 Other Activities</button>
            <button class="filter-tab" data-filter="Annual Day">🎭 Annual Day</button>
            <?php foreach ($annualYears as $yr): ?>
            <button class="filter-tab" data-filter="Annual Day <?php echo $yr; ?>"><?php echo $yr; ?></button>
            <?php endforeach; ?>
        </div>

        <!-- Gallery Grid -->
        <div class="gallery-grid">
            <?php
            $allItems = [];
            foreach ($galleryData as $cat => $items) {
                foreach ($items as $item) {
                    $item['_category'] = $cat;
                    $allItems[] = $item;
                }
            }

            if (empty($allItems)) {
                // Show dummy placeholders
                $dummies = [
                    ['title'=>'Diwali Celebration','cat'=>'Indian Festivals','emoji'=>'🪔'],
                    ['title'=>'Holi Festival','cat'=>'Indian Festivals','emoji'=>'🌈'],
                    ['title'=>'Republic Day','cat'=>'Indian Festivals','emoji'=>'🇮🇳'],
                    ['title'=>'Independence Day','cat'=>'Indian Festivals','emoji'=>'🎆'],
                    ['title'=>'Science Exhibition','cat'=>'Other Activities','emoji'=>'🔬'],
                    ['title'=>'Sports Day','cat'=>'Other Activities','emoji'=>'🏃'],
                    ['title'=>'Art Competition','cat'=>'Other Activities','emoji'=>'🎨'],
                    ['title'=>'Music Event','cat'=>'Other Activities','emoji'=>'🎵'],
                    ['title'=>'Annual Day 2024','cat'=>'Annual Day','emoji'=>'🎭','year'=>'2024'],
                    ['title'=>'Annual Day 2023','cat'=>'Annual Day','emoji'=>'🎤','year'=>'2023'],
                    ['title'=>'Annual Day 2022','cat'=>'Annual Day','emoji'=>'🏅','year'=>'2022'],
                    ['title'=>'Annual Day 2021','cat'=>'Annual Day','emoji'=>'🌟','year'=>'2021'],
                ];
                foreach ($dummies as $d): ?>
                <div class="gallery-item" data-category="<?php echo $d['cat']; ?>" <?php echo isset($d['year']) ? "data-year=\"{$d['year']}\"" : ''; ?>>
                    <div style="width:100%;height:100%;background:linear-gradient(135deg,#FFC107,#FF8F00);display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:50px;">
                        <?php echo $d['emoji']; ?>
                        <span style="font-size:12px;color:rgba(0,0,0,0.6);margin-top:8px;font-weight:600;"><?php echo $d['title']; ?></span>
                    </div>
                    <div class="gallery-overlay"><span><?php echo $d['title']; ?></span></div>
                </div>
                <?php endforeach;
            } else {
                foreach ($allItems as $item):
                    $catKey = $item['_category'];
                    $yearAttr = $item['year'] ? " data-year=\"{$item['year']}\"" : '';
            ?>
            <div class="gallery-item" data-category="<?php echo htmlspecialchars($catKey); ?>"<?php echo $yearAttr; ?>>
                <?php if (!empty($item['image_path']) && file_exists('uploads/gallery/' . $item['image_path'])): ?>
                <img src="uploads/gallery/<?php echo htmlspecialchars($item['image_path']); ?>" alt="<?php echo htmlspecialchars($item['title']); ?>" data-category="<?php echo htmlspecialchars($item['title']); ?>">
                <?php else:
                    $emojiArr = $catKey === 'Indian Festivals' ? $festivalEmojis : ($catKey === 'Annual Day' ? $annualEmojis : $activityEmojis);
                    $emoji = $emojiArr[array_rand($emojiArr)];
                ?>
                <div style="width:100%;height:100%;background:linear-gradient(135deg,#FFC107,#FF8F00);display:flex;flex-direction:column;align-items:center;justify-content:center;font-size:50px;">
                    <?php echo $emoji; ?>
                    <span style="font-size:11px;color:rgba(0,0,0,0.6);margin-top:8px;font-weight:600;text-align:center;padding:0 5px;"><?php echo htmlspecialchars($item['title']); ?></span>
                </div>
                <?php endif; ?>
                <div class="gallery-overlay">
                    <span><?php echo htmlspecialchars($item['title']); ?> <?php echo $item['year'] ? "({$item['year']})" : ''; ?></span>
                </div>
            </div>
            <?php endforeach; } ?>
        </div>
    </div>
</section>

<script>
// Enhanced gallery filter including year-based filtering
document.querySelectorAll('.filter-tab').forEach(tab => {
    tab.addEventListener('click', function() {
        document.querySelectorAll('.filter-tab').forEach(t => t.classList.remove('active'));
        this.classList.add('active');
        const filter = this.dataset.filter;
        document.querySelectorAll('.gallery-item').forEach(item => {
            const cat = item.dataset.category;
            const yr = item.dataset.year || '';
            let show = false;
            if (filter === 'all') show = true;
            else if (filter.includes(' ') && filter.startsWith('Annual Day ')) {
                const yearFilter = filter.split(' ')[2];
                show = (cat === 'Annual Day' && yr === yearFilter);
            } else {
                show = (cat === filter);
            }
            item.style.display = show ? '' : 'none';
        });
    });
});
</script>

<?php require_once 'includes/footer.php'; ?>
