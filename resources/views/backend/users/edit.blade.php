@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            Orders
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Orders</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Create/Edit user</h3>
                    <div class="box-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Back to Orders</a>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" method="post" action="{{ route('admin.users.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{old('id')}}">

                        <div class="row">
                            <div class="col-sm-4">

                                <div class="form-group">
                                    <label for="">Username</label>
                                    <input class="form-control" type="text" name="name" value="{{old('name')}}">
                                    <span class="text-danger">{{($errors->has('name'))?$errors->first('name'):""}}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Email address</label>
                                    <input class="form-control" type="email" name="email" value="{{old('email')}}">
                                    <span class="text-danger">{{($errors->has('email'))?$errors->first('email'):""}}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Phone number</label>
                                    <input class="form-control" type="text" name="phone_number" value="{{old('phone_number')}}">
                                    <span class="text-danger">{{($errors->has('phone_number'))?$errors->first('phone_number'):""}}</span>
                                </div>


                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">User type</label>
                                    <select class="form-control" name="user_type">
                                        <option value="0" {{(old('user_type')==0)?"selected":""}}>admin</option>
                                        <option value="1" {{(old('user_type')==1)?"selected":""}}>writer</option>
                                        <option value="2" {{(old('user_type')==2)?"selected":""}}>client</option>
                                    </select>
                                    <span class="text-danger">{{($errors->has('email'))?$errors->first('email'):""}}</span>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label for="">Avatar</label>
                                    <input class="form-control" type="file" name="avatar" value="{{old('avatar')}}">
                                    <span class="text-danger">{{($errors->has('avatar'))?$errors->first('avatar'):""}}</span>
                                </div>

                                <div class="form-group">
                                    <label for="">Ratings</label>
                                    <input class="form-control" type="text" name="ratings" value="{{old('ratings')}}">
                                    <span class="text-danger">{{($errors->has('ratings'))?$errors->first('ratings'):""}}</span>
                                </div>
                            </div>
                        </div>

                        <Button class="btn btn-primary" type="submit">Submit</Button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            CKEDITOR.replace('notes')
        })
    </script>
@stop