<?php if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>

<script src="https://api-maps.yandex.ru/2.1/?apikey=YOUR_API_KEY&lang=ru_RU" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container">
    <h1>Адреса офисов</h1>
    <div class="row">
        <div class="col-md-6">
            <div id="map-all-offices" style="width: 100%; height: 500px;"></div>
        </div>
        <div class="col-md-6">
            <? if (!empty($arResult)) :
                foreach ($arResult as $office) : ?>
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3><?= $office["OFFICE_NAME"] ?></h3>
                            <p>Телефон: <?= $office["OFFICE_PHONE"] ?></p>
                            <p>Email: <?= $office["OFFICE_EMAIL"] ?></p>
                            <p>Город: <?= $office["OFFICE_CITY"] ?></p>

                            <button class="btn btn-primary toggle-details" data-bs-toggle="collapse" data-bs-target="#office-details-<?= $office["ID"] ?>">
                                Показать подробности
                            </button>

                            <div id="office-details-<?= $office["ID"] ?>" class="collapse mt-3">
                                <p>Координаты: <?= $office["OFFICE_COORDINATES"] ?></p>
                                <div id="map_<?= $office["ID"] ?>" style="width: 40%; height: 300px;"></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <? else : ?>
                <p>Офисы не найдены!</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
    ymaps.ready(function() {
        // Создаем общую карту всех офисов
        var mapAllOffices = new ymaps.Map("map-all-offices", {
            center: [55.7558, 37.6173],
            zoom: 10
        });

        // Создаем массив меток для всех офисов
        var placemarks = [
            <? foreach ($arResult as $office) : ?> {
                    coordinates: "<?= $office["OFFICE_COORDINATES"] ?>",
                    name: "<?= $office["OFFICE_NAME"] ?>",
                    id: "<?= $office["ID"] ?>"
                },
            <? endforeach; ?>
        ];

        // Создаем переменную для хранения текущего открытого офиса
        var openOfficeId = null;

        // Функция для создания карты и метки
        function createMapAndPlacemark(lat, long, hintContent, mapId) {
            var myMap = new ymaps.Map(mapId, {
                center: [lat, long],
                zoom: 15
            });

            var myPlacemark = new ymaps.Placemark([lat, long], {
                hintContent: hintContent
            });

            myMap.geoObjects.add(myPlacemark);

            return myMap;
        }

        // Функция для открытия и закрытия деталей офиса
        function toggleOfficeDetails(officeId) {
            var officeDetails = document.getElementById("office-details-" + officeId);
            if (officeDetails) {
                officeDetails.classList.toggle('show');
            }
        }

        // Добавляем метки на общую карту и настраиваем всплывающие окна
        placemarks.forEach(function(place) {
            var coordinatesArray = place.coordinates.split(", ");
            var latitude = parseFloat(coordinatesArray[0]);
            var longitude = parseFloat(coordinatesArray[1]);
            var officeId = place.id;

            var myPlacemark = new ymaps.Placemark([latitude, longitude], {
                hintContent: place.name
            });

            mapAllOffices.geoObjects.add(myPlacemark);

            myPlacemark.events.add('click', function() {
                if (openOfficeId === officeId) {
                    toggleOfficeDetails(officeId);
                    openOfficeId = null;
                } else {
                    if (openOfficeId !== null) {
                        toggleOfficeDetails(openOfficeId);
                    }
                    toggleOfficeDetails(officeId);
                    openOfficeId = officeId;
                }
            });

            var buttons = document.querySelectorAll('.toggle-details');
            buttons.forEach(function(button) {
                button.addEventListener('click', function() {
                    var officeId = this.getAttribute('data-bs-target').replace('#office-details-', '');
                    toggleOfficeDetails(officeId);
                });
            });

            var mapId = "map_" + officeId;
            createMapAndPlacemark(latitude, longitude, place.name, mapId);
        });

        // Установить границы карты по всем меткам
        mapAllOffices.setBounds(mapAllOffices.geoObjects.getBounds());
    });
</script>