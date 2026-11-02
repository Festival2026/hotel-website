<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 p-5">
                <!-- Внимание: мы выводим контент БЕЗ htmlspecialchars, чтобы теги <h3> и <p> работали! -->
                <?= $model['page']->content ?>
            </div>
        </div>
    </div>
</div>