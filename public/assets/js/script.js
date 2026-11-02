// Массивы с именами фотографий и их подписями
$(function () {
	const PHOTOS = window.PHOTOS || [];
    const fotos  = PHOTOS.map(p => p.src);
    const titles = PHOTOS.map(p => p.title);

    let currentIndex = 0;

    function showImage(index) {
        const $largeImage = $("#largeImage");
        const $imageCounter = $("#imageCounter");

        $largeImage.fadeOut(150, function () {
            $largeImage.attr({
                src: fotos[index],
                alt: titles[index],
                title: titles[index]
            }).fadeIn(150);
        });

        // Обновляем текст с номером фото
        $imageCounter.text(`Фото ${index + 1} из ${fotos.length}`);
    }

// Обработчик клика по картинке
    $(document).on("click", ".album-photo", function () {
        currentIndex = parseInt($(this).data("index")) || 0;
        showImage(currentIndex);
        $("#largeImageContainer").fadeIn(300);
    });

      // Стрелки
    $("#prevImage").on("click", function (e) {
        e.stopPropagation();
        currentIndex = (currentIndex - 1 + fotos.length) % fotos.length;
        showImage(currentIndex);
    });

    $("#nextImage").on("click", function (e) {
        e.stopPropagation();
        currentIndex = (currentIndex + 1) % fotos.length;
        showImage(currentIndex);
    });

    $("#closeButton").on("click", function () {
        $("#largeImageContainer").fadeOut(200);
    });

    $("#largeImageContainer").on("click", function (e) {
        if (e.target === this) {
            $(this).fadeOut(200);
        }
    });
});


// Функция валидации теста на странице "Тест по дисциплине"
function validateTestForm() {
    const name = $('#name').val();
    const group = $('#group').val();
    const question1 = $('#question1').val();
    const question2 = $('input[name="question2"]:checked').length;
    const question3 = $('#question3').val();

    if (!name) {
        alert("Пожалуйста, укажите Фамилию, Имя и Отчество.");
        $('#name').focus();
        return false;
    }

    if (!group) {
        alert("Пожалуйста, выберите группу.");
        $('#group').focus();
        return false;
    }

    if (!question1) {
        alert("Пожалуйста, ответьте на вопрос 1.");
        $('#question1').focus();
        return false;
    }

    // Проверка, что выбрано хотя бы два переключателя для вопроса 2
    if (question2 < 2) {
        alert("Пожалуйста, выберите хотя бы два метода для решения интегралов.");
        $('input[name="question2"]').focus();
        return false;
    }

    if (!question3) {
        alert("Пожалуйста, выберите метод для решения дифференциальных уравнений.");
        $('#question3').focus();
        return false;
    }

    return true;
}


function updateDateTime() {
    const currentDate = new Date();

    const day = currentDate.getDate();
    const month = currentDate.toLocaleString('ru-RU', { month: 'long' });
    const year = currentDate.getFullYear();
    const hours = currentDate.getHours();
    const minutes = currentDate.getMinutes().toString().padStart(2, '0');
    const seconds = currentDate.getSeconds().toString().padStart(2, '0');

    let hoursText;
    if (hours === 1 || hours === 21) {
        hoursText = `${hours} час,`;
    } else if ([2, 3, 4, 22, 23, 24].includes(hours)) {
        hoursText = `${hours} часа,`;
    } else {
        hoursText = `${hours} часов,`;
    }

    const dateStr = `${hoursText} ${month} ${year}`;

    $('#current-time').text(dateStr);
}



$(function () {
    if ($('#current-time').length) { // Проверим, есть ли элемент с id "current-time"
        updateDateTime();  // Обновляем время сразу
        setInterval(updateDateTime, 1000);  // Обновляем время каждую секунду
    }
});



$(function () {
    const $dobInput = $('#dob');
    const $calendar = $('#calendar');
    const $monthSelect = $('#month-select');
    const $yearSelect = $('#year-select');
    const $calendarBody = $('#calendar-body');

    if (!$dobInput.length || !$calendar.length || !$monthSelect.length || !$yearSelect.length || !$calendarBody.length) return;

    const monthNames = [
        'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь',
        'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'
    ];

    let selectedMonth, selectedYear;

    $dobInput.on('click', function (e) {
        $calendar.show();
        positionCalendar();
        setupSelectors();
        generateCalendar();
        e.stopPropagation(); // Останавливаем дальнейшее распространение события
    });

        $(document).on('click', function (e) {
        // Если кликнули НЕ по календарю (и его потомкам) И НЕ по полю ввода — скрываем
        if (!$(e.target).closest($calendar).length && !$(e.target).closest($dobInput).length) {
            $calendar.hide();
        }
    });

    function positionCalendar() {
        const rect = $dobInput[0].getBoundingClientRect();
        $calendar.css('top', $dobInput.outerHeight() + 5);
    }

    function setupSelectors() {
        const currentDate = new Date();
        selectedMonth = currentDate.getMonth();
        selectedYear = currentDate.getFullYear();

        $monthSelect.empty();
        $yearSelect.empty();

        monthNames.forEach((name, i) => {
            const $option = $('<option>', {
                value: i,
                text: name,
                selected: i === selectedMonth
            });
            $monthSelect.append($option);
        });

        for (let y = currentDate.getFullYear() - 100; y <= currentDate.getFullYear(); y++) {
            const $option = $('<option>', {
                value: y,
                text: y,
                selected: y === selectedYear
            });
            $yearSelect.append($option);
        }

        $monthSelect.on('change', function () {
            selectedMonth = parseInt($monthSelect.val());
            generateCalendar();
        });

        $yearSelect.on('change', function () {
            selectedYear = parseInt($yearSelect.val());
            generateCalendar();
        });
    }

    function generateCalendar() {
        $calendarBody.empty();

        const firstDay = new Date(selectedYear, selectedMonth, 1);
        const lastDay = new Date(selectedYear, selectedMonth + 1, 0);
        const firstWeekDay = (firstDay.getDay() + 6) % 7;

        let day = 1;

        for (let i = 0; i < 6; i++) {
            const $row = $('<tr>');

            for (let j = 0; j < 7; j++) {
                const $cell = $('<td>');

                if (i === 0 && j < firstWeekDay) {
                    $cell.text('');
                } else if (day <= lastDay.getDate()) {
                    $cell.text(day);
                    const currentDay = day;
                    $cell.on('click', function () {
                        $dobInput.val(formatDate(selectedMonth, currentDay, selectedYear));
                        $calendar.hide();
                    });
                    day++;
                } else {
                    $cell.text('');
                }

                $row.append($cell);
            }

            $calendarBody.append($row);
            if (day > lastDay.getDate()) break;
        }
    }

    function formatDate(month, day, year) {
        const m = (month + 1).toString().padStart(2, '0');
        const d = day.toString().padStart(2, '0');
        return `${m}/${d}/${year}`;
    }
});



$(function () {
    function updatePageVisitCount() {
        const path = location.pathname; // например, /mysite/page/about

        if (path.indexOf("history") !== -1) return; // Исключаем саму страницу истории

        let sessionCount = localStorage.getItem("session_" + path);
        sessionCount = sessionCount ? parseInt(sessionCount) + 1 : 1;
        localStorage.setItem("session_" + path, sessionCount);

        let totalCount = getCookie("total_" + path);
        totalCount = totalCount ? parseInt(totalCount) + 1 : 1;
        setCookie("total_" + path, totalCount, 365);
    }

    function setCookie(name, value, expiration_days) {
        const d = new Date();
        d.setTime(d.getTime() + (expiration_days * 24 * 60 * 60 * 1000));
        const expires = "expires=" + d.toUTCString();
        document.cookie = `${name}=${encodeURIComponent(value)}; ${expires}; path=/; SameSite=Lax`;
    }

    function getCookie(name) {
        const matches = document.cookie.match(new RegExp(
            "(?:^|; )" + name.replace(/([.$?*|{}()[\]\\/+^])/g, '\\$1') + "=([^;]*)"
        ));
        return matches ? decodeURIComponent(matches[1]) : undefined;
    }

    if (document.title.includes("История просмотра")) {
        fillHistoryTables();
    }

    // Заполнение таблиц истории
    function fillHistoryTables() {
        const pages = {
            "Главная": "/mysite/page/index",
            "Обо мне": "/mysite/page/about",
            "Мои интересы": "/mysite/page/interests",
            "Учеба": "/mysite/page/education",
            "Фотоальбом": "/mysite/page/album",
            "Контакт": "/mysite/contact/index",
            "Тест": "/mysite/test/index"
        };

        const $sessionTable = $("#session-history");
        const $totalTable = $("#total-history");

        for (const [label, path] of Object.entries(pages)) {
            const sessionCount = localStorage.getItem("session_" + path) || 0;
            const totalCount = getCookie("total_" + path) || 0;

            const $row1 = $("<tr>").appendTo($sessionTable);
            $row1.html(`<td>${label}</td><td>${sessionCount}</td>`);

            const $row2 = $("<tr>").appendTo($totalTable);
            $row2.html(`<td>${label}</td><td>${totalCount}</td>`);
        }
    }

    updatePageVisitCount();
});
