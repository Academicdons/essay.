@extends('layouts.index')

@section('style')
    

@endsection


@section('content')


    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-sm-12 border-right border-left">

                <h3 class="mt-3 mb-3">{{$article->title}}</h3>
                <p class="text-light-blue">{{$article->created_at->diffForHumans()}}</p>
                <p class="mb-5">
                    {!! $article->description !!}
                </p>

                <p class="text-center">
                    <a class="button" href="{{route('customer.orders.create')}}">Order your paper now</a>

                </p>

            </div>
        </div>
    </div>

    @endsection