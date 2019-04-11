@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Paper Types
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Paper Types</li>
        </ol>
    </section>

    <section class="content">

        <div class="box">
            <div class="box-body">
                <div class="row">
                    <div class="col-xs-12">
                        <form action="{{route('admin.settings.store_system')}}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Auto assign jobs</label>
                                        <input type="checkbox" name="auto_assign" {{(old('auto_assign')==1)?"checked":""}}>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Auto assign jobs</label>
                                        <input type="checkbox" name="send_sms" {{(old('send_sms')==1)?"checked":""}}>
                                    </div>
                                </div>
                                <div class="col-sm-4"></div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary">update</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
@stop

@section('script')
    <script>



    </script>
@stop