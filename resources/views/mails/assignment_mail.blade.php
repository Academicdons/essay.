@extends('mails.master')

@section('content')
    <p>Dear {{$user->name}},</p>
    <p>
        You have been assigned an order, please log in to check the order.
        <br>
         Thank you for your time and interest in us.

    </p>
    {{--<h3> {!! $data['title'] !!} </h3>--}}
    {{--<p>{{$data['message']}}</p>--}}
    @endsection
