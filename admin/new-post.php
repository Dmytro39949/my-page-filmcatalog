<?php include_once 'header-admin.php'; ?>
<?php $categories = get_categories(); ?>
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="admin-card">
            <h3>Додавання нового запису</h3>
            <p class="text-muted">Заповніть інформацію про фільм або серіал і додайте постер.</p>
            <form action="check-new.php" method="post" enctype="multipart/form-data">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Назва</label>
                        <input name="header" type="text" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Тип</label>
                        <select name="media_type" class="custom-select">
                            <option value="Фільм">Фільм</option>
                            <option value="Серіал">Серіал</option>
                            <option value="Мультфільм">Мультфільм</option>
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Категорія</label>
                        <select name="category_id" class="custom-select">
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= (int)$category['id']; ?>"><?= esc($category['name']); ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>Опис</label>
                    <textarea name="content" class="form-control" rows="7" required></textarea>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Посилання на зображення</label>
                        <input name="image_url" type="url" class="form-control" placeholder="https://...">
                    </div>
                    <div class="form-group col-md-6">
                        <label>Або завантажити файл</label>
                        <input name="image" type="file" class="form-control-file">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-2">
                        <label>Рік</label>
                        <input name="year" type="number" class="form-control" value="2024" required>
                    </div>
                    <div class="form-group col-md-2">
                        <label>Рейтинг</label>
                        <input name="rating" type="number" step="0.1" min="0" max="10" class="form-control" value="8.0" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Режисер / шоуранер</label>
                        <input name="director" type="text" class="form-control">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Країна</label>
                        <input name="country" type="text" class="form-control">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label>Тривалість</label>
                        <input name="duration" type="text" class="form-control" placeholder="2 год 30 хв / 1 сезон">
                    </div>
                    <div class="form-group col-md-4">
                        <label>Дата додавання</label>
                        <input name="datetime" type="date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>
                    <div class="form-group col-md-4">
                        <label>Трейлер</label>
                        <input name="trailer" type="url" class="form-control" placeholder="https://www.youtube.com/...">
                    </div>
                </div>
                <div class="form-check mb-4">
                    <input name="featured" class="form-check-input" type="checkbox" value="1" id="featured">
                    <label class="form-check-label" for="featured">Показувати у топ-підбірці</label>
                </div>
                <button type="submit" class="btn btn-warning">Додати запис</button>
                <a href="index.php" class="btn btn-outline-light">Назад</a>
            </form>
        </div>
    </div>
</div>
<?php include_once 'footer-admin.php'; ?>
