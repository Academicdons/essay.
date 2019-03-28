@extends('mails.master')

@section('content')
    <p>Dear {{$user->name}},</p>
    <p>
        {!!  $msg !!}
    </p>

    @endsection
