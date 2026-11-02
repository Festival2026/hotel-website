<h2 class="mb-4">Управление отзывами</h2>

<?php if (empty($model['reviews'])): ?>
    <div class="alert alert-info">Пока нет ни одного отзыва.</div>
<?php else: ?>
    <div class="table-responsive">
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark-green text-white">
                <tr>
                    <th>Дата</th>
                    <th>Автор</th>
                    <th>Оценка</th>
                    <th>Текст отзыва</th>
                    <th>Статус</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model['reviews'] as $rev): ?>
                <tr>
                    <td><?= date('d.m.Y', strtotime($rev->created_at)) ?></td>
                    <td><?= htmlspecialchars($rev->author_name) ?></td>
                    <td class="text-warning"><?= str_repeat('★', $rev->rating) ?></td>
                    <td><?= htmlspecialchars($rev->text) ?></td>
                    <td>
                        <?php if ($rev->is_approved): ?>
                            <span class="badge bg-success">Одобрен</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">На модерации</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <?php if (!$rev->is_approved): ?>
                                <form action="/hotel/admin/reviews/approve" method="POST">
                                    <input type="hidden" name="id" value="<?= $rev->id ?>">
                                    <button type="submit" class="btn btn-sm btn-success">Одобрить</button>
                                </form>
                            <?php endif; ?>
                            <form action="/hotel/admin/reviews/delete" method="POST">
                                <input type="hidden" name="id" value="<?= $rev->id ?>">
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Удалить отзыв?')">Удалить</button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>