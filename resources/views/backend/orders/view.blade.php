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
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-xs btn-info">Back To Orders</a>
                            <button class="btn-danger btn-xs" data-toggle="modal" data-target="#disputedModal">Mark Order as Disputed</button>
                            <div class="modal" id="disputedModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Mark Order as Disputed</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card " v-if="existing_disputes!=''">
                                                <div class="card-header">
                                                    <h6 >Existing Disputes</h6>

                                                </div>
                                                <div class="card-body">
                                                    <li v-for="existing_dispute in existing_disputes">@{{ existing_dispute.reason }}</li>

                                                </div>
                                            </div>


                                            <p><b>Provide a reason why you need to mark the order as disputed below</b></p>

                                            <textarea v-model="dispute_reason" style="min-height: 200px" class="form-control" placeholder=""></textarea>

                                            <p class="text-center">
                                                <button @click="requestDispute()" class="btn btn-success mt-3">Submit Dispute request</button>
                                            </p>

                                        </div>
                                    </div>
                                </div>
                            </div>


                        @if($order->status==0 )

                            <button class="btn btn-primary btn-xs" data-toggle="modal" data-target="#rateModal"  @click="getBids('{{$order->id}}')">View Placed Bids</button>
                            @endif
                            <div class="modal" id="rateModal" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">Assign Writer an Order</h5>
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
                                        <td>@{{ bid.user.email  }}</td>
                                        <td>@{{ bid.order.order_no }}</td>
                                        <td>

                                            <a :href="'{{url('/admin/orders/assign_user_bid')}}/' +  bid.order_id +'/'+ bid.user_id"  class="btn btn-primary">Assign Order</a>
                                        </td>

                                        </tr>

                                        </tbody>
                                    </table>


                                        </div>
                                    </div>
                                </div>
                            </div>

                            <a href="javascript:;" class="btn btn-xs btn-warning" onclick="manualAssign()">Manual assign</a>
                            <a href="javascript:;" class="btn btn-xs btn-success" onclick="getAdditionalTransactions()">Fine.Bonus</a>
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
                            <span class="description" id="description_data">To be completed -
                                @{{ deadline }}(@{{ writer_deadline }})

                               &nbsp <b>-</b> &nbsp;Bid Expiry Time - <span class="text-orange">  @{{ expiry }}</span> &nbsp;
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
                                                @if($order->Education!=null)
                                                {{$order->Education->name}}

                                                    @endif
                                            </th>

                                            <td>Pages</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Words </td>
                                            <th>{{ $order->no_words }}</th>
                                        </tr>

                                        <tr>
                                            <td>Salary</td>
                                            <th>{{ $order->salary }}</th>
                                            <td>Amount </td>
                                            <th>{{ $order->amount }}</th>
                                            <td>Paper type</td>
                                            <th>
                                                @if($order->Paper!=null)
                                                {{ $order->Paper->name }}

                                                    @endif
                                            </th>
                                            <td> Discipline </td>

                                            <th>
                                                @if($order->Discipline!=null)
                                                {{ $order->Discipline->name }}
                                                @endif
                                            </th>
                                        </tr>

                                        <tr>
                                            <td>Status</td>
                                            <th>
                                                @if($order->status==0)
                                                    Un assigned
                                                @elseif($order->status==1)
                                                    In progress
                                                @elseif($order->status==2)
                                                    Revision
                                                @elseif($order->status==3)
                                                    Complete
                                                @else
                                                    Post client
                                                @endif
                                            </th>
                                            <td>Type of service</td>
                                            <th>
                                                @if($order->type_of_service==1)
                                                    From scratch
                                                @elseif($order->type_of_service==2)
                                                    Rewriting
                                                @else
                                                    Editing
                                                @endif

                                            </th>

                                            <td>Bonus/fines</td>
                                            <th>{{ $order->bargains()->sum('amount') }}</th>
                                            <td> Writer quality </td>
                                            <th>
                                                @if($order->writer_quality==1)
                                                    standard
                                                @elseif($order->writer_quality==2)
                                                    premium
                                                @else
                                                    platinum
                                                @endif

                                            </th>
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
                                        <form action="{{route('admin.orders.upload_file',$order->id)}}" method="post" enctype="multipart/form-data">
                                            @csrf
                                            <input type="text" name="display_name" class="btn btn-default btn-xs" placeholder="display name" required>
                                            <label for="file" class="btn btn-xs btn-warning">Choose file</label>
                                            <input type="file" name="file" id="file" style="display: none" required>
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-upload"></i></button>
                                        </form>
                                    </div>

                                </div>
                                <div class="col-sm-12">


                                    <div class="table-responsive">
                                        <table class="table table-striped" id="table_area">
                                            <tbody><tr>
                                                <th style="width: 10px">#</th>
                                                <th>File</th>
                                                <th>Created by</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th>Action</th>
                                                <th style="width: 40px"></th>
                                            </tr>

                                            @foreach($order->attachments as $attachment)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>{{$attachment->display_name}}</td>
                                                    <td>-</td>
                                                    <td>-</td>
                                                    <td id="date{{$loop->iteration}}">
                                                        <script>
                                                            $(function(){
                                                                let date ='{{$attachment->created_at}}';
                                                                let converted_date = moment.utc(date).local().format('MMMM Do YYYY, h:mm:ss a')
                                                                $('#date{{$loop->iteration}}').html(converted_date)
                                                            })
                                                        </script>

                                                    </td>
                                                    <td>{{current(array_reverse(explode('.',$attachment->file_name)))}}</td>
                                                    <td>
                                                        @if(!$attachment->is_verified)
                                                        <a href="{{route('admin.orders.verify_file',$attachment->id)}}" class="btn btn-xs btn-primary">Verify</a>
                                                            @else
                                                        <span class="badge badge-primary">Verified</span>
                                                        @endif
                                                    </td>
                                                    <td><a href="{{asset('uploads/files/order_files/'. $attachment->file_name)}}" class="btn btn-warning btn-xs" download>
                                                            <i class="fa fa-cloud-download"></i>
                                                        </a></td>
                                                </tr>
                                                @endforeach


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

    <!------------------ manual assign Modals----------------->
    <div id="bargainsModal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="box">
                <div class="box-header">
                    <h3>Manage fines and bonuses</h3>
                </div>
                <div class="box-body" id="bargains_area">

                    <form action="">
                        <div class="row">
                            <div class="col-sm-8">
                                <input type="number" class="form-control" v-model="bargain.amount">
                            </div>
                            <div class="col-sm-4">
                                <button type="button" @click="saveBargain()" class="btn btn-block btn-primary">Add bargain</button>
                            </div>
                        </div>
                        
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Type</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="(bar,index) in bargains">
                                    <td>@{{ index+1 }}</td>
                                    <td>
                                        <span v-if="bar.amount>0" class="label label-success">bonus</span>
                                        <span v-if="bar.amount<0"class="label label-danger">fine</span>
                                    </td>
                                    <td>@{{ bar.amount }}</td>
                                    <td>
                                        <button   class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>

                </div>
            </div>
        </div>
    </div>


@stop

@section('script')

    <script src="{{asset('plugins/easycomplete/jquery.easy-autocomplete.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>

    <script>
        var dadsd=new Vue({
            el:'#description_data',
            data:{
                deadline:null,
                writer_deadline:null,
                expiry:null
            },
            created:function(){
                this.updateDeadline();
                this.updateExpiry();
                this.updateWriterDeadline();
            },
            methods:{
                updateDeadline:function () {
                    let x = moment.utc('{{$order->deadline}}').local()
                    let y = moment.now()
                    let duration = x.diff(y)
                    this.deadline= moment.utc(duration).format('h[h] m[m] s[s]')
                },
                updateExpiry:function () {
                    let x = moment.utc('{{$order->bid_expiry}}').local()
                    let y = moment.now()
                    let duration = x.diff(y)
                    this.expiry= moment.utc(duration).format('h[h] m[m] s[s]')
                },
                updateWriterDeadline:function () {
                    let x = moment.utc('{{$order->writer_deadline}}').local()
                    let y = moment.now()
                    let duration = x.diff(y)
                    this.writer_deadline= moment.utc(duration).format('h[h] m[m] s[s]')
                }
            }
        });
    </script>
    <script type="text/javascript">

        let bid_area=new Vue({

            el:'#bid_area',
            data:{
                bids:[],
                dispute_reason:'',
                dispute:{},
                existing_disputes:[],
            },
            created:function(){
                this.getDisputes();

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

                },
                requestDispute:function(){
                    let order_id_id='<?php echo $order->id; ?>';

                    let url = '{{route('customer.orders.dispute_order',$order->id)}}';
                    let me = this;
                    axios.post(url,{'dispute_reason':me.dispute_reason,'order_id':order_id_id})
                        .then(function (res) {
                            me.dispute=res.data.dispute;
                            me.getDisputes();
                            $('#disputedModal').modal('hide')
                        })
                },
                getDisputes(){
                    let url='{{route('customer.orders.fetch_disputes',$order->id)}}';
                    let me = this
                    axios.get(url)
                        .then(function (res) {
                            me.existing_disputes=res.data.disputes;
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


        let load_mode = 1;
        window.chatVue = new Vue({
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
                            // console.log(res.data)
                            me.assignments = res.data.assignments;
                        })
                },
                getMessages(mode){
                    load_mode = mode;
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
                window.chatVue.getMessages(load_mode)
            });
        }


        window.bargains_area = new Vue({
            el:'#bargains_area',
            data:{
                bargains:[],
                bargain:{}
            },
            created:function(){
                console.log("Bargain area created");
                this.getBargains()
            },
            methods:{

                getBargains:function () {
                    let url = '{{route('admin.orders.bargains',$order->id)}}'
                    let me = this;
                    axios.get(url)
                        .then(function(res){
                            me.bargains = res.data
                        })
                },
                saveBargain:function(){
                    let url = '{{route('admin.orders.create_bargain',$order->id)}}'
                    let me = this;
                    axios.post(url,this.bargain)
                        .then(function(res){
                            me.getBargains()
                        })

                }

            }
        })
        
        function getAdditionalTransactions() {
            $('#bargainsModal').modal('show')
        }

    </script>

    @endsection