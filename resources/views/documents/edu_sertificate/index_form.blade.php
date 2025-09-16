@extends('layouts.app')

@section('title')
    Пакетная генерация справок для обучающихся
@endsection

@section('content')
    <div class="container h-100">
        <div class="row my-4">
            <div class="col-12">
                <h1 class="text-center m-4">Пакетная генерация справок для обучающихся</h1>
            </div>
        </div>
        <elspr-form-page
            :generate-link="`{{ route('documents.edu_sertificate.index_form_request') }}`"
            :download-example-link="`{{ route('documents.edu_sertificate.download_example') }}`"
            :default-current-date="`{{ Carbon\Carbon::now()->format('Y-m-d') }}`"
        >
        </elspr-form-page>
    </div>
@endsection
