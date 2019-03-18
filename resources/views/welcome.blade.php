@extends('layouts.index')


@section('content')

    <section class="header">

        <div class="container pt-5 pb-5">

            <div class="row mt-5 mb-5">
                <div class="col-sm-6">

                    <h1 class="heading heading-light">Get Your Paper Done</h1>
                    <div class="separator"></div>
                    <h3 class="mt-5">Let professional writers handle your academic paper work
                    </h3>

                    <a href="{{route('client.place_order')}}" class="btn btn-primary bg-homework mt-3">Place order</a>

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
                    <img src="{{asset('images/landing page resource.svg')}}" class="img-fluid" alt="">
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
                                <tr>
                                    <td>Hypnotize Yourself Into The Ghost…</td>
                                    <td>Master</td>
                                    <td>10d 05h</td>
                                    <td>12</td>
                                    <td>$40</td>
                                </tr>
                                <tr>
                                    <td>Hypnotize Yourself Into The Ghost…</td>
                                    <td>Master</td>
                                    <td>10d 05h</td>
                                    <td>12</td>
                                    <td>$40</td>
                                </tr>
                                <tr>
                                    <td>Hypnotize Yourself Into The Ghost…</td>
                                    <td>Master</td>
                                    <td>10d 05h</td>
                                    <td>12</td>
                                    <td>$40</td>
                                </tr>
                                <tr>
                                    <td>Hypnotize Yourself Into The Ghost…</td>
                                    <td>Master</td>
                                    <td>10d 05h</td>
                                    <td>12</td>
                                    <td>$40</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
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
                    <p class="mt-3">Get started by submitting a form in less than 5 minutes.
                    </p>
                </div>
                <div class="col-sm-3 text-center">
                    <img src="{{asset('images/show-skill.png')}}" class="img-fluid" alt="">
                    <h4 class="mt-3">Show skills</h4>
                    <p class="mt-3">Get started by submitting a form in less than 5 minutes.
                    </p>
                </div>

                <div class="col-sm-3 text-center">
                    <img src="{{asset('images/get-paid.png')}}" class="img-fluid" alt="">
                    <h4 class="mt-3">Sign up</h4>
                    <p class="mt-3">Get started by submitting a form in less than 5 minutes.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="testimonials">

        <div class="container pt-5 pb-5">
            <div class="row">
                <div class="col-sm-6 mt-3 mb-3">
                    <h3>Testimonials</h3>
                    <p>
                        We’ve designed a feedback platform for more effective cooperation with our freelancers.
                    </p>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div>
    </section>
@endsection
