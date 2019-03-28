<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>Homework pro writers</title>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">


        <link rel="stylesheet" href="{{asset('bs4/dist/css/bootstrap.css')}}">
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
        <link rel="icon" type="image/png" href="images/logo2.png" />

        <style type="text/css">

            body{
                font-family: 'Roboto', sans-serif;
            }

            .heading{
                font-family: 'Poppins', sans-serif;
            }

            .heading-light{
                color: green;
            }


            .bg-base{
                background-color: #018021 !important;
                color: white !important;
            }

            .become-writer{
                background-color: #00ab6b;
                color: white;

            }

            .top-bar-text{
                font-size: 13px;
            }

            .separator{
                width: 180px;
                height: 4px;
                background: orange;
            }

            /* STATS */

            .stats {
                color: orangered;
                position: relative;
                padding-bottom: 25px;
            }

            .stats__amount {
                font-size: 42px;
                font-weight: bold;
                line-height: 1.2;
            }

            .stats__caption {
                font-size: 18px;

            }

            .stats__change {
                position: absolute;
                top: 10px;
                right: 0;
                text-align: right;
                color: #B1B7C8;
            }

            .stats__value {
                font-size: 18px;
            }

            .stats__period {
                font-size: 14px;
            }

            .stats__value--positive {
                color: green;
            }

            .stats__value--negative {
                color: #FB5055;
            }

            .stats--main .stats__amount {
                font-size: 54px;
            }

            .partner-img{
                margin-top: 15px;
                margin-bottom: 15px;
                margin-left: 50px;
                width: 170px;
                -webkit-filter: grayscale(100%); /* Safari 6.0 - 9.0 */
                filter: grayscale(100%);
            }

            .about-us{
                background: #DCDCDC;
            }

            .icon{
                width: 80px;
                height: 80px;
                line-height: 50px;
                font-size: 40px;
                padding-top: 20px;
                text-align:center;
                color: orangered;
                border-radius: 50%;
                border: 1px solid green;
            }

            .about-title{
                color: green;
            }

            .bottom-list{
                list-style: none;
            }

            .bottom-list a{
                color: green;
                font-size:14px;
            }

            .table-recent{
                font-size: 13px !important;
            }
            .table-recent thead th{
                border-top: none !important;
            }

            .brnd{
                color: green !important;
                font-weight: bold;
            }

            .testimonials{
                background: #00ab6b;
                color: white;
            }

            .deadline-default{
                color: lightgrey;
            }

            .deadline-danger{
                color: red;
                animation: blinker 1s linear infinite;
            }
            @keyframes blinker {
                50% {
                    opacity: 0;
                }
            }

            .deadline-warning{
                color: orange;
            }

            .deadline-success{
                color: forestgreen;
            }

        </style>

        @yield('style')

    </head>

    <body>

    @php($domain = Saas::getDomain())

    <div class="top-bar bg-base">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p class="top-bar-text p-2  mb-0">{{$domain->tag_line}}</p>
                </div>
                <div class="col-sm-6 float-left">
                    <ul class="list-inline pt-2 top-bar-text float-right">
                        <li class="list-inline-item">&copy; Homework pro writers</li>
                        <li class="list-inline-item">| {{$domain->email}}</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">

        <a class="navbar-brand brnd" href="#">
            <img src="{{asset('images/logo2.png')}}" width="30" height="30" alt=""> Homework pro writers
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
                </li>

                <li class="nav-item active">
                    <a class="nav-link" href="{{route('articles')}}">Articles <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{url('/')}}#about-us">About us</a>
                </li>

                @if(Auth::check() && $domain->domain_type==0)


                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        My account
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="{{route('profile')}}">Profile</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('customer.orders.list')}}" tabindex="-1">My orders</a>
                </li>

                @endif

            </ul>


        @if(!Auth::check())
                <a href="{{($domain->domain_type==0)?route('register'):url('register_writer')}}" class="btn btn-success my-2 my-sm-0" ><i class="fa fa-user"></i> Register</a>
                <a href="{{route('login')}}" class="btn btn-warning my-2 my-sm-0 ml-3" ><i class="fa fa-key"></i> Login</a>
                    @else
                <a href="{{url('logout')}}" class="btn btn-default my-2 my-sm-0 ml-3" ><i class="fa fa-power-off"></i> Logout</a>

            @endif

        </div>
    </nav>


    @yield('content')

    <footer id="myFooter" class="pt-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h2 class="logo"><a href="#"><img src="{{asset('images/logo.png')}}" class="img-fluid" alt=""></a></h2>
                </div>
                <div class="col-sm-2">
                    <h5>Get started</h5>
                    <ul>
                        <li><a href="{{url('/')}}">Home</a></li>
                        <li><a href="{{url('/register')}}">Sign up</a></li>
                        <li><a href="{{route('articles')}}">Articles</a></li>
                    </ul>
                </div>
                <div class="col-sm-2">
                    <h5>About us</h5>
                    <ul>
                        <li><a href="#">Company Information</a></li>
                        <li><a href="#">Contact us</a></li>
                        <li><a href="#">Reviews</a></li>
                    </ul>
                </div>
                <div class="col-sm-2">
                    <h5>Support</h5>
                    <ul>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Help desk</a></li>
                        <li><a href="#">Forums</a></li>
                    </ul>
                </div>
                <div class="col-sm-3">

                    <button type="button" class="btn btn-default">Contact us</button>
                </div>
            </div>
        </div>
        <div class="footer-copyright">
            <p>© {{date('Y')}} Copyright Text </p>
        </div>
    </footer>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="{{asset('bs4/dist/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('axios.min.js')}}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="http://cdn.sockjs.org/sockjs-0.3.min.js"></script>
    <script src="{{asset('js/thunder.js')}}"></script>

    @yield('script')

    </body>
</html>