<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use App\Traits\Documents;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use App\Http\Helpers\StudentDTO;
use Carbon\Carbon;
use PhpOffice\PhpWord\PhpWord;
use Exception;
use Illuminate\Support\Facades\Storage;

class GenerateController extends Controller
{
    use Documents;


    public function generate(Request $request){
        
        $students_array = $this->get_excel_file($request);

        $user_objects_array = $this->create_user_objects_array($students_array);
        $documetn_date = Carbon::createFromFormat('Y-m-d', $request->documetn_date);
        if($request->doc_type == 'pdf'){
            $pdf = PDF::loadView('export.edu_referens_pdf', ['students' => $user_objects_array, 'documetn_date' => $documetn_date]);
            return $pdf->stream();
        }
        if($request->doc_type == 'word'){
           
          $doc = Documents::create_word($user_objects_array, $documetn_date );

          $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
         ];

         try {
            return Storage::download($doc, 'Справка.docx');
         } catch (Exception $e) {
            return back()->withError('Файл не найден')->withInput();
         }
         
        }
    }

    /**
     * input @param Request $request 
     * 
     * return @param array $user_objects_array
     */
    private function get_excel_file(Request $request) :array{ // Валидируем форму
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx',
            'documetn_date' => 'date|required'
        ]);
        try{ // проверяем на валидность формат даты Y-m-d
            $documetn_date = Carbon::createFromFormat('Y-m-d', $request->documetn_date);
        }
        catch (Exception $e) {
            return back()->withError('Ошибка ввода даты ')->withInput();
        }
        $reader = new ReaderXlsx(); // Получаем объект считывателя
        $excel = $reader->load($request->file); // Читаем файл
        $sheet = $excel->getActiveSheet(); // Открываем активную книгу
        $data = $sheet->toArray(); // Преобразуем книгу в неассоциативный массив
        unset($data[0]); // Убираем заголовки (1 строка) таблицы из массива
        
        return $data;
    }
    /**
     * input @param array $students_array
     * return array $student_objects_array
     */
    private function create_user_objects_array(array $students_array) :array{
        $users_object_array = [];
        // dd($students_array);
        foreach($students_array as $index => $student){
            try{
                    if($student[0] != null){
                            $obj = new StudentDTO(
                            fio:$student[0], 
                            date:Carbon::createFromFormat('m/d/Y', $student[1]),
                            program: $student[2],
                            spec: $student[3],
                            course: $student[4],
                            group: $student[5],
                            form_edu: $student[6],
                            form_pay: $student[7],
                            date_edu_start: Carbon::createFromFormat('m/d/Y', $student[8]),
                            date_edu_end: Carbon::createFromFormat('m/d/Y', $student[9]),
                            order_date: Carbon::createFromFormat('m/d/Y', $student[10]),
                            order_num: $student[11],
                            amount:$student[12], 
                        );
                        $user_objects_array[] = $obj;
                    }
                }
                catch (Exception $e) {
                            return back()->withError('Ошибка в форме данных на строчке '.$index/*$e->getMessage()*/)->withInput();
                }  
        }
        return $user_objects_array;   
    }



    


}
