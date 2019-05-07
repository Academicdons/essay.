@extends('layouts.writer')

@section('page')
    Available orders
    @endsection

@section('style')

    <style type="text/css">

        table{
            font-size: 14px;
        }

    </style>

    @endsection


@section('content')
    <section class="" id="orders_area">
        <div class="card">
            <div class="card-body">

                <div class="row mb-5">
                    <div class="col-sm-12 text-center">
                        <div class="btn-group" role="group" aria-label="Basic example">
                            <button type="button" @click="getUserOrders(1)" class="btn btn-outline-primary"><i class="fa fa-spinner"></i> In progress</button>
                            <button type="button" @click="getUserOrders(2)" class="btn btn-outline-warning"><i class="fa fa-refresh"></i> Revision</button>
                            <button type="button" @click="getUserOrders(3)" class="btn btn-outline-success"><i class="fa fa-check"></i> Complete</button>
                            <button type="button" @click="getUserOrders(5)" class="btn btn-outline-danger"><i class="fa fa-trash"></i> Disputed</button>
                            <button type="button" class="btn btn-outline-info" @click="loadAvailable()">Available orders</button>
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
                                    <th>Order No</th>
                                    <th>Title </th>
                                    <th>Files</th>
                                    <th class="text-center">Deadline</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                                </thead>

                                <tbody>
                                <tr v-for="(order,index) in orders">
                                    <td>@{{ index+1 }}</td>
                                    <td class="font-weight-bold">#@{{ order.order_no }}</td>
                                    <td><a :href="'{{url('/writer/orders/view')}}/' + order.id">@{{ order.title }}</a>
                                        <br> <span class="small">@{{ order.no_pages }} page(s) / @{{ order.no_words }} words</span>
                                    </td>
                                    <td><i class="fa fa-paperclip"></i> @{{ order.attachments_count }}</td>
                                    <td class="text-center">
                                        @{{ getTimedifference(order.deadline) }} <br>
                                        <span class="small">
                                            @{{ moment.utc(order.deadline).local().format("dddd,Do M-YYYY, h:mm:ss a")  }}
                                        </span>
                                    </td>
                                    <td>@{{ getStatusString(order.status) }}</td>
                                    <td>
                                        <a v-if="order.status==1" :href="'{{url('/writer/orders/mark_as_complete')}}/' + order.id" class="btn btn-primary btn-sm" ><i class="fa fa-check"></i></a>
                                        <a :href="'{{url('/writer/orders/view')}}/' + order.id" class="btn btn-sm btn-success"><i class="fa fa-eye"></i></a>
                                        <button v-if="order.status==2" class="btn btn-primary btn-sm" data-target="#edit_modal" data-toggle="modal" @click="getRevisions(order.id)"><i class="fa fa-refresh"></i></button>

                                    </td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!--Show the revisions an order has-->
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

        <!--Bargains modal needed for finished orders-->
        <div id="bargainsModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
                <div class="box">
                    <div class="box-header">
                        <h3>Fines/Bonuses</h3>
                    </div>
                    <div class="box-body" id="bargains_area">

                        <table class="table">
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
                revisions:[],
                bargains:[],
            },
            created:function(){
                console.log("the orders vue created");
                this.getUserOrders({{$status}})
            },
            methods:{
                getUserOrders:function(status){
                    // alert(status);
                    let url = '{{route('writer.orders.user_orders')}}'+"?status="+status;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            console.log(res.data.orders);
                            me.orders = res.data.orders
                        })
                },
                loadAvailable:function(){
                    location.href='{{route('writer.orders.available')}}'
                },
                getRevisions:function (order_id) {
                    let url = '{{route('writer.orders.revisions')}}'+"?order_id="+order_id;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.revisions=res.data;

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

            }

        })

    </script>

    @endsection