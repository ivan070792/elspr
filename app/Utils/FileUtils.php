<?php

namespace App\Utils;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use PhpOffice\PhpSpreadsheet\Reader\Exception;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;

final class FileUtils
{
    /**
     * @throws \Exception
     */
    public static function readExelFile(string $filePath, bool $isFirstRow = true ): array
    {
        $reader = new ReaderXlsx(); // Получаем объект считывателя
        try {
            $excel = $reader->load($filePath); // Читаем файл
        } catch (Exception $e) {
            //TODO Логирование ошибки
            throw new FileNotFoundException('Файл не найден | '. $e->getMessage());
        }

        $sheet = $excel->getActiveSheet(); // Открываем активную книгу
        $data = $sheet->toArray(); // Преобразуем книгу в неассоциативный массив
        if (!$isFirstRow) {
            unset($data[0]); // Убираем заголовки (1 строка) таблицы из массива
        }
        return $data;
    }
}
