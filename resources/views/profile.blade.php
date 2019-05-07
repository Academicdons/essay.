@extends('layouts.index')
@section('style')
    <link href="{{asset('plugins/jasny-bootstrap/css/jasny-bootstrap.css')}}" rel="stylesheet" />

    <style>
        .image_style{
            height: 250px;
            width: 250px;
        }

    </style>

@endsection

@section('content')
    <section class="place-order">


        <div class="container">
            <h3>Profile</h3>



                <div class="row">

                    <div class="col-sm-12 col-md-8  col-lg-8">

                        <form action="{{route('save_profile')}}" method="post" >
                            @csrf

                            <div class="step-area p-3">

                            <div class="row">

                                <div class="form-group col-md-6 col-sm-12 col-lg-6">

                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{old('name')}}" id="name">
                                    <span class="text-danger">{{($errors->has('name'))?$errors->first('name'):""}}</span>


                                </div>

                                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" value="{{old('email')}}" id="email">
                                    <span class="text-danger">{{($errors->has('email'))?$errors->first('email'):""}}</span>

                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                                    <label for="phone_number">Phone Number</label>
                                    <input class="form-control" type="text" name="phone_number" value="{{old('phone_number')}}" id="phone_number">
                                    <span class="text-danger">{{($errors->has('phone_number'))?$errors->first('phone_number'):""}}</span>

                                </div>

                                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" id="password">
                                    <span class="text-danger">{{($errors->has('password'))?$errors->first('password'):""}}</span>


                                </div>
                            </div>
                            <div class="row">

                                <div class="form-group col-md-6 col-sm-12 col-lg-6">
                                    <label for="password_confirmation">Password Confirmation</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                                    <span class="text-danger">{{($errors->has('password_confirmation'))?$errors->first('password_confirmation'):""}}</span>

                                </div>

                                <div class="form-group col-md-8 col-sm-12 col-lg-8">
                                    <button class="btn btn-success" type="submit">Update</button>

                                </div>
                            </div>

                        </div>
                        </form>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">

<div class="box box-default ">


    <div class="box-body">
        @if(count($errors->all())>0)
            <div class="alert-danger">
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </div>

        @endif

        <form role="form" name="businessPic" method="post" action="{{route('update_picture')}}" enctype="multipart/form-data">
            {{csrf_field()}}
            <div class="form-group">
                <div class="fileinput fileinput-new" data-provides="fileinput">
                    <div class="fileinput-new thumbnail">
                        <img   alt="..."   src="{{asset('uploads/user_pictures/'. old('avatar'))}}" class="image_style img img-responsive">

                    </div>
                    <div class="image_style fileinput-preview fileinput-exists thumbnail"  ></div>
                    <div id="image_btn">
                                                                            <span class="btn btn-primary btn-file">
                                                                                <span class="fileinput-new">Select image</span>
                                                                                <span class="fileinput-exists">Change</span>
                                                                                <input type="file"  class="img img-responsive" name="user_pic" ></span>
                        <a href="#" class="btn btn-danger fileinput-exists" data-dismiss="fileinput">Remove</a>
                        <input type="submit"  class="btn btn-success fileinput-exists">

                    </div>
                </div>
            </div>

        </form>

    </div>

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
        @if(\Illuminate\Support\Facades\Session::has("success"))
                let messagewewe='{!! session('success') !!}';
        swal("Success!",messagewewe, "success");
        @endif

                @if(\Illuminate\Support\Facades\Session::has("failure"))
        let messager='{!! session('failure') !!}';
        swal("Success!",messager, "error");
        @endif
    </script>
@endsection