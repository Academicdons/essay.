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
            font-size: 16px;
        }

        .order h4{
            font-weight: bold;
            font-size: 16px;
        }

        .order .col-sm-4:nth-child(1){
        }

        .order .col-sm-4:nth-child(2){
        }

        .order .col-sm-4:nth-child(3){
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
                    <div class="col-sm-4"><h4>Deadline: <span>@{{ moment.utc(order.deadline).local().format("dddd,Do M-YYYY, h:mm:ss a")  }}</span></h4></div>
                    <div class="col-sm-4"><h4 style="">Duration: <span v-bind:class="getDeadlineClass(order.deadline)">@{{ getTimedifference(order.deadline) }}</span></h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Discipline</td><th>@{{ order.discipline.name }}</th>
                            </tr>
                            <tr>
                                <td>Education level</td><th>@{{ order.education.name }}</th>
                            </tr>
                            <tr>
                                <td>Paper type</td><th>@{{ order.paper.name }}</th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-4">
                        <div class="row">
                            <div class="col-sm-12">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td>No of words</td><th>@{{ order.no_words }}</th>
                                    </tr>
                                    <tr>
                                        <td>Pages</td><th>@{{ order.no_pages }}</th>
                                    </tr>
                                    <tr>
                                        <td>CPP</td><th>@{{ order.cpp }}</th>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Amount</td><th>@{{ order.amount }}</th>
                            </tr>
                            <tr>
                                <td>Created at</td><th>@{{ moment.utc(order.created_at).local().format("D-M-YYYY, h:mm:ss a") }}</th>
                            </tr>
                            <tr>
                                <td>Status</td><th>@{{ getStatusString(order.status) }}</th>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <a :href="'{{url('/customer/orders/view')}}/' + order.id" class="btn btn-default pull-right btn-sm"><i class="fa text-primary fa-file"></i> view</a> &nbsp;
                        <a :href="'{{url('/customer/orders/view')}}/' + order.id" class="btn btn-default pull-right btn-sm" style="margin-right: 10px"><i class="fa text-primary fa-paperclip"></i> @{{ order.attachments_count }} files</a>
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
            mounted: function () {

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
                    let y = moment.now()
                    let duration = x.diff(y)
                    return moment.utc(duration).format('h[h] m[m] s[s]')
                },
                getDeadlineClass:function (order_date) {
                    let x = moment.utc(order_date).local();
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

                },
                getStatusString:function(status){
                    if(status==1){
                        return "in-progress"
                    }else if(status==2){
                        return "revision"
                    }else if(status==3){
                        return "completing"
                    }else{
                        return "processing"
                    }
                }
            }
        });
        {{--Thunder.connect("157.230.213.22:8080", "MhPN3ItPqy", ["{{$order->id}}","homepro_user_{{Auth::id()}}"], {log: true});--}}
        {{--Thunder.listen(function(message) {--}}
            {{--this.getClientOrders();--}}
            {{--// alert(message);--}}

        {{--});--}}
    </script>

    @endsection