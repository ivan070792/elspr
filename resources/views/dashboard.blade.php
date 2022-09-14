@extends('layouts.app')

@section('title')
    Дашборд
@endsection

@section('content')
    <div class="container g-4">
        <div class="row">
            <h1>Дашборд</h1>
        </div>
        <div class="row row-cols-4 row-cols-md-4 g-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title text-center">6862</h4>
                        <p class="card-text text-center">Общее количесво студентов</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container g-4">
        <div class="row">
            <h3>Сервисы</h3>
        </div>
        <div class="row row-cols-4 row-cols-md-4 g-4">
            <div class="col">
                <a class="card" href="/generate">
                    <div class="card-body">
                        <h4 class="card-title text-center">Пакетная генерация справок для обучающихся</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection