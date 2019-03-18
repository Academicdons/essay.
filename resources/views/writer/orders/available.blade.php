@extends('layouts.writer')

@section('page')
    Available orders
    @endsection

@section('style')

    <style type="text/css">

        .table-striped tr:nth-child(odd){
            background: lightgrey !important;
        }



        .order h4 span{
            font-weight: bold;
        }

        .order h4{
            font-weight: bold;
        }

        .order .col-sm-4:nth-child(1){
            padding-right: 0px !important;
        }

        .order .col-sm-4:nth-child(2){
            padding-right: 2px !important;
            padding-left: 2px !important;
        }

        .order .col-sm-4:nth-child(3){
            padding-left: 0px !important;
        }

        .table-sm th,td{
            padding: 5px !important;
        }

    </style>

    @endsection


@section('content')

    <div class="container">
        <div class="order box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4"><h4 class="text-light-blue">The order title goes here</h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4>ID: <span>345232312141</span></h4></div>
                    <div class="col-sm-4"><h4>Deadline: <span>24/56/2018</span></h4></div>
                    <div class="col-sm-4"><h4>Time remaining: <span class="text-danger">3h 56min 34s</span></h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Order type</td><th>ASSI</th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="" class="btn btn-default pull-right btn-sm"><i class="fa text-primary fa-file"></i> view</a> &nbsp;
                        <a href="" class="btn btn-default pull-right btn-sm" style="margin-right: 10px"><i class="fa text-primary fa-file"></i> files</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="order box box-solid">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4"><h4 class="text-light-blue">The order title goes here</h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4>ID: <span>345232312141</span></h4></div>
                    <div class="col-sm-4"><h4>Deadline: <span>24/56/2018</span></h4></div>
                    <div class="col-sm-4"><h4>Time remaining: <span class="text-danger">3h 56min 34s</span></h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Order type</td><th>ASSI</th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                            <tr>
                                <td>Order type</td><th></th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a href="" class="btn btn-default pull-right btn-sm"><i class="fa text-primary fa-file"></i> view</a> &nbsp;
                        <a href="" class="btn btn-default pull-right btn-sm" style="margin-right: 10px"><i class="fa text-primary fa-file"></i> files</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection