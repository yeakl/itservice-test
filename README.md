#Первая установка


```bash
docker-compose build
docker volume create --name=itservice_mysql
docker-compose up -d
docker-compose exec php-fpm composer install
docker-compose exec php-fpm ./init --env=Development -y
docker-compose exec php-fpm ./yii migrate
```

#Повторный запуск
```bash
export UID
docker-compose up -d
```