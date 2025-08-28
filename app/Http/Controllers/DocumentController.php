<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class DocumentController extends Controller
{
    public function elsprForm(): \Illuminate\Contracts\View\View
    {
        return view('documents.elspr_form');
    }

    public function downloadExample()
    {
        try {
            return Storage::download('students.xlsx');
        } catch (NotFoundHttpException $e) {
            abort(404);
        }
    }
}
