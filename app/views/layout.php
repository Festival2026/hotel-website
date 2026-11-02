<?php 
if (session_status() === PHP_SESSION_NONE) session_start(); 
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
	<title>Отель «Лесная сказка». <?= $title ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
    <!-- Наш кастомный CSS -->
    <link rel="stylesheet" href="/hotel/public/assets/css/style.css">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS (для выпадающих меню и мобильной версии) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/hotel/public/assets/js/script.js" defer></script>
</head>
<body>

    <!-- Шапка сайта -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark-green fixed-top">
        <div class="container">
            <a class="navbar-brand font-montserrat fw-bold" href="/hotel/page/index">
                🌲 Лесная сказка
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="/hotel/page/index">Главная</a></li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Отель</a>
                        <ul class="dropdown-menu">
    <li><a class="dropdown-item" href="/hotel/page/about">Об отеле</a></li>
    <li><a class="dropdown-item" href="/hotel/page/services">Услуги и удобства</a></li>
    <li><a class="dropdown-item" href="/hotel/page/gallery">Фото отеля</a></li>
    <li><a class="dropdown-item" href="/hotel/review/index">Отзывы гостей</a></li>
    <li><a class="dropdown-item" href="/hotel/page/contacts">Контакты</a></li>
</ul>
                    </li>
                    
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Номера</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/hotel/rooms/index">Каталог номеров</a></li>
                            <li><a class="dropdown-item" href="/hotel/booking/index">Бронирование</a></li>
                        </ul>
                    </li>
                    
                    <li class="nav-item"><a class="nav-link" href="/hotel/page/food">Питание</a></li>
                    <li class="nav-item"><a class="nav-link" href="/hotel/page/offers">Спецпредложения</a></li>
                    
                    <!-- Блок пользователя -->
                    <?php if (isset($_SESSION['user_id'])): ?>
                        <li class="nav-item"><span class="nav-link text-warning">👤 <?= htmlspecialchars($_SESSION['user_fio']) ?></span></li>
                        <li class="nav-item"><a class="nav-link" href="/hotel/account/logout">Выйти</a></li>
                    <?php else: ?>
                        
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Основной контент -->
    <main style="min-height: 80vh; padding-top: 76px;">
        <?php include 'app/views/' . $content_view; ?>
    </main>

    <!-- Подвал -->
    <footer class="bg-dark-green text-white py-4 mt-5">
    <div class="container text-center">
        <p class="mb-1 font-montserrat">© 2026 Отель «Лесная сказка»</p>
        <p class="small" style="color: #b7e4c7;">Мы в соцсетях: 
            <a href="#" class="text-white text-decoration-none fw-bold">ВКонтакте</a> | 
            <a href="#" class="text-white text-decoration-none fw-bold">Telegram</a>
        </p>
        <p class="mt-3 mb-0">
            <a href="/hotel/authorization/index" class="text-decoration-none" style="color: #52b788; font-size: 0.8rem;">Вход для администратора</a>
        </p>
    </div>
</footer>

</body>
</html>