<h2 class="mb-4">Управление страницами</h2>
<p class="text-muted">Здесь вы можете редактировать текстовое наполнение страниц вашего сайта.</p>

<div class="table-responsive">
    <table class="table table-bordered table-hover bg-white shadow-sm">
        <thead class="table-dark-green text-white">
            <tr>
                <th>URL (Slug)</th>
                <th>Название страницы</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($model['pages'] as $page): ?>
            <tr>
                <td><code>/<?= htmlspecialchars($page->slug) ?></code></td>
                <td><?= htmlspecialchars($page->title) ?></td>
                <td>
                    <a href="/hotel/admin/pages/edit?id=<?= $page->id ?>" class="btn btn-sm btn-success">Редактировать</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>