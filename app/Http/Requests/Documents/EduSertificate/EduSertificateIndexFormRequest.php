<?php

namespace App\Http\Requests\Documents\EduSertificate;

use Illuminate\Foundation\Http\FormRequest;

class EduSertificateIndexFormRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx',
            'document_date' => 'date|required',
            'doc_type' => 'required|in:pdf,word',
        ];
    }

    public function authorize(): bool
    {
        return (bool)\Auth::user();
    }
}
