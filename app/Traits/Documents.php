<?php

namespace App\Traits;

use PhpOffice\PhpWord\PhpWord;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

trait Documents{

    static function create_word (array $user_objects_array, object $documetn_date){

        $phpWord = new PHPWord('Word2007');
        $phpWord->setDefaultFontName('Times New Roman');

        $paragraphStyleName = 'pStyle';
        $phpWord->addParagraphStyle($paragraphStyleName, array('spaceAfter' => 0));
        $count = 0;
        $section = $phpWord->addSection(['marginTop' => 14*56.7, 'marginBottom' => 13*56.7, 'marginLeft' => 12.5*56.7, 'marginRight' => 12.5*56.7]);
        foreach($user_objects_array as $index => $user_object){

            for($a = 1; $a <= $user_object->get_amount(); $a++){
                $count++;
                $section->addText('МИНИСТЕРСТВО ОБРАЗОВАНИЯ И НАУКИ АЛТАЙСКОГО КРАЯ', ['name' => 'Times New Roman', 'size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('краевое государственное бюджетное профессиональное образовательное учреждение', ['name' => 'Times New Roman', 'size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('«Барнаульский государственный педагогический колледж имени Василия Константиновича', ['name' => 'Times New Roman', 'size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('Штильке» (КГБПОУ «БГПК имени В.К. Штильке»)', ['name' => 'Times New Roman', 'size'=> 12], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('80-й Гвардейской Дивизии ул., д. 41, Барнаул, 656010, телефон: (3852) 33-61-00,', ['name' => 'Times New Roman', 'size'=> 11], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('факс: (3852) 55-56-21, E-mail: bgpk@22edu.ru', ['name' => 'Times New Roman', 'size'=> 11], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('', ['name' => 'Times New Roman', 'size'=> 14], ['align' => 'center', 'spaceAfter' => 0]);
                $section->addText('СПРАВКА', ['name' => 'Times New Roman', 'size'=> 12, 'bold' => true], ['align' => 'center', 'spaceAfter' => 0]);
                $table1 = $section->addTable(['width' => 100*50, 'unit' => 'pct']);
                $row1 = $table1->addRow();
                $cell1 = $row1->addCell()->addText($documetn_date->isoFormat('« D » MMMM YYYY г.', 'Do MMMM'), ['name' => 'Times New Roman', 'size'=> 14], ['align' => 'left']);
                $cell1 = $row1->addCell()->addText('№__________', ['name' => 'Times New Roman', 'size'=> 14], ['align' => 'right']);
                // $section->addText('', ['name' => 'Times New Roman', 'size'=> 14], ['align' => 'center', 'spaceAfter' => 0]);
        
                $textrun = $section->addTextRun('pStyle');
                $textrun->addText($user_object->get_fio(), ['name' => 'Times New Roman', 'size'=> 14, 'underline' => 'single'], ['spaceAfter' => 0]);
                $textrun->addText(',    ', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $textrun->addText($user_object->get_date()->isoFormat('« D » MMMM YYYY года рождения', 'Do MMMM'), ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                // $textrun->addTextBreak($user_object->get_date()->isoFormat('« D » MMMM YYYY года рождения', 'Do MMMM'), ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $section->addText('обучается в КГБПОУ «БГПК имени В.К. Штильке» по основной образовательной ', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
        
                
                $textrun = $section->addTextRun('pStyle');
                $textrun->addText('программе   ', ['name' => 'Times New Roman', 'size'=> 14],['spaceAfter' => 0]);
                $textrun->addText('   '.$user_object->get_program().'   ', ['name' => 'Times New Roman', 'size'=> 14, 'underline' => 'single'], ['spaceAfter' => 0]);
                
                $section->addText($user_object->get_spec(), ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $section->addText('и является студентом '.$user_object->get_course().' курса '. $user_object->get_group().' группы', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                
                $textrun = $section->addTextRun('pStyle');
                $textrun->addText('Форма обучения: ', ['name' => 'Times New Roman', 'size'=> 14],['spaceAfter' => 0]);
                if($user_object->get_form_edu() == "Очная"){
                    $textrun->addText('очная', ['name' => 'Times New Roman', 'size'=> 14, 'underline' => 'single'], ['spaceAfter' => 0]);
                    $textrun->addText('/заочная', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                }else{
                    $textrun->addText('очная/', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                    $textrun->addText('заочная', ['name' => 'Times New Roman', 'size'=> 14,'underline' => 'single'], ['spaceAfter' => 0]);
                }
        
                if($user_object->get_form_pay() == 'Бюджет'){
                    $textrun->addText(' (', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                    $textrun->addText('бюджет', ['name' => 'Times New Roman', 'size'=> 14, 'underline' => 'single'], ['spaceAfter' => 0]);
                    $textrun->addText('/платно по договору', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                    $textrun->addText(')', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                }else{
                    $textrun->addText(' (', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                    $textrun->addText('бюджет/', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                    $textrun->addText('платно по договору', ['name' => 'Times New Roman', 'size'=> 14, 'underline' => 'single'], ['spaceAfter' => 0]);
                    $textrun->addText(')', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                }
        
                $textrun = $section->addTextRun('pStyle');
                $textrun->addText('Срок обучения с ', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $textrun->addText($user_object->get_date_edu_start()->format('« d » m Y г.'), ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $textrun->addText(' по ', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $textrun->addText($user_object->get_date_edu_end()->format('« d » m Y г.,'), ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
        
                $textrun = $section->addTextRun('pStyle');
                $textrun->addText('зачислен(а) ', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $textrun->addText(' приказом от '. $user_object->get_order_date()->isoFormat('« D » MMMM YYYY г.', 'Do MMMM г.').' ' , ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                $textrun->addText('№ '. $user_object->get_order_num().'.' , ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
        
                $section->addText('Справка выдана для предоставления по месту требования.', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
        
                $section->addText('', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                
                $table2 = $section->addTable(['width' => 100*50, 'unit' => 'pct']);
                $row2 = $table2->addRow();
                $cell2 = $row2->addCell()->addText('Директор', ['name' => 'Times New Roman', 'size'=> 14], ['align' => 'left']);
                $cell2 = $row2->addCell()->addText('М. Б. Самолетов', ['name' => 'Times New Roman', 'size'=> 14], ['align' => 'right']);
                if($count % 2 == 0){
                    $section->addPageBreak();
                }else{
                    if(count($user_objects_array) != 1){
                        $section->addText('', ['name' => 'Times New Roman', 'size'=> 14], ['spaceAfter' => 0]);
                        $section->addLine(['weight' => 1, 'width' => 400, 'height' => 0]);
                    }
                }
            }

        }


        $tmp_doc_file = uniqid().'.docx';
        $phpWord->save(storage_path('app/'.$tmp_doc_file));
        return $tmp_doc_file;
   }

   static function download_doc(string $path){
        Storage::download('app/'.$path);
   }

}