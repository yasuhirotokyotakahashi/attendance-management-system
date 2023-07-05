@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
    <div class="attendance__alert">
        // メッセージ機能
    </div>

    <div class="attendance__content">
        <form action="/performance" method="post">
            @csrf

            <input type="date" name="date">
            <input type="submit" value="選択">
            {{-- <select name="month" id="">
                @for ($i = 1; $i <= 12; $i++)
                    <option>{{ $i }}</option>
                @endfor
            </select>
            <p>月</p>

            <select name="day" id="">
                @for ($i = 1; $i <= 31; $i++)
                    <option>{{ $i }}</option>
                @endfor
            </select>
            <p>日</p>
            <input type="submit" value="選択"> --}}
        </form>

        <h1 class=""></h1>
        <div class="">
            <table class="attendance-table__inner">
                @foreach ($items as $item)
                    <tr class="attendance-table__row">
                        <th class="attendance-table__header">日付</th>

                        <th class="attendance-table__header">名前</th>
                        <th class="attendance-table__header">勤務開始</th>
                        <th class="attendance-table__header">勤務終了</th>
                        <th class="attendance-table__header">休憩時間</th>
                        <th class="attendance-table__header">勤務時間</th>
                    </tr>
                    <tr class="attendance-table__row">
                        <th class="attendance-table__item">{{ $item->date }}</th>
                        <th class="attendance-table__item">{{ $item->user->name }}</th>
                        <th class="attendance-table__item">{{ $item->punchIn }}</th>
                        <th class="attendance-table__item">{{ $item->punchOut }}</th>
                        <th class="attendance-table__item"> {{ $breakTime }} 秒</th>
                        <th class="attendance-table__item">{{$workTime}}</th>


                    </tr>
                @endforeach
            </table>

            {{ $items->links() }}
        </div>
    </div>
@endsection
