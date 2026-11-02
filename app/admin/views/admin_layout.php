<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель. <?= $title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/hotel/public/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-green shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand font-montserrat fw-bold" href="/hotel/admin/rooms/index">🌲 Админ-панель</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/hotel/admin/rooms/index">Номера</a></li>
                    <li class="nav-item"><a class="nav-link" href="/hotel/admin/bookings/index">Заявки на бронь</a></li>
					<li class="nav-item"><a class="nav-link" href="/hotel/admin/pages/index">Страницы сайта</a></li>
                    <li class="nav-item"><a class="nav-link" href="/hotel/admin/reviews/index">Отзывы</a></li>
                    <li class="nav-item"><a class="nav-link text-danger fw-bold" href="/hotel/authorization/log_out">Выход</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        <?= isset($model['validator']) ? $model['validator']->ShowErrors() : '' ?>
        <?php include 'app/admin/views/' . $content_view; ?>
    </main>
</body>
</html>