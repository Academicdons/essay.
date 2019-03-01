<html>
    <head>

        <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700" rel="stylesheet">


        <link rel="stylesheet" href="{{asset('bs4/dist/css/bootstrap.css')}}">
        <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

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
                background-color: #018021;
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

        </style>

    </head>

    <body>

    <div class="top-bar bg-base">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <p class="top-bar-text p-2  mb-0">Get a professional service</p>
                </div>
                <div class="col-sm-6 float-left">
                    <ul class="list-inline pt-2 top-bar-text float-right">
                        <li class="list-inline-item">&copy; Homework pro writers</li>
                        <li class="list-inline-item">| 0723123231</a></li>
                        <li class="list-inline-item">| info@homeworkprowriters.com</li>
                    </ul>
                </div>
            </div>
        </div>

    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Navbar</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Link</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Dropdown
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>


    <section class="header">

        <div class="container pt-5 pb-5">

            <div class="row mt-5 mb-5">
                <div class="col-sm-6">

                    <h1 class="heading heading-light">Get Your Paper Done</h1>
                    <div class="separator"></div>
                    <h3 class="mt-5">Let professional writers handle your academic paper work
                    </h3>

                    <a href="" class="btn btn-primary bg-homework mt-3">Place order</a>

                    <div class="row mt-5">
                        <div class="col-sm-6">
                            <div class="stats">
                                <div class="stats__amount">281</div>
                                <div class="stats__caption">Current orders</div>
                                <div class="stats__change">
                                    <div class="stats__value stats__value--positive">+7%</div>
                                    <div class="stats__period">this week</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="stats">
                                <div class="stats__amount">3641</div>
                                <div class="stats__caption">Loyal customers</div>
                                <div class="stats__change">
                                    <div class="stats__value stats__value--positive">+21%</div>
                                    <div class="stats__period">this week</div>
                                </div>
                            </div>
                        </div>
                    </div>
                        
                </div>
                <div class="col-sm-6">
                    <img src="https://unixtitan.net/images/transparent-writers-png-2.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>

    </section>

    <section class="become-writer">

        <div class="container pt-5 pb-1">

            <div class="row mt-5 mb-5">

                <div class="col-sm-6">
                    <img src="https://pngimage.net/wp-content/uploads/2018/06/png-company-register-5.png" class="img-fluid" alt="">
                </div>

                <div class="col-sm-6 pt-5">

                    <h1 class="heading">Enjoy writting?</h1>
                    <div class="separator"></div>
                    <h3 class="mt-5">Join our network of freelance academic writers
                    </h3>

                    <ul>
                        <li>Create an account and perform evaluation. On success, your writer accout will be activated</li>
                        <li>Bid for academic papers orders</li>
                        <li>Research the work and submit on the site</li>
                        <li>Get paid conveniently through <b>M-pesa</b> or <b>paypal</b> and <b>cash</b></li>
                    </ul>

                    <a href="" class="btn btn-primary mt-4">Become a writer now</a>

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
                    <p>Academia-Research is an online academic writing and consulting company. Since 2004, we have worked to ensure the highest quality standards of service and offer a stable income for aspiring academic writers. We value our employees, ensure career growth, provide various rewards programs, and 24/7 support.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-edit"></i></p>
                    <h5 class="about-title mt-2">Zero plagiarism</h5>
                    <p class="mt-2">
                        Ensure constant communication with the writer via live chat and ensure all your needs are met
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-briefcase"></i></p>
                    <h5 class="about-title mt-2">Professional work</h5>
                    <p class="mt-2">
                        Ensure constant communication with the writer via live chat and ensure all your needs are met
                    </p>
                </div>
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-comment"></i></p>
                    <h5 class="about-title mt-2">Realtime chat</h5>
                    <p class="mt-2">
                        Ensure constant communication with the writer via live chat and ensure all your needs are met
                    </p>

                </div>
                <div class="col-sm-3">
                    <p class="icon"><i class="fa fa-google-wallet"></i></p>
                    <h5 class="about-title mt-2">Get paid</h5>
                    <p class="mt-2">
                        Ensure constant communication with the writer via live chat and ensure all your needs are met
                    </p>

                </div>
            </div>
        </div>

    </section>


    <section class="footer">

        <div class="container">
            <div class="row mt-5 mb-3">
                <div class="col-sm-6">

                </div>
                <div class="col-sm-6">

                    <div class="row">
                        <div class="col-sm-6">

                            <h4>Quick links</h4>
                            <ul class="bottom-list">
                                <li><a href=""><i class="fa fa-link"></i> About</a></li>
                                <li><a href=""><i class="fa fa-link"></i> How it works</a></li>
                                <li><a href=""><i class="fa fa-link"></i> Register</a></li>
                                <li><a href=""><i class="fa fa-link"></i> Login</a></li>
                            </ul>

                        </div>
                        <div class="col-sm-6">

                            <h4>Contact us</h4>
                            <ul class="bottom-list">
                                <li><a href=""><i class="fa fa-envelope"></i> info@gmail.com</a></li>
                                <li><a href=""><i class="fa fa-phone"></i> +4567029839</a></li>
                                <li><a href=""><i class="fa fa-money"></i> P.O.BOX 34</a></li>
                                <li><a href=""><i class="fa fa-globe"></i> www.homeworkpros.com</a></li>
                            </ul>
                        </div>
                    </div>

                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <p class="text-center mb-3 mt-3" style="color: gray;font-size: 13px">Copyright &copy; Homework pro writers. All right reserved. Designed and maintained by Homework pro</p>
                </div>
            </div>
        </div>

    </section>



    <script src="{{asset('bs4/dist/js/bootstrap.min.js')}}"></script>

    </body>
</html>