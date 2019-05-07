@extends('layouts.admin')

@section('style')

    <style>
        /*---------- Search ----------*/
        .result-bucket li {
            padding: 7px 15px;
        }
        .instant-results {
            background: #fff;
            width: 100%;
            color: gray;
            position: absolute;
            top: 100%;
            left: 0;
            border: 1px solid rgba(0, 0, 0, .15);
            border-radius: 4px;
            -webkit-box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
            box-shadow: 0 2px 4px rgba(0, 0, 0, .175);
            display: none;
            z-index: 9;
        }
        .form-search {
            transition: all 200ms ease-out;
            -webkit-transition: all 200ms ease-out;
            -ms-transition: all 200ms ease-out;
        }
        .search-form {
            position: relative;
            max-width: 100%;
        }

        .top-keyword {
            margin: 3px 0 0;
            font-size: 12px;
            font-family: Arial;
        }
        .top-keyword a {
            font-size: 12px;
            font-family: Arial;
        }
        .top-keyword a:hover {
            color: rgba(0, 0, 0, 0.7);
        }
    </style>

    @endsection

@section('content')
    <section class="content-header">
        <h1>
            Orders
            <small>Control panel</small>
        </h1>


        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Orders</li>
        </ol>
    </section>

    <section class="content">

        <div class="container">

            <div class="row">
                <div class="col-sm-12">
                    <div id="search-form" class="search-form js-search-form">
                        <form class="form-search" role="search" action="/search.php" method="get">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search_field" placeholder="Search for Order number, Title or more..." />
                                <span class="input-group-btn">
                        <button class="btn btn-info" type="button">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                            </div>
                            <p class="clear top-keyword"><span class="hidden-xs">Top Keywords:</span>
                                <a href="#" title="345232423">345232423</a>,
                                <a href="#" title="Evolution of agriculture">Evolution of agriculture</a>,
                                <a href="#" title="The theory of law">The theory of law</a>,
                                <a href="#" title="Waka..">Waka..</a>,
                            </p>
                        </form>
                        <div class="instant-results">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order number</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="search_tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <br>

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

        $(document).ready(function () {
            //Hover Menu in Header
            $('ul.nav li.dropdown').hover(function () {
                $(this).find('.mega-dropdown-menu').stop(true, true).delay(200).fadeIn(200);
            }, function () {
                $(this).find('.mega-dropdown-menu').stop(true, true).delay(200).fadeOut(200);
            });

            //Open Search
            $('.form-search').click(function (event) {
                $(".instant-results").fadeIn('slow').css('height', 'auto');
                event.stopPropagation();
            });

            $('body').click(function () {
                $(".instant-results").fadeOut('500');
            });

            let typingTimer;
            let doneTypingInterval = 1000;

            $('#search_field').on('keyup', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(doneTyping, doneTypingInterval);
            });

            $('#search_field').on('keydown', function () {
                clearTimeout(typingTimer);
            });

            function doneTyping () {
                let url = '{{route('admin.orders.search')}}'+"?search="+$('#search_field').val();
                axios.get(url)
                    .then(function(res){
                        $('#search_tbody').html('')
                      $.each(res.data.orders,function (key,order) {
                          let base_url='{{url('/admin/orders/view')}}/' + order.id
                          $('#search_tbody').append("<tr>\n" +
                              "                                        <td>"+(key+1)+"</td>\n" +
                              "                                        <td>"+order.order_no+"</td>\n" +
                              "                                        <td>"+order.title+"</td>\n" +
                              "                                        <td><a href='"+base_url+"'>view order</a></td>\n" +
                              "                                    </tr>")
                      })
                    })
                    .catch(function(res){
                        console.log(res)
                    })

            }
        });
    </script>


    @endsection