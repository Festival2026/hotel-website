<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Наши номера</h2>
        <p class="text-muted">Выберите идеальный вариант для вашего отдыха</p>
    </div>

    <div class="row">
        <?php foreach ($model['rooms'] as $room): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm">
                    <!-- Картинка номера (если нет, показываем заглушку) -->
                    <?php if ($room->image && file_exists('public/assets/img/' . $room->image)): ?>
                        <img src="/hotel/public/assets/img/<?= $room->image ?>" class="card-img-top" alt="<?= htmlspecialchars($room->title) ?>">
                    <?php else: ?>
                        <img src="/hotel/public/assets/img/room_standard.jpg" class="card-img-top" alt="Заглушка">
                    <?php endif; ?>
                    
                                        <div class="card-body d-flex flex-column">
                        <h4 class="card-title fw-bold">
                            <a href="/hotel/rooms/view?id=<?= $room->id ?>" class="text-decoration-none text-dark">
                                <?= htmlspecialchars($room->title) ?>
                            </a>
                        </h4>
                        <p class="card-text text-muted flex-grow-1"><?= htmlspecialchars($room->description) ?></p>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div>
                                <span class="fs-4 fw-bold text-success"><?= number_format($room->price, 0, '', ' ') ?> ₽</span>
                                <span class="text-muted small">/ ночь</span>
                            </div>
                            <div class="d-flex gap-2">
                                <a href="/hotel/rooms/view?id=<?= $room->id ?>" class="btn btn-outline-success">Подробнее</a>
                                <a href="/hotel/booking/index?room_id=<?= $room->id ?>" class="btn btn-success">Забронировать</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>