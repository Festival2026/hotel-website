<section>
    <h2>Загрузка сообщений гостевой книги</h2>
    <p>Выберите файл <code>messages.inc</code> для загрузки на сервер.</p>
    <form action="/mysite/admin/guestbook/processUpload" method="post" enctype="multipart/form-data" novalidate>
        <label for="book_file">Выберите файл (.inc или .txt):</label>
        <input type="file" id="book_file" name="book_file" required><br><br>
        <input type="submit" value="Загрузить файл">
    </form>
</section>
<!-- Модальное окно для script.js -->
<div id="confirmationModal" class="modal-overlay" style="display: none;">
    <div id="confirmationWindow" class="modal-window">
        <div id="confirmationMessage">Вы уверены, что хотите загрузить файл?</div>
        <button id="confirmButton">Подтвердить</button>
        <button id="cancelButton">Отменить</button>
    </div>
</div>