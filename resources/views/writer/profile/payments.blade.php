@extends('writer.profile.profile')

@section('body')

    <div class="row">
        <div class="col-sm-12 text-right">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" onclick="location.href='{{route('writer.profile.index')}}';" class="btn btn-outline-info"><i class="fa fa-user"></i> Basic information</button>
                <button type="button" onclick="location.href='{{route('writer.profile.payments')}}';" class="btn btn-outline-success"><i class="fa fa-money"></i> Payment information</button>
            </div>
        </div>
        <div class="col-sm-12 mt-3">

            <form action="{{route('writer.profile.store_payments')}}" method="post">
                @csrf
                <h6 class="text-right text-aqua">M-Pesa payments</h6>
                <hr class="m-0">
                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Mpesa number</label>
                        <input type="text" name="mpesa_number" value="{{old('mpesa_number')}}" class="form-control">
                    </div>

                    <div class="col-sm-6">
                        <label for="">Mpesa name</label>
                        <input type="text" name="mpesa_name" value="{{old('mpesa_name')}}" class="form-control">
                    </div>

                    <div class="col-sm-6">
                        <label for="">Id number</label>
                        <input type="text" name="id_number" value="{{old('id_number')}}" class="form-control">
                    </div>


                </div>

                <h6 class="text-right text-aqua mt-4">Banking information</h6>
                <hr class="m-0">

                <div class="row">
                    <div class="col-sm-6">
                        <label for="">Bank name</label>
                        <input type="text" name="bank_name" value="{{old('bank_name')}}" class="form-control">
                    </div>

                    <div class="col-sm-6">
                        <label for="">Account number</label>
                        <input type="text" name="account_number" value="{{old('account_number')}}" class="form-control">
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary">Update payment information</button>
                    </div>
                </div>
            </form>


        </div>
    </div>

@endsection