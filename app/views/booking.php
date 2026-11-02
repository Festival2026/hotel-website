<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-dark-green text-white text-center py-3">
                    <h3 class="mb-0">Забронировать номер</h3>
                </div>
                <div class="card-body p-4">
                    <form action="/hotel/booking/save" method="POST" id="bookingForm" novalidate>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold">Выберите номер</label>
                            <select name="room_id" id="roomSelect" class="form-select" required>
                                <option value="">-- Выберите номер --</option>
                                <?php foreach ($model['rooms'] as $room): ?>
                                    <option value="<?= $room->id ?>" 
                                            data-price="<?= $room->price ?>"
                                            <?= ($model['selected_room_id'] === $room->id) ? 'selected' : '' ?>>
                                        <?= htmlspecialchars($room->title) ?> (<?= number_format($room->price, 0, '', ' ') ?> ₽/ночь)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Дата заезда</label>
                                <input type="date" name="check_in" id="checkIn" class="form-control" required min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Дата выезда</label>
                                <input type="date" name="check_out" id="checkOut" class="form-control" required min="<?= date('Y-m-d', strtotime('+1 day')) ?>">
                            </div>
                        </div>

                        <div class="alert alert-info d-flex justify-content-between align-items-center" id="priceAlert" style="display: none;">
                            <span>Предварительная стоимость (за <span id="daysCount">0</span> ноч.):</span>
                            <strong class="fs-4" id="totalPrice">0 ₽</strong>
                        </div>

                        <hr>

                        <div class="mb-3">
                            <label class="form-label fw-bold">ФИО гостя</label>
                            <input type="text" name="fio" class="form-control" placeholder="Иванов Иван Иванович" required>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Телефон</label>
                                <input type="tel" name="phone" class="form-control" placeholder="+7 (978) 123-45-67" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">E-mail</label>
                                <input type="email" name="email" class="form-control" placeholder="example@mail.ru" required>
                            </div>
							<div class="mb-3">
    <label class="form-label fw-bold">Промокод (если есть)</label>
    <input type="text" name="promo_code" class="form-control" placeholder="Например: AUTUMN2026">
</div>
                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-success btn-lg px-5">Отправить заявку</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JS для расчета стоимости -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomSelect = document.getElementById('roomSelect');
    const checkIn = document.getElementById('checkIn');
    const checkOut = document.getElementById('checkOut');
    const priceAlert = document.getElementById('priceAlert');
    const daysCountSpan = document.getElementById('daysCount');
    const totalPriceSpan = document.getElementById('totalPrice');

    function calculatePrice() {
        const roomOption = roomSelect.options[roomSelect.selectedIndex];
        const pricePerNight = parseFloat(roomOption.getAttribute('data-price')) || 0;
        
        const date1 = new Date(checkIn.value);
        const date2 = new Date(checkOut.value);

        // Проверяем, что даты выбраны и дата выезда позже даты заезда
        if (checkIn.value && checkOut.value && date2 > date1) {
            const timeDiff = date2.getTime() - date1.getTime();
            const days = Math.ceil(timeDiff / (1000 * 3600 * 24)); // Количество дней
            
            if (days > 0 && pricePerNight > 0) {
                const total = days * pricePerNight;
                daysCountSpan.textContent = days;
                totalPriceSpan.textContent = total.toLocaleString('ru-RU') + ' ₽';
                priceAlert.style.display = 'flex';
                return;
            }
        }
        
        // Если данные неполные или некорректные — скрываем блок
        priceAlert.style.display = 'none';
    }

    // Слушаем изменения в полях
    roomSelect.addEventListener('change', calculatePrice);
    checkIn.addEventListener('change', calculatePrice);
    checkOut.addEventListener('change', calculatePrice);
});
</script>