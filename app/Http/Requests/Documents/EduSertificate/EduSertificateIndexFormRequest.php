<?php

namespace App\Http\Requests\Documents\EduSertificate;

use App\Data\Documents\EduSertificateIndexFormData;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;

class EduSertificateIndexFormRequest extends FormRequest
{

    protected string $dataClass = EduSertificateIndexFormData::class;

    public function rules(): array
    {
        return [
            'file' => 'required|file|mimes:xlsx',
            'document_date' => 'date|required',
            'doc_type' => 'required|in:PDF,DOC',
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'document_date' => Carbon::parse($this->document_date),
        ]);
    }

    public function authorize(): bool
    {
        return (bool)\Auth::user();
    }

    public function getData(): EduSertificateIndexFormData
    {
        return EduSertificateIndexFormData::from($this->validated());
    }
}
