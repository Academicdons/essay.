@extends('layouts.index')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Register') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register') }}">
                        @csrf
                <div class="row">
                    <div class="form-group col-md-6 col-lg-6 col-sm-12">
                        <label for="name" class=" col-form-label text-md-right">{{ __('Name') }}</label>

                            <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('name') }}</strong>
                                                    </span>
                            @endif

                    </div>

                    <div class="form-group col-md-6 col-lg-6 col-sm-12 ">
                        <label for="email" class="col-form-label text-md-right">{{ __('E-Mail Address') }}</label>


                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $errors->first('email') }}</strong>
                                                    </span>
                            @endif

                    </div>

                </div>

                    <div class="row">
                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="phone_number" class=" col-form-label text-md-right">Phone Number</label>

                                <input id="phone_number" type="text" class="form-control{{ $errors->has('phone_number') ? ' is-invalid' : '' }}" name="phone_number" value="{{ old('phone_number') }}" required>

                                @if ($errors->has('phone_number'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('phone_number') }}</strong>
                                    </span>
                                @endif

                        </div>

                        <div class="form-group col-md-6 col-lg-6 col-sm-12">
                            <label for="user_type" class="col-form-label text-md-right">Register As:</label>

                                <select name="user_type" id="user_type" class="form-control{{ $errors->has('user_type') ? ' is-invalid' : '' }}">
                                    <option value="1">Writer (Take Assignments)</option>
                                    <option value="1">Client (Give Assignments)</option>
                                </select>

                                @if ($errors->has('user_type'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('user_type') }}</strong>
                                    </span>
                                @endif
                        </div>


                    </div>


                        <div class="row ">

                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                <label for="password" class=" col-form-label text-md-right">{{ __('Password') }}</label>

                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                            </div>

                            <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                <label for="password-confirm" class=" col-form-label text-md-right">{{ __('Confirm Password') }}</label>

                                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                            </div>

                        </div>

                        <div class="form-group row mb-0">

                              <div class="col-md-6"> <input class="checkbox" type="checkbox">   <h6>  By Clicking the here means you agree with the  </h6><a href="{{url('terms')}}">Terms and Conditions</a>
                              </div>
                            <div class="col-md-6 ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Register') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
