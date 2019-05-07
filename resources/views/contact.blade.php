@extends('layouts.index')

@section('content')

    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <form action="">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Full name</label>
                                        <input type="text" class="form-control" name="name" placeholder="jane doe" value="{{old('name')}}">
                                        <span class="text-danger">{{($errors->has('name'))?$errors->first('name'):""}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Email address</label>
                                        <input type="email" class="form-control" name="email" placeholder="jane@doe.com" value="{{old('email')}}">
                                        <span class="text-danger">{{($errors->has('email'))?$errors->first('email'):""}}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Phone number</label>
                                        <input type="text" class="form-control" name="phone_number" placeholder="+1 31 542323" value="{{old('phone_number')}}">
                                        <span class="text-danger">{{($errors->has('phone_number'))?$errors->first('phone_number'):""}}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Topic</label>
                                        <select name="topic"class="form-control">
                                            <option value="1">Order placement</option>
                                            <option value="2">Writers account</option>
                                            <option value="3">Technical support</option>
                                            <option value="4">Referrals</option>
                                            <option value="0">Other</option>
                                        </select>
                                        <span class="text-danger">{{($errors->has('topic'))?$errors->first('topic'):""}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="">Message</label>
                                <textarea name="message" class="form-control" rows="12" placeholder="Type your message here">{{old('message')}}</textarea>
                                <span class="text-danger">{{($errors->has('message'))?$errors->first('message'):""}}</span>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection