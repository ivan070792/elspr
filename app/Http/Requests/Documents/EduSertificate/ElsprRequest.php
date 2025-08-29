<?php

namespace App\Http\Requests\Documents\EduSertificate;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ElsprRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return (bool)Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'required|file|mimes:xlsx',
            'document_date' => 'date|required',
            'doc_type' => 'required|in:pdf,word',
        ];
    }

    public function prepareForValidation(): void
    {
        $this->merge(['document_date' => Carbon::parse($this->document_date)]);
    }

}
