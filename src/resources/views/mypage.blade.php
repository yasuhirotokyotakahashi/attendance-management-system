@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="attendance__alert">
        // メッセージ機能
    </div>

    <div class="attendance__content">
        <h1 class="">Dateを表示</h1>
        <div class="">
            <table class="attendance-table__inner">
                <tr class="attendance-table__row">
                    <th class="attendance-table__header">名前</th>
                    <th class="attendance-table__header">勤務開始</th>
                    <th class="attendance-table__header">勤務終了</th>
                    <th class="attendance-table__header">休憩時間</th>
                    <th class="attendance-table__header">勤務時間</th>
                </tr>
                <tr class="attendance-table__row">
                    <th class="attendance-table__item">name</th>
                    <th class="attendance-table__item">kinmukaisi</th>
                    <th class="attendance-table__item">kinmusyuuryou</th>
                    <th class="attendance-table__item">kyuukei</th>
                    <th class="attendance-table__item">kinmujikan</th>
                </tr>
            </table>
        </div>
    </div>
@endsection
