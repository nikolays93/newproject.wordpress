# Заготовка нового проекта на WordPress

Это заготовка для разработки нового сайта на Wordpress с использованием Docker и xDebug

## Необходимый инструмент
1. Docker (или [Docker Desktop](https://docs.docker.com/desktop/)) - для запуска сайта
2. [Node.js](https://nodejs.org/en/download/) - для запуска JavaScript на вашем компьютере
3. [Yarn](https://yarnpkg.com/en/docs/install/) - Как альтернатива Npm для сборки проекта
4. [Composer](https://getcomposer.org) - Пакетный менаджер PHP

## Как запустить сервер

> Убедитесь, что Docker запущен

1. Запустите docker-compose в папке с проектом
```sh
$ docker-compose up -d
```
2. Перейдите по ссылке http://localhost:8000 или откройте в браузере

> Вы также можете запустить http://localhost:8080 для управления базами данных

## Как работать с проектом

> Установка может занять некоторое время в зависимости от скорости вашего интернета.

1. Клонируйте репозиторий ```git clone https://github.com/nikolays93/newproject.wordpress.git``` или [скачайте](https://github.com/nikolays93/newproject.wordpress/releases/latest) последнюю версию к себе на компьютер;
2. Перейдите в папку командой ```cd newproject.wordpress``` или откройте консоль в папке скачанной сборки;
3. Введите команду ```yarn``` для установки проекта; Начнется перенос библиотек в проект (bootstrap, jQuery и т.д.)

> Если ваш проект установлен воспользуйтесь следующими командами для сборки проекта

- Введите ```yarn build``` или ```gulp build --production``` для сборки проекта;
- Введите ```yarn dev``` или ```gulp``` для запуска сервера разработки;

## Как установить Code Sniffer

> Убедитесь что пакетный менаджер composer установлен на вашем компьютере

0. Откройте консоль в папке `./www`
1. Запустите команду `composer install`

> Проверить установку можно командой `vendor/bin/phpcs --version`

2. Установите WordPress проект wp-coding-standards командой `composer create-project wp-coding-standards/wpcs:dev-master --no-dev`
3. Установите правила в PHP CodeSniffer командой `vendor/bin/phpcs --config-set installed_paths wpcs`

> Проверить список правил можно командой `vendor/bin/phpcs -i`

## Как исользовать Code Sniffer

Скопируйте команду `scripts.sniff` для проверки и `scripts.fix` для автоисправлений и запустите в консоли для автозапуска

> Под Unix используйте `composer sniff` или `composer fix` соответсвенно

## Docker
#### Настройки Базы данных
Пользователь по умолчанию: __root__ с паролем __root__  
Таблица: __wordpress__ (уже создана)  
При установке использовать __db__ вместо __localhost__  

#### Образы
- wordpress:5-php7.2-apache (with xdebug)
- mariadb
- adminer

## Структура шаблона

```
inc/                // Дополнительные файлы расширяющие функционал functions.php
├── system/         // Все функции данного каталога можно заранее предопределить
│   │               // Не рекомендуется изменять - для удобства обновлений файлов.
│   ├── class-wp-bootstrap-navwalker.php';
│   ├── setup.php         *
│   ├── widgets.php       * Сайдбар панели (Виджеты)
│   ├── assets.php        * Дополнительные ресурсы
│   ├── utilites.php      * Вспомогательные функции
│   ├── admin.php         * Фильтры и функции административной части WP
│   ├── template.php      * Основные функции вывода информации в шаблон
│   ├── navigation.php    * Навигация
│   ├── gallery.php       * Шаблон встроенной галереи wordpress
│   ├── customizer.php    * Дополнительные функии в настройки внешнего вида
│   ├── wpcf7.php         * Дополнение к отправке почтовых сообщений
│   ├── woocommerce.php   *
│   └── wc-customizer.php *
│
├── post-type.php   // Регистрируем собственный тип записи (Слайдер для примера)
├── shortcode.php   // [Шорткод] - вспомогательный код, разделяющий логику и представления

template-parts/     //
├──

templates/          //
├──

woocommerce/        //
├──

├── functions.php   // Функции сайта, запускается перед выводом шаблона
├── header.php      // Шапка сайта
├── footer.php      // Подвал сайта
├── sidebar.php     // Боковая панель сайта, как правило выводит виджеты из настроек внешнего вида

├── index.php       // Основной файл, CMS обращается к нему, если не найдет замены
├── 404.php         // Страница 404, отображается при не существующем запросе
├── archive.php     // Архив записей, страница списка записей типа "Запись" (post)
├── single.php      // Вывод записи типа "Запись" (post)
├── front-page.php  // Титульная (главная) страница? устанавливается в настройках внешнего вида
├── page.php        // Вывод записи типа "Страница" (page)
│
├── style.css
└── template-styles.css
```

### Настройки XDebug

<details>
    <summary>Как использовать PHP xDebug в редакторе VS Code</summary>

> Убедитесь что установленно дополнение [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) для VSCode

0. Создайте файл `./.vscode/launch.json` с содержимым:
```json
{
  "version": "0.2.0",
  "configurations": [
    {
      "name": "Listen for XDebug",
      "type": "php",
      "request": "launch",
      "port": 9000,
      "pathMappings": {
        "/var/www/html": "${workspaceFolder}/www/html"
      },
      "xdebugSettings": {
        "max_data": 65535,
        "show_hidden": 1,
        "max_children": 100,
        "max_depth": 5
      }
    }
  ]
}
```

1. Запустите проект
2. Откройте раздел "Запустить" `CTRL+SHIFT+D` в боковой панели редактора и нажмите `Listen for XDebug`
3. Установите в PHP файле точку останова

</details>
