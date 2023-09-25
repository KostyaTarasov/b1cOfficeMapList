# Вывод списка офисов через Яндекс.Карты на 1с bitrix

## Основные возможности на сайте:

- Создание модуля, создающего структуру и свойства инфоблока через API Bitrix
- Заполнение инфоблока контактами через API Bitrix
- Создание шаблона компонента контактов офисов
- Вывод списка офисов (API Яндекс.Карт)
- Вывод местоположения всех офисов на карте
- При клике на кнопку из списка либо на офисную точку на карте открывается соответствующая карточка с контактной информацией и местоположением на карте (API Яндекс.Карт)

## Основные технологии:

1. php 8
2. MySQL 5
3. 1с bitrix
4. Кэширование
5. API Яндекс.Карт
6. Bootstrap 5

## Версии

- PHP: 8.1.23
- MySQL: 5.7.43-47
- 1С-Битрикс: Управление сайтом 23

## Установка и запуск

1. Клонируйте репозиторий:

   ```
   git clone https://github.com/KostyaTarasov/b1cOfficeMapList.git
   ```

2. На чистый проект перенести папку "local"

3. В корне проекта разместить файл "index.php"

4. В административной панели Bitrix, в настройках продукта, выберать "Модули", затем включить новый модуль "Контакты"

5. Открыть главную страницу сайта