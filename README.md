<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

## Автоматическая генерация справок об обучении

Данное веб-приложение генерирует спправки об обжуении в виде pdf документа. Данные для работы преложения предоставляются в Excel файле, шаблок которого досупен для скачивания.

## Состав приложения

В работе приложения учавствуют дополнительные пакеты 

 - barryvdh/laravel-dompdf для генерации PDF документа
 - phpoffice/phpspreadsheet для парсинга excel документа

## Особенности разворачивания

В пакете laravel-dompdf отсутвуют нужные шрифты. Их необходимо добавить.
