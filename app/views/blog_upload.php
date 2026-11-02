<section>
    <h2>Загрузка сообщений блога из CSV</h2>
    <p>Выберите файл формата .csv. Ожидаемый формат: <code>"тема","сообщение","автор","YYYY-MM-DD HH:MM"</code></p>

    <form action="/mysite/blog/processCsv" method="post" enctype="multipart/form-data" novalidate>
        <label for="csv_file">Выберите CSV-файл:</label>
        <input type="file" id="csv_file" name="csv_file" accept=".csv" required><br><br>

        <input type="submit" value="Загрузить и добавить записи">
    </form>

    <p><a href="/mysite/blog/editor">← Вернуться в редактор блога</a></p>

    <!-- Модальное окно для script.js -->
    <div id="confirmationModal" class="modal-overlay" style="display: none;">
        <div id="confirmationWindow" class="modal-window">
            <div id="confirmationMessage">Вы уверены, что хотите загрузить файл?</div>
            <button id="confirmButton">Подтвердить</button>
            <button id="cancelButton">Отменить</button>
        </div>
    </div>
</section>