# Тестовое задание на PHP

## Фамилия Имя
Бородин Климентий

## Тестовое задание на PHP
Сервис чек-листов с админ-панелью и REST API.

## Описание проекта
Данный проект реализует сервис для управления чек-листами, включающий:
- Админку для управления пользователями и чек-листами (с разграничением прав и возможностью блокировки пользователей).
- REST API для регистрации, авторизации, создания и удаления чек-листов с учетом ограничения по их количеству.
- Добавление и удаление пунктов чек-листа.
- Отметку пунктов как выполненные/невыполненные.
- Получение списка чек-листов и списка пунктов с фильтрацией по статусу.

## Подготовительные действия
Для успешного запуска проекта выполните следующие шаги:

1. Клонируйте репозиторий:
    ```bash
    git clone <ссылка-на-репозиторий>
    cd checklist-service
    ```

2. Установите зависимости через Composer:
    ```bash
    composer install
    ```

3. Создайте файл окружения и сгенерируйте ключ приложения:
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4. Проверьте настройки базы данных в `.env`:
    ```
    DB_CONNECTION=sqlite
    ```

5. Создайте файл базы данных:
    ```bash
    touch database/database.sqlite
    ```

6. Запустите миграции:
    ```bash
    php artisan migrate
    ```

7. Запустите локальный сервер:
    ```bash
    php artisan serve
    ```

## Информация о доступах
Для тестирования API:

### Регистрация пользователя
**POST** `/api/register`

Пример Body (JSON):
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

### Логин пользователя
**POST** `/api/login`

Пример Body (JSON):
```json
{
    "name": "Test User",
    "email": "test@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

После успешного логина в ответе будет возвращен токен, который нужно использовать в заголовке всех защищенных запросов:
```bash 
{
    Authorization: Bearer {token}
}
```

### Получить список чек-листов
**GET** `/api/checklists`

### Создать чек-лист
**POST** `/api/checklists`

Пример Body (JSON):
```json
{
    "title": "My new checklist"
}
```

### Удалить чек-лист
**DELETE** `/api/checklists/{checklist}`

### Добавить пункт в чек-лист
**POST** `/api/checklists/{checklist}/items`

Пример Body (JSON):
```json
{
    "content": "My new checklist item"
}
```

### Удалить пункт чек-листа
**DELETE** `/api/checklists/{checklist}/items/{item}`

### Отметить пункт выполненным(true/false)
**PATCH** `/api/checklists/{checklist}/items/{item}`

Пример Body (JSON):
```json
{
    "completed": true
}
```

### Получить список пунктов чек-листа
**GET** `/api/checklists/{checklist}/items`

### Получить выполненные/невыполненные пункты чек-листа (default=false)
**GET** `/api/checklists/{checklist}/items?completed=true`
## Или
**GET** `/api/checklists/{checklist}/items?completed=false`
