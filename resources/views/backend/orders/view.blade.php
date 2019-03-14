@extends('layouts.admin')

@section('style')

    <style type="text/css">
        .border-right{
            border-right: 1px solid gray;
        }

        .chat{
            border: 1px solid gray;
            border-radius:  6px 6px 0px 0px;
            padding: 0px !important;
            margin: 6px 0px 6px 0px;
        }

        .chat .col-sm-12{
            padding-left: 2px !important;
            padding-right: 2px !important;
        }

        .chat-header{
            background: green !important;
            border-radius:  6px 6px 0px 0px !important;
        }


        .chat-header .col-sm-6{
            padding: 0px !important;
        }

        .chat-header p{
            font-size: 18px;
            color: white;
            font-weight: bold;
            padding: 5px;
        }

        .chat-header .br{
            border-right: 2px solid white !important;
        }
        .chat-foot{
            margin-bottom: 3px;
        }
    </style>
    @endsection

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
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-xs btn-info">Back To Orders</a>
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
                            <span class="description">To be completed - {{ \Carbon\Carbon::parse($order->deadline)->diffForHumans() }} &nbsp <b>-</b> &nbsp;Bid Expiry Time - <span class="text-orange">{{ \Carbon\Carbon::parse($order->bid_expiry)->diffForHumans() }}</span> &nbsp;
                                {{--Added by -  <span class="text-aqua">Admin</span> &nbsp;--}}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="col-sm-12">
                                    <br>
                                    <table class="table table-striped table-sm">
                                        <tr>
                                            <td>Order type</td>
                                            <th>
                                                @if($order->order_assign_type == 1)
                                                    writers to bid
                                                @elseif($order->order_assign_type == 2)
                                                    First come take
                                                @else
                                                    Manual assignment
                                                @endif
                                            </th>
                                            <td>Academic level</td>
                                            <th>
                                                @if($order->order_assign_type == 1)
                                                    writers to bid
                                                @elseif($order->order_assign_type == 2)
                                                    First come take
                                                @else
                                                    Manual assignment
                                                @endif
                                            </th>

                                            <td>Bonus</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Writer quality </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>

                                        <tr>
                                            <td>Number of pages</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Number of words </td>
                                            <th>{{ $order->no_words }}</th>
                                            <td>Education level</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Salary </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>

                                        <tr>
                                            <td>Bonus</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Writer quality </td>
                                            <th>{{ $order->no_words }}</th>

                                            <td>Bonus</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Writer quality </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-6 border-right">
                                    <div class="row">


                                        <div class="col-md-12">
                                            <h4><u>Clients review:</u></h4>

                                            <p>
                                                <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>Maniruzzaman Akash</strong></a>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>

                                            </p>
                                            <div class="clearfix"></div>
                                            <p>Lorem Ipsum is simply dummy text of the pr make  but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        </div>

                                        <div class="col-md-12">
                                            <h4><u>Writers review:</u></h4>

                                            <p>
                                                <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>Maniruzzaman Akash</strong></a>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>
                                                <span class="float-right"><i class="text-warning fa fa-star"></i></span>

                                            </p>
                                            <div class="clearfix"></div>
                                            <p>Lorem Ipsum is simply dummy text of the pr make  but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                                        </div>
                                    </div>
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
                            <div class="col-sm-4">
                                <div class="row chat">
                                    <div class="col-sm-12 chat-header">
                                        <div class="row">
                                            <div class="col-sm-6 br">
                                                <p class="text-center">Writer(3)</p>
                                            </div>
                                            <div class="col-sm-6">
                                                <p class="text-center">Client(2)</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 chat-body">
                                        <div class="direct-chat-messages" style="min-height: 400px !important;">
                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-info clearfix">
                                                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                                    <span class="direct-chat-timestamp pull-right">23 Jan 2:00 pm</span>
                                                </div>
                                                <!-- /.direct-chat-info -->
                                                <img class="direct-chat-img" src="{{asset('dist/img/user1-128x128.jpg')}}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    Is this template really for free? That's unbelievable!
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-info clearfix">
                                                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                                    <span class="direct-chat-timestamp pull-left">23 Jan 2:05 pm</span>
                                                </div>
                                                <!-- /.direct-chat-info -->
                                                <img class="direct-chat-img" src="{{asset('dist/img/user3-128x128.jpg')}}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    You better believe it!
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Message. Default to the left -->
                                            <div class="direct-chat-msg">
                                                <div class="direct-chat-info clearfix">
                                                    <span class="direct-chat-name pull-left">Alexander Pierce</span>
                                                    <span class="direct-chat-timestamp pull-right">23 Jan 5:37 pm</span>
                                                </div>
                                                <!-- /.direct-chat-info -->
                                                <img class="direct-chat-img" src="{{asset('dist/img/user1-128x128.jpg')}}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    Working with AdminLTE on a great new app! Wanna join?
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                            <!-- Message to the right -->
                                            <div class="direct-chat-msg right">
                                                <div class="direct-chat-info clearfix">
                                                    <span class="direct-chat-name pull-right">Sarah Bullock</span>
                                                    <span class="direct-chat-timestamp pull-left">23 Jan 6:10 pm</span>
                                                </div>
                                                <!-- /.direct-chat-info -->
                                                <img class="direct-chat-img" src="{{asset('dist/img/user3-128x128.jpg')}}" alt="message user image">
                                                <!-- /.direct-chat-img -->
                                                <div class="direct-chat-text">
                                                    I would love to.
                                                </div>
                                                <!-- /.direct-chat-text -->
                                            </div>
                                            <!-- /.direct-chat-msg -->

                                        </div>
                                    </div>
                                    <div class="col-sm-12 chat-foot">
                                        <form action="#" method="post">
                                            <div class="input-group">
                                                <input type="text" name="message" placeholder="Type Message ..." class="form-control">
                                                <span class="input-group-btn">
                                                <button type="button" class="btn btn-warning btn-flat">Send</button>
                                              </span>
                                            </div>
                                        </form>
                                    </div>


                                    <div class="col-sm-12">
                                        <h4>Assignments:</h4>
                                        <hr>
                                        <ul class="users-list clearfix">
                                            <li>
                                                <img src="{{asset('dist/img/user1-128x128.jpg')}}" alt="User Image">
                                                <a class="users-list-name" href="#">Alexander Pierce</a>
                                                <span class="users-list-date">Today</span>
                                            </li>
                                            <li>
                                                <img src="{{asset('dist/img/user8-128x128.jpg')}}" alt="User Image">
                                                <a class="users-list-name" href="#">Norman</a>
                                                <span class="users-list-date">Yesterday</span>
                                            </li>
                                            <li>
                                                <img src="{{asset('dist/img/user7-128x128.jpg')}}" alt="User Image">
                                                <a class="users-list-name" href="#">Jane</a>
                                                <span class="users-list-date">12 Jan</span>
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
@stop