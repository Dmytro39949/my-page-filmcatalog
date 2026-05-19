<?php include_once 'header-admin.php'; ?>
<?php $posts = get_post(); ?>
<div class="row align-items-center mb-4">
    <div class="col-md-8">
        <h1>Адмін-панель</h1>
        <p class="text-muted">Керування каталогом фільмів та серіалів.</p>
    </div>
    <div class="col-md-4 text-md-right">
        <a href="new-post.php" class="btn btn-warning">Додати запис</a>
    </div>
</div>
<div class="admin-card table-responsive">
    <table class="table table-hover">
        <thead>
        <tr>
            <th>ID</th>
            <th>Фото</th>
            <th>Назва</th>
            <th>Категорія</th>
            <th>Рейтинг</th>
            <th>Дії</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($posts as $post): ?>
            <tr>
                <th scope="row"><?= (int)$post['id']; ?></th>
                <td><img class="admin-thumb" src="<?= esc($post['image']); ?>" alt="<?= esc($post['header']); ?>" onerror="this.src='../img/no-image.svg'"></td>
                <td><?= esc($post['header']); ?><br><small class="text-muted"><?= esc($post['media_type']); ?> • <?= esc($post['year']); ?></small></td>
                <td><?= esc($post['category_name']); ?></td>
                <td>★ <?= esc($post['rating']); ?></td>
                <td>
                    <div class="admin-actions">
                        <a href="edit-new.php?post_id=<?= (int)$post['id']; ?>" class="btn btn-info btn-sm">Редагувати</a>
                        <a href="delete-new.php?post_id=<?= (int)$post['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Видалити запис?')">Видалити</a>
                    </div>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php include_once 'footer-admin.php'; ?>
