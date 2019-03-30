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

    <div class="container pb-5" id="available_container">
        <div class="order box box-solid" v-for="order in orders">
            <div class="box-body">
                <div class="row">
                    <div class="col-sm-12 col-md-12 col-lg-12"><h4 class="text-light-blue">@{{ order.title }}</h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-4"><h4>ID: <span>@{{ order.order_no }}</span></h4></div>
                    <div class="col-sm-4"><h4>Deadline: <span>@{{ moment.utc(order.writer_deadline).local().format("dddd,Do M-YYYY, h:mm:ss a")  }}  </span></h4></div>
                    <div class="col-sm-4"><h4 style="">Duration: <span v-bind:class="getDeadlineClass(order.writer_deadline)">@{{ getTimedifference(order.writer_deadline) }}  </span></h4></div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Discipline</td><th><span v-if="order.discipline!=null">@{{ order.discipline.name }}</span></th>
                            </tr>
                            <tr>
                                <td>Education level</td><th><span v-if="order.education!=null">@{{ order.education.name }}</span></th>
                            </tr>
                            <tr>
                                <td>Paper type</td><th><span v-if="order.paper!=null">@{{ order.paper.name }}</span></th>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        {{--<div class="row">--}}
                            {{--<div class="col-sm-12">--}}
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td>No of words</td><th>@{{ order.no_words }}</th>
                                    </tr>
                                    <tr>
                                        <td>Pages</td><th>@{{ order.no_pages }}</th>
                                    </tr>
                                    <tr>
                                        <td>Salary</td><th>@{{ order.salary }}</th>
                                    </tr>
                                </table>
                            {{--</div>--}}
                        {{--</div>--}}
                    </div>
                    <div class="col-sm-12 col-md-4 col-lg-4">
                        <table class="table table-sm table-striped">
                            <tr>
                                <td>Spacing</td><th>
                                    <span v-if="order.spacing==0">Single</span>
                                    <span v-if="order.spacing==1">Double</span>
                                    </th>
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
                        <a :href="'{{url('/writer/orders/view')}}/' + order.id" class="btn btn-default pull-right btn-sm"><i class="fa text-primary fa-file"></i> view</a> &nbsp;

                        <a :href="'{{url('/writer/orders/view')}}/' + order.id" class="btn btn-default pull-right btn-sm" style="margin-right: 10px"><i class="fa text-primary fa-paperclip"></i> @{{ order.attachments_count }} files</a>

                    </div>
                </div>
            </div>
        </div>
    </div>


    @endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script>

        window.av_orders=new Vue({
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
                getClientOrders:function () {
                    let url = '{{route('customer.orders.get_orders')}}';
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.orders = res.data.orders
                        })
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
                },



                dateConverter:function (date) {
                  return  moment(date).format("dddd, MMMM Do YYYY, h:mm a")
                },

                getTimedifference:function (order_date) {
                    let x = moment.utc(order_date).local()
                    return x.fromNow();
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

                }
            }
        });

        Thunder.connect("157.230.213.22:8080", "MhPN3ItPqy", ["orders","homepro_user_{{Auth::id()}}"], {log: true});
        Thunder.listen(function(message) {
            window.av_orders.getClientOrders();

        });
    </script>
    @endsection