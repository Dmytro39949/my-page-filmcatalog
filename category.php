<?php include_once 'header.php'; ?>
<?php
$category_id = isset($_GET['category_id']) ? $_GET['category_id'] : 0;
if (!is_numeric($category_id)) exit('Некоректний ідентифікатор категорії');
$posts = get_post_by_category($category_id);
$category = get_category_title($category_id);
?>
<section class="container catalog-section category-page">
    <?php if (!$category): ?>
        <div class="alert alert-danger">Категорію не знайдено.</div>
    <?php else: ?>
        <div class="section-heading">
            <div>
                <p>Категорія</p>
                <h2><?= esc($category['name']); ?></h2>
            </div>
            <span><?= esc($category['description']); ?></span>
        </div>
        <div class="row">
            <?php foreach ($posts as $post): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="movie-card h-100">
                        <div class="poster-wrap">
                            <img src="<?= esc($post['image']); ?>" class="card-img-top" alt="<?= esc($post['header']); ?>" onerror="this.src='img/no-image.svg'">
                            <span class="rating-badge">★ <?= esc($post['rating']); ?></span>
                        </div>
                        <div class="card-body d-flex flex-column">
                            <div class="movie-meta">
                                <span><?= esc($post['media_type']); ?></span>
                                <span><?= esc($post['year']); ?></span>
                            </div>
                            <a href="post.php?post_id=<?= (int)$post['id']; ?>"><h5 class="card-title"><?= esc($post['header']); ?></h5></a>
                            <p class="card-text"><?= esc(short_text($post['content'], 155)); ?></p>
                            <a href="post.php?post_id=<?= (int)$post['id']; ?>" class="btn btn-primary mt-auto">Детальніше</a>
                        </div>
                        <div class="card-footer text-muted">Додано: <?= esc($post['datatime']); ?></div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <?php if (empty($posts)): ?>
            <div class="alert alert-dark">У цій категорії поки немає записів.</div>
        <?php endif; ?>
    <?php endif; ?>
</section>
<?php include_once 'footer.php'; ?>
