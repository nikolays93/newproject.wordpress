# New WordPress project boilerplate

This boilerplate is to build Wordpress websites using Docker and xDebug

## Usage with VSCode

> Make sure Docker is running and the [PHP Debug](https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug) extension for VSCode is installed


1. Run the docker instance
```sh
$ docker-compose up
```

2. Open http://localhost:8000

3. Open the debugger tab on the sidebar and run `Listen for XDebug`

4. Set anywhere in your PHP files a breakpoint

> Also can open http://localhost:8080 for manage databases

## Docker ##
#### Настройки Базы данных ####
Пользователь по умолчанию: __root__ с паролем __root__  
Таблица: __wordpress__ (уже создана)  
При установке использовать __db__ вместо __localhost__  

#### Образы ####
- wordpress:5-php7.2-apache (with xdebug)
- mariadb
- adminer

## Структура шаблона ##

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
