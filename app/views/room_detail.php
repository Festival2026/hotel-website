<div class="container my-5">
    <div class="mb-4">
        <a href="/hotel/rooms/index" class="text-decoration-none text-success fw-bold">← Назад в каталог</a>
    </div>

    <div class="row">
        <!-- Левая колонка: Фото -->
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 overflow-hidden">
                <?php if ($model['room']->image && file_exists('public/assets/img/' . $model['room']->image)): ?>
                    <img src="/hotel/public/assets/img/<?= $model['room']->image ?>" class="img-fluid w-100" alt="<?= htmlspecialchars($model['room']->title) ?>" style="object-fit: cover; max-height: 500px;">
                <?php else: ?>
                    <img src="/hotel/public/assets/img/room_standard.jpg" class="img-fluid w-100" alt="Заглушка" style="object-fit: cover; max-height: 500px;">
                <?php endif; ?>
            </div>
        </div>

        <!-- Правая колонка: Информация -->
        <div class="col-lg-5">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-body p-4 d-flex flex-column">
                    <h1 class="fw-bold mb-3"><?= htmlspecialchars($model['room']->title) ?></h1>
                    <p class="text-muted fs-5 mb-4">Вместимость: до <?= $model['room']->capacity ?> человек</p>
                    
                    <h5 class="fw-bold mb-3">Описание</h5>
                    <p class="mb-4"><?= nl2br(htmlspecialchars($model['room']->description)) ?></p>

                    <h5 class="fw-bold mb-3">Удобства в номере</h5>
                    <ul class="list-unstyled mb-4">
                        <li class="mb-2">📶 Бесплатный Wi-Fi</li>
                        <li class="mb-2">📺 Телевизор с плоским экраном</li>
                        <li class="mb-2">❄️ Кондиционер</li>
                        <li class="mb-2">🚿 Собственная ванная комната</li>
                        <li class="mb-2">☕ Чайная станция</li>
                    </ul>

                    <div class="mt-auto pt-3 border-top">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="fs-3 fw-bold text-success"><?= number_format($model['room']->price, 0, '', ' ') ?> ₽</span>
                            <span class="text-muted">/ за ночь</span>
                        </div>
                        <a href="/hotel/booking/index?room_id=<?= $model['room']->id ?>" class="btn btn-success btn-lg w-100 fw-bold">Забронировать этот номер</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>