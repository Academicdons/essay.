@extends('mails.master')

@section('content')
    <p>Dear {{$user->name}},</p>
    <p>
        Your account with homework pro writers has been created. Login and get your work done by professional writers
    </p>

@endsection
