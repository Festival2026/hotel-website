<div class="container" style="margin-top: 100px; margin-bottom: 100px;">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-dark-green text-white text-center py-3">
                    <h3 class="mb-0">Вход на сайт</h3>
                </div>
                <div class="card-body p-4">
                    <?php if (isset($model['error'])): ?>
                        <div class="alert alert-danger text-center"><?= htmlspecialchars($model['error']) ?></div>
                    <?php endif; ?>
                    <form action="/hotel/account/login" method="post">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Логин:</label>
                            <input type="text" name="login" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Пароль:</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success w-100 btn-lg">Войти</button>
                    </form>
                    <p class="text-center mt-3 mb-0">Нет аккаунта? <a href="/hotel/account/register">Зарегистрироваться</a></p>
                </div>
            </div>
        </div>
    </div>
</div>