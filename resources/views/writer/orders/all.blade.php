@extends('layouts.writer')

@section('page')
    Available orders
    @endsection

@section('style')

    <style type="text/css">


    </style>

    @endsection


@section('content')
    <section class="col-sm-10 col-lg-offset-1" id="orders_area">
        <div class="row">
            <div class="col-md-3">
                {{--<a href="compose.html" class="btn btn-primary btn-block margin-bottom">Compose</a>--}}

                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Folders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#"  @click="getUserOrders(0)"><i class="fa fa-inbox"></i> Available
                                    <span class="label label-primary pull-right"></span></a></li>
                            <li><a href="#" @click="getUserOrders(1)"><i class="fa fa-envelope-o" ></i> In Progress</a></li>
                            <li><a href="#" @click="getUserOrders(2)"><i class="fa fa-file-text-o" ></i> Revision</a></li>
                            <li><a href="#" @click="getUserOrders(3)"><i class="fa fa-filter" ></i> Complete </a>
                            <li><a href="#" @click="getUserOrders(5)"><i class="fa fa-times" ></i> Disputed </a>
                            </li>
                            {{--<li><a href="#"><i class="fa fa-trash-o"></i> Trash</a></li>--}}
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /. box -->
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Finished orders</h3>

                        <div class="box-tools">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                            </button>
                        </div>
                    </div>
                    <div class="box-body no-padding">
                        <ul class="nav nav-pills nav-stacked">
                            <li><a href="#" @click="getFinishedOrders(0)"><i class="fa fa-circle-o text-red"></i>Unpaid orders</a></li>
                            <li><a href="#" @click="getFinishedOrders(1)"><i class="fa fa-circle-o text-yellow"></i>Paid orders</a></li>
                        </ul>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
            <div class="col-md-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Orders list</h3>

                        <div class="box-tools pull-right">
                            <div class="has-feedback">
                                <input type="text" class="form-control input-sm" placeholder="Search Orders">
                                <span class="glyphicon glyphicon-search form-control-feedback"></span>
                            </div>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body no-padding">
                        <div class="mailbox-controls">
                            <!-- Check all button -->
                            <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="fa fa-square-o"></i>
                            </button>
                            <div class="btn-group">
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-trash-o"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-reply"></i></button>
                                <button type="button" class="btn btn-default btn-sm"><i class="fa fa-share"></i></button>
                            </div>
                            <!-- /.btn-group -->
                            <button type="button" class="btn btn-default btn-sm"><i class="fa fa-refresh"></i></button>
                            <div class="pull-right">
                                1-50/200
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-left"></i></button>
                                    <button type="button" class="btn btn-default btn-sm"><i class="fa fa-chevron-right"></i></button>
                                </div>
                                <!-- /.btn-group -->
                            </div>
                            <!-- /.pull-right -->
                        </div>
                        <div class="table-responsive mailbox-messages">
                            <table class="table table-hover table-striped" v-if="!accounts">
                                <tbody>

                                <tr v-for="(order,index) in orders">
                                    <td>@{{ index+1 }}<div class="icheckbox_flat-blue" aria-checked="false" aria-disabled="false" style="position: relative;"><input type="checkbox" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div></td>
                                    <td class="mailbox-star"><a href="#"><i class="fa fa-star text-yellow"></i></a></td>
                                    <td class="mailbox-name"><a href="#">@{{ order.client.name }}</a></td>
                                    <td class="mailbox-subject"><b>@{{ order.title }}</b> - Trying to find a solution to this problem...
                                    </td>
                                    <td class="mailbox-attachment"></td>
                                    <td class="mailbox-date" v-if="order.status==2"><button class="btn btn-primary btn-sm" data-target="#edit_modal" data-toggle="modal" @click="getRevisions(order.revision)">View Comments</button> </td>
                                    <td class="mailbox-date" v-if="order.status==1"><a :href="'{{url('/writer/orders/mark_as_complete')}}/' + order.id" class="btn btn-primary btn-sm" >Mark As Complete</a> </td>
                                    <td class="mailbox-date">
                                        <a :href="'{{url('/writer/orders/view')}}/' + order.id" class="btn btn-xs btn-default">Read more</a>
                                    </td>
                                </tr>


                                </tbody>
                            </table>

                            <table class="table table-hover table-striped" v-if="accounts">

                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Order number</th>
                                        <th>Salary</th>
                                        <th>Bonus/Fine</th>
                                        <th>Total</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <tr v-for="(order,index) in pay_orders">
                                    <td>@{{ index+1 }}</td>
                                    <td><a href="#">@{{ order.order_no }}</a></td>
                                    <td ><b>$@{{ order.salary }}</b></td>
                                    <td>$@{{ order.bargains_sum }}</td>
                                    <td>$@{{ order.bargains_sum+order.salary }}</td>
                                    <td>
                                        <a :href="'{{url('/writer/orders/view')}}/' + order.id" class="btn btn-xs btn-default">Read more</a>
                                    </td>
                                </tr>


                                </tbody>
                            </table>
                            <!-- /.table -->
                        </div>
                        <!-- /.mail-box-messages -->
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer no-padding">

                    </div>
                </div>
                <!-- /. box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        <div class="modal " tabindex="-1" role="dialog" id="edit_modal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Revision Reasons</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="form-group">

                                <ul>
                                <li v-for="revision in revisions">
                                   @{{ revision.reason }}

                                </li>
                                </ul>
                            </div>
                        </div>


                    </div>

                </div>
            </div>
        </div>

    </section>

    @endsection


@section('script')

    <script type="text/javascript">

        var orders_vue=new Vue({
            el:'#orders_area',
            data:{
                orders:[],
                revisions:[],
                pay_orders:[],
                accounts:false
            },
            created:function(){
                console.log("the orders vue created");
                this.getUserOrders(0)
            },
            methods:{
                getUserOrders:function(status){
                    // alert(status);
                    let url = '{{route('writer.orders.user_orders')}}'+"?status="+status;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            console.log(res.data.orders);
                            me.accounts = false
                            me.orders = res.data.orders
                        })
                },
                getRevisions:function (orderRevisions) {
                    this.revisions=orderRevisions;
                },
                getFinishedOrders:function (pay_state) {
                    let url = '{{route('writer.orders.finished_orders')}}'+"?pay_state="+pay_state;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.pay_orders=res.data
                            me.accounts = true
                        })

                }
            }

        })

    </script>

    @endsection