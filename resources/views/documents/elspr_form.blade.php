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
            :generate-link="`{{ route('documents.elspr.generate') }}`"
            :download-example-link="`{{ route('documents.elspr.example') }}`"
            :default-current-date="`{{ Carbon\Carbon::now()->format('Y-m-d') }}`"
        >
        </elspr-form-page>
{{--        <div class="row justify-content-center">--}}
{{--            <div class="col-md-12 col-lg-6 bg-light border p-4 shadow-sm">--}}
{{--                @if ($errors->any())--}}
{{--                    <div class="alert alert-danger">--}}
{{--                        <ul>--}}
{{--                            @foreach ($errors->all() as $error)--}}
{{--                                <li>{{ $error }}</li>--}}
{{--                            @endforeach--}}
{{--                        </ul>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                @if (session('error'))--}}
{{--                    <div class="alert alert-danger">{{ session('error') }}</div>--}}
{{--                @endif--}}
{{--                    <form action="{{ route('documents.elspr.generate') }}" method="post" enctype="multipart/form-data">--}}
{{--                        @csrf--}}
{{--                        <div class="row">--}}
{{--                            <div class="col-lg-8 col-md-12 mb-3">--}}
{{--                                <label for="formFile" class="form-label">Загрузите EXCEL форму с данными</label>--}}
{{--                                <input class="form-control" name='file' type="file" id="formFile" required>--}}
{{--                            </div>--}}
{{--                            <div class="col-lg-4 col-md-12 mb-3">--}}
{{--                                <label for="documetn_date" class="form-label">Дата создания документов</label>--}}
{{--                                <input class="form-control" name='document_date' type="date" id="documetn_date" value="{{ Carbon\Carbon::now()->format('Y-m-d') }}">--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 col-lg-12 mb-3 d-md-flex">--}}
{{--                                <button type="submit" name="doc_type" value="pdf"  class="btn btn-primary me-2"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-word" viewBox="0 0 16 16">--}}
{{--                                    <path d="M5.485 6.879a.5.5 0 1 0-.97.242l1.5 6a.5.5 0 0 0 .967.01L8 9.402l1.018 3.73a.5.5 0 0 0 .967-.01l1.5-6a.5.5 0 0 0-.97-.242l-1.036 4.144-.997-3.655a.5.5 0 0 0-.964 0l-.997 3.655L5.485 6.88z"/>--}}
{{--                                    <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>--}}
{{--                                  </svg></span>Сгенерировать PDF</button>--}}
{{--                                  <button type="submit" name="doc_type" value="word"  class="btn btn-primary me-2"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-briefcase-fill" viewBox="0 0 16 16">--}}
{{--                                      <path d="M6.5 1A1.5 1.5 0 0 0 5 2.5V3H1.5A1.5 1.5 0 0 0 0 4.5v1.384l7.614 2.03a1.5 1.5 0 0 0 .772 0L16 5.884V4.5A1.5 1.5 0 0 0 14.5 3H11v-.5A1.5 1.5 0 0 0 9.5 1h-3zm0 1h3a.5.5 0 0 1 .5.5V3H6v-.5a.5.5 0 0 1 .5-.5z"/>--}}
{{--                                      <path d="M0 12.5A1.5 1.5 0 0 0 1.5 14h13a1.5 1.5 0 0 0 1.5-1.5V6.85L8.129 8.947a.5.5 0 0 1-.258 0L0 6.85v5.65z"/>--}}
{{--                                    </svg></span>Сгенерировать WORD</button>--}}
{{--                                    <a class="btn align-middle me-2" href="/download-example"> <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-file-earmark-arrow-down" viewBox="0 0 16 16">--}}
{{--                                        <path d="M8.5 6.5a.5.5 0 0 0-1 0v3.793L6.354 9.146a.5.5 0 1 0-.708.708l2 2a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 10.293V6.5z"/>--}}
{{--                                        <path d="M14 14V4.5L9.5 0H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2zM9.5 3A1.5 1.5 0 0 0 11 4.5h2V14a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h5.5v2z"/>--}}
{{--                                    </svg></span> Скачать форму EXCEL документа</a>--}}
{{--                                    <a href="#info_modal" class="my-auto" data-bs-toggle="modal" data-bs-target="#info_modal">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-question-circle-fill" viewBox="0 0 16 16">--}}
{{--                                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM5.496 6.033h.825c.138 0 .248-.113.266-.25.09-.656.54-1.134 1.342-1.134.686 0 1.314.343 1.314 1.168 0 .635-.374.927-.965 1.371-.673.489-1.206 1.06-1.168 1.987l.003.217a.25.25 0 0 0 .25.246h.811a.25.25 0 0 0 .25-.25v-.105c0-.718.273-.927 1.01-1.486.609-.463 1.244-.977 1.244-2.056 0-1.511-1.276-2.241-2.673-2.241-1.267 0-2.655.59-2.75 2.286a.237.237 0 0 0 .241.247zm2.325 6.443c.61 0 1.029-.394 1.029-.927 0-.552-.42-.94-1.029-.94-.584 0-1.009.388-1.009.94 0 .533.425.927 1.01.927z"/>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                            </div>--}}
{{--                            <div class="col-md-12 col-lg-6 mb-3">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </form>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- Modal -->--}}
{{--        <div class="modal modal-lg fade" id="info_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">--}}
{{--            <div class="modal-dialog modal-dialog-centered">--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h5 class="modal-title" id="exampleModalLabel">Справочная информация</h5>--}}
{{--                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                </div>--}}
{{--                <div class="modal-body">--}}
{{--                    <p>Используйте форму EXCEL документа для генерации справок.</p>--}}
{{--                    <p>Колонка "Форма обучения" может быть заполнена значениями "Очная" или "Заочная"</p>--}}
{{--                    <p>Колонка "Форма оплаты" может быть заполнена значениями "Бюджет" или "Платно"</p>--}}
{{--                    <p>Если вам необходимо сделать несколько справок для одного студента, то введите нужно количество в колонку "Кол-во справок". Если справка не нужна, то введите 0</p>--}}
{{--                </div>--}}
{{--                <div class="modal-footer">--}}
{{--                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
