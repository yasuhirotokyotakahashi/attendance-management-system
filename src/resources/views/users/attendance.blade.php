@extends('layouts.app')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>{{ $user->name }}の勤怠表</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>日付</th>
                    <th>出勤時間</th>
                    <th>退勤時間</th>
                    <th>休憩時間</th>
                    <!-- 他の勤怠情報を追加 -->
                </tr>
            </thead>
            <tbody>
                @foreach ($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->date }}</td>
                        <td>{{ $attendance->punchIn }}</td>
                        <td>{{ $attendance->punchOut }}</td>
                        <td>{{ $attendance->totalRestTime }}</td>
                        <!-- 他の勤怠情報を表示 -->
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
