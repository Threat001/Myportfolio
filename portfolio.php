<?php
$projects = [];
$json_file = 'assets/uploads.json';

if (file_exists($json_file)) {
    $projects = json_decode(file_get_contents($json_file), true) ?: [];
}

// Sort by date (newest first)
usort($projects, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio | Threat3D</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header class="header">
        <!-- Your existing header -->
    </header>

    <main>
        <section class="hero hero-portfolio">
            <div class="container">
                <h1 class="hero-title">Portfolio</h1>
                <p class="hero-subtitle">A showcase of my 3D artwork</p>
            </div>
        </section>

        <section class="section portfolio-section">
            <div class="container">
                <div class="portfolio-filters">
                    <button class="filter-btn active" data-filter="all">All</button>
                    <button class="filter-btn" data-filter="product">Product Design</button>
                    <button class="filter-btn" data-filter="character">Characters</button>
                    <button class="filter-btn" data-filter="environment">Environments</button>
                    <button class="filter-btn" data-filter="stylized">Stylized</button>
                </div>

                <div class="portfolio-grid">
                    <?php foreach ($projects as $project): ?>
                        <div class="portfolio-item <?= htmlspecialchars($project['category']) ?>">
                            <div class="portfolio-item-inner">
                                <img src="assets/uploads/<?= htmlspecialchars($project['thumbnail'] ?? $project['filename']) ?>" 
                                     alt="<?= htmlspecialchars($project['title']) ?>">
                                <div class="portfolio-overlay">
                                    <h3><?= htmlspecialchars($project['title']) ?></h3>
                                    <span class="portfolio-category"><?= htmlspecialchars(ucfirst($project['category'])) ?></span>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>

    <script src="js/portfolio.js"></script>
</body>
</html>
