<section>
    <h2>Управление номерами</h2>
    
    <form action="/hotel/admin/rooms/save" method="POST" enctype="multipart/form-data" class="card p-4 mb-4 shadow-sm border-0">
        <!-- Скрытое поле для ID (если мы редактируем) -->
        <input type="hidden" name="id" value="<?= $model['edit_room']->id ?? '' ?>">
        
        <h4><?= $model['edit_room'] ? 'Редактировать номер ID: ' . $model['edit_room']->id : 'Добавить новый номер' ?></h4>
        <hr>

        <div class="mb-3">
            <label>Название номера:</label>
            <input type="text" name="title" required class="form-control" value="<?= htmlspecialchars($model['edit_room']->title ?? '') ?>">
        </div>
        
        <div class="mb-3">
            <label>Описание:</label>
            <textarea name="description" rows="3" required class="form-control"><?= htmlspecialchars($model['edit_room']->description ?? '') ?></textarea>
        </div>
        
        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Цена (руб):</label>
                <input type="number" name="price" required class="form-control" value="<?= $model['edit_room']->price ?? '' ?>">
            </div>
            <div class="col-md-4 mb-3">
                <label>Вместимость (чел):</label>
                <input type="number" name="capacity" value="<?= $model['edit_room']->capacity ?? '2' ?>" required class="form-control">
            </div>
            <div class="col-md-4 mb-3">
                <label>Фото (оставьте пустым, чтобы не менять):</label>
                <input type="file" name="image" class="form-control">
            </div>
        </div>
        
        <button type="submit" class="btn btn-success"><?= $model['edit_room'] ? 'Сохранить изменения' : 'Добавить номер' ?></button>
        <?php if($model['edit_room']): ?>
            <a href="/hotel/admin/rooms/index" class="btn btn-secondary">Отмена</a>
        <?php endif; ?>
    </form>

    <h3>Список номеров</h3>
    <table class="table table-bordered bg-white shadow-sm">
        <tr class="table-dark-green text-white">
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Вместимость</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($model['rooms'] as $room): ?>
        <tr>
            <td><?= $room->id ?></td>
            <td><?= htmlspecialchars($room->title) ?></td>
            <td><?= $room->price ?> ₽</td>
            <td><?= $room->capacity ?> чел.</td>
            <td>
                <a href="/hotel/admin/rooms/index?id=<?= $room->id ?>" class="btn btn-sm btn-warning">Редактировать</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>