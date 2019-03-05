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
                    <h3 class="box-title">Create/Edit Order</h3>
                    <div class="box-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Back to Orders</a>
                    </div>
                </div>
                <div class="box-body">
                    <form role="form" method="post" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{old('id')}}">

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" id="title" class="form-control" name="title" value="{{old('title')}}">
                                    <span class="form-control-feedback text-danger text-sm">{{($errors->has('title')?$errors->first('title'):"")}}</span>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="no_pages">No. of Pages</label>
                                            <input type="text" id="no_pages" class="form-control" name="no_pages" value="{{old('no_pages')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('no_pages')?$errors->first('no_pages'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="no_words">No. of Words</label>
                                            <input type="text" id="no_words" class="form-control" name="no_words" value="{{old('no_words')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('no_words')?$errors->first('no_words'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="amount">Amount</label>
                                            <input type="text" id="amount" class="form-control" name="amount" value="{{old('amount')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('amount')?$errors->first('amount'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="cpp">CPP</label>
                                            <input type="text" id="cpp" class="form-control" name="cpp" value="{{old('cpp')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('cpp')?$errors->first('cpp'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="order_assign_type">Order Assign Type</label>
                                    <select name="order_assign_type" id="order_assign_type" class="form-control">
                                        <option value="1" {{ old('order_assign_type') == 1?"selected":'' }}>Bid</option>
                                        <option value="2" {{ old('order_assign_type') == 2?"selected":'' }}>Take</option>
                                        <option value="3" {{ old('order_assign_type') == 3?"selected":'' }}>Manual</option>
                                    </select>
                                    <span class="form-control-feedback text-danger text-sm">{{($errors->has('order_assign_type')?$errors->first('order_assign_type'):"")}}</span>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="bid_expiry">Bid Expiry Time</label>
                                            <input type="datetime-local" id="bid_expiry" class="form-control" name="bid_expiry" value="{{old('bid_expiry')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('bid_expiry')?$errors->first('bid_expiry'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="deadline">Deadline</label>
                                            <input type="datetime-local" id="deadline" class="form-control" name="deadline" value="{{old('deadline')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('deadline')?$errors->first('deadline'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="col-sm-6">


                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea rows="12" id="notes" class="form-control" name="notes">{{old('notes')}}</textarea>
                                    <span class="form-control-feedback text-danger text-sm">{{($errors->has('notes')?$errors->first('notes'):"")}}</span>
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