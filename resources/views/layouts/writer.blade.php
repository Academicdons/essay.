<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="{{asset('bs4/dist/css/bootstrap.css')}}">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet" href="node_modules/open-sans-fontface/open-sans.css">
    <link rel="stylesheet" href="{{asset('css/perfect-scrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('css/sidebar.css')}}">

    <style type="text/css">

        @font-face {
            font-family: 'Helvetica';
            src: URL('{{asset('css/helvetica.ttf')}}') format('truetype');
        }

        body{
            font-family: Helvetica;
            font-size: 110%;
        }

        .bg-base{
            background: green;
            color: white;
        }

        .light-border{
            border: 1px solid #E8E8E8;
            box-shadow: 0 1px 1px 0 rgba(0,0,0,0.1);
            transition: 0.3s;


        }

        /*
        Available orders styles
         */
        .available-order{
            border: 1px solid #c0ddf6;
            background: white;
        }

        .available-order label{
            font-weight: bold;
        }

        .available-order .bottom-bar{
            background: #e9e9e9;
            color:black;
        }

        .title{
            color: #23c0e9;
        }

        .available-order:hover{
            border: 1px solid #23c0e9;
        }
        .available-order:hover .bottom-bar {
            background: #23c0e9;
            color: white;
        }

        .text-aqua{
            color: #23c0e9;

        }

        .heading:before {
            content: '';
            border: 1px solid #23c0e9;
            width: 15px;
            position: absolute;
            bottom: 0px;
            left: 15px;
        }

        .heading:after {
            content: '';
            border: 1px solid #23c0e9;
            width: 40px;
            position: absolute;
            bottom: 0px;
            left: 33px;
        }

        .right-side-bar{
            background: white;
            min-height: 100vh;
        }


        #available_container a{
            text-decoration: none;
            color: black;
        }

        #available_container label,span{
            font-size: 14px;
        }

        .mini-btn{
            border-radius: 3px;
            border: 1px solid #23c0e9;
            padding: 5px 10px 5px 10px;
            margin: 1px;
        }


        /*
        pace js css
         */
        .pace {
            -webkit-pointer-events: none;
            pointer-events: none;

            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;

            z-index: 2000;
            position: fixed;
            margin: auto;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            height: 5px;
            width: 200px;
            background: #fff;
            border: 1px solid #29d;

            overflow: hidden;
        }

        .pace .pace-progress {
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            -o-box-sizing: border-box;
            box-sizing: border-box;

            -webkit-transform: translate3d(0, 0, 0);
            -moz-transform: translate3d(0, 0, 0);
            -ms-transform: translate3d(0, 0, 0);
            -o-transform: translate3d(0, 0, 0);
            transform: translate3d(0, 0, 0);

            max-width: 200px;
            position: fixed;
            z-index: 2000;
            display: block;
            position: absolute;
            top: 0;
            right: 100%;
            height: 100%;
            width: 100%;
            background: #29d;
        }

        .pace.pace-inactive {
            display: none;
        }




    </style>

    @yield('style')
    <title>Sidebar menu on bootstrap 4</title>
</head>

<body class="body body-lighten">
<div class="d-flex" id="wrapper">

    <!-- sidebar -->
    <div class="sidebar sidebar-lighten">
        <!-- sidebar menu -->
        <div class="sidebar-menu">

            <!-- menu -->
            <ul class="list list-unstyled list-scrollbar">

                <!-- simple menu -->
                <li class="list-item">
                    <p class="list-title text-uppercase">Account</p>
                    <ul class="list-unstyled">
                        <li><a href="{{route('writer.profile.index')}}" class="list-link current">Profile</a></li>
                    </ul>
                </li>

                <!-- multi-level dropdown menu -->
                <li class="list-item">
                    <p class="list-title text-uppercase">Dashboard</p>
                    <ul class="list-unstyled">
                        <li><a href="{{route('writer.dashboard.index')}}" class="list-link"><span class="list-icon"><i class="fa fa-home" aria-hidden="true"></i></span>Home</a></li>
                        <li><a href="{{route('writer.orders.available')}}" class="list-link"><span class="list-icon"><i class="fa fa-briefcase" aria-hidden="true"></i></span>Available orders</a></li>
                        <li><a href="#" class="list-link link-arrow link-current"><span class="list-icon"><i class="fa fa-cog" aria-hidden="true"></i></span>My orders</a>
                            <ul class="list-unstyled list-hidden">
                                <li><a href="{{route('writer.orders.all')}}?status=1" class="list-link"><i class="fa fa-spinner"></i> In-progress</a></li>
                                <li><a href="{{route('writer.orders.all')}}?status=2" class="list-link"><i class="fa fa-refresh"></i> Revision</a></li>
                                <li><a href="{{route('writer.orders.all')}}?status=3" class="list-link"><i class="fa fa-check"></i> Completed</a></li>
                                <li><a href="{{route('writer.orders.all')}}?status=5" class="list-link"><i class="fa fa-times"></i> Disputed orders</a></li>
                                <li><a href="#" class="list-link link-arrow link-current"> <i class="fa fa-check-circle"></i> Finished orders</a>
                                    <ul class="list-unstyled list-hidden">
                                        <li><a href="{{route('writer.orders.finished')}}?paid=1" class="list-link"><i class="fa fa-cart-plus"></i> paid orders</a></li>
                                        <li><a href="{{route('writer.orders.finished')}}?paid=0" class="list-link"><i class="fa fa-shopping-cart"></i> unpaid orders</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                <!-- multi-level dropdown menu -->
                <li class="list-item">
                    <p class="list-title text-uppercase">Notifications</p>
                    <ul class="list-unstyled">
                        <li><a href="#" class="list-link"><span class="list-icon"><i class="fa fa-envelope" aria-hidden="true"></i></span>All notifications</a></li>
                        <li><a href="#" class="list-link link-arrow"><span class="list-icon"><i class="fa fa-cog" aria-hidden="true"></i></span>Settings</a>
                            <ul class="list-unstyled list-hidden">
                                <li><a href="#" class="list-link">Disable</a></li>
                                <li><a href="#" class="list-link">Enable</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>

{{--                <!-- simple menu -->--}}
{{--                <li class="list-item">--}}
{{--                    <p class="list-title text-uppercase">Blog</p>--}}
{{--                    <ul class="list-unstyled">--}}
{{--                        <li><a href="#" class="list-link"><span class="list-icon"><i class="fa fa-plus" aria-hidden="true"></i></span>Add</a></li>--}}
{{--                        <li><a href="#" class="list-link"><span class="list-icon"><i class="fa fa-table" aria-hidden="true"></i></span>List</a></li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
            </ul>
        </div>
    </div>

    <!-- website content -->
    <div class="content">

        <!-- navbar top fixed -->
        <nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-base">

            <!-- navbar title -->
            <a class="navbar-brand navbar-link" href="#">Homework pro</a>

            <!-- navbar sidebar menu toggle -->
            <span class="navbar-text">
					<a href="#" id="sidebar-toggle" class="navbar-bars">
						<i class="fa fa-bars" aria-hidden="true"></i>
					</a>
				</span>

            <!-- navbar dropdown menu-->
            <div class="collapse navbar-collapse">
                <div class="dropdown dropdown-logged dropdown-logged-lighten">
                    <a href="#" data-toggle="dropdown" class="dropdown-logged-toggle dropdown-link">
                        <span class="dropdown-user text-white float-left">{{Auth::user()->name}}</span>
                        <img src="https://cdn3.iconfinder.com/data/icons/business-avatar-1/512/10_avatar-512.png" alt="avatar" class="dropdown-avatar">
                    </a>
                    <div class="dropdown-menu dropdown-logged-menu dropdown-menu-right border-0 dropdown-menu-lighten">
                        <div class="dropdown-menu-arrow"></div>
                        <a class="dropdown-item dropdown-logged-item" href="#"><i class="fa fa-user-o" aria-hidden="true"></i>Your profile</a>
                        <a class="dropdown-item dropdown-logged-item" href="#"><i class="fa fa-comments-o" aria-hidden="true"></i>Your comments</a>
                        <a class="dropdown-item dropdown-logged-item" href="#"><i class="fa fa-key" aria-hidden="true"></i>Change password</a>
                        <div class="dropdown-divider border-light"></div>
                        <a class="dropdown-item dropdown-logged-item" href="#"><i class="fa fa-sign-out" aria-hidden="true"></i>Logout</a>
                    </div>
                </div>
            </div>
        </nav>

        <!-- content container -->
        <div class="container-fluid">

            <div class="row">
                <div class="col-sm-10 border-right">
                    <br>

                    @yield('content')

                </div>
                <div class="col-sm-2 d-none d-lg-block right-side-bar" >

                    <div class="row">
                        <div class="col-sm-12 text-center">
                            <img class="img-fluid" src="{{asset('images/logo.png')}}" alt="">
                        </div>
                    </div>


                    <div class="row" id="recent_orders">
                        <div class="col-sm-12">
                            <h6 class="heading mt-3">Recent orders</h6>
                        </div>
                        <div class="col-sm-12 small mt-3" v-for="order in recent_orders">
                            <div class="recent-order">
                                <a :href="'{{url('/writer/orders/view')}}/' + order.id"><span class="text-aqua font-weight-bold">#@{{ order.order_no }}- @{{ order.title }}</span></a>
                            </div>
                        </div>

                        <div class="col-sm-12" v-if="recent_orders.length<=0">
                            <div class="alert alert-info">
                                <p class="small">No recent orders available</p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <p class="small">
                        © 2019 Homework pro inc <br> <br>
                        site design / logo © 2019 Homework pro inc; user contributions licensed under cc by-sa 3.0 with attribution required. rev 2019.5.3.33fsr4
                    </p>

                </div>
            </div>


        </div>
    </div>
</div>

<!-- javascript library -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="{{asset('bs4/dist/js/bootstrap.min.js')}}"></script>
<script src="{{asset('js/sidebar.menu.js')}}"></script>
<script src="{{asset('js/perfect-scrollbar.min.js')}}"></script>
<script src='{{asset('js/pace.js')}}'></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>


<script>
    $(function() {
        new PerfectScrollbar('.list-scrollbar');
    });
</script>
<script src="{{asset('axios.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/vue"></script>

<script src="{{asset('js/sock.min.js')}}"></script>
<script src="{{asset('js/thunder.js')}}"></script>

@yield('script')
<script>
    let recent_orders = new Vue({
        el:'#recent_orders',
        data:{
            recent_orders:[]
        },
        created:function(){
            this.getRecentOrders()
        },
        methods:{
            getRecentOrders:function(){
                let url = '{{route('writer.orders.recent')}}'
                let me = this;
                axios.get(url)
                    .then(function(res){
                        me.recent_orders  = res.data;
                    })
            }
        }
    })
</script>
</body>

</html>
