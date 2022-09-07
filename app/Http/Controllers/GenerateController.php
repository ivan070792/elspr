<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use PDF;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as ReaderXlsx;
use App\Http\Helpers\StudentDTO;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GenerateController extends Controller
{


    public function generate(Request $request){
        
        $validated = $request->validate([
            'file' => 'required|file|mimes:xlsx',
            'documetn_date' => 'date|required'
        ]);
        try{
            $documetn_date = Carbon::createFromFormat('Y-m-d', $request->documetn_date);
        }
        catch (Exception $e) {
            return back()->withError('Ошибка ввода даты '/*$e->getMessage()*/)->withInput();
        }
        if($request->file){
            $reader = new ReaderXlsx(); // получаем объект считывателя
            // $reader->setReadDataOnly(true);
            $excel = $reader->load($request->file); // Читаем файл
            $sheet = $excel->getActiveSheet(); // Открываем активную книгу
            $data = $sheet->toArray(); // преобразуем в неассоциативный массив
            unset($data[0]); // убираем заголовки таблицы из массива
            $students = [];
            foreach($data as $index => $student){
                if($student[0] != null){
                    try {
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
                            order_num: $student[11]
                        );
                        $students[] = $obj;
                    }
                    catch (Exception $e) {
                        return back()->withError('Ошибка в форме данных на строчке '.$index/*$e->getMessage()*/)->withInput();
                    }  
                }
            }
            $pdf = PDF::loadView('export.edu_referens', ['students' => $students, 'documetn_date' => Carbon::createFromFormat('Y-m-d', $request->documetn_date)]);
            return $pdf->stream();
        }
    }
}
