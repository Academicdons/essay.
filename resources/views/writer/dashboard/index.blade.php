@extends('layouts.writer')

@section('page')
    Dashboard
@endsection

@section('style')

    <style>
        .dash-card{
            box-shadow: 0 2px 4px 0 rgba(0,0,0,0.2);
            transition: 0.3s;
            border-radius: 0px !important;
        }

        .stat-card .icon{
            font-size: 40px;
        }

        .stat-blue{
            background: #23c0e9;
            border: 1px solid #23c0e9 !important;
            color: white;
        }

        .stat-red{
            background: red;
            border: 1px solid red !important;
            color: white;
        }


        .stat-orange{
            background: orange;
            border: 1px solid orange !important;
            color: white;
        }

        .stat-green{
            background: green;
            border: 1px solid green !important;
            color: white;
        }

        .recent-orders{
            min-height: 500px;
        }

        .table-sm td,th{
            font-size: 14px;
        }


        .user-avatar{
            width: 80px;
            height: 80px;
            border: 7px solid #23c0e9;
            border-radius: 50%;
        }

    </style>

    <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">

    @endsection


@section('content')

    <div class="carid">
        <div class="card-biody">
            <div class="row mb-5">

                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card dash-card stat-card stat-blue">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-briefcase icon"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>278</h3>
                                        <span>Available orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card dash-card stat-card stat-red">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-pencil icon"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>278</h3>
                                        <span>New Posts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card dash-card stat-card stat-orange">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-pencil icon"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>278</h3>
                                        <span>New Posts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-6 col-12">
                    <div class="card dash-card stat-card stat-green">
                        <div class="card-content">
                            <div class="card-body">
                                <div class="media d-flex">
                                    <div class="align-self-center">
                                        <i class="fa fa-pencil icon"></i>
                                    </div>
                                    <div class="media-body text-right">
                                        <h3>278</h3>
                                        <span>New Posts</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="card dash-card">
                        <div class="card-body">
                            <div class="row p-3">
                                <div class="half-circle">
                                    <img src="https://homeworkprowriters.com/images/logo2.png" class="user-avatar">
                                </div>
                                <div class="dash-content mt-2">
                                    <p class="p-3">Logged in as {{Auth::user()->name}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-sm-6">
                    <div class="card dash-card recent-orders">
                        <div class="card-body">

                            <h6>Orders flow</h6>

                            <div id="line-chart" class="mt-3 mb-3">

                            </div>

                            <p class="small mt-3">Personal statistics will only be shown on attainment of the minimal threshold</p>

                        </div>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card dash-card recent-orders">
                        <div class="card-body">
                            <h6>Latest orders</h6>

                            <div class="table-responsive">
                                <table class="table table-sm">

                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Salary</th>
                                            <th>Education level</th>
                                            <th>Discipline</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td>Title</td>
                                            <td>Salary</td>
                                            <td>Education level</td>
                                            <td>Discipline</td>
                                        </tr>
                                    </tbody>

                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')

    <script src="{{asset('plugins/morris/rephael.js')}}"></script>
    <script src="{{asset('plugins/morris/morris.min.js')}}"></script>

    <script>
        var data = [
                { y: '2014', a: 50, b: 90},
                { y: '2015', a: 65,  b: 75},
                { y: '2016', a: 50,  b: 50},
                { y: '2017', a: 75,  b: 60},
                { y: '2018', a: 80,  b: 65},
                { y: '2019', a: 90,  b: 70},
                { y: '2020', a: 100, b: 75},
                { y: '2021', a: 115, b: 75},
                { y: '2022', a: 120, b: 85},
                { y: '2023', a: 145, b: 85},
                { y: '2024', a: 160, b: 95}
            ],
            config = {
                data: data,
                xkey: 'y',
                ykeys: ['a', 'b'],
                labels: ['Total Income', 'Total Outcome'],
                fillOpacity: 0.6,
                hideHover: 'auto',
                behaveLikeLine: true,
                resize: true,
                pointFillColors:['#ffffff'],
                pointStrokeColors: ['black'],
                lineColors:['gray','red']
            };

        config.element = 'line-chart';
        Morris.Line(config);
    </script>

    @endsection