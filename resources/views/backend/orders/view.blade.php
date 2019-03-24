@extends('layouts.admin')

@section('style')

    <link rel="stylesheet" href="{{asset('plugins/easycomplete/easy-autocomplete.css')}}">

    <style type="text/css">
        .border-right{
            border-right: 1px solid gray;
        }

        .chat{
            border: 1px solid gray;
            border-radius:  6px 6px 0px 0px;
            padding: 0px !important;
            margin: 6px 0px 6px 0px;
        }

        .chat .col-sm-12{
            padding-left: 2px !important;
            padding-right: 2px !important;
        }

        .chat-header{
            background: green !important;
            border-radius:  6px 6px 0px 0px !important;
        }


        .chat-header .col-sm-6{
            padding: 0px !important;
        }

        .chat-header p{
            font-size: 18px;
            color: white;
            font-weight: bold;
            padding: 5px;
        }

        .chat-header .br{
            border-right: 2px solid white !important;
        }
        .chat-foot{
            margin-bottom: 3px;
        }

        .easy-autocomplete{
            width:100% !important
        }

        .easy-autocomplete input{
            width: 100%;
        }

        .form-wrapper{
            width: 500px;
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
            <li class="active">View Order</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order No. {{ $order->order_no }}</h3>
                        <div class="box-tools" id="bid_area">
                            @if($order->status==0)
                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#rateModal"  @click="getBids('{{$order->id}}')">View Placed Bids</button>
                            @endif
                            <div class="modal" id="rateModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Rate the quality of service</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                    <table class="table table-responsive table-striped">
                                        <thead>
                                        <tr>
                                         <td>   User Name</td>
                                        <td>Order Id</td>
                                        <td>Action</td>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        <tr v-for="bid in bids">
                                        <td>@{{ bid.user_id }}</td>
                                        <td>@{{ bid.order_id }}</td>
                                        <td><a :href="{{url('admin/order/assign_user_bid/'}}' . '/'. bid->order_id .'/'.  bid->user_id"  class="btn btn-primary">Assign Order</a></td>

                                        </tr>

                                        </tbody>
                                    </table>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="{{ route('admin.orders.index') }}" class="btn btn-xs btn-info">Back To Orders</a>
                            <a href="javascript:;" class="btn btn-xs btn-warning" onclick="manualAssign()">Manual assign</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/anonymous.jpg') }}" alt="User Image">
                            <span class="username">
                          <a href="#">{{ $order->title }}</a>
                          <div class="pull-right btn-box-tool">
                                {{--<a href="" class="btn btn-xs bg-aqua"><i class="fa fa-check"></i>Done</a>--}}
                        </div>
                        </span>
                            <span class="description">To be completed - {{ \Carbon\Carbon::parse($order->deadline)->diffForHumans() }} &nbsp <b>-</b> &nbsp;Bid Expiry Time - <span class="text-orange">{{ \Carbon\Carbon::parse($order->bid_expiry)->diffForHumans() }}</span> &nbsp;
                                {{--Added by -  <span class="text-aqua">Admin</span> &nbsp;--}}
                            </span>
                        </div>

                        <div class="row">
                            <div class="col-sm-8">
                                <div class="col-sm-12">
                                    <br>
                                    <table class="table table-striped table-sm">
                                        <tr>
                                            <td>Order type</td>
                                            <th>
                                                @if($order->order_assign_type == 1)
                                                    writers to bid
                                                @elseif($order->order_assign_type == 2)
                                                    First come take
                                                @else
                                                    Manual assignment
                                                @endif
                                            </th>
                                            <td>Academic level</td>
                                            <th>
                                                @if($order->order_assign_type == 1)
                                                    writers to bid
                                                @elseif($order->order_assign_type == 2)
                                                    First come take
                                                @else
                                                    Manual assignment
                                                @endif
                                            </th>

                                            <td>Bonus</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Writer quality </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>

                                        <tr>
                                            <td>Number of pages</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Number of words </td>
                                            <th>{{ $order->no_words }}</th>
                                            <td>Education level</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Salary </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>

                                        <tr>
                                            <td>Bonus</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Writer quality </td>
                                            <th>{{ $order->no_words }}</th>

                                            <td>Bonus</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Writer quality </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-sm-6 border-right">

                                    <div class="row" id="review_area">
                                        <div class="col-sm-12">
                                            <h4><u>Clients review:</u></h4>

                                        </div>
                                        <div class="col-md-12" v-for="review in reviews">

                                            <p>
                                                <a class="float-left" href="https://maniruzzaman-akash.blogspot.com/p/contact.html"><strong>@{{ review.user.name}}</strong></a>
                                                <span class="float-right" v-for="star in Math.ceil(review.rating)"><i class="text-success fa fa-star"></i></span>
                                                <span class="float-right" v-for="star in (10-Math.ceil(review.rating))"><i class="fa fa-star"></i></span>


                                            </p>
                                            <div class="clearfix"></div>
                                            <p>@{{ review.review }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <h3>Notes</h3>
                                    <p>
                                        Any topic (writer's choice)
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <form action="https://academicdons.com/admin/save_file" method="post" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="zKZlLTxABOWHmdOl56Lz1RHrXQilvvfC7IlAsxTF">
                                            <input type="hidden" name="task_id" value="639">
                                            <input type="text" name="display_name" class="btn btn-default btn-xs" placeholder="display name">
                                            <label for="file" class="btn btn-xs btn-warning">Choose file</label>
                                            <input type="file" name="file" id="file" style="display: none">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-upload"></i></button>
                                        </form>

                                    </div>

                                </div>
                                <div class="col-sm-12">


                                    <div class="table-responsive">
                                        <table class="table table-striped">
                                            <tbody><tr>
                                                <th style="width: 10px">#</th>
                                                <th>File</th>
                                                <th>Created by</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th style="width: 40px"></th>
                                            </tr>

                                            <tr>
                                                <td>1</td>
                                                <td>Final Paper Rubric (1).docx</td>
                                                <td>Admin</td>
                                                <td></td>
                                                <td>2 months ago</td>
                                                <td>docx</td>
                                                <td><a href="https://academicdons.com/download/1258" class="btn btn-warning btn-xs">
                                                        <i class="fa fa-cloud-download"></i>
                                                    </a></td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Final Paper Instructions (5).docx</td>
                                                <td>Admin</td>
                                                <td></td>
                                                <td>2 months ago</td>
                                                <td>docx</td>
                                                <td><a href="https://academicdons.com/download/1259" class="btn btn-warning btn-xs">
                                                        <i class="fa fa-cloud-download"></i>
                                                    </a></td>
                                            </tr>

                                            </tbody></table>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4" id="chat_area">
                                <div class="row chat">
                                    <div class="col-sm-12 chat-header">
                                        <div class="row">
                                            <div class="col-sm-6 br" @click="getMessages(0)">
                                                <p class="text-center">Writer</p>
                                            </div>
                                            <div class="col-sm-6" @click="getMessages(1)">
                                                <p class="text-center">Client</p>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-sm-12 chat-body">
                                        <p class="text-center" v-if="!messages.length" style="padding: 10px">There are no messages in this conversation</p>
                                        <div class="direct-chat-messages" style="min-height: 400px !important;">

                                            <div v-for="msg in messages" v-cloak>
                                                <!-- Message. Default to the left -->
                                                <div class="direct-chat-msg" v-if="msg.user.id == conversation_user.id">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name pull-left">@{{ msg.user.name }}</span>
                                                        <span class="direct-chat-timestamp pull-right">@{{ msg.created_at }}</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="{{asset('dist/img/user1-128x128.jpg')}}" alt="message user image">
                                                    <!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        @{{ msg.message }}
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->

                                                <!-- Message to the right -->
                                                <div class="direct-chat-msg right" v-if="msg.user.id != conversation_user.id">
                                                    <div class="direct-chat-info clearfix">
                                                        <span class="direct-chat-name pull-right">@{{ msg.user.name }}</span>
                                                        <span class="direct-chat-timestamp pull-left">@{{ msg.created_at }}</span>
                                                    </div>
                                                    <!-- /.direct-chat-info -->
                                                    <img class="direct-chat-img" src="{{asset('dist/img/user3-128x128.jpg')}}" alt="message user image">
                                                    <!-- /.direct-chat-img -->
                                                    <div class="direct-chat-text">
                                                        @{{ msg.message }}
                                                    </div>
                                                    <!-- /.direct-chat-text -->
                                                </div>
                                                <!-- /.direct-chat-msg -->
                                            </div>


                                        </div>
                                    </div>
                                    <div class="col-sm-12 chat-foot">
                                        <form action="#" method="post">
                                            <div class="input-group">
                                                <input type="text" v-model="message.message" id="message_input" name="message" placeholder="Type Message ..." class="form-control">
                                                <span class="input-group-btn">
                                                <button type="button" class="btn btn-warning btn-flat" @click="sendMessage()">Send</button>
                                              </span>
                                            </div>
                                        </form>
                                    </div>


                                    <div class="col-sm-12">
                                        <h4>Assignments:</h4>
                                        <hr>
                                        <ul class="users-list clearfix">
                                            <li v-for="ass in assignments" @click="getUserConversation(ass.id)">
                                                <img src="{{asset('dist/img/user1-128x128.jpg')}}" alt="User Image">
                                                <a class="users-list-name" href="#">@{{ ass.name }}</a>
                                                <span class="users-list-date">@{{ ass.phone_number }}</span>
                                            </li>

                                        </ul>
                                    </div>

                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!------------------ manual assign Modals----------------->
    <div id="assignModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="box">
                <div class="box-header">

                </div>
                <div class="box-body">
                    <div class="alert alert-error" id="error_message" style="display: none">
                        <p>Select a writer before proceeding</p>
                    </div>
                    <form action="">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label for="">Type the writers username to assign</label>
                                    <input id="example-mail" class="form-control"/>
                                </div>

                                <div class="form-group text-center">
                                    <button type="button" onclick="assignOrder()" class="btn btn">Assign to this writer</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@stop

@section('script')

    <script src="{{asset('plugins/easycomplete/jquery.easy-autocomplete.min.js')}}"></script>

    <script type="text/javascript">

        let bid_area=new Vue({

            el:'#bid_area',
            data:{
                bids:[]
            },
            methods:{
                getBids:function (order_id) {
                    // alert(order_id);
                    let url='{{url('admin/orders/get_order_bids')}}'+'/'+order_id;
                    let me=this;
                    axios.get(url)
                        .then(res=>{
                            me.bids=res.data.bids;
                        })

                }

            }
        });
        function assignOrder() {

            if(window.selected==null){
                $('#error_message').slideDown()
            }else{
                $('#error_message').hide()
            }

            let url = '{{route('admin.orders.manual_assign')}}';
            let order_id = '{{$order->id}}';
            axios.post(url,{par1:order_id,par2:selected})
                .then(function (res) {
                    $('#assignModal').modal('hide');
                    window.location.reload()
                })
        }

        $(function () {


            var options = {
                url: "{{route('admin.general.suggest_writer')}}",

                getValue: "name",

                template: {
                    type: "description",
                    fields: {
                        description: "email"
                    }
                },

                list: {
                    onSelectItemEvent: function() {
                        window.selected = $("#example-mail").getSelectedItemData().id;

                    },
                    match: {
                        enabled: true
                    }
                },

                theme: "plate-dark"
            };

            $("#example-mail").easyAutocomplete(options);

        })


        function manualAssign(){
            $('#assignModal').modal('show');
        }

       let chatVue = new Vue({
            'el':'#chat_area',
            data:{
                assignments:[],
                conversation_user:{},
                messages:[],
                message:{}
            },

            created:function () {
                console.log('Chat vue created')
                this.getChatAreaData()
            },
            methods: {
                getChatAreaData:function(){
                    let url = '{{route('admin.orders.chat_data',$order->id)}}'
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            console.log(res.data)
                            me.assignments = res.data.assignments;
                        })
                },
                getMessages(mode){
                    let url = '{{route('admin.orders.messages',$order->id)}}'+"?mode="+mode;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.conversation_user  = res.data.conversation_user;
                            me.messages  = res.data.messages;
                            me.message.conversation_id  = res.data.conversation.id;
                            thunderListen(res.data.conversation.id)
                        })

                },
                sendMessage:function(){
                    let url = '{{route('admin.orders.save_messages',$order->id)}}'
                    let me = this;
                    axios.post(url,this.message)
                        .then(function(res){
                            me.message={}
                        })


                },
                getUserConversation:function(id){
                    let url = '{{route('admin.orders.messages',$order->id)}}'+"?user="+id;
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.conversation_user  = res.data.conversation_user;
                            me.messages  = res.data.messages;
                            me.message.conversation_id  = res.data.conversation.id;
                        })
                }
            }

        });

        var reviewArea = new Vue({
            el:'#review_area',
            data:{
                reviews:[]
            },
            created:function(){
                console.log("review area created")
                this.getOrderReviews()
            },
            methods:{
                getOrderReviews:function () {
                    let url = '{{route('admin.orders.reviews',$order->id)}}';
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.reviews  = res.data.reviews;
                        })
                }
            }
        });

        function thunderListen(conv_id){
            console.log(conv_id)
            Thunder.connect("157.230.213.22:8080", "MhPN3ItPqy", [conv_id,"homepro_user_{{Auth::id()}}"], {log: true});
            Thunder.listen(function(message) {
                // chatVue.getConversations();
            });
        }

    </script>

    @endsection