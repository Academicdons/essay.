@extends('layouts.index')

@section('style')

    <style>
        .chat_window {
            width: calc(100% - 20px);
            min-height: 500px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            background-color: #f8f8f8;
            overflow: hidden;
        }

        .top_menu {
            background-color: #fff;
            width: 100%;
            padding: 20px 0 15px;
            box-shadow: 0 1px 30px rgba(0, 0, 0, 0.1);
        }
        .top_menu .buttons {
            margin: 3px 0 0 20px;
            position: absolute;
        }
        .top_menu .buttons .button {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 10px;
            position: relative;
        }
        .top_menu .buttons .button.close {
            background-color: #f5886e;
        }
        .top_menu .buttons .button.minimize {
            background-color: #fdbf68;
        }
        .top_menu .buttons .button.maximize {
            background-color: #a3d063;
        }
        .top_menu .title {
            text-align: center;
            color: #bcbdc0;
            font-size: 20px;
        }

        .messages {
            position: relative;
            list-style: none;
            padding: 20px 10px 0 10px;
            margin: 0;
            height: 347px;
            overflow: scroll;
        }
        .messages .message {
            clear: both;
            overflow: hidden;
            margin-bottom: 20px;
            transition: all 0.5s linear;
            opacity: 0;
        }
        .messages .message.left .avatar {
            background-color: #f5886e;
            float: left;
        }
        .messages .message.left .text_wrapper {
            background-color: #ffe6cb;
            margin-left: 20px;
        }
        .messages .message.left .text_wrapper::after, .messages .message.left .text_wrapper::before {
            right: 100%;
            border-right-color: #ffe6cb;
        }
        .messages .message.left .text {
            color: #c48843;
        }
        .messages .message.right .avatar {
            background-color: #fdbf68;
            float: right;
        }
        .messages .message.right .text_wrapper {
            background-color: #c7eafc;
            margin-right: 20px;
            float: right;
        }
        .messages .message.right .text_wrapper::after, .messages .message.right .text_wrapper::before {
            left: 100%;
            border-left-color: #c7eafc;
        }
        .messages .message.right .text {
            color: #45829b;
        }
        .messages .message.appeared {
            opacity: 1;
        }
        .messages .message .avatar {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-block;
        }
        .messages .message .text_wrapper {
            display: inline-block;
            padding: 20px;
            border-radius: 6px;
            width: calc(100% - 85px);
            min-width: 100px;
            position: relative;
        }


        .messages .message .text_wrapper::after, .messages .message .text_wrapper:before {
            top: 18px;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }
        .messages .message .text_wrapper::after {
            border-width: 13px;
            margin-top: 0px;
        }
        .messages .message .text_wrapper::before {
            border-width: 15px;
            margin-top: -2px;
        }
        .messages .message .text_wrapper .text {
            font-size: 14px;
            font-weight: 300;
            color: black;
        }

        .btn-send{
            border-radius: 0px !important;
        }

        .area-send{
            border-radius: 0px !important;

        }

        .table-striped tr:nth-child(odd){
            background: lightgrey !important;
        }

        .order {
            /* Add shadows to create the "card" effect */
            padding: 10px;
            margin-top: 10px;
        }

        .order h4 span{
            font-weight: normal;
            font-size: 16px;
        }

        .order h4{
            font-weight: bold;
            font-size: 16px;
        }

        .order .col-sm-4:nth-child(1){
        }

        .order .col-sm-4:nth-child(2){
        }

        .order .col-sm-4:nth-child(3){
        }

        .table-sm th,td{
            padding: 5px !important;
        }

        .text-light-blue{
            color: deepskyblue !important;
        }

        .file-card{
            
        }

        .file-card .bottom{
            border-top: 1px solid whitesmoke;
            margin-bottom: 10px;
        }
        .rating{
            font-size: 30px;
            color: orange;
        }



    </style>
    <link rel="stylesheet" href="{{asset('bstpick/css/bootstrap-datetimepicker.css')}}">

    @endsection

@section('content')

    <div class="container">

        <div class="row">
            <div class="col-sm-8" id="order_area">

                <div class="row">
                    <div class="col-sm-12">
                        <h6 class="mt-3">Order details</h6>

                    </div>

                </div>

                <div class="order box box-solid" v-if="order">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4"><h4 class="text-light-blue">@{{ order.title }}</h4></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-4"><h4>ID: <span>@{{ order.order_no }}</span></h4></div>
                            <div class="col-sm-4"><h4></h4></div>
                            <div class="col-sm-4"><h4 style="">Duration: <span v-bind:class="getDeadlineClass(order.deadline)">@{{ getTimedifference(order.deadline) }}</span></h4></div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <table class="table table-sm table-striped">
                                    <tr>
                                        <td>Discipline</td><th><span v-if="order.discipline!=null">@{{ order.discipline.name }}</span></th>
                                    </tr>
                                    <tr>
                                        <td>Education level</td><th><span v-if="order.education!=null">@{{ order.education.name }}</span></th>
                                    </tr>
                                    <tr>
                                        <td>Paper type</td><th><span v-if="order.paper!=null">@{{ order.paper.name }}</span></th>
                                    </tr>
                                    <tr>
                                        <td>Status</td><th><p v-bind:class="getStatusClass(order.status)">@{{ getStatusString(order.status) }}</p></th>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-sm-6">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-sm table-striped">
                                            <tr>
                                                <td>No of words</td><th>@{{ order.no_words }}</th>
                                            </tr>
                                            <tr>
                                                <td>Pages</td><th>@{{ order.no_pages }}</th>
                                            </tr>
                                            <tr>
                                                <td>CPP</td><th>@{{ order.cpp }}</th>
                                            </tr>
                                            <tr>
                                                <td>Amount</td><th>@{{ order.amount }}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>

                    </div>
                </div>
                <div class="row pt-1 pb-1">
                    <div class="col-sm-12">
                        <button class="btn-success btn-sm float-right" v-if="order.status<4" data-toggle="modal" data-target="#rateModal">Complete order</button>
                        <button class="btn-danger btn-sm float-right mr-3" data-toggle="modal" data-target="#revisionModal">Request a revision</button>


                    </div>
                </div>

                <h6>Files</h6>
                <div class="row p-2">
                    <div class="col-lg-3 col-md-4 mb-2 col-sm-2 file-card" v-for="file in files">
                        <div class="card">
                            <p class="small text-center font-weight-bold p-1">@{{ file.display_name.substring(0,10) }}...</p>
                            <img src="https://static.thenounproject.com/png/47347-200.png" class="img-fluid" alt="">
                            <div class="bottom text-center pt-2 pb-2">
                                <a :href="'{{asset('uploads/files/order_files')}}'+'/'+file.file_name" download><i class="fa fa-cloud-download"></i></a>
                                <a href="javascript:;" @click="deleteFile(file.id)" class="ml-5"><i class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-4 col-sm-2 file-card"  >
                        <div class="card" id="upload-area">
                            <label for="add_file">
                                <p class="small text-center font-weight-bold text-light-blue p-1">Add a new file</p>
                                <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQuxEYuRw5af-5irXjNfOAZp2Ek7CQRZLvwOwTCElIzQlbcnxa8" class="img-fluid" alt="">
                            </label>
                            <div class="bottom text-center pt-2 pb-2" style="min-height: 34px;">
                                <div class="active-upload" style="display: none">
                                    <div class="progress">
                                        <div class="progress-bar" style="width:0%">0%</div>
                                    </div>
                                </div>
                                <input type="file" style="display: none;" name="file" id="add_file" @change="uploadFile()">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="row">
                    <div class="col-sm-6 border-right">
                        <h6>Your review:</h6>
                        <div class="alert alert-info" v-if="client_review==null">
                            <p class="small">You have not made any review yet!</p>
                        </div>
                        <div class="col-md-12" v-if="client_review">

                            <p>
                                <span class="float-left" v-for="star in Math.ceil(client_review.rating)"><i class="text-success fa fa-star"></i></span>
                                <span class="float-left" v-for="star in (10-Math.ceil(client_review.rating))"><i class="fa fa-star"></i></span>


                            </p>
                            <div class="clearfix"></div>
                            <p>@{{ client_review.review }}</p>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <h6>Writers review:</h6>
                        <div class="alert alert-info" v-if="other_review==null">
                            <p class="small">Order is still in progress</p>
                        </div>

                        <div class="col-md-12" v-if="other_review">
                            <p>
                                <span class="float-left" v-for="star in Math.ceil(other_review.rating)"><i class="text-success fa fa-star"></i></span>
                                <span class="float-left" v-for="star in (10-Math.ceil(other_review.rating))"><i class="fa fa-star"></i></span>

                            </p>
                            <div class="clearfix"></div>
                            <p>@{{ other_review.review }}</p>
                        </div>
                    </div>
                </div>

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
                                <p>Help us improve the quality of our service by providing a review</p>
                                <p class="text-center">Rate the quality of work</p>
                                <div class="rating mx-auto"></div>
                                <p class="text-center">Review the quality of work</p>
                                <textarea v-model="review.review" class="form-control" placeholder="The writer understood the task and delivered as instruc..."></textarea>

                                <p class="text-center">
                                    <button @click="submitReview()" class="btn btn-success mt-3">Submit review</button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal" id="revisionModal" tabindex="-1" role="dialog">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Request a revision</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <p>Provide a reason for the request and suggest improvements to be done on the revised work</p>
                                <input type="hidden" v-model="revision.tz" name="tz" id="tz">

                                <textarea v-model="revision.reason" style="min-height: 200px" class="form-control" placeholder="Example: I would like the page numbers included too, thanks"></textarea>

                                <div class="row">

                                    <div class="form-group col-sm-6">
                                        <label for="">Deadline</label>
                                        <div class='input-group date' >
                                            <input type='text' id='deadline' name="deadline" v-model="revision.deadline" class="form-control" />
                                            <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                        </div>
                                    </div>



                                    {{--<div class="form-group col-sm-6">--}}
                                        {{--<label>Deadline</label>--}}
                                        {{--<input id="deadline" name="deadline" v-model="revision.deadline" class="form-control" >--}}
                                    {{--</div>--}}
                                </div>
                                <p class="text-center">
                                    <button @click="requestRevision()" class="btn btn-success mt-3">Submit revision request</button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>
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

                                {{--@{{ order.id }}--}}
                                <p class="text-center">
                                    <button @click="requestDispute()" class="btn btn-success mt-3">Submit Dispute request</button>
                                </p>

                            </div>
                        </div>
                    </div>
                </div>


            </div>
            <div class="col-sm-4 pt-5 pb-5" id="chat_area">
                <div class="chat_window">
                    <div class="top_menu">
                        <div class="buttons">
{{--                            <div class="button close"></div><div class="button minimize"></div><div class="button maximize"></div>--}}
                        </div>
                        <div class="title">Order Chat</div>
                    </div>
                    <ul class="messages" id="messages">
                        <li v-bind:class="getMessageClass(msg.user_id)" v-for="msg in messages">
                            <div class="avatar">
                            </div>
                            <div class="text_wrapper">
                                <div class="text">@{{ msg.message }}</div>
                            </div>
                        </li>
                    </ul>
                    <div class="bottom_wrapper">
                        <div class="row">
                            <div class="col-sm-12 pl-3 pr-3 text-center">
                                <textarea name="message" v-model="message.message" class="form-control area-send" style="height: 100px" placeholder="Type your message here" id="" cols="30" rows="10"></textarea>
                                <button @click="sendMessage()" class="btn btn-success btn-block btn-send">Send message</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="message_template">
                    <li class="message">
                        <div class="avatar">
                        </div><div class="text_wrapper">
                            <div class="text"></div>
                        </div>
                    </li>
                </div>

                <p>
                    Keep in touch with the progress of your tasks. Raise any questions to our professional writer and suggestions to perfect the output
                </p>
            </div>
        </div>

    </div>

    <hr>




    @endsection


@section('script')

    <script type="text/javascript" src="{{asset('js/resumable.js')}}"></script>
    <script src="{{asset('plugins/rater/rater.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jstz.min.js')}}"></script>

    <script src="{{ asset('bower_components/moment/moment.js') }}"></script>
    <script src="{{asset('bstpick/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script>



        $(function () {


            $('#deadline').datetimepicker({
                format:'DD/MM/YYYY H:mm:ss'
            });



            //or for example
            var options = {
                max_value: 10,
                step_size: 1,
                initial_value: 9,

            };
            $(".rating").rate(options);
            $(".rating").on("change", function(ev, data){
                window.order_area.updateRating(data.to)
            });
        })

        var r = new Resumable({
            target: '{{url('/upload_order_files')}}'+"?order="+'{{$order->id}}'
        });

        r.assignBrowse(document.getElementById('upload-area'));

        r.on('fileProgress', function(file){
            var p =(r.progress()*100).toFixed(2);
            $('.progress-bar').css('width',p+"%")
            $('.progress-bar').text(p + "%")
        });

        r.on('complete', function(){
            $('.active-upload').hide()
            window.order_area.getOrder()
        });

        r.on('fileAdded', function(file, event){
            $('.active-upload').show()
            r.upload();
        });




        window.order_area = new Vue({
            el:'#order_area',
            data:{
                order:null,
                message:{},
                messages:[],
                files:[],
                revision:{},
                review:{},
                client_review:null,
                other_review:null,
                dispute_reason:'',
                dispute:{},
                existing_disputes:[]
            },
            created:function () {
                console.log("Order vue created");
                this.getOrder();
                this.getOrderReviews();
                this.getDisputes();
            },
            methods:{
                getOrder:function(){
                    console.log(1   )
                    let url='{{route('customer.orders.fetch_order',$order->id)}}';
                    let me = this
                    axios.get(url)
                        .then(function (res) {
                            me.order=res.data.order
                            me.files=res.data.files.attachments
                        })
                },
                getDisputes(){
                    let url='{{route('customer.orders.fetch_disputes',$order->id)}}';
                    let me = this
                    axios.get(url)
                        .then(function (res) {
                            me.existing_disputes=res.data.disputes;
                        })
                },
                getTimedifference:function (order_date) {
                    let x = moment.utc(order_date).local()
                    let y = moment.now()
                    let duration = x.diff(y)
                    return moment.utc(duration).format('h[h] m[m] s[s]')
                },
                getDeadlineClass:function (order_date) {
                    let x = moment.utc(order_date).local()
                    let y = moment.now()
                    let duration = moment.duration(x.diff(y)).asHours();
                    if(duration<0){
                        return "deadline-default"
                    }else if(duration<20){
                        return "deadline-danger"
                    }else if(duration<72){
                        return "deadline-warning"
                    }else{
                        return "deadline-success"
                    }

                },
                getStatusString:function(status){
                    if(status==1){
                        return "in-progress"
                    }else if(status==2){
                        return "revision"
                    }else if(status==3){
                        return "assessment"
                    }else if(status==4){
                        return "Finished"
                    }else if(status==5){
                        return "Disputed"
                    }else{
                        return "processing"
                    }
                },
                getStatusClass:function(status){
                    if(status==1){
                        return "text-primary"
                    }else if(status==2){
                        return "text-warning"
                    }else if(status==3){
                        return "text-success"
                    }else if(status==4){
                        return "text-success"
                    }else if(status==5){
                        return "text-warning"
                    }else{
                        return "text-default"
                    }
                },
                uploadFile:function(){
                    r.addFile(document.getElementById('add_file').files[0])
                },
                deleteFile:function (id) {
                    let url='{{url('customer/orders/delete_file')}}'+"?attachment="+id
                    let me =this;
                    axios.get(url)
                        .then(function (res) {
                            me.getOrder()
                        })
                },
                requestRevision:function () {

                    var tz = jstz.determine();

                    this.revision.tzone=tz.name();
                    let url = '{{route('customer.orders.revision',$order->id)}}';
                    let me = this;
                    axios.post(url,this.revision)
                        .then(function (res) {
                            me.getOrder();
                            $('#revisionModal').modal('hide')
                        })

                },
                requestDispute:function(){
                    let url = '{{route('customer.orders.dispute_order',$order->id)}}';
                    // let order_id=
                    let me = this;
                    axios.post(url,{'dispute_reason':this.dispute_reason,'order_id':this.order.id})
                        .then(function (res) {
                            me.dispute=res.data.dispute;
                            me.getOrder();
                            $('#disputedModal').modal('hide')
                        })
                },
                updateRating:function (rate) {
                    this.review.rating=rate
                },
                submitReview:function () {
                    let url = '{{route('customer.orders.review',$order->id)}}'
                    let me = this;
                    axios.post(url,this.review)
                        .then(function (res) {
                            me.getOrderReviews();
                            $('#rateModal').modal('hide');
                            if(res.data.success){
                                window.location.reload()
                            }else{
                                alert('You have reviewd this order already')
                                window.location.reload()
                            }
                        })
                },
                getOrderReviews:function () {
                    let url = '{{route('customer.orders.reviews',$order->id)}}'
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.client_review = res.data.client_review
                            me.other_review = res.data.other_review
                        })
                }
            }
        })

        window.message_area = new Vue({
            el:'#chat_area',
            data:{
                message:{},
                conversation_user:{},
                messages:[]
            },
            created:function(){
                console.log("Created chat vue")
                this.getConversations();
            },
            methods:{
                getConversations(){
                    let url = '{{route('customer.orders.messages',$order->id)}}';
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.conversation_user  = res.data.conversation_user;
                            me.messages  = res.data.messages;
                            me.message.conversation_id  = res.data.conversation.id;
                            console.log(res.data.conversation.id)
                            thunderListen(res.data.conversation.id)
                            var elem = document.getElementById('messages');
                            elem.scrollTop = elem.scrollHeight;
                        })

                },
                sendMessage:function(){
                    let url = '{{route('customer.orders.save_message',$order->id)}}'
                    let me = this;
                    axios.post(url,this.message)
                        .then(function(res){
                            me.message={}
                            me.getConversations()
                        })
                },
                getMessageClass:function (id) {
                    if(id == this.conversation_user.id){
                        return "message right appeared"
                    }else{
                        return "message left appeared"
                    }
                }
            }
        });

        function thunderListen(conv_id){
            console.log(conv_id);
            Thunder.connect("eneza.neverest.co.ke", "MhPN3ItPqy", [conv_id,"homepro_user_{{Auth::id()}}"], {log: true});
            Thunder.listen(function(message) {
                window.message_area.getConversations();

            });
        }

    </script>

    @endsection