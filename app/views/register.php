<section>
    <h2>Регистрация пользователя</h2>
    
    <?= isset($model['validator']) ? $model['validator']->ShowErrors() : '' ?>

    <form action="/mysite/account/register" method="post" novalidate>
        <label for="fio">ФИО:</label>
        <input type="text" id="fio" name="fio" value="<?= htmlspecialchars($model['post']['fio'] ?? '') ?>" required><br>

        <label for="email">E-mail:</label>
        <input type="email" id="email" name="email" value="<?= htmlspecialchars($model['post']['email'] ?? '') ?>" required><br>

        <label for="login">Логин:</label>
        <input type="text" id="login" name="login" value="<?= htmlspecialchars($model['post']['login'] ?? '') ?>" required>
        <span id="login-status"></span><br>

        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required><br>

        <input type="submit" value="Зарегистрироваться">
    </form>
    <p>Уже есть аккаунт? <a href="/mysite/account/login">Войти</a></p>

    <div id="confirmationModal" class="modal-overlay" style="display: none;">
        <div id="confirmationWindow" class="modal-window">
            <div id="confirmationMessage">Вы уверены, что хотите отправить форму?</div>
            <button id="confirmButton">Подтвердить</button>
            <button id="cancelButton">Отменить</button>
        </div>
    </div>
	<script>
document.addEventListener('DOMContentLoaded', function() {
    const loginInput = document.getElementById('login');
    const statusSpan = document.getElementById('login-status');

    loginInput.addEventListener('blur', function() {
        const login = this.value.trim();
        if (login === '') {
            statusSpan.innerHTML = '';
            return;
        }

        statusSpan.innerHTML = 'Проверка...';

        // Отправляем запрос через Fetch API
        fetch('/mysite/account/checkLogin', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'login=' + encodeURIComponent(login)
        })
        .then(response => response.text()) // Ожидаем HTML
        .then(html => {
            statusSpan.innerHTML = html; // Вставляем HTML как есть
        })
        .catch(error => {
            statusSpan.innerHTML = 'Ошибка';
            console.error(error);
        });
    });
});
</script>
</section>