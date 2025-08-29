<?php

namespace App\Http\Controllers\Documents;

use App\Actions\Documents\GenerateEducationSertificateDoc;
use App\Actions\Documents\GenerateEducationSertificatePdf;
use App\Data\Student\StudentData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Documents\EduSertificate\EduSertificateIndexFormRequest;
use App\Utils\FileUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EduSertificateController extends Controller
{

    /**
     * @param array $fileData
     * TODO как будто бы нужен сервис для этого
     *
     * @return array
     * @throws \Exception
     */
    public function getPrepareFileData(array $fileData): array
    {
        $prepareFileData = [];
        foreach ($fileData as $key => $data) {
            try {
                $prepareFileData [] = [
                    'fullname'     => $data[0],
                    'birthDate'    => Carbon::parse($data[1]),
                    'program'      => $data[2],
                    'specialty'    => $data[3],
                    'course'       => $data[4],
                    'group'        => $data[5],
                    'formEdu'      => $data[6],
                    'formPay'      => $data[7],
                    'dateStartEdu' => Carbon::parse($data[8]),
                    'dateEndEdu'   => Carbon::parse($data[9]),
                    'orderDate'    => Carbon::parse($data[10]),
                    'orderNum'     => $data[11],
                    'amount'       => $data[12],
                ];
            } catch (\Exception $e) {
                throw new \Exception('Ошибка в строке ' . $key);
            }
        }
        return $prepareFileData;
    }

    /*
     * Страница формы генерирования справок
     */
    public function indexForm() {
        return view('documents.edu_sertificate.index_form', [
            'currentData' => Carbon::now()->format('Y-m-d')
        ]);
    }

    public function indexFormRequest(EduSertificateIndexFormRequest $request)
    {
        $formData = $request->getData();
        $fileData = FileUtils::readExelFile($formData->file, false);
        if (!$fileData) {
            return back()->withErrors(['Неизвестный тип документа'])->withInput();
        }
        $prepareFileData = $this->getPrepareFileData($fileData);
        $students = StudentData::collection($prepareFileData);

        if($formData->docType === 'pdf'){
            $documentAction = new GenerateEducationSertificatePdf();
            $pdf = $documentAction($students, $formData->documentDate);
            return $pdf->stream();
        }
        if($formData->docType === 'word'){
            $documentAction = new GenerateEducationSertificateDoc();
            $file = $documentAction($students, $formData->documentDate);
            $headers = [
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ];

            // TODO Логирование и эксшепны
            try {
                return response()->download(storage_path().'/app/'.$file, 'Справка.docx', $headers)->deleteFileAfterSend(true);
            } catch (Exception $e) {
                return back()->withErrors(['error' => 'Файл не найден'])->withInput();
            }
        }
        return back()->withErrors(['Неизвестный тип документа'])->withInput();
    }

    /*
     * Загрузка файла-примера
     */
    public function downloadExampleXlsx()
    {
        try {
            return Storage::download('students.xlsx');
        } catch (NotFoundHttpException $e) {
            abort(404);
        }
    }
}
