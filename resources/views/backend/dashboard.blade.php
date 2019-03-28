@extends('layouts.admin')

@section('style')

    <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
    <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">
    @endsection
@section('content')
    <section class="content">
        <!-- Small boxes (Stat box) -->
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{count(\App\User::where('user_type',1)->get())}}</h3>

                        <p>Writers</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker"></i>
                    </div>
                    <a href="{{url('admin/users/list/1')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{count(\App\User::where('user_type',2)->get())}}</h3>

                        <p>Clients</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-person-stalker "></i>
                    </div>
                    <a href="{{url('admin/users/list/2')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{count(\App\Models\Order::all())}}</h3>

                        <p>Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-stats-bars"></i>
                    </div>
                    <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{count(\App\Models\Order::where('status',0)->get())}}</h3>

                        <p>Un Assigned Orders</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-pie-graph"></i>
                    </div>
                    <a href="{{url('admin/orders')}}" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
            <!-- ./col -->
        </div>


        <div class="row">
            <div class="col-sm-12">
                <div class="alert alert-info">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="col-sm-6">
                                Filter a custom statistical range
                            </div>
                            <div class="col-sm-12">
                                <form action="" method="" class="form-inline">
                                    {{ csrf_field() }}
                                    <div class="form-group pull-right">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-default pull-right" id="daterange-btn">
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
                    </div>
                </div>
            </div>
        </div>


        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-7 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="nav-tabs-custom">
                    <!-- Tabs within a box -->
                    <ul class="nav nav-tabs pull-right">
                        {{--<li class="active"><a href="#revenue-chart" data-toggle="tab">Area</a></li>--}}
                        <li class="pull-left header"><i class="fa fa-users"></i> Writers</li>
                    </ul>
                    <div class="tab-content no-padding">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="revenue-chart" style="position: relative; height: 300px;"></div>
                    </div>
                </div>
                <!-- /.nav-tabs-custom -->

            </section>
            <!-- /.Left col -->
            <!-- right col (We are only adding the ID to make the widgets sortable)-->
            <section class="col-lg-5 connectedSortable">

                <!-- Map box -->
                <div class="box box-solid bg-light-blue-gradient">
                    <div class="box-header">
                        <!-- tools box -->
                        <div class="pull-right box-tools">

                        </div>
                        <!-- /. tools -->

                        <i class="fa fa-users"></i>

                        <h3 class="box-title">
                            Clients
                        </h3>
                    </div>
                    <div class="box-body">
                        <div class="chart tab-pane active" id="clients-chart" style="position: relative; height: 300px;"></div>
                    </div>
                    <!-- /.box-body-->

                </div>
                <!-- /.box -->

                <!-- solid sales graph -->
                <div class="box box-solid bg-teal-gradient">
                    <div class="box-header">
                        <i class="fa fa-money"></i>

                        <h3 class="box-title">Total Order Monetary Amounts</h3>

                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body border-radius-none">
                        <div class="chart tab-pane active" id="logins-chart" style="position: relative; height: 300px;"></div>
                    </div>

                </div>
                <!-- /.box -->

            </section>
            <!-- right col -->
        </div>
    </section>
@endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

    {{--//import morris js--}}
    <script src="{{asset('plugins/morris/rephael.js')}}"></script>
    <script src="{{asset('plugins/morris/morris.min.js')}}"></script>

    <script>

        //declare global variables
        window.start_date=0;
        window.stop_date=0;

        $(document).ready(function () {
//                    'Today': [moment(), moment()],

            $('#daterange-btn').daterangepicker(
                {
                    ranges: {
                        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days').add(1,'days')],
                        'Last 7 Days': [moment().subtract(6, 'days'), moment().add(1,'days')],
                        'Last 30 Days': [moment().subtract(29, 'days'), moment().add(1,'days')],
                        'This Month': [moment().startOf('month'), moment().endOf('month')],
                        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                    },
                    startDate: moment().subtract(29, 'days'),
                    endDate: moment()
                },
                function (start, end) {
                    $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                    $('#progress').fadeIn();
                    start_date=start.format('YYYY-MM-DD H');
                    stop_date=end.format('YYYY-MM-DD  H');
                    configure_charts();

                }
            );
        });



        $(document).ready(function () {
            window.listings_area_one = new Morris.Area({
                element: 'revenue-chart',
                resize: true,
                xkey: 'date',
                ykeys: ['writers'],
                labels: ['writers'],
                lineColors: ['#a0d0e0'],
                hideHover: 'auto'
            });
            window.listings_area_two = new Morris.Area({
                element: 'clients-chart',
                resize: true,
                xkey: 'date',
                ykeys: ['clients'],
                labels: ['clients'],
                lineColors: ['#a0d0e0'],
                hideHover: 'auto'
            });

            window.logins_chart = new Morris.Area({
                element: 'logins-chart',
                resize: true,
                xkey: 'date',
                ykeys: ['orders'],
                labels: ['orders'],
                lineColors: ['#a0d0e0'],
                hideHover: 'auto'
            });

            //initialize shit with basic shit
            start_date=moment().subtract(29, 'days').format('YYYY-MM-DD H');
            stop_date=moment().add(1,'days').format('YYYY-MM-DD  H');
            configure_charts();

        });

        function configure_charts() {
            $.getJSON('{{url('admin/get_writers_json')}}', {start: start_date, stop: stop_date}, function (data, status) {
                // AREA CHART
                listings_area_one.setData(data);
            });

            $.getJSON('{{url('admin/get_date_order_json')}}', {start: start_date, stop: stop_date}, function (data, status) {
                // AREA CHART
                logins_chart.setData(data);
            });

            //configure clients charts
            $.getJSON('{{url('admin/get_clients_json')}}', {start: start_date, stop: stop_date}, function (data, status) {
                // AREA CHART
                listings_area_two.options["ymin"] =  data[0].clients;
                listings_area_two.options["ymax"] =  data[(data.length-1)].clients;
                listings_area_two.setData(data);
            });
        }
    </script>

    @endsection