@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="attendance__alert">
        // メッセージ機能
    </div>

    <div class="attendance__content">
        <h1 class="greeting">高橋さんこんちゃ</h1>
        <div class="attendance__panel">
            <form class="attendance__button" action="/timein" method="post">
                @csrf
                <input class="attendance__button-submit" type="submit" value="勤務開始">
            </form>
            <form class="attendance__button" action="/timeout" method="post">
                @csrf
                <input class="attendance__button-submit" type="submit" value="勤務終了">
            </form>
        </div>
        <div class="attendance__panel">
            <form class="attendance__button" action="/breakin" method="post">
                @csrf
                <input class="attendance__button-submit" type="submit" value="休憩開始">
            </form>
            <form class="attendance__button" action="/breakout" method="post">
                @csrf
                <input class="attendance__button-submit" type="submit" value="休憩終了">
            </form>
        </div>
    </div>
@endsection
