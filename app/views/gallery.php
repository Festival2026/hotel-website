<div class="container my-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Фото отеля</h2>
        <p class="text-muted">Оцените красоту и уют «Лесной сказки»</p>
    </div>

    <div class="row">
        <?php 
        // Массив с картинками: Имя файла => Подпись
        // ВАЖНО: Убедись, что эти файлы реально лежат в папке public/assets/img/
        $images = [
            'hotel_main.jpg'    => 'Фасад отеля',
            'room_lux.jpg'      => 'Номер Люкс',
            'room_standard.jpg' => 'Номер Стандарт',
            'nature.jpg'        => 'Природа вокруг',
            'restaurant.jpg'    => 'Наш ресторан',
            'room_family.jpg'   => 'Семейный номер'
        ];

        foreach ($images as $file => $caption): 
            // Проверяем, существует ли файл физически на сервере
            if (file_exists('public/assets/img/' . $file)): 
        ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 overflow-hidden h-100">
                    <img src="/hotel/public/assets/img/<?= $file ?>" class="card-img-top" alt="<?= $caption ?>" style="height: 250px; object-fit: cover;">
                    <div class="card-body text-center bg-light">
                        <h5 class="card-title mb-0"><?= $caption ?></h5>
                    </div>
                </div>
            </div>
        <?php 
            endif; 
        endforeach; 
        ?>
    </div>
</div>