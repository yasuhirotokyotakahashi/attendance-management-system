@extends('layouts.app')

@section('content')
    <h1>メールアドレスの確認</h1>
    <p>以下のリンクをクリックして、メールアドレスを確認してください。</p>
    <a href="{{ $verificationUrl }}">メールアドレスを確認する</a>
@endsection
