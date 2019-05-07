@extends('layouts.writer')

@section('page')
    Payment information
@endsection

@section('style')

@endsection

@section('content')

    <div class="container">
        <div class="box box-primary">
            <div class="box-header">
                <h3>Payment information</h3>
            </div>
            <div class="box-body">

                <form action="{{route('writer.payments.store')}}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">M-Pesa phone number</label>
                                <input type="text" class="form-control" name="mpesa_number" value="{{old('mpesa_number')}}">
                                <span class="text-danger">{{($errors->has('mpesa_number'))?$errors->first('mpesa_number'):""}}</span>
                            </div>

                            <div class="form-group">
                                <label for="">Id Number</label>
                                <input type="text" class="form-control" name="id_number" value="{{old('id_number')}}">
                                <span class="text-danger">{{($errors->has('id_number'))?$errors->first('id_number'):""}}</span>
                            </div>

                            <div class="form-group">
                                <label for="">M-Pesa name</label>
                                <input type="text" class="form-control" name="mpesa_name" value="{{old('mpesa_name')}}">
                                <span class="text-danger">{{($errors->has('mpesa_name'))?$errors->first('mpesa_name'):""}}</span>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="">Bank name</label>
                                <input type="text" class="form-control " name="bank_name" value="{{old('bank_name')}}">
                                <span class="text-danger">{{($errors->has('bank_name'))?$errors->first('bank_name'):""}}</span>
                            </div>

                            <div class="form-group">
                                <label for="">Bank account number</label>
                                <input type="text" class="form-control " name="account_number" value="{{old('account_number')}}">
                                <span class="text-danger">{{($errors->has('account_number'))?$errors->first('account_number'):""}}</span>
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">update</button>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

@endsection


