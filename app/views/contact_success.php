<section>
    <h2>Сообщение успешно отправлено!</h2>
    <p>Спасибо, <strong><?= htmlspecialchars($model['post']['name']) ?></strong>, ваше сообщение получено.</p>
    <p>Мы свяжемся с вами по адресу <strong><?= htmlspecialchars($model['post']['email']) ?></strong>.</p>
    <p><a href="/mysite/page/index">← Вернуться на главную</a></p>
</section>