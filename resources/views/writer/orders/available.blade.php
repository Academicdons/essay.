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

    <div class="container" id="available_container">
        <div class="order box box-solid" v-for="order in orders">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-4"><h4 class="text-light-blue">@{{ order.title }}</h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h5>ID: <span>@{{ order.order_no }}</span></h5></div>
                    <div class="col-sm-4"><h5>Deadline: <span class="text-green">@{{ dateConverter(order.deadline) }}</span></h5></div>
                    <div class="col-sm-4"><h5>Time remaining: <span class="text-danger">3h 56min 34s</span></h5></div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>No. of Pages</td><th>@{{ order.no_pages }}</th>
                            </tr>
                            <tr>
                                <td>Amount</td><th>@{{ order.amount }}</th>
                            </tr>
                            <tr>
                                <td>Bid Expiry</td><th>@{{  dateConverter( order.bid_expiry) }}</th>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script>

        let hehe=new Vue({
            el:'#available_container',
            data:{
                'orders':[]
            },
            created:function () {
                let url='{{url('writer/orders/available_orders_json')}}';
                let me=this;
                axios.get(url)
                    .then(res=>{
                        me.orders=res.data.orders;
                    })
                    .catch(err=>{

                    });
            },
            methods:{
                dateConverter:function (date) {
                  return  moment(date).format("dddd, MMMM Do YYYY, h:mm a")
                }
            }
        })
    </script>
    @endsection