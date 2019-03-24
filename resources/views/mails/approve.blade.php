@extends('mails.master')

@section('content')
    <p>Dear {{$user->name}},</p>
    <p>
        Your account has been approved. Please login.

    </p>

@endsection
