# Подключение xDebug к VSCode
*VSCode + Laravel + Docker + xDebug*

## Обеспечение запуска вебсервиса для xDebug
В корневом каталоге необходимо создать файл с именем php, следующего содержания

```
#!/bin/bash
docker exec -it <web_container_name> php $@
```

__web_container_name__ это имя контейнера web-сервиса. Например __blog-php-fpm__ в файле __docker_compose.yml__:

```
version: '3'

services:
    php-fpm:
        build:
            context: ./docker
            dockerfile: php-fpm.docker
        restart: unless-stopped
        container_name: blog-php-fpm
        extra_hosts:
            - "host.docker.internal:host-gateway"
        environment:
            - PHP_EXTENSION_XDEBUG:1
            - XDEBUG_MODE=develop,debug
        depends_on:
            - mysql
        env_file:
            - .env
        volumes:
            - ./app:/app
            - ./docker/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
            - ./app/storage/logs:/var/logs/xdebug
        networks:
            - internal
```

Сделать файл исполняемым.

```
chmod +x php
```

## Создать файл с параметрами xDebug

В корневом каталоге, возможно, уже есть каталог __docker__, если нет, то нужно его создать.
В каталоге нужно создать файл __xdebug.ini__, следующего содержания:

```
zend_extension=xdebug

[xdebug]
xdebug.mode=off
xdebug.start_with_request=yes
xdebug.client_host="host.docker.internal"
xdebug.idekey="VSCODE"
xdebug.log="/var/logs/xdebug/xdebug.log"
```

Как можно видеть, параметр __xdebug.mode__ отключен. Он переопределяется в __docker_copose.yml__, в определении вебсервиса, как указано выше.

```
        environment:
            - PHP_EXTENSION_XDEBUG:1
            - XDEBUG_MODE=develop,debug
```

## Создать файл с определением служб xDebug

В корневом каталоге нужно создать каталог __vscode__ и в нем файл __launch.json__ следующего содержания:

```
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "runtimeExecutable": "/php",
            "pathMappings": {
                "/app": "${workspaceFolder}/app"
            },
            "ignore": [
                "**/vendor/**/*.php"
            ],
            "log": true
        },
        {
            "name": "Launch currently open script",
            "type": "php",
            "request": "launch",
            "program": "${file}",
            "cwd": "${fileDirname}",
            "port": 9003,
            "externalConsole": false
        }
    ]
}
```

Большинство параметров приводятся во многих примерах, но назначение нескольких стоит уточнить.

```
            "runtimeExecutable": "/php",
```

Это ссылка как раз тот __php__ файл, который был определен в начале.

```
            "pathMappings": {
                "/app": "${workspaceFolder}/app"
            },
```

Это очень важный параметр, но для __Laravel__ его менять не нужно. Он устанавливает соответствие рабочего каталога в контейнере и рабочего пространства __xDebug__.

```
            "ignore": [
                "**/vendor/**/*.php"
            ],
```

Этот параметр устанавливает игнорирование ошибок классов каталога __vendor__ при отладке с помощью __xDebug__. Это предотвращает выброс исключений, связанных с __Cookies__.

```
            "port": 9003,
```

Наконец, начиная с версии __xDebug 3__, порт изменился с 9000 на 9003.

## Внести изменения в файл docker-compose.yml
Собственно, эти изменения уже указаны, но так как это конкретный пример __docker-compose.yml__ файла, стоит уточнить, что именно важно.
Во-первых нужно добавить дополнительный __host__ и задать правило использования  __xDebug__.

```
        extra_hosts:
            - "host.docker.internal:host-gateway"
        environment:
            - PHP_EXTENSION_XDEBUG:1
            - XDEBUG_MODE=develop,debug
```

Кроме того нужно определить местонахождение файла __xdebug.ini__ на локальной машине и в образе. Тоже касается файла для логов.

```
        volumes:
            - ./app:/app
            - ./docker/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
            - ./app/storage/logs:/var/logs/xdebug
```

Для __Laravel__ нужно указать эти значения как есть.
