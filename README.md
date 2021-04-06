# Тестовое задание для Ай Ти Сервис

Реализовано на базе фреймворка Yii2, окружение разворачивается через docker.

## Разворачивание окружения
### Первая установка

```bash
cp .env.dist .env
docker-compose build
docker volume create --name=itservice_mysql
docker-compose up -d
docker-compose exec php-fpm composer install
docker-compose exec php-fpm ./init --env=Development -y
docker-compose exec php-fpm ./yii migrate
```

### Повторный запуск
```bash
export UID
docker-compose up -d
```

### Использование
1. **Импорт новостей**
   <p>За импорт отвечает консольная команда import/news</p>
   <p>Вызывается подобным образом:</p>
   
   ```docker-compose exec php-fpm ./yii import/news liferu```
   <p>где liferu - ресурс, с которого получаются новости</p>
   <br>
   <p>Парсер построен таким образом, что можно добавить несколько ресурсов для получения новостей.
   Для того, чтобы добавить новый обработчик ресурса, нужно отнаследоваться от абстрактного класса 
   \console\components\news\Resource.php, реализовать в нем метод getRecords() и дополнить конструктор парсера
   \console\components\news\Parser.php новым обработчиком. Сейчас все сделано для обработчика 
   \console\components\news\LifeRu.php
   </p>
   <br>
   
2. **Реализованные HTTP-методы**
   - GET /news
   - GET /news/{id}
   - DELETE /news/{id}
   <p>Базовый url сервиса - http://localhost:8080/, т.е. все запросы нужно осуществлять к нему</p>
   <p>Реализовано через \yii\rest\ActiveController.</p>
   <p>При запросе GET /news можно добавить параметры limit или offset. Если параметры не добавлены, то возвращаются все новости.</p>
<br>

## Этапы реализации ##
(в скобках указаны конкретные коммиты)
1. Установлен чистый Yii2 Advanced фреймворк ([bb014d2](https://github.com/yeakl/itservice-test/commit/bb014d2dd538535c54072916c3bd36cdd7055b91))
2. Подготовка проекта ([4c70bf4](https://github.com/yeakl/itservice-test/commit/4c70bf4d4412dd80a2327ae6048e8f7a54a323be))
   - Добавлено api-приложение
   - Убраны ненужные приложения, которые идут из коробки фреймворка (frontend, backend)
   - Добавлена docker-конфигурация
   - Добавлен базовый SiteController, для проверки работоспособности запросов к сервису.
3. Добавлена таблица news в базу данных с помощью миграций, добавлена ActiveRecord модель для этой таблицы. ([2e5b77e](https://github.com/yeakl/itservice-test/commit/2e5b77ed32be72d1830e26b4d83d43526c9af717))
4. Реализован парсинг новостных ресурсов ([228c247](https://github.com/yeakl/itservice-test/commit/228c24737a321f8d48f0aeafaa6e747bfbd1ff83))
   - Добавлен парсер, с возможностью подключения обработчиков разных новостных ресурсов
   - Добавлен обработчик life.ru
   - Добавлена консольная команда, с помощью которой производится импорт
5. Реализовано обращение к сервису с помощью HTTP-запросов ([377b7fa](https://github.com/yeakl/itservice-test/commit/377b7fa0cb842e947982479489c4f6c6eaed7e4c))
   - Добавлен контроллер NewsController
   
### Комментарий по реализации ###
Таблица новостей состоит из колонок id, title, image, url, external_id. В external_id записывается
идентификатор новости в новостном ресурсе (в случае с life.ru это поле _id). Это поле используется только при импорте.
Во время импорта новостям присваиваются свои идентификаторы (автоинкрементное поле id) и доступ с помощью http-запросов 
осуществляется именно по этим идентификаторам, а не внешним. (Это из задания не совсем четко понятно, поэтому сделано так, как это было понятно мной).

При выводе новостей (с помощью GET запросов) поле external_id скрывается с помощью метода fields() AR-модели и возвращаются только поля id, title, image, url.
