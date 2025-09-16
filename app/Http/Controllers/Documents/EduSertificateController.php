<?php

namespace App\Http\Controllers\Documents;

use App\Actions\Documents\GenerateEducationSertificateDoc;
use App\Actions\Documents\GenerateEducationSertificatePdf;
use App\Data\Student\StudentData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Documents\EduSertificate\EduSertificateIndexFormRequest;
use App\Services\DocumentService;
use App\Utils\FileUtils;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class EduSertificateController extends Controller
{
    /*
     * Страница формы генерирования справок
     */
    public function indexForm() {
        return view('documents.edu_sertificate.index_form', [
            'currentData' => Carbon::now()->format('Y-m-d')
        ]);
    }

    /**
     * @throws Exception
     */
    public function indexFormRequest(EduSertificateIndexFormRequest $request, DocumentService $documentService)
    {
        $formData = $request->getData();
        $fileData = FileUtils::readExelFile($formData->file, false);
        if (!$fileData) {
            return back()->withErrors(['Неизвестный тип документа'])->withInput();
        }
        $prepareFileData = $documentService->getPrepareFileData($fileData);
        $students = StudentData::collection($prepareFileData);

        if($formData->docType === 'PDF'){
            $documentAction = new GenerateEducationSertificatePdf();
            $pdf = $documentAction($students, $formData->documentDate);
            return $pdf->stream();
        }
        if($formData->docType === 'DOC'){
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
