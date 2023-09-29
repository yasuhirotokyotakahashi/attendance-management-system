@extends('layouts.app')
<!-- レイアウトを利用する場合に指定 -->

@section('css')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
@endsection

@section('content')
    <div class="container">
        <h1>ユーザー一覧</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>名前</th>
                    <th>Email</th>
                    <!-- 他のユーザー情報を追加 -->
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                <h1>一覧だよ</h1>


                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <!-- 他のユーザー情報を表示 -->
                        <td>
                            <a href="{{ route('user.attendance', ['id' => $user->id]) }}" class="button">勤怠表</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
