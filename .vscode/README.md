# Подключение xDebug к VSCode
*VSCode + xDebug + Docker + Laravel*

## Подготовка окружения
Необходимо:
- создать пару файлов для `xDebug` с параметрами `xdebug.ini` и конфигурацией `launch.json`;
- внести изменения в `docker_compose.yml`;
- наконец, создать исполняемый скрипт, для запуска `PHP` из `xDebug`.

Начнем с последнего пункта.

### Обеспечить запуск PHP из xDebug
Для отладки `xDebug` необходим интерпритатор `PHP`. Запуск `PHP` должен выполняться в уже запущенном контейнере. Для этого в корневом каталоге необходимо создать файл с именем php, следующего содержания

```
#!/bin/bash
docker exec -it <web_container_name> php $@
```

и сделать файл исполняемым.

```
chmod +x php
```

`web_container_name` это имя контейнера web-сервиса. Например `blog-php-fpm` в файле `docker_compose.yml`:

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


### Создать файл с параметрами xDebug

В корневом каталоге, возможно, уже есть каталог `docker`, если нет, то нужно его создать.
В каталоге нужно создать файл `xdebug.ini`, следующего содержания:

```
zend_extension=xdebug

[xdebug]
xdebug.mode=off
xdebug.start_with_request=yes
xdebug.client_host="host.docker.internal"
xdebug.idekey="VSCODE"
xdebug.log="/var/logs/xdebug/xdebug.log"
```

Как можно видеть, параметр `xdebug.mode` отключен. Он переопределяется в `docker_compose.yml`, в секции вебсервиса.

```
        environment:
            - PHP_EXTENSION_XDEBUG:1
            - XDEBUG_MODE=develop,debug
```

### Создать файл конфигурации xDebug

В корневом каталоге нужно создать каталог `.vscode` и в нем файл `launch.json` следующего содержания:

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

Большинство параметров приводятся во многих примерах, но назначение нескольких параметров стоит уточнить так как он связаны с использованием `docker` и `Laravel`.

```
            "runtimeExecutable": "/php",
```

Это ссылка как раз на тот `php` файл, который был определен в начале.

```
            "pathMappings": {
                "/app": "${workspaceFolder}/app"
            },
```

Это очень важный параметр. Он устанавливает соответствие рабочего каталога в контейнере и рабочего пространства `xDebug`. Для `Laravel` можно  использоать указанные значения, если только каталоги
не изменены.

```
            "ignore": [
                "**/vendor/**/*.php"
            ],
```

Этот параметр устанавливает игнорирование ошибок классов каталога `vendor` при отладке с помощью `xDebug`. Это предотвращает выброс исключений, связанных, например, с `Cookies`.

```
            "port": 9003,
```

Наконец, хоть это и не связано ни с `docker` ни с фреймворком, начиная с версии `xDebug 3`, порт изменился с `9000` на `9003`.

### Внести изменения в файл docker-compose.yml
Собственно, эти изменения уже указаны в примере файла `docker-compose.yml`, но стоит уточнить, что именно важно.
Во-первых нужно добавить дополнительный `host` и задать правило использования  `xDebug`.

```
        extra_hosts:
            - "host.docker.internal:host-gateway"
        environment:
            - PHP_EXTENSION_XDEBUG:1
            - XDEBUG_MODE=develop,debug
```

Кроме того нужно определить местонахождение файла `xdebug.ini` на локальной машине и в образе. Тоже касается файла для логов.

```
        volumes:
            - ./app:/app
            - ./docker/xdebug.ini:/usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
            - ./app/storage/logs:/var/logs/xdebug
```

Для `Laravel` можно указать эти значения как есть, если, конечно, корневой каталог `/app` не переименован.

## Проверка
Кратко о использовании `xDebug`:
- выбрать на боковой панели пункт *Запуск и отладка (Ctrl+Shift+D)*;
- установить `breakpoint` в исследуемом файле;
- нажать зеленый треугольник или `F5` для запуска отладки, предварительно выбрав в выпадающем меню *Listen for xDebug*, при этом внизу окна должна появиться оранжевая строка;
- ввести адрес разрабатываемого сайта в браузере.

После запуска сайта в браузере должен произойти переход в `VSCode` на `breakpoint` или на исключение, если, после правок, есть ошибки.
 