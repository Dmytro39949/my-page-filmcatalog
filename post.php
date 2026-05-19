<?php include_once 'header.php'; ?>
<?php
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
if (!is_numeric($post_id)) exit('Некоректний ідентифікатор запису');
$post = get_post_by_id($post_id);
$hide_episodes = $post && (int)$post['id'] === 13;
$episodes = $post && !$hide_episodes ? get_episodes_by_post_id($post_id) : [];
?>
<?php if (!$post): ?>
    <div class="container py-5"><div class="alert alert-danger">Запис не знайдено.</div></div>
<?php else: ?>
<section class="details-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-4">
                <img class="details-poster" src="<?= esc($post['image']); ?>" alt="<?= esc($post['header']); ?>" onerror="this.src='img/no-image.svg'">
            </div>
            <div class="col-lg-8 mt-4 mt-lg-0">
                <span class="hero-badge"><?= esc($post['category_name']); ?></span>
                <h1><?= esc($post['header']); ?></h1>
                <div class="details-meta">
                    <span><?= esc($post['media_type']); ?></span>
                    <span><?= esc($post['year']); ?></span>
                    <span><?= esc($post['country']); ?></span>
                    <span>★ <?= esc($post['rating']); ?>/10</span>
                </div>
                <p><?= nl2br(esc($post['content'])); ?></p>
                <div class="info-grid">
                    <div><strong>Режисер / шоуранер</strong><span><?= esc($post['director']); ?></span></div>
                    <div><strong>Тривалість</strong><span><?= esc($post['duration']); ?></span></div>
                    <div><strong>Дата додавання</strong><span><?= esc($post['datatime']); ?></span></div>
                </div>
                <div class="mt-4">
                    <?php if (!empty($post['trailer'])): ?>
                        <a class="btn btn-warning" href="<?= esc($post['trailer']); ?>" target="_blank" rel="noopener">Дивитися трейлер</a>
                    <?php endif; ?>
                    <a href="index.php" class="btn btn-outline-light ml-2">Назад</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($episodes)): ?>
<section class="container episode-section">
    <div class="section-heading episode-heading">
        <div>
            <p>Плеєр серій</p>
            <h2><?= esc($post['header']); ?> — серії</h2>
        </div>
        <span>Обери серію нижче, і відео відкриється у вбудованому плеєрі.</span>
    </div>

    <div class="episode-player-card">
        <div class="episode-video-wrap">
            <iframe id="episodeFrame" src="<?= esc(youtube_to_embed_url($episodes[0]['video_url'])); ?>" title="Плеєр серій" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        </div>
        <div class="episode-list">
            <?php foreach ($episodes as $index => $episode): ?>
                <button type="button"
                        class="episode-btn <?= $index === 0 ? 'active' : ''; ?>"
                        data-video="<?= esc(youtube_to_embed_url($episode['video_url'])); ?>"
                        data-title="<?= esc($episode['title']); ?>">
                    <strong><?= (int)$episode['season_number']; ?> сезон, <?= (int)$episode['episode_number']; ?> серія</strong>
                    <span><?= esc($episode['title']); ?></span>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>
<?php endif; ?>
<?php include_once 'footer.php'; ?>
