@extends('layouts.writer')

@section('page')
    Available orders
@endsection

@section('style')

    <style type="text/css">


    </style>

@endsection


@section('content')
    <section class="" id="orders_area">
        <div class="card">
            <div class="card-body">

                <div class="row mb-5">
                    <div class="col-sm-12 text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" @click="getFinishedOrders(0)" class="btn btn-outline-primary"><i class="fa fa-spinner"></i> Paid orders</button>
                            <button type="button" @click="getFinishedOrders(1)" class="btn btn-outline-warning"><i class="fa fa-refresh"></i> Unpaid orders</button>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th class="text-center">Order details</th>
                                    <th>Deadline</th>
                                    <th class="text-center">Salary</th>
                                    <th>fines/bonuses</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr v-for="(order,index) in orders">
                                    <td>@{{ index+1 }}</td>
                                    <td class="text-center"><a :href="'{{url('/writer/orders/view')}}/' + order.id">#@{{ order.order_no }}
                                            <br>
                                            <span class="small text-gray">@{{ order.title }}</span>
                                        </a>
                                    </td>
                                    <td>
                                        @{{ getTimedifference(order.deadline) }} <br>
                                        <span class="small">
                                            @{{ moment.utc(order.deadline).local().format("dddd,Do M-YYYY, h:mm:ss a")  }}
                                        </span>
                                    </td>
                                    <td class="text-center">$ @{{ order.salary }} <br>
                                    <span class="small">@{{ order.no_pages }}pages /@{{ order.no_words }} words</span>
                                    </td>
                                    <td class="text-center">$ @{{ 0+order.bargains_sum }}</td>
                                    <td>
                                        <button title="view fines/bonuses" class="btn btn-primary btn-sm" data-target="#bargainsModal" data-toggle="modal" @click="loadBargains(order.id)"><i class="fa fa-refresh"></i></button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>



        <!--Bargains modal needed for finished orders-->
        <div id="bargainsModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h6>Fines/Bonuses</h6>
                    </div>
                    <div class="modal-body" id="bargains_area">

                        <table class="table table-sm">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Reason</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(bar,index) in bargains">
                                <td>@{{ index+1 }}</td>
                                <td>
                                    <span v-if="bar.amount>0" class="label label-success">bonus</span>
                                    <span v-if="bar.amount<0"class="label label-danger">fine</span>
                                </td>
                                <td>@{{ bar.amount }}</td>
                                <td>@{{ bar.reason }}</td>
                            </tr>
                            </tbody>
                        </table>

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
                bargains:[],
                accounts:false
            },
            created:function(){
                console.log("the orders vue created");
                this.getFinishedOrders({{$paid}})
            },
            methods:{

                getFinishedOrders:function (pay_state) {
                    let url = '{{route('writer.orders.finished_orders')}}'+"?pay_state="+pay_state;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.orders=res.data
                            me.accounts = true
                        })

                },
                getTimedifference:function (order_date) {
                    let x = moment.utc(order_date).local()
                    let y = moment.now()
                    let duration = x.diff(y)
                    return moment.utc(duration).format('h[h] m[m] s[s]')
                },
                getStatusString:function(status){
                    if(status==1){
                        return "in-progress"
                    }else if(status==2){
                        return "revision"
                    }else if(status==3){
                        return "completing"
                    }else if(status==5){
                        return "disputed"
                    }else if(status ==4){
                        return "complete"
                    }else{
                        return "processing"
                    }
                },
                loadBargains:function(id){
                    let url='{{route('writer.orders.bargains')}}'+"?order="+id;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.bargains = res.data;
                            $('#bargainsModal').modal('show')
                        })
                }
            }

        })

    </script>

@endsection