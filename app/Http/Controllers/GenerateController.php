<?php

namespace App\Http\Controllers;

use App\Dto\StudentDTO;
use App\Services\Document;
use App\Traits\Documents;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class GenerateController extends Controller
{
    use Documents;

    /**
     * @throws ValidationException
     */
    public function generate(Request $request, Document $documentService){

        //TODO Переделать валидацию
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:xlsx',
            'document_date' => 'date|required',
            'doc_type' => 'required|in:pdf,word',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Получить проверенные данные...
        $validated = $validator->validated();

        try {
            // Создаём дату из строки (для дополнительной проверки)
            $documentDate = Carbon::createFromFormat('Y-m-d', $validated['document_date']);
            $documentDate->format('Y-m-d'); // Триггер ошибки, если дата некорректна
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'document_date' => 'Неверный формат даты. Используйте YYYY-MM-DD.',
            ]);
        }

        $studentsData = $documentService->readExelFile($validated['file']);

        $usersArray = $this->prepareUserData($studentsData);
        $date = Carbon::createFromFormat('Y-m-d', $validated['document_date']);
        if($validated['doc_type'] == 'pdf'){
            $pdf = PDF::loadView('export.edu_referens_pdf', ['students' => $usersArray, 'documetn_date' => $date]);
            return $pdf->stream();
        }
        if($validated['doc_type'] == 'word'){
            $doc = $documentService->createWord($usersArray, $date);
          $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
         ];

         try {
            return response()->download(storage_path().'/app/'.$doc, 'Справка.docx', $headers)->deleteFileAfterSend(true);
         } catch (Exception $e) {
            return back()->withError('Файл не найден')->withInput();
         }

        }
    }
    /**
     * @return StudentDTO[]
     */
    private function prepareUserData(array $data): array
    {
        $result = [];
        foreach($data as $index => $student){
            try{
                if($student[0] != null){
                        $obj = new StudentDTO(
                        fullname:$student[0],
                        birthDate:Carbon::createFromFormat('m/d/Y', $student[1]),
                        program: $student[2],
                        specialty: $student[3],
                        course: $student[4],
                        group: $student[5],
                        formEdu: $student[6],
                        formPay: $student[7],
                        dateStartEdu: Carbon::createFromFormat('m/d/Y', $student[8]),
                        dateEndEdu: Carbon::createFromFormat('m/d/Y', $student[9]),
                        orderDate: Carbon::createFromFormat('m/d/Y', $student[10]),
                        orderNum: $student[11],
                        amount:$student[12],
                    );
                    $result[] = $obj;
                }
            }
            catch (Exception $e) {
                        return back()->withError('Ошибка в форме данных на строчке '.$index/*$e->getMessage()*/)->withInput();
            }
        }
        return $result;
    }






}
