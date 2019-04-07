@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Orders
            <small>Control panel</small>
        </h1>
        <div>
            <div id="console-event">Auto Assign Jobs</div>

            <input id="toggle-event" type="checkbox" data-toggle="toggle">

        </div>

        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Orders</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="nav-tabs-custom" style="cursor: move;">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right ui-sortable-handle">
                        <li class=""><a href="#sales-chart" data-toggle="tab" aria-expanded="false" status="5"><i class="fa fa-times"></i> Disputed</a></li>
                        <li class=""><a href="#sales-chart" data-toggle="tab" aria-expanded="false" status="4"><i class="fa fa-plus"></i> Finished</a></li>
                        <li class=""><a href="#sales-chart" data-toggle="tab" aria-expanded="false" status="3"><i class="fa fa-check"></i> Complete</a></li>
                        <li class=""><a href="#sales-chart" data-toggle="tab" aria-expanded="false" status="2"><i class="fa fa-refresh"></i> Revision</a></li>
                        <li class=""><a href="#sales-chart" data-toggle="tab" aria-expanded="false" status="1"><i class="fa fa-circle"></i> In progress</a></li>
                        <li class="active"><a href="#revenue-chart" data-toggle="tab" aria-expanded="true" status="0"><i class="fa fa-envelope-open"></i> Available</a></li>
                        <li class="pull-left header"><i class="fa fa-inbox"></i> Orders</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <br>
                        <div id="orders_area" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                                        <thead>
                                        <tr role="row">
                                            <th>No.</th>
                                            <th>Order No.</th>
                                            <th>Title</th>
                                            <th>No. Pages</th>
                                            <th>No. Words</th>
                                            <th>Amount</th>
                                            <th>Deadline</th>
                                            <th>Assign Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr v-for="(order, index) in orders">
                                            <td>@{{ index+1 }}</td>
                                            <td>@{{ order.order_no }}</td>
                                            <td>@{{ order.title }}</td>
                                            <td>@{{ order.no_pages }}</td>
                                            <td>@{{ order.no_words }}</td>
                                            <td>@{{ order.amount }}</td>
                                            <td>
                                                @{{ moment.utc(order.deadline).local().format("dddd,Do M-YYYY, h:mm:ss a")  }}

                                            </td>

                                            <td>
                                                <span class="label label-success" v-if="order.order_assign_type==0">Take</span>
                                                <span class="label label-success" v-if="order.order_assign_type==1">Bid</span>
                                            </td>
                                            <td>
                                                <a :href="'{{url('/admin/orders/edit')}}/'+ order.id" ><i class="fa fa-edit"></i></a>
                                                <a :href="'{{url('/admin/orders/view')}}/' + order.id"><i class="fa fa-eye"></i></a>
                                            </td>
                                        </tr>
                                        </tbody>
                                        <tfoot>
                                        <tr>
                                            <th>No.</th>
                                            <th>Order No.</th>
                                            <th>Title</th>
                                            <th>No. Pages</th>
                                            <th>No. Words</th>
                                            <th>Amount</th>
                                            <th>Deadline</th>
                                            <th>Assign Type</th>
                                            <th>Action</th>
                                        </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Manually place an order</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.orders.new') }}" class="btn btn-sm btn-info">New Order</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="edlevelsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="z-index: 100000000000;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title" id="album_name"></div>
                        </div>

                        <div class="box-body">
                            <form method="POST" action="{{ route('admin.education_level.add') }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ old('id') }}">

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <script type="text/javascript">

        $(function () {

            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var status = $(e.target).attr("status");
                window.orders_vue.getOrders(status)
            });

        });

        window.orders_vue = new Vue({
            el:'#orders_area',
            data:{
                orders:[]
            },
            created:function () {
                this.getOrders(0)
            },
            methods:{
                getOrders:function (status) {
                    let url='{{route('admin.orders.all')}}'+"?status="+status
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.orders=res.data.orders
                        })
                }
            }
        });

    </script>

    <script>
        $(function() {
            $('#toggle-event').change(function() {
                if ($(this).prop('checked')==true){
                    //true
                    $('#console-event').html('Auto Assign is ON');
                    var url='{{url('admin/orders/toggle_auto_assign')}}'+'/'+1;


                } else{
                    //false
                    $('#console-event').html('Auto Assign is OFF' );
                    var url='{{url('admin/orders/toggle_auto_assign')}}'+'/'+0;

                }

                axios.get(url)
                    .then(res=>{
                        swal("Success!",'The auto assign has successfully been toggled', "success");

                    })
                    .catch(err=>{
                        swal("Error!",'Something went wrong as you were toggling', "error");


                    })
            })
        })
    </script>
    @endsection