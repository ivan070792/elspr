<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
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

    public function testFetch(): JsonResponse
    {
        $result = [
            'a' => 1,
            'b' => 'sdsdasdasdasd'
        ];
        return response()->json($result);
    }
}
