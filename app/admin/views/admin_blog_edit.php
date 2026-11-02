<section>
    <h2>Редактор Блога (Админка)</h2>

    <form action="/mysite/admin/blog/save" method="post" enctype="multipart/form-data" novalidate>
        <label for="title">Тема сообщения (обязательно):</label>
        <input type="text" id="title" name="title" 
               value="<?= htmlspecialchars($model['post']['title'] ?? '') ?>" required><br>

        <label for="image">Изображение (не обязательно):</label>
        <input type="file" id="image" name="image" accept="image/*"><br><br>

        <label for="message">Текст сообщения:</label><br>
        <textarea id="message" name="message" rows="6" cols="60" required><?= htmlspecialchars($model['post']['message'] ?? '') ?></textarea><br>

        <input type="submit" value="Сохранить запись">
    </form>
</section>

<!-- ... верхняя часть с формой добавления остается без изменений ... -->

<section>
    <h2>Список записей</h2>
    <?php if (empty($model['posts'])): ?>
        <p>Пока нет ни одной записи.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Тема</th>
                    <th>Изображение</th>
                    <th>Текст</th>
                    <th>Действия</th> <!-- НОВАЯ КОЛОНКА -->
                </tr>
            </thead>
            <tbody>
                <?php foreach ($model['posts'] as $post): ?>
                    <!-- ДОБАВИЛИ ID ДЛЯ СТРОКИ -->
                    <tr id="post-row-<?= $post->id ?>">
                        <td><?= htmlspecialchars($post->created_at) ?></td>
                        <td><?= htmlspecialchars($post->title) ?></td>
                        <td>
                            <?php if ($post->image): ?>
                                <img src="/mysite/public/assets/img/blog/<?= $post->image ?>" alt="Картинка" style="max-width: 100px;">
                            <?php else: ?>
                                Нет
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars(mb_substr($post->message, 0, 50)) ?>...</td>
                        <!-- КНОПКА РЕДАКТИРОВАНИЯ -->
                        <td>
                            <button onclick="openEdit(<?= $post->id ?>, '<?= htmlspecialchars(addslashes($post->title)) ?>', '<?= htmlspecialchars(addslashes($post->message)) ?>')" style="background: #4CAF50; color: white; border: none; padding: 5px 10px; cursor: pointer;">Изменить</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <!-- Блок пагинации для редактора -->
        <?php if ($model['pagination']['total_pages'] > 1): ?>
            <div class="pagination" style="margin-top: 20px; padding: 10px; background: #eee; border-radius: 5px;">
                <strong>Страницы:</strong>
                <?php for ($i = 0; $i < $model['pagination']['total_pages']; $i++): ?>
                    <?php if ($i === $model['pagination']['current_page']): ?>
                        <span style="font-weight: bold; margin: 0 5px; color: #4CAF50;"><?= $i + 1 ?></span>
                    <?php else: ?>
                        <a href="/mysite/admin/blog/editor?page=<?= $i ?>" style="margin: 0 5px; text-decoration: none; color: #333;"><?= $i + 1 ?></a>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>
        <?php endif; ?>

    <?php endif; ?>
</section>

<!-- МОДАЛЬНОЕ ОКНО ДЛЯ РЕДАКТИРОВАНИЯ -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999;">
    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 5px; width: 400px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);">
        <h3 style="margin-top: 0;">Редактировать запись</h3>
        
        <input type="hidden" id="edit_id">
        
        <label>Тема:</label><br>
        <input type="text" id="edit_title" style="width: 100%; margin-bottom: 10px; padding: 5px;"><br>
        
        <label>Текст:</label><br>
        <textarea id="edit_message" rows="5" style="width: 100%; margin-bottom: 10px; padding: 5px;"></textarea><br>
        
        <button onclick="saveEdit()" style="background: #4CAF50; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Сохранить изменения</button>
        <button onclick="document.getElementById('editModal').style.display='none'" style="background: #f44336; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer;">Отмена</button>
    </div>
</div>

<script>
// Открытие окна и заполнение полей
function openEdit(id, title, message) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_title').value = title;
    document.getElementById('edit_message').value = message;
    document.getElementById('editModal').style.display = 'block';
}

// Отправка данных через динамический тег <script>
function saveEdit() {
    var id = document.getElementById('edit_id').value;
    var title = document.getElementById('edit_title').value;
    var message = document.getElementById('edit_message').value;

    // Формируем XML-строку
    var xmlString = '<post><id>' + id + '</id><title>' + title + '</title><message>' + message + '</message></post>';

    // Создаем тег <script>
    var script = document.createElement('script');
    // Передаем XML в качестве GET-параметра
    script.src = '/mysite/admin/blog/updateXml?data=' + encodeURIComponent(xmlString);
    
    // Добавляем тег на страницу, что вызовет запрос к серверу
    document.body.appendChild(script);
}

// Функция обратного вызова (ее вызывает сервер в ответе)
function processUpdate(id, title, message) {
    // Обновляем данные прямо в таблице без перезагрузки страницы
    var row = document.getElementById('post-row-' + id);
    if (row) {
        row.cells[1].innerText = title;
        row.cells[3].innerText = message.substring(0, 50) + '...';
    }
    
    // Закрываем окно
    document.getElementById('editModal').style.display = 'none';
}
</script>

<!-- Модальное окно для script.js -->
<div id="confirmationModal" class="modal-overlay" style="display: none;">
    <div id="confirmationWindow" class="modal-window">
        <div id="confirmationMessage">Вы уверены, что хотите сохранить запись?</div>
        <button id="confirmButton">Подтвердить</button>
        <button id="cancelButton">Отменить</button>
    </div>
</div>