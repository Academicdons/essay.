@extends('layouts.writer')

@section('style')

    <style type="text/css">
        .border-right{
            border-right: 1px solid gray;
        }


        .rating{
            font-size: 30px;
            color: orange;
        }

        table{
            font-size: 14px;
        }

        h5,h6{
            font-weight: bold;
            color: #23c0e9;

        }

        h6 i{
            color: #23c0e9;
        }

        .comments-main{
            background: #FFF;
        }
        .comment time, .comment:hover time,.icon-rocknroll, .like-count {
            -webkit-transition: .25s opacity linear;
            transition: .25s opacity linear;
        }
        .comments-main ul li{
            list-style: none;
        }
        .comments .comment {
            padding: 5px 10px;
            background: #00AF90;
        }
        .comments .comment:hover time{
            opacity: 1;
        }
        .comments .user-img img {
            width: 50px;
            height: 50px;
        }
        .comments .comment h4 {
            display: inline-block;
            font-size: 16px;
        }
        .comments .comment h4 a {
            color: #404040;
            text-decoration: none;
        }
        .comments .comment .icon-rocknroll {
            color: #545454;
            font-size: .85rem;
        }
        .comments .comment .icon-rocknroll:hover {
            opacity: .5;
        }
        .comments .comment time,.comments .comment .like-count,.comments .comment .icon-rocknroll {
            font-size: .75rem;
            opacity: 0;
        }
        .comments .comment time, .comments .comment .like-count {
            font-weight: 300;
        }
        .comments .comment p {
            font-size: 13px;
        }
        .comments .comment p .reply {
            color: #BFBFA8;
            cursor: pointer;
        }
        .comments .comment .active {
            opacity: 1;
        }
        .icon-rocknroll {
            background: none;
            outline: none;
            cursor: pointer;
            margin: 0 .125rem 0 0;
        }
        .comments .comment:hover .icon-rocknroll,.comments .comment:hover .like-count {
            opacity: 1;
        }
        .comment-box-main{
            background: #CA1D5F;
        }
        @media (min-width: 320px) and (max-width: 480px){
            .comments .comment h4 {
                font-size: 12px;
            }
            .comments .comment p{
                font-size: 11px;
            }
            .comment-box-main .send-btn button{
                margin-left: 5px;
            }
        }


        .upload-area{
            min-height: 200px;
            width: 100%;
            text-align: center;
            border: 2px dashed dodgerblue;
            margin-bottom: 10px;
        }


    </style>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>

@endsection

@section('content')

    <div class="row">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="box-title">Order No. {{ $order->order_no }} <span class="text-aqua font-weight-bold">{{ $order->title }}</span></label>
                        </div>
                        <div class="col-sm-6 text-right text-success">
                            <button class="btn btn-outline-warning btn-sm" data-toggle="modal" data-target="#reviewsModal"><i class="fa fa-comment"></i> reviews</button>
                            <button class="btn btn-outline-success btn-sm" data-toggle="modal" data-target="#chatModal"><i class="fa fa-envelope"></i> messages</button>
                        </div>
                    </div>
                    <hr style="margin-top: 0px;">

                    <!--start order details section-->

                    <div class="row mt-5">
                        <div class="col-sm-12">
                            <h6><i class="fa fa-clipboard"></i> Order details</h6>
                        </div>
                        <div class="col-sm-12">
                            <div class="table-responsive light-border">

                                <table class="table table-borderless">
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

                                <tr>
                                    <td>Number of sources</td>
                                    <th>{{ $order->no_of_sources }}</th>
                                    <td colspan="3">
                                        Deadline: <span id="deadline"></span>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                    <td colspan="3">
                                        Bid expiry: <span id="bid_expiry"></span>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6><i class="fa fa-file-pdf-o"></i> Instructions/ notes</h6>
                        </div>
                        <div class="col-sm-12">
                            <div class="light-border p-2">
                                {!! $order->notes !!}
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-sm-12">
                            <h6><i class="fa fa-file-pdf-o"></i> Attachments/ files <span class="pull-right mini-btn" data-toggle="modal" data-target="#uploadModal"><i class="fa fa-cloud-upload"></i> upload files</span></h6>
                        </div>
                        <div class="col-sm-12">
                            <div class="light-border">
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
                                                <td><a href="{{asset('uploads/files/order_files/'. $attachment->file_name)}}" class="btn btn-warning btn-sm" download>
                                                        <i class="fa fa-cloud-download"></i>
                                                    </a></td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>


    <!--Chat moadal-->
    <div class="modal fade" id="chatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content" id="chat_area">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Order conversation</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="padding-bottom: 0px">



                    <div class="comments-main rounded" >
                        <div class="messages-div" style="max-height: 400px;overflow: auto;">
                            <ul class="p-0">
                                <div v-for="msg in messages" v-cloak>
                                    <li v-if="msg.user.id == conversation_user.id">
                                        <div class="row comments mb-2">
                                            <div class="col-md-2 col-sm-2 col-3 text-center user-img">
                                                <img id="profile-photo" src="http://nicesnippets.com/demo/man01.png" class="rounded-circle" />
                                            </div>
                                            <div class="col-md-9 col-sm-9 col-9 comment rounded mb-2">
                                                <h4 class="m-0"><a href="#">@{{ msg.user.name }}</a></h4>
                                                <time class="text-white ml-3">@{{ msg.created_at }}</time>
                                                <like></like>
                                                <p class="mb-0 text-white">@{{ msg.message }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <ul v-if="msg.user.id != conversation_user.id" class="p-0">
                                        <li>
                                            <div class="row comments mb-2">
                                                <div class="col-md-2 offset-md-2 col-sm-2 offset-sm-2 col-3 offset-1 text-center user-img">
                                                    <img id="profile-photo" src="http://nicesnippets.com/demo/man02.png" class="rounded-circle" />
                                                </div>
                                                <div class="col-md-7 col-sm-7 col-8 comment rounded mb-2">
                                                    <h4 class="m-0"><a href="#">@{{ msg.user.name }}</a></h4>
                                                    <time class="text-white ml-3">@{{ msg.created_at }}</time>
                                                    <like></like>
                                                    <p class="mb-0 text-white">@{{ msg.message }}</p>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </ul>
                        </div>


                        <div class="row comment-box-main p-3 rounded-bottom">
                            <div class="col-md-9 col-sm-9 col-9 pr-0 comment-box">
                                <input type="text" class="form-control"  v-model="message.message" id="message_input" name="message" placeholder="Type Message ..."  />
                            </div>
                            <div class="col-md-3 col-sm-2 col-2 pl-0 text-center send-btn">
                                <button type="button" id="send_btn" data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Sending..." class="btn btn-info" @click="sendMessage()">Send</button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <!--All reviews modal-->
    <div class="modal fade" id="reviewsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Orders reviews</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" id="review_area" v-if="reviews.length<=0">

                        <div class="col-sm-12">
                            <div class="alert alert-info">
                                There are no reviews for this order yet!
                            </div>
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Dismiss</button>
                </div>
            </div>
        </div>
    </div>

    <!--Uploads modal-->
    <div class="modal fade" id="uploadModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">

                <div class="modal-body">
                    <div class="upload-area" id="upload-area">
                        <p class="text-center" style="margin-top:95px">
                            <i class="fa fa-cloud-upload"></i> Click here or drop files to upload
                        </p>
                    </div>

                    <div class="progress">
                        <div id="upload_progress" class="progress-bar progress-bar-primary progress-bar-striped" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 5%">
                            <span class="sr-only">40% Complete (success)</span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

@stop


@section('script')
    <script src="{{asset('plugins/rater/rater.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/resumable.js')}}"></script>

    <script>

        //TODO configure the review area and deadline progress bars
        var revision_area=new Vue({
            el:'#revision_content',
            data:{
                deadline:moment.utc('{{$order->writer_deadline}}').local().startOf('hour').fromNow(),
                expiry:moment.utc('{{$order->bid_expiry}}').local().startOf('hour').fromNow(),
                revision:{},
                deadliner:''
            },
            created:function(){
                var url43='{{url('writer/orders/get_revision_deadline')}}'+'/'+'{{$order->id}}';
                let me=this;
                axios.get(url43)
                    .then(function (res) {
                        me.revision=res.data.revision;
                        // me.deadliner=res.data.revision.deadline
                        if (res.data.revision.deadline==null || res.data.revision.deadline===''){
                            me.deadliner='No deadline'
                        } else{
                            me.deadliner=res.data.revision.deadline;
                        }
                        console.log(me.revision)
                    })
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

            /*
            pass the deadlines and bid expiry to the views
             */
            let deadline = moment.utc('{{$order->writer_deadline}}').local().startOf('hour').fromNow();
            let bid_expiry = moment.utc('{{$order->bid_expiry}}').local().startOf('hour').fromNow();
            $('#deadline').text(deadline)
            $('#bid_expiry').text(bid_expiry)

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
                    Pace.restart();
                    axios.post(url,this.message)
                        .then(function(res){
                            me.message.message=null;
                            Pace.stop();
                        })
                        .catch(res=>{
                            Pace.stop();
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

    <script type="text/javascript">
        var r = new Resumable({
            target: '{{route('writer.orders.upload',$order->id)}}'
        });
        r.assignBrowse(document.getElementById('upload-area'));

        r.on('fileProgress', function(file){
            var p =(r.progress()*100).toFixed(2);
            $('#upload_progress').css('width',p+"%")
            $('#upload_progress').text(p + "%")
        });

        r.on('complete', function(){
            $('.active-upload').hide()
            window.location.reload()
        });

        r.on('fileAdded', function(file, event){
            $('.active-upload').show()
            r.upload();
        });
    </script>
    @endsection