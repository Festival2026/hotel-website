<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Отзывы наших гостей</h2>
        <p class="text-muted">Что говорят люди об отдыхе в «Лесной сказке»</p>
    </div>

    <div class="row">
        <!-- Левая колонка: список отзывов -->
        <div class="col-md-7">
            <?php if (isset($_GET['sent'])): ?>
                <div class="alert alert-success">Спасибо! Ваш отзыв отправлен на модерацию и скоро появится на сайте.</div>
            <?php endif; ?>

            <?php if (empty($model['reviews'])): ?>
                <p class="text-muted">Пока нет отзывов. Будьте первыми!</p>
            <?php else: ?>
                <?php foreach ($model['reviews'] as $rev): ?>
                    <div class="card mb-3 shadow-sm border-0">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title fw-bold mb-0 text-success"><?= htmlspecialchars($rev->author_name) ?></h5>
                                <span class="text-warning fs-5">
                                    <?php for($i=1; $i<=5; $i++): ?>
                                        <?= $i <= $rev->rating ? '★' : '☆' ?>
                                    <?php endfor; ?>
                                </span>
                            </div>
                            <p class="card-text"><?= nl2br(htmlspecialchars($rev->text)) ?></p>
                            <small class="text-muted"><?= date('d.m.Y', strtotime($rev->created_at)) ?></small>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Правая колонка: форма добавления -->
        <div class="col-md-5">
            <div class="card shadow border-0 bg-light">
                <div class="card-body p-4">
                    <h4 class="fw-bold mb-3">Оставить отзыв</h4>
                    <form action="/hotel/review/save" method="POST">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Ваше имя</label>
                            <input type="text" name="author_name" class="form-control" value="<?= htmlspecialchars($model['user_fio']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Оценка</label>
                            <select name="rating" class="form-select">
                                <option value="5">5 — Отлично</option>
                                <option value="4">4 — Хорошо</option>
                                <option value="3">3 — Нормально</option>
                                <option value="2">2 — Плохо</option>
                                <option value="1">1 — Ужасно</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Текст отзыва</label>
                            <textarea name="text" rows="4" class="form-control" required placeholder="Поделитесь впечатлениями..."></textarea>
                        </div>
                        <button type="submit" class="btn btn-success w-100">Отправить на модерацию</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>