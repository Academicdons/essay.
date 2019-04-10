@extends('layouts.writer')

@section('style')

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

        .rating{
            font-size: 30px;
            color: orange;
        }
    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>

@endsection

@section('content')


    <section class="container" >
        <div class="row">
            @if($errors->has('bid'))
                <div class="alert alert-danger">
                    {{$errors->first('bid')}}
                </div>
            @endif
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Order No. {{ $order->order_no }}</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.orders.index') }}" class="btn btn-xs btn-info">Back To Orders</a>

                            @if($order->status==1)

                            <a href="#" class="btn btn-xs btn-success" data-toggle="modal" data-target="#rateModal">Mark as done</a>
                            @elseif($order->status==0)
                                @if(\App\Models\Bid::where('order_id',$order->id)->where('user_id',\Illuminate\Support\Facades\Auth::id())->first()==null)
                                <a href="{{url('writer/orders/place_bid/'.$order->id)}}" class="btn btn-xs btn-success" >Bid</a>
                                @else
                                    <span class="badge badge-success">Already Bid</span>
                                    @endif
                            @endif
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" id="">
                        <div class="user-block">
                            <img class="img-circle img-bordered-sm" src="{{ asset('dist/img/anonymous.jpg') }}" alt="User Image">
                            <span class="username">
                          <a href="#">{{ $order->title }}</a>
                          <div class="pull-right btn-box-tool">
                        </div>
                        </span>
                            <span class="description" id="description_data">To be completed -
                                @{{ deadline }}

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
                                                @if($order->order_assign_type == 1)
                                                    writers to bid
                                                @elseif($order->order_assign_type == 2)
                                                    First come take
                                                @else
                                                    Manual assignment
                                                @endif
                                            </th>

                                            <td>Bonus/fine</td>
                                            <th>{{ $order->bargains()->sum('amount') }}</th>
                                            <td> Spacing </td>
                                            <th>
                                                @if($order->spacing==1)
                                                    Double
                                                    @else
                                                    Single
                                                    @endif
                                            </th>
                                        </tr>

                                        <tr>
                                            <td>Number of pages</td>
                                            <th>{{ $order->no_pages }}</th>
                                            <td> Number of words </td>
                                            <th>{{ $order->no_words }}</th>
                                            <td>Education level</td>
                                            <th>{{( $order->Education!=null)? $order->Education->name:"" }}</th>
                                            <td> Paper type </td>
                                            <th>{{ ($order->Paper!=null)?$order->Paper->name:"" }}</th>
                                        </tr>

                                        <tr>
                                            <td>SPP</td>
                                            <th>{{ $order->salary/$order->no_pages }}</th>
                                            <td> Discipline </td>
                                            <th>{{ ($order->Discipline!=null)?$order->Discipline->name:"" }}</th>

                                            <td>Salary</td>
                                            <th>{{ $order->salary    }}</th>
                                            <td> Writer quality </td>
                                            <th>

                                                @if($order->writer_quality==1)
                                                    standard
                                                @elseif($order->writer_quality==2)
                                                    premium
                                                @elseif($order->writer_quality==3)
                                                    platinum
                                                @else
                                                    standard
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
                                        {!! $order->notes !!}
                                    </p>
                                </div>
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <form action="{{route('writer.orders.upload_file',$order->id)}}" method="post" enctype="multipart/form-data">
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
                                        <table class="table table-striped">
                                            <tbody><tr>
                                                <th style="width: 10px">#</th>
                                                <th>File</th>
                                                <th>Description</th>
                                                <th>Date</th>
                                                <th>Type</th>
                                                <th style="width: 40px"></th>
                                            </tr>

                                            @foreach($order->attachments as $attachment)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$attachment->file_name}}</td>
                                                <td>{{$attachment->display_name}}</td>

                                                <td id="date{{$loop->iteration}}">
                                                    <script>
                                                        $(function(){
                                                            let date ='{{$attachment->created_at}}';
                                                            let converted_date = moment.utc(date).local().format('MMMM Do YYYY, h:mm:ss a');
                                                            $('#date{{$loop->iteration}}').html(converted_date)
                                                        })
                                                    </script>

                                                </td>
                                                <td>{{current(array_reverse(explode('.',$attachment->file_name)))}}</td>
                                                <td><a href="{{asset('uploads/files/order_files/'. $attachment->file_name)}}" class="btn btn-warning btn-xs" download>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </a></td>
                                            </tr>
                                          @endforeach

                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="row chat" id="chat_area">
                                    <div class="col-sm-12 chat-header">
                                        <div class="row">
                                            <div class="col-sm-12 br">
                                                <p class="text-center">Order chat</p>
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
                                        <form action="#" onsubmit="return false" method="post">
                                            <div class="input-group">
                                                <input type="text" v-model="message.message" id="message_input" name="message" placeholder="Type Message ..." class="form-control">
                                                <span class="input-group-btn">
                                                <button type="button" class="btn btn-warning btn-flat" @click="sendMessage()">Send</button>
                                              </span>
                                            </div>
                                        </form>
                                    </div>


                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

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

                    @if(\App\Models\Attachment::where('order_id',$order->id)->where('created_by',\Illuminate\Support\Facades\Auth::id())->first() ==null)


                        <div class="alert alert-danger">
                            <h3>Please upload a file before marking the order as done</h3>
                        </div>
                    @endif
                    <p>Help us improve the quality of our service by providing a review</p>
                    <p class="text-ceter">Rate the quality of work:</p>
                    <div class="rating mx-auto"></div>
                    <p class="text-center">Review the quality of work:</p>
                    <form action="{{route('writer.orders.review')}}" method="post" >

                        @csrf
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <input type="hidden" name="rating" id="rating_value" value="9">
                        <textarea v-model="review.review" class="form-control" name="review_data" placeholder="The writer understood the task and delivered as instruc..."></textarea>
                        <br>
                        <p class="text-center">
                            @if(\App\Models\Attachment::where('order_id',$order->id)->where('created_by',\Illuminate\Support\Facades\Auth::id())->first() ==null)
                                <button type="submit" class="btn btn-success mt-3" disabled>Submit review</button>
                            @else
                                <button type="submit" class="btn btn-success mt-3">Submit review</button>
                            @endif
                        </p>
                    </form>

                </div>
            </div>
        </div>
    </div>

@stop


@section('script')
    <script src="{{asset('plugins/rater/rater.min.js')}}"></script>
    <script>
        var dadsd=new Vue({
            el:'#description_data',
            data:{
                deadline:moment.utc('{{$order->writer_deadline}}').local().startOf('hour').fromNow(),
                expiry:moment.utc('{{$order->bid_expiry}}').local().startOf('hour').fromNow()
            },
            created:function(){

            },
            methods:{

            }
        });
    </script>

    <script>

        $(function () {
            var options = {
                max_value: 10,
                step_size: 1,
                initial_value: 9,

            };
            $(".rating").rate(options);
            $(".rating").on("change", function(ev, data){
                $('#rating_value').val(data.to)
            });
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
                    let url = '{{route('writer.orders.reviews',$order->id)}}';
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.reviews  = res.data.reviews;
                        })
                }
            }
        })


        var chat_area = new Vue({
            el:'#chat_area',
            data:{
                message:{},
                messages:[],
                conversation_user:{}
            },
            created:function(){
                console.log("the conversation vue has been created")
                this.getConversations();
            },
            methods:{
                getConversations(){
                    let url = '{{route('writer.orders.messages',$order->id)}}';
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.conversation_user  = res.data.conversation_user;
                            me.messages  = res.data.messages;
                            me.message.conversation_id  = res.data.conversation.id;
                        })

                },
                sendMessage:function(){
                    let url = '{{route('writer.orders.save_messages',$order->id)}}'
                    let me = this;
                    axios.post(url,this.message)
                        .then(function(res){
                            me.message={}
                        })


                }
            }
        });
        Thunder.connect("eneza.neverest.co.ke", "MhPN3ItPqy", ["{{$order->id}}","homepro_user_{{Auth::id()}}"], {log: true});
        Thunder.listen(function(message) {
            this.getClientOrders();
            // alert(message);

        });

        Thunder.connect("eneza.neverest.co.ke", "MhPN3ItPqy", [chat_area.message.conversation_id,"homepro_user_{{Auth::id()}}"], {log: true});
        Thunder.listen(function(message) {
            this.getClientOrders();
            // alert(message);

        });
    </script>
    @endsection