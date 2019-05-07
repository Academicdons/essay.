@extends('layouts.writer')

@section('page')
    Available orders
@endsection

@section('style')
    <link href="{{asset('plugins/jasny-bootstrap/css/jasny-bootstrap.css')}}" rel="stylesheet" />
    <style>
        .field-area{
            border-bottom: 1px solid darkgray;
            margin-bottom: 2px;
        }

        .field-area .label{
            font-size: 15px;
            margin-bottom: 0px !important;
            color: gray;
        }

        label{
            font-size: 15px;
        }
    </style>
@endsection


@section('content')

    <section class="container-fluid content" id="profile_content">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-3 pb-5">

                        <img src="https://cdn3.iconfinder.com/data/icons/business-avatar-1/512/10_avatar-512.png" class="img-fluid" alt="">

                        <div class="field-area">
                            <p class="label"><i class="fa fa-address-card"></i> Full name:</p>
                            <p class="font-weight-bold">{{$user->name}}</p>
                        </div>

                        <div class="field-area">
                            <p class="label"><i class="fa fa-envelope"></i> Email address:</p>
                            <p class="font-weight-bold">{{$user->email}}</p>
                        </div>

                        <div class="field-area">
                            <p class="label"><i class="fa fa-phone-square"></i> Phone number:</p>
                            <p class="font-weight-bold">{{$user->phone_number}}</p>
                        </div>

                        <div class="field-area">
                            <p class="label"><i class="fa fa-google-wallet"></i> Account status:</p>
                            <p class="font-weight-bold text-success">Active</p>
                        </div>


                    </div>
                    <div class="col-sm-9 border-left">
                        @yield('body')
                    </div>
                </div>
            </div>
        </div>

    </section>
    @endsection
@section('script')
    <script src="{{asset('plugins/holder-master/holder.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/jasny-bootstrap/js/jasny-bootstrap.js')}}"></script>

    <script>

    </script>
@endsection