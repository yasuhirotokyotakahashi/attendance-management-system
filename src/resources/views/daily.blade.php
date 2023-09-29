@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/daily.css') }}">
@endsection

@section('content')
    <div class="attendance__alert">
        // メッセージ機能です
    </div>

    <div class="attendance__content">

        <div class="date-navigation">
            <a href="/performance?date={{ $previousDate->format('Y-m-d') }}" class="prev-date">&lt;</a>
            <h1 class="date">{{ $selectedDate->format('Y年m月d日') }}</h1>
            <a href="/performance?date={{ $nextDate->format('Y-m-d') }}" class="next-date">&gt;</a>
        </div>
        <div class="">
            <table class="attendance-table__inner">
                <tr class="attendance-table__row">
                    <th class="attendance-table__header">名前</th>
                    <th class="attendance-table__header">勤務開始</th>
                    <th class="attendance-table__header">勤務終了</th>
                    <th class="attendance-table__header">休憩時間</th>
                    <th class="attendance-table__header">勤務時間</th>
                </tr>
                @foreach ($processedItems as $processedItem)
                    <tr class="attendance-table__row">
                        <th class="attendance-table__item">{{ $processedItem['item']->user->name }}</th>
                        <th class="attendance-table__item">{{ $processedItem['item']->punchIn }}</th>
                        <th class="attendance-table__item">{{ $processedItem['item']->punchOut }}</th>
                        <th class="attendance-table__item">
                            {{ $processedItem['totalRestDifference'] }}</th>
                        <th class="attendance-table__item">
                            {{ $processedItem['actualWorkingTime'] }}
                        </th>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>
    {{ $items->links() }}
@endsection
