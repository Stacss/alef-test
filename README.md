# Описание проекта

Этот проект является тестовым заданием для разработки API-методов для работы с базой данных. В данном приложении реализовано API для управления студентами, классами(группами) и лекциями.

## Установка и настройка

1. Склонируйте репозиторий: `git clone https://github.com/Stacss/alef-test.git`
2. Перейдите в каталог проекта: `cd alef-test`
3. Установите зависимости: `composer install`
4. Настройте файл окружения `.env` с параметрами подключения к базе данных
5. Выполните миграции: `php artisan migrate`
6. Запустите сервер: `php artisan serve`
7. Дамп базы данных для примера находится в корне проекта, имя файла alef.sql

## Документация API

Документация API доступна по ссылке /api/documentation. В документации Swagger представлены все доступные методы API, их параметры и примеры запросов и ответов.

## Использование API

Проект предоставляет следующие функции через API:

- Создание, обновление и удаление студентов, групп и лекций
- Получение списка студентов, групп и лекций
- Добавление и удаление студентов из группы
- Управление учебным планом группы
- Получение информации о прослушанных лекциях студентами и группами

API реализовано с помощью фреймворка Laravel.
