@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    @endsection

@section('content')
    <section class="content-header">
        <h1>
            Accounts management
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Accounts</li>
        </ol>
    </section>

    <section class="content">

        <div class="box box-primary">
            <div class="box-header">
                <h3 class="box-title">Order accounts management</h3>
                <div class="box-tools pull-right">
                    <form action="" method="" class="form-inline">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <select name="status" onchange="window.accounts_area.getAllData();" class="btn btn-primary bnt-xs" id="status" style="margin-right: 5px;">
                                <option value="0">Unpaid orders </option>
                                <option value="1">Paid orders</option>
                            </select>
                        </div>
                        <div class="form-group pull-right">
                            <div class="input-group">
                                <button type="button" class="btn btn-success btn-sm pull-right" id="daterange-btn">
                                            <span>
                                                <i class="fa fa-calendar"></i>
                                                Date range
                                            </span>
                                    <i class="fa fa-caret-down"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body" id="accounts_area">
                
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order No</th>
                            <th>Writer</th>
                            <th>Salary</th>
                            <th>Extras</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td colspan="7" v-if="orders.length == 0">
                                <p class="text-center">No transactions to show</p>
                            </td>
                        </tr>
                        <tr v-for="(order,index) in orders">
                            <td>@{{ index+1 }}</td>
                            <td>#@{{ order.order_no }}</td>
                            <td>@{{ order.name }}</td>
                            <td>@{{ order.salary }}</td>
                            <td>@{{ order.bargains_sum }}
                                <i class="fa fa-arrow-up" style="color: green" v-if="order.bargains_sum > 0"></i>
                                <i class="fa fa-arrow-down" style="color: red" v-if="order.bargains_sum < 0"></i>
                                <span class="label label-primary" style="color: red" v-if="order.bargains_sum == null">none</span>
                            </td>
                            <td>@{{ order.bargains_sum+order.salary }}</td>
                            <td>
                                <a href="javascript:;" @click="markPaid(order.id)" v-if="order.payment==null" class="label label-warning">Mark paid</a>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </section>

    @endsection

@section('script')

    <!-- date-range-picker -->
    <script src="{{asset('bower_components/moment/moment.js')}}"></script>
    <script src="{{ asset('bower_components/bootstrap-daterangepicker/daterangepicker.js') }}"></script>

    <script type="text/javascript">

        $(document).ready(function () {
            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Today': [moment(), moment().add(1, 'days')],
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days').add(1, 'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1, 'days')],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1, 'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    window.start = start.format('YYYY-MM-DD H');
                    window.stop_date = end.format('YYYY-MM-DD H');
                    console.log(window.start);
                    window.accounts_area.getAllData();
                }
            );

            //TODO format the dates correct
            window.start = 0;
            window.stop_date = 0;

        });


        window.accounts_area = new Vue({
            el:'#accounts_area',
            data:{
                orders:[]
            },
            created:function () {
                console.log("Orders vue created")
                this.getAllData()
            },
            methods:{
                getAllData:function(){
                    let url ='{{route('admin.accounts.data')}}'+"?start="+window.start+"&stop="+window.stop_date+"&status="+$('#status').val()
                    let me = this;
                    axios.get(url)
                        .then(function(res){
                            me.orders = res.data
                        })
                },
                markPaid:function(order_id){
                    let url='{{route('admin.accounts.pay_orders')}}';
                    let me = this;
                    axios.post(url,{order:order_id})
                        .then(function(res){
                            me.getAllData();
                        })
                }
            }
        })

    </script>

    @endsection