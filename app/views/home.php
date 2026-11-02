<?php if (isset($_GET['booking_success'])): ?>
    <div class="alert alert-success text-center rounded-0 py-3 shadow-sm" style="margin-top: 55px;">
        <strong>Спасибо!</strong> Ваша заявка на бронирование успешно отправлена. Наш менеджер свяжется с вами в ближайшее время.
    </div>
<?php endif; ?>

<!-- Hero-секция с фоновой картинкой -->
<!-- Карусель (Слайдшоу) -->
<div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
        <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    </div>
    <div class="carousel-inner">
        <!-- Слайд 1 -->
        <div class="carousel-item active">
            <div class="hero-slide" style="background-image: url('/hotel/public/assets/img/hotel_main.jpg');">
                <div class="hero-overlay d-flex align-items-center justify-content-center text-center">
                    <div class="container text-white">
                        <h1 class="display-4 fw-bold mb-4">Добро пожаловать в «Лесную сказку»</h1>
                        <p class="lead mb-5">Уютный частный отель в окружении векового леса.</p>
                        <a href="/hotel/booking/index" class="btn btn-success btn-lg px-5 py-3 fw-bold">Забронировать номер</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Слайд 2 (Если есть картинка room_lux.jpg, используй её, или замени имя) -->
        <div class="carousel-item">
            <div class="hero-slide" style="background-image: url('/hotel/public/assets/img/room_lux.jpg');">
                <div class="hero-overlay d-flex align-items-center justify-content-center text-center">
                    <div class="container text-white">
                        <h1 class="display-4 fw-bold mb-4">Комфорт премиум-класса</h1>
                        <p class="lead mb-5">Просторные номера с панорамными окнами и видом на лес.</p>
                        <a href="/hotel/rooms/index" class="btn btn-light btn-lg px-5 py-3 fw-bold text-success">Смотреть номера</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- Слайд 3 (Природа) -->
        <div class="carousel-item">
            <div class="hero-slide" style="background-image: url('/hotel/public/assets/img/nature.jpg');">
                <div class="hero-overlay d-flex align-items-center justify-content-center text-center">
                    <div class="container text-white">
                        <h1 class="display-4 fw-bold mb-4">Единение с природой</h1>
                        <p class="lead mb-5">Отдохните от городской суеты на берегу лесного озера.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
    </button>
</div>

<!-- Блок преимуществ -->
<div class="container my-5">
    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="card p-4 h-100 shadow-sm border-0">
                <div class="fs-1 mb-3">🌲</div>
                <h4 class="fw-bold">Тишина и природа</h4>
                <p class="text-muted">Отель расположен вдали от шумных трасс, прямо на берегу лесного озера.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 h-100 shadow-sm border-0">
                <div class="fs-1 mb-3">🍽️</div>
                <h4 class="fw-bold">Ресторан</h4>
                <p class="text-muted">Известный ресторан с авторской кухней и богатой коллекцией вин.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <div class="card p-4 h-100 shadow-sm border-0">
                <div class="fs-1 mb-3">🧖‍♂️</div>
                <h4 class="fw-bold">СПА и отдых</h4>
                <p class="text-muted">Финская сауна, бассейн с подогревом и услуги профессиональных массажистов.</p>
            </div>
        </div>
    </div>
</div>

<!-- Призыв к действию -->
<div class="container mb-5">
    <div class="bg-dark-green text-white p-5 rounded-3 text-center">
        <h2 class="text-white mb-3">Не знаете, какой номер выбрать?</h2>
        <p class="mb-4">Посмотрите наш каталог. У нас есть уютные стандарты для двоих и просторные семейные люксы.</p>
        <a href="/hotel/rooms/index" class="btn btn-light btn-lg text-success fw-bold">Перейти в каталог номеров</a>
    </div>
</div>