@extends('layouts.index')

@section('style')

    <style>
        .carousel {
            width: 650px;
            margin: 0 auto;
            padding-bottom: 50px;
        }
        .carousel .item {
            color: #ffffff;
            font-size: 14px;
            text-align: center;
            overflow: hidden;
            min-height: 340px;
        }
        .carousel .item a {
            color: #eb7245;
        }
        .carousel .img-box {
            width: 145px;
            height: 145px;
            margin: 0 auto;
            border-radius: 50%;
        }
        .carousel .img-box img {
            width: 100%;
            height: 100%;
            display: block;
            border-radius: 50%;
        }
        .carousel .testimonial {
            padding: 30px 0 10px;
        }
        .carousel .overview {
            text-align: center;
            padding-bottom: 5px;
        }
        .carousel .overview b {
            color: #333;
            font-size: 15px;
            text-transform: uppercase;
            display: block;
            padding-bottom: 5px;
        }
        .carousel .star-rating i {
            font-size: 18px;
            color: #ffdc12;
        }
        .carousel .carousel-control {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background: #000000;
            text-shadow: none;
            top: 4px;
        }
        .carousel-control i {
            font-size: 20px;
            margin-right: 2px;
        }
        .carousel-control.left {
            left: auto;
            right: 40px;
        }
        .carousel-control.right i {
            margin-right: -2px;
        }
        .carousel .carousel-indicators {
            bottom: 15px;
        }
        .carousel-indicators li, .carousel-indicators li.active {
            width: 11px;
            height: 11px;
            margin: 1px 5px;
            border-radius: 50%;
        }
        .carousel-indicators li {
            background: #e2e2e2;
            border-color: transparent;
        }
        .carousel-indicators li.active {
            border: none;
            background: #888;
        }
    </style>

    @endsection


@section('content')

    <section class="header">

        <div class="container pt-5 pb-5">

            <div class="row mt-5 mb-5">
                <div class="col-sm-6">

                    <h1 class="heading heading-light">Are you a passionate writer?</h1>
                    <div class="separator"></div>
                    <h3 class="mt-5">Join our network and earn from writing.
                    </h3>


                    <div class="row mt-5">
                        <div class="col-sm-6">
                            <div class="stats">
                                <div class="stats__amount">{{rand(100,1000)}}</div>
                                <div class="stats__caption">Current orders</div>
                                <div class="stats__change">
                                    <div class="stats__value stats__value--positive">+7%</div>
                                    <div class="stats__period">this week</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="stats">
                                <div class="stats__amount">{{rand(2000,10000)}}</div>
                                <div class="stats__caption">Active writers</div>
                                <div class="stats__change">
                                    <div class="stats__value stats__value--positive">+6%</div>
                                    <div class="stats__period">this week</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <p class="text-center mt-3">
                        <a href="{{url('register_writer')}}" class="button" > Become a writer</a>
                    </p>

                </div>
                <div class="col-sm-6">
                    <img src="{{asset('images/landing page resource.svg')}}" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>

    <section class="become-writer  bg-base">

        <div class="container pt-5 pb-1">

            <div class="row mt-2 mb-5">

                <div class="col-sm-4">
                    <img src="https://pngimage.net/wp-content/uploads/2018/06/png-company-register-5.png" class="img-fluid" alt="">
                </div>

                <div class="col-sm-8 pt-2">

                    <h1 class="heading">Get the best out of us!</h1>
                    <div class="separator"></div>


                    <div class="mt-2">

                        <p>
                            Are you a skilled and passionate writer?  want to earn while staying at home? Do you have what it takes? Sign up here and join our team of experienced writers and get paid conveniently through Mpesa or PayPal
                            Our writing services include:
                        </p>

                        <div class="row">
                            <div class="col-sm-6">
                                <ul style="list-style: none">
                                    <li><i class="fa fa-check"></i> Academic essays</li>
                                    <li><i class="fa fa-check"></i> Research papers</li>
                                    <li><i class="fa fa-check"></i> Coursework and term papers</li>
                                    <li><i class="fa fa-check"></i> Book/Movie reviews</li>

                                </ul>
                            </div>
                            <div class="col-sm-6">
                                <ul style="list-style: none">
                                    <li><i class="fa fa-check"></i> Book reports</li>
                                    <li><i class="fa fa-check"></i> Annotated bibliographies</li>
                                    <li><i class="fa fa-check"></i> Various text rewriting</li>
                                    <li><i class="fa fa-check"></i> Dissertation and thesis</li>
                                    <li><i class="fa fa-check"></i> Editing and proofreading</li>
                                </ul>

                            </div>
                        </div>

                    </div>
                    <p class="text-center">
                        <a href="{{url('/register_writer')}}" class="button" >Become a writer</a>

                    </p>



                </div>

            </div>
        </div>

    </section>

    <section class="partners">

        <div class="container p-4">
            <div class="row">
                <div class="col-sm-12 ">
                    <center>
                        <img src="https://seeklogo.com/images/M/mpesa-logo-AE44B6F8EB-seeklogo.com.png" class="partner-img" alt="">
                        <img src="https://www.freepnglogos.com/uploads/paypal-logo-png-3.png" class="partner-img" alt="">
                    </center>

                </div>
            </div>
        </div>

    </section>


    <section class="about-us pt-5 pb-5">

        <div class="container">
            <div class="row">
                <div class="col-sm-12">
                    <h1 class="heading">About us?</h1>
                </div>
                <div class="col-sm-12">
                    <p>Homework pro writers is an online academic writing and consulting company. Since 2004, we have worked to ensure the highest quality standards of service and offer a stable income for aspiring academic writers. We value our employees, ensure career growth, provide various rewards programs, and 24/7 support.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-edit"></i></p>
                    <h5 class="about-title mt-2">Zero plagiarism</h5>
                    <p class="mt-2">
                        Our customers expect nothing less than your original work. Any plagiarism is penalised.
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-briefcase"></i></p>
                    <h5 class="about-title mt-2">Professional work</h5>
                    <p class="mt-2">
                        Work submitted should conform to instructions and any formats of writing given
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-comment"></i></p>
                    <h5 class="about-title mt-2">Realtime chat</h5>
                    <p class="mt-2">
                        Ensure constant communication with the client via live chat and ensure all needs are met
                    </p>

                </div>
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-google-wallet"></i></p>
                    <h5 class="about-title mt-2">Get paid</h5>
                    <p class="mt-2">
                        Get conveniently paid through bank, paypal or M-Pesa
                    </p>

                </div>
            </div>
        </div>

    </section>



    <section class="how-it-works pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 mt-3 mb-3">
                    <h3>How it works</h3>
                </div>
                <div class="col-sm-3 text-center">
                    <img src="{{asset('images/signup.png')}}" class="img-fluid" alt="">
                    <h4 class="mt-3">Sign up</h4>
                    <p class="mt-3">Get started by submitting a form in less than 5 minutes.
                    </p>
                </div>

                <div class="col-sm-3 text-center">
                    <img src="{{asset('images/start-career.png')}}" class="img-fluid" alt="">
                    <h4 class="mt-3">Start career</h4>
                    <p class="mt-3">Your road to earning begins with receiving a starter kit from.
                    </p>
                </div>
                <div class="col-sm-3 text-center">
                    <img src="{{asset('images/show-skill.png')}}" class="img-fluid" alt="">
                    <h4 class="mt-3">Show skills</h4>
                    <p class="mt-3">Carry out the task in the starter kit and submit it for evaluation.
                    </p>
                </div>

                <div class="col-sm-3 text-center">
                    <img src="{{asset('images/get-paid.png')}}" class="img-fluid" alt="">
                    <h4 class="mt-3">Earn money</h4>
                    <p class="mt-3">Receive orders, bid for more and get paid
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials  bg-base">

        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-sm-6 border-right">
                    <h3>Why choose us</h3>
                    <div class="separator"></div>
                    <ul class="pr-4">
                        <li>we only academic knowledge and experience are needed. No entrance fees</li>
                        <li>we offer Flexibility - You can work from anywhere during your free time as long as you can access internet.</li>
                        <li>Very flexible system that shows you the status of your orders and the total amount you have made at any given time.</li>
                        <li>Guaranteed payments for the quality work via Mpesa and Airtel Money</li>
                        <li>Initial training and training materials</li>
                        <li>Round the clock support</li>
                        <li>A wide variety of orders</li>
                        <li>No earnings limit</li>
                        <li>Bonuses for best writers</li>
                    </ul>

                </div>
                <div class="col-sm-6">
                    <h3>Testimonials</h3>
                    <div class="separator"></div>
                    <section class="text-white">
                        <div id="myCarousel" class="carousel slide" data-ride="carousel">
                            <!-- Carousel indicators -->

                            <!-- Wrapper for carousel items -->
                            <div class="carousel-inner">
                                <div class="item carousel-item active">
                                    <div class="img-box"><img src="https://media.reason.com/mc/ngillespie/2018_04/zuckerberg856.jpg?h=263&w=350" alt=""></div>
                                    <p class="testimonial">Phasellus vitae suscipit justo. Mauris pharetra feugiat ante id lacinia. Etiam faucibus mauris id tempor egestas. Duis luctus turpis at accumsan tincidunt. Phasellus risus risus, volutpat vel tellus ac, tincidunt fringilla massa. Etiam hendrerit dolor eget rutrum.</p>
                                    <p class="overview"><b>Michael Holz</b>Seo Analyst at <a href="#">OsCorp Tech.</a></p>
                                    <div class="star-rating">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="item carousel-item">
                                    <div class="img-box"><img src="https://media.reason.com/mc/ngillespie/2018_04/zuckerberg856.jpg?h=263&w=350" alt=""></div>
                                    <p class="testimonial">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam eu sem tempor, varius quam at, luctus dui. Mauris magna metus, dapibus nec turpis vel, semper malesuada ante. Vestibulum idac nisl bibendum scelerisque non non purus. Suspendisse varius nibh non aliquet.</p>
                                    <p class="overview"><b>Paula Wilson</b>Media Analyst at <a href="#">SkyNet Inc.</a></p>
                                    <div class="star-rating">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star-o"></i></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="item carousel-item">
                                    <div class="img-box"><img src="https://media.reason.com/mc/ngillespie/2018_04/zuckerberg856.jpg?h=263&w=350" alt=""></div>
                                    <p class="testimonial">Vestibulum quis quam ut magna consequat faucibus. Pellentesque eget nisi a mi suscipit tincidunt. Utmtc tempus dictum risus. Pellentesque viverra sagittis quam at mattis. Suspendisse potenti. Aliquam sit amet gravida nibh, facilisis gravida odio. Phasellus auctor velit.</p>
                                    <p class="overview"><b>Antonio Moreno</b>Web Developer at <a href="#">Circle Ltd.</a></p>
                                    <div class="star-rating">
                                        <ul class="list-inline">
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star"></i></li>
                                            <li class="list-inline-item"><i class="fa fa-star-half-o"></i></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <!-- Carousel controls -->
                            <a class="carousel-control left carousel-control-prev" href="#myCarousel" data-slide="prev">
                                <i class="fa fa-angle-left"></i>
                            </a>
                            <a class="carousel-control right carousel-control-next" href="#myCarousel" data-slide="next">
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </div>

                    </section>

                </div>
            </div>
        </div>
    </section>

    <section class="recent-orders pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-4">
                    <h3>Recent orders</h3>

                    <p>
                        Wondering if this job covers your intellectual ambitions? Working with us, you can choose orders of different subjects, deadlines, and levels of complexity. Here is a small portion of what we've offered earlier today.
                    </p>

                </div>

                <div class="col-sm-8">
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-recent">
                                <thead>
                                <tr>
                                    <th>Topic</th>
                                    <th>Level</th>
                                    <th>Deadline</th>
                                    <th>No of pages</th>
                                    <th>Salary</th>
                                </tr>
                                </thead>

                                <tbody>
                                    @foreach($orders as $order)
                                        <tr>
                                            <td>{{$order->title}}</td>
                                            <td>{{$order->Education->name}}</td>
                                            <td>{{$order->deadline->diffForHumans()}}</td>
                                            <td>{{$order->no_pages}}</td>
                                            <td>${{$order->amount}}</td>
                                        </tr>
                                        @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
