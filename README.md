# Task list

Для установки Копируем .env.example в .env Настраиваем бд (MariaDB >= 10.5.15)

Делаем
    composer install
    php artisan key:generate
    php artisan migrate
    php artisan db:seed

Дефолтый админ admin@example.ru / 12345678
