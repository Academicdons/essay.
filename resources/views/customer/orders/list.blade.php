@extends('layouts.index')

@section('style')

    <style class="text/css">
        .table-striped tr:nth-child(odd){
            background: lightgrey !important;
        }

        .order {
            /* Add shadows to create the "card" effect */
            box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            padding: 10px;
            margin-top: 20px;
        }

        .order h4 span{
            font-weight: normal;
            font-size: 17px;
        }

        .order h4{
            font-weight: bold;
            font-size: 17px;
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

        .text-light-blue{
            color: deepskyblue !important;
        }
    </style>

    @endsection


@section('content')

    <div class="container pb-5" id="orders_area">
        <div class="order box box-solid" v-for="order in orders">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4"><h4 class="text-light-blue">@{{ order.title }}</h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4>ID: <span>@{{ order.order_no }}</span></h4></div>
                    <div class="col-sm-4"><h4>Deadline: <span>@{{ moment.utc(order.deadline).local().format("dddd, MMMM Do YYYY, h:mm:ss a")  }}</span></h4></div>
                    <div class="col-sm-4"><h4 style="padding-left: 10px;">Duration: <span v-bind:class="getDeadlineClass(order.deadline)">@{{ getTimedifference(order.deadline) }}</span></h4></div>
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


@section('script')

    <script type="text/javascript">

        var orders_vue = new Vue({
            el:'#orders_area',
            data:{
                orders:[]
            },
            created:function () {
                console.log("created orders vue")
                this.getClientOrders()
            },
            methods:{
                getClientOrders:function () {
                    let url = '{{route('customer.orders.get_orders')}}'
                    let me = this
                    axios.get(url)
                        .then(function (res) {
                            me.orders = res.data.orders
                        })
                },
                getTimedifference:function (order_date) {
                    let x = moment.utc(order_date).local()
                    return x.fromNow();
                },
                getDeadlineClass:function (order_date) {
                    let x = moment.utc(order_date).local()
                    let y = moment.now()
                    let duration = moment.duration(x.diff(y)).asHours();
                    if(duration<0){
                        return "deadline-default"
                    }else if(duration<20){
                        return "deadline-danger"
                    }else if(duration<72){
                        return "deadline-warning"
                    }else{
                        return "deadline-success"
                    }

                }
            }
        })

    </script>

    @endsection