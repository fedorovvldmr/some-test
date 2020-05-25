### Задание
Имеются таблицы: пользователей, новостей и фотографий на базе стека Laravel, Vue и postgers(или mysql) реализовать функционал управления новостями и фотографиями (CRUD) и возможность пользователем поставить лайк новости или фотографиию

#### Установка
Создать в базе таблицу и заполнить .env
```shell script
composer install
npm ci
php artisan migrate
php artisan db:seed

```

#### Тестовый пользователь
```
some_user@gmail.com
some_password
```