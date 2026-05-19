<?php include_once 'header.php'; ?>
<?php
$search = isset($_GET['q']) ? $_GET['q'] : '';
$news = get_news($search);
$featured = get_featured_items(3);
?>
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <span class="hero-badge">Каталог фільмів та серіалів</span>
                <h1>Обирай, що подивитися сьогодні</h1>
                <p>У каталозі зібрані популярні фільми, серіали та мультфільми з рейтингами, описами, категоріями і сторінками деталей.</p>
                <div class="hero-actions">
                    <a class="btn btn-warning btn-lg" href="#catalog">Переглянути каталог</a>
                    <a class="btn btn-outline-light btn-lg" href="category.php?category_id=1">Фільми</a>
                </div>
            </div>
            <div class="col-lg-5 mt-5 mt-lg-0">
                <div class="hero-panel">
                    <h4>Топ підбірка</h4>
                    <?php foreach ($featured as $item): ?>
                        <a class="mini-card" href="post.php?post_id=<?= (int)$item['id']; ?>">
                            <img src="<?= esc($item['image']); ?>" alt="<?= esc($item['header']); ?>" onerror="this.src='img/no-image.svg'">
                            <span>
                                <strong><?= esc($item['header']); ?></strong>
                                <small><?= esc($item['media_type']); ?> • <?= esc($item['rating']); ?>/10</small>
                            </span>
                        </a>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="container stats-row">
    <div class="stat-card"><strong><?= count($news); ?></strong><span>позицій у каталозі</span></div>
    <div class="stat-card"><strong><?= count($categories); ?></strong><span>категорій</span></div>
</section>

<section class="container catalog-section" id="catalog">
    <div class="section-heading">
        <div>
            <p>Усі записи</p>
            <h2><?= $search ? 'Результати пошуку: ' . esc($search) : 'Каталог'; ?></h2>
        </div>
        <span>Фільми / Серіали / Мультфільми</span>
    </div>

    <?php if (empty($news)): ?>
        <div class="alert alert-dark">За вашим запитом нічого не знайдено.</div>
    <?php endif; ?>

    <div class="row">
        <?php foreach ($news as $new): ?>
            <div class="col-md-6 col-lg-4 mb-4">
                <div class="movie-card h-100">
                    <div class="poster-wrap">
                        <img src="<?= esc($new['image']); ?>" class="card-img-top" alt="<?= esc($new['header']); ?>" onerror="this.src='img/no-image.svg'">
                        <span class="rating-badge">★ <?= esc($new['rating']); ?></span>
                    </div>
                    <div class="card-body d-flex flex-column">
                        <div class="movie-meta">
                            <span><?= esc($new['media_type']); ?></span>
                            <span><?= esc($new['year']); ?></span>
                            <span><?= esc($new['category_name']); ?></span>
                        </div>
                        <h5 class="card-title"><?= esc($new['header']); ?></h5>
                        <p class="card-text"><?= esc(short_text($new['content'], 155)); ?></p>
                        <a href="post.php?post_id=<?= (int)$new['id']; ?>" class="btn btn-primary mt-auto">Детальніше</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php include_once 'footer.php'; ?>
