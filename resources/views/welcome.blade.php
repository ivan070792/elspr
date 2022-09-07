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
        <div class="row justify-content-center">
            <div class="col-md-12 col-lg-6 bg-light border p-4 shadow-sm">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">{{ session('error') }}</div>
                @endif
                    <form action="{{ route('generate') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-8 col-md-12 mb-3">
                                <label for="formFile" class="form-label">Загрузите EXCEL форму с данными</label>
                                <input class="form-control" name='file' type="file" id="formFile" required>
                            </div>
                            <div class="col-lg-4 col-md-12 mb-3">
                                <label for="documetn_date" class="form-label">Дата созданяи документов</label>
                                <input class="form-control" name='documetn_date' type="date" id="documetn_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">
                            </div>
                            <div class="col-md-12 col-lg-6 mb-3 d-md-flex">
                                <button type="submit" class="btn btn-primary"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">
                                    <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>
                                    <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>
                                  </svg></span> Сгенерировать</button>
                            </div>
                            <div class="col-md-12 col-lg-6 mb-3">
                                <a class="btn align-middle" href="/download-example"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">
                                    <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>
                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>
                                  </svg></span> Скачать форму EXCEL документа</a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </div>
@endsection