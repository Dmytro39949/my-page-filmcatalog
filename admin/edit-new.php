<?php include_once 'header-admin.php'; ?>
<?php
$post_id = isset($_GET['post_id']) ? $_GET['post_id'] : 0;
if (!is_numeric($post_id)) exit('Некоректний ідентифікатор запису');
$post = get_post_by_id($post_id);
$categories = get_categories();
if (!$post) exit('Запис не знайдено');
?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="admin-card">
            <h3>Редагування запису</h3>
            <form action="update-new.php" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= (int)$post['id']; ?>">
                <input type="hidden" name="current_image" value="<?= esc($post['image']); ?>">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Назва</label>
                        <input name="header" type="text" class="form-control" value="<?= esc($post['header']); ?>" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Тип</label>
                        <select name="media_type" class="custom-select">
                            <option value="Фільм" <?= $post['media_type'] === 'Фільм' ? 'selected' : ''; ?>>Фільм</option>
                            <option value="Серіал" <?= $post['media_type'] === 'Серіал' ? 'selected' : ''; ?>>Серіал</option>
                            <option value="Мультфільм" <?= $post['media_type'] === 'Мультфільм' ? 'selected' : ''; ?>>Мультфільм</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Категорія</label>
                        <select name="category_id" class="custom-select">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int)$category['id']; ?>" <?= (int)$category['id'] === (int)$post['category_id'] ? 'selected' : ''; ?>><?= esc($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Опис</label>
                    <textarea name="content" class="form-control" rows="7" required><?= esc($post['content']); ?></textarea>
                </div>
                <div class="form-row align-items-center">
                    <div class="form-group col-md-2">
                        <img class="admin-thumb" src="<?= esc($post['image']); ?>" alt="<?= esc($post['header']); ?>" onerror="this.src='../img/no-image.svg'">
                    </div>
                    <div class="form-group col-md-5">
                        <label>Нове посилання на зображення</label>
                        <input name="image_url" type="url" class="form-control" value="<?= esc($post['image']); ?>">
                    </div>
                    <div class="form-group col-md-5">
                        <label>Або завантажити новий файл</label>
                        <input name="image" type="file" class="form-control-file">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label>Рік</label>
                        <input name="year" type="number" class="form-control" value="<?= esc($post['year']); ?>" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Рейтинг</label>
                        <input name="rating" type="number" step="0.1" min="0" max="10" class="form-control" value="<?= esc($post['rating']); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Режисер / шоуранер</label>
                        <input name="director" type="text" class="form-control" value="<?= esc($post['director']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Країна</label>
                        <input name="country" type="text" class="form-control" value="<?= esc($post['country']); ?>">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Тривалість</label>
                        <input name="duration" type="text" class="form-control" value="<?= esc($post['duration']); ?>">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Дата додавання</label>
                        <input name="datetime" type="date" class="form-control" value="<?= esc($post['datatime']); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Трейлер</label>
                        <input name="trailer" type="url" class="form-control" value="<?= esc($post['trailer']); ?>">
                    </div>
                </div>
                <div class="form-check mb-4">
                    <input name="featured" class="form-check-input" type="checkbox" value="1" id="featured" <?= (int)$post['featured'] === 1 ? 'checked' : ''; ?>>
                    <label class="form-check-label" for="featured">Показувати у топ-підбірці</label>
                </div>
                <button type="submit" class="btn btn-warning">Оновити запис</button>
                <a href="index.php" class="btn btn-outline-light">Назад</a>
            </form>
        </div>
    </div>
</div>
<?php include_once 'footer-admin.php'; ?>
