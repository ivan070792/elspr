<?php

namespace App\Http\Controllers\Documents;

use App\Http\Controllers\Controller;
use App\Http\Requests\Documents\EduSertificate\EduSertificateIndexFormRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
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

    public function indexFormRequest(EduSertificateIndexFormRequest $request)
    {
        $formData = $request->validated();
        $data = $formData['document_date'];
        dd($formData);
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
