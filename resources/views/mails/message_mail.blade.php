@extends('mails.master')

@section('content')
    <p>Dear {{$user->name}},</p>
    <p>
        {!!  $message_to_user!!}
    </p>
@endsection
