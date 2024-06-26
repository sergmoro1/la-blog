# la-blog - пример api для блога
## Таблицы

Блог состоит из [постов](https://github.com/sergmoro1/la-blog/tree/master/app/database/migrations/2021_09_15_144351_create_posts_table.php "posts table creation").
Посты могут быть помечены [тегами](https://github.com/sergmoro1/la-blog/tree/master/app/database/migrations/2022_04_29_085413_create_tags_table.php "tags table creation").
Для понимания того, какие теги относятся к данному посту и какие посты помечены данным тегом используется таблица [связей](https://github.com/sergmoro1/la-blog/blob/master/app/database/migrations/2022_04_29_090203_create_post_tag_table.php "post_tag table creation").

## Требования
- при запросе конкретного поста должы выводятся все, относящиеся к нему теги;
- при запросе конкретного тега должны выводятся все, помеченные этим тегом посты;
- запросы к api должны быть защищены Basic авторизацией;
- api должно быть покрыто [тестами](https://github.com/sergmoro1/la-blog/tree/master/app/tests/Unit "unit tests");
- api должно быть [задокументировано](https://github.com/sergmoro1/la-blog/blob/master/app/app/Http/Controllers/Controller.php "Swagger");
- локальная среда должна быть определена в [docker](https://github.com/sergmoro1/la-blog/blob/master/docker-compose.yml);
- при внесении изменений в код репозитария, должен использоваться механизм workflows от github для [запуска тестов](https://github.com/sergmoro1/la-blog/blob/master/.github/workflows/ci.yml "Continuous Integration"). 

## Инициализация
Выполнить в директории приложения
```
make shell-cli
# php artisan migrate
# php artisan db:seed
```

## Запуск тестов локально
Выполнить в директории приложения
```
make shell-cli
# php artisan test
```

## Swagger
Генерация файла [swagger](https://zircote.github.io/swagger-php/) определений API
```
./vendor/bin/openapi app -o doc/openapi.yaml
```
Просмотр по адресу - http://your-site.local:8080.

## Настройка IDE VSCode
В проекте используется IDE `VSCode` и отладчик `xDebug`, `Docker` и `Laravel`. Как связать все вместе можно прочитать в каталоге [.vscode](https://github.com/sergmoro1/la-blog/tree/master/.vscode "VSCode + xDebug + Docker + Laravel") проекта.
