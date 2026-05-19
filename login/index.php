<!doctype html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Вхід в адмін-панель</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/main.css">
</head>
<body>
<div class="container admin-page">
    <div class="row justify-content-center">
        <div class="col-md-7 col-lg-5">
            <div class="main-form">
                <a href="../index.php" class="btn btn-outline-light mb-4">← На сайт</a>
                <form class="login" action="check-login.php" method="post">
                    <h3>Вхід в адмін-панель</h3>
                    <div class="form-group">
                        <label for="login">Логін</label>
                        <input type="text" name="login" class="form-control" id="login" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Пароль</label>
                        <input type="password" name="password" class="form-control" id="password" required>
                    </div>
                    <button type="submit" class="btn btn-warning btn-block form-btn">Увійти</button>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>
