<?php

namespace App\Services;

use App\Dto\StudentDTO;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use PhpOffice\PhpWord\PhpWord;

class Document
{

    /**
     * @param StudentDTO[] $userObjectsArray
     * @param Carbon $date
     *
     * @return string
     */
    public function createWord(array $userObjectsArray, Carbon $date): string
    {

        $phpWord = new PHPWord('Word2007');
        $phpWord->setDefaultFontName('Times New Roman');
        $phpWord->setDefaultFontSize(14);

        $paragraphStyleName = 'pStyle';
        $phpWord->addParagraphStyle($paragraphStyleName, array('spaceAfter' => 0));
        $count = 0;
        $section = $phpWord->addSection(['marginTop' => 14*56.7, 'marginBottom' => 13*56.7, 'marginLeft' => 12.5*56.7, 'marginRight' => 12.5*56.7]);
        foreach($userObjectsArray as $index => $user){
            $count++;
            $section->addText('МИНИСТЕРСТВО ОБРАЗОВАНИЯ И НАУКИ АЛТАЙСКОГО КРАЯ', ['size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('краевое государственное бюджетное профессиональное образовательное учреждение', ['size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('«Барнаульский государственный педагогический колледж имени Василия Константиновича', ['size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('Штильке» (КГБПОУ «БГПК имени В.К. Штильке»)', ['size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('80-й Гвардейской Дивизии ул., д. 41, Барнаул, 656010, телефон: (3852) 33-61-00,', ['size'=> 11], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('факс: (3852) 55-56-21, E-mail: bgpk@22edu.ru', ['size'=> 11], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('', ['size'=> 14], ['align' => 'center', 'spaceAfter' => 0]);
            $section->addText('СПРАВКА', ['size'=> 12, 'bold' => true], ['align' => 'center', 'spaceAfter' => 0]);
            // Для простоты верстки использую таблицу
            $table1 = $section->addTable(['width' => 100*50, 'unit' => 'pct']);
            $row1 = $table1->addRow();
            $row1->addCell()->addText($date->isoFormat('« D » MMMM YYYY г.', 'Do MMMM'), ['size'=> 14], ['align' => 'left']);
            $row1->addCell()->addText('№__________', ['size'=> 14], ['align' => 'right']);
            $textrun = $section->addTextRun('pStyle');
            $textrun->addText($user->getFullname(), ['size'=> 14, 'underline' => 'single'], ['spaceAfter' => 0]);
            $textrun->addText(',    ', ['size'=> 14], ['spaceAfter' => 0]);
            $textrun->addText($user->getBirthDate()->isoFormat('« D » MMMM YYYY года рождения', 'Do MMMM'), ['size'=> 14], ['spaceAfter' => 0]);
            $section->addText('обучается в КГБПОУ «БГПК имени В.К. Штильке» по основной образовательной ', ['size'=> 14], ['spaceAfter' => 0]);
            $textrun = $section->addTextRun('pStyle');
            $textrun->addText('программе   ', [], ['spaceAfter' => 0]);
            $textrun->addText('   '.$user->getProgram().'   ', ['underline' => 'single'], ['spaceAfter' => 0]);
            $section->addText($user->getSpecialty(), [],  ['spaceAfter' => 0]);
            $section->addText('и является студентом '.$user->getCourse().' курса '. $user->getGroup().' группы', ['size'=> 14], ['spaceAfter' => 0]);

            $textrun = $section->addTextRun('pStyle');
            $textrun->addText('Форма обучения: ', [],  ['spaceAfter' => 0]);
            if($user->getFormEdu() == "Очная"){
                $textrun->addText('очная', ['underline' => 'single'], ['spaceAfter' => 0]);
                $textrun->addText('/заочная', [],   ['spaceAfter' => 0]);
            }else{
                $textrun->addText('очная/', [],  ['spaceAfter' => 0]);
                $textrun->addText('заочная', ['underline' => 'single'], ['spaceAfter' => 0]);
            }

            if($user->getFormPay() == 'Бюджет'){
                $textrun->addText(' (', [],  ['spaceAfter' => 0]);
                $textrun->addText('бюджет', ['underline' => 'single'], ['spaceAfter' => 0]);
                $textrun->addText('/платно по договору', [],  ['spaceAfter' => 0]);
                $textrun->addText(')', [],  ['spaceAfter' => 0]);
            }else{
                $textrun->addText(' (', [],  ['spaceAfter' => 0]);
                $textrun->addText('бюджет/', [],  ['spaceAfter' => 0]);
                $textrun->addText('платно по договору', ['underline' => 'single'], ['spaceAfter' => 0]);
                $textrun->addText(')', [],  ['spaceAfter' => 0]);
            }
            $textrun = $section->addTextRun('pStyle');
            $textrun->addText('Срок обучения с ', [],  ['spaceAfter' => 0]);
            $textrun->addText($user->getDateStartEdu()->format('« d » m Y г.'), [],  ['spaceAfter' => 0]);
            $textrun->addText(' по ', [],  ['spaceAfter' => 0]);
            $textrun->addText($user->getDateEndEdu()->format('« d » m Y г.,'), [],  ['spaceAfter' => 0]);

            $textrun = $section->addTextRun('pStyle');
            $textrun->addText('зачислен(а) ', [],  ['spaceAfter' => 0]);
            $textrun->addText(' приказом от '. $user->getOrderDate()->isoFormat('« D » MMMM YYYY г.', 'Do MMMM г.').' ' , [],  ['spaceAfter' => 0]);
            $textrun->addText('№ '. $user->getOrderNum().'.' , [], ['spaceAfter' => 0]);
            $section->addText('Справка выдана для предоставления по месту требования.', [], ['spaceAfter' => 0]);
            $section->addText('', [], ['spaceAfter' => 0]);

            $table2 = $section->addTable(['width' => 100*50, 'unit' => 'pct']);
            $row2 = $table2->addRow();
            $row2->addCell()->addText('Директор', [], ['align' => 'left']);
            $row2->addCell()->addText('М. Б. Самолетов', [], ['align' => 'right']);

            if($count % 2 == 0){
                $section->addPageBreak();
            }else{
                $section->addText('', [], ['spaceAfter' => 0]);
                $section->addLine(['weight' => 1, 'width' => 400, 'height' => 0]);
            }

        }


        $tmp_doc_file = uniqid().'.docx';
        $phpWord->save(storage_path('app/'.$tmp_doc_file));
        return $tmp_doc_file;
    }
    public function readExelFile($file) :array
    {

        $reader = new ReaderXlsx(); // Получаем объект считывателя
        $excel = $reader->load($file); // Читаем файл
        $sheet = $excel->getActiveSheet(); // Открываем активную книгу
        $data = $sheet->toArray(); // Преобразуем книгу в неассоциативный массив
        unset($data[0]); // Убираем заголовки (1 строка) таблицы из массива

        return $data;
    }
}
