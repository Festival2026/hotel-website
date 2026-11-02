<h2 class="mb-4">Заявки на бронирование</h2>

<?php if (empty($model['bookings'])): ?>
    <div class="alert alert-info">Пока нет ни одной заявки.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered table-hover bg-white shadow-sm">
            <thead class="table-dark-green text-white">
                <tr>
                    <th>Дата заявки</th>
                    <th>Номер</th>
                    <th>Гость</th>
                    <th>Контакты</th>
                    <th>Даты</th>
                    <th>Сумма</th>
                    <th>Статус</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model['bookings'] as $b): ?>
                <tr>
                    <td><?= date('d.m.Y H:i', strtotime($b->created_at)) ?></td>
                    <td><?= htmlspecialchars($model['roomsMap'][$b->room_id] ?? 'Неизвестно') ?></td>
                    <td><?= htmlspecialchars($b->fio) ?></td>
                    <td>
    <?= htmlspecialchars($b->phone) ?><br>
    <small class="text-muted"><?= htmlspecialchars($b->email) ?></small>
    <?php if ($b->promo_code): ?>
        <br><span class="badge bg-warning text-dark">Промокод: <?= htmlspecialchars($b->promo_code) ?></span>
    <?php endif; ?>
</td>
                    <td>
                        с <?= date('d.m.Y', strtotime($b->check_in)) ?><br>
                        по <?= date('d.m.Y', strtotime($b->check_out)) ?>
                    </td>
                    <td class="fw-bold text-success"><?= number_format($b->total_price, 0, '', ' ') ?> ₽</td>
                    <td>
                        <form action="/hotel/admin/bookings/updateStatus" method="POST" class="d-flex">
                            <input type="hidden" name="id" value="<?= $b->id ?>">
                            <select name="status" class="form-select form-select-sm me-2" onchange="this.form.submit()">
                                <option value="Новая" <?= $b->status === 'Новая' ? 'selected' : '' ?>>Новая</option>
                                <option value="Подтверждена" <?= $b->status === 'Подтверждена' ? 'selected' : '' ?>>Подтверждена</option>
                                <option value="Отклонена" <?= $b->status === 'Отклонена' ? 'selected' : '' ?>>Отклонена</option>
                            </select>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>