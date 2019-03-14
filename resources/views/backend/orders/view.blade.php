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
            <li class="active">View Order</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order No. {{ $order->order_no }}</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-info">Back To Orders</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/anonymous.jpg') }}" alt="User Image">
                            <span class="username">
                          <a href="#">{{ $order->title }}</a>
                          <div class="pull-right btn-box-tool">
                                {{--<a href="" class="btn btn-xs bg-aqua"><i class="fa fa-check"></i>Done</a>--}}
                        </div>
                        </span>
                            <span class="description">To be completed - {{ \Carbon\Carbon::parse($order->deadline)->diffForHumans() }}
                                <br>Bid Expiry Time - <span class="text-orange">{{ \Carbon\Carbon::parse($order->bid_expiry)->diffForHumans() }}</span> &nbsp;
                                {{--Added by -  <span class="text-aqua">Admin</span> &nbsp;--}}
                            </span>
                        </div>
                        <hr>
                        <div class="col-sm-6">
                            <h3>Description</h3>
                            <p>
                            </p><p>Title: {{ $order->title }}</p>

                            <p>Amount: {{ $order->amount }}</p>

                            <p>Number of Pages: {{ $order->no_pages }}</p>

                            <p>Number of Words: {{ $order->no_words }}</p>

                            <p>CPP: {{ $order->cpp }}</p>

                            <p>
                                Order Assign Type: @if($order->order_assign_type == 1)
                                    <i class="badge badge-info">Bid</i>
                                @elseif($order->order_assign_type == 2)
                                    <i class="badge badge-light">Take</i>
                                @else
                                    <i class="badge badge-primary">Manual</i>
                                @endif
                            </p>
                            <p></p>
                        </div>
                        <div class="col-sm-6">
                            <h3>Notes</h3>
                            <p>
                                Any topic (writer's choice)
                            </p>
                        </div>
                        <div class="col-sm-12">
                            <div class="pull-right">
                                <form action="https://academicdons.com/admin/save_file" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="zKZlLTxABOWHmdOl56Lz1RHrXQilvvfC7IlAsxTF">
                                    <input type="hidden" name="task_id" value="639">
                                    <input type="text" name="display_name" class="btn btn-default btn-xs" placeholder="display name">
                                    <label for="file" class="btn btn-xs btn-warning">Choose file</label>
                                    <input type="file" name="file" id="file" style="display: none">
                                    <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-upload"></i></button>
                                </form>

                            </div>

                        </div>



                        <div class="col-sm-12">


                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <tbody><tr>
                                        <th style="width: 10px">#</th>
                                        <th>File</th>
                                        <th>Created by</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Type</th>
                                        <th style="width: 40px"></th>
                                    </tr>

                                    <tr>
                                        <td>1</td>
                                        <td>Final Paper Rubric (1).docx</td>
                                        <td>Admin</td>
                                        <td></td>
                                        <td>2 months ago</td>
                                        <td>docx</td>
                                        <td><a href="https://academicdons.com/download/1258" class="btn btn-warning btn-xs">
                                                <i class="fa fa-cloud-download"></i>
                                            </a></td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Final Paper Instructions (5).docx</td>
                                        <td>Admin</td>
                                        <td></td>
                                        <td>2 months ago</td>
                                        <td>docx</td>
                                        <td><a href="https://academicdons.com/download/1259" class="btn btn-warning btn-xs">
                                                <i class="fa fa-cloud-download"></i>
                                            </a></td>
                                    </tr>

                                    </tbody></table>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop