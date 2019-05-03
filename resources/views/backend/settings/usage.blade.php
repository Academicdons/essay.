@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            Usage statistics
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Usage statistics</li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">

                <form action="{{route('admin.settings.save_stats')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="">Current orders</label>
                        <input type="text" class="form-control" name="current_orders" value="{{old('current_orders')}}">
                    </div>

                    <div class="form-group">
                        <label for="">Loyal customers</label>
                        <input type="text" class="form-control" name="loyal_customers" value="{{old('loyal_customers')}}">
                    </div>

                    <div class="form-group">
                        <label for="">Active writers</label>
                        <input type="text" class="form-control" name="active_writers" value="{{old('active_writers')}}">
                    </div>

                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Update">
                    </div>

                </form>
            </div>
        </div>
    </section>

    @endsection