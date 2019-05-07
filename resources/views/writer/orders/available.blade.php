@extends('layouts.writer')

@section('page')
    Available orders
    @endsection

@section('style')

    @endsection


@section('content')



    <div class="row">
        <div class="col-sm-12">
            <h5 class="heading">Available orders</h5>
        </div>
    </div>

    <!-- Available orders -->
    <div class="row" id="available_container">
        <div class="col-sm-6 mb-3 col-md-6" v-for="order in orders">
            <a :href="'{{url('/writer/orders/view')}}/' + order.id">
            <div class="row p-3">
                <div class="col-sm-12 available-order">
                    <div class="row mt-2 mb-2">
                        <div class="col-sm-3 border-right"><label for="">Order ID:</label><span> @{{ order.order_no }}</span></div>
                        <div class="col-sm-6"><label for="">Deadline</label><span> @{{ moment.utc(order.writer_deadline).local().format("dddd,Do M-YYYY, h:mm:ss a")  }}</span></div>
                        <div class="col-sm-3 border-left"><label for="">Salary</label><span> $@{{ order.salary }}</span></div>
                    </div>
                    <div class="row mb-3 mt-2">
                        <div class="col-sm-12">
                            <label>Title:</label><label class="title">@{{ order.title }}</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 bottom-bar">
                            <div class="row">
                                <div class="col-sm-4 pt-2">
                                    <p class="small text-center">Discipline: <span v-if="order.discipline!=null">@{{ order.discipline.name }}</span> </p>
                                </div>
                                <div class="col-sm-4 pt-2">
                                    <p class="small text-center">Education level: <span v-if="order.education!=null">@{{ order.education.name }}</span></p>
                                </div>
                                <div class="col-sm-4 pt-1">
                                    <p class="small text-center">Pages/Words: @{{ order.no_pages }}/@{{ order.no_words }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </a>

        </div>
    </div>


    @endsection

@section('script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script>

        window.av_orders=new Vue({
            el:'#available_container',
            data:{
                'orders':[]
            },
            created:function () {
                let url='{{url('writer/orders/available_orders_json')}}';
                let me=this;
                axios.get(url)
                    .then(res=>{
                        me.orders=res.data.orders;
                    })
                    .catch(err=>{

                    });
            },
            methods:{
                getClientOrders:function () {
                    let url = '{{route('customer.orders.get_orders')}}';
                    let me = this;
                    axios.get(url)
                        .then(function (res) {
                            me.orders = res.data.orders
                        })
                },

                getStatusString:function(status){
                    if(status==1){
                        return "in-progress"
                    }else if(status==2){
                        return "revision"
                    }else if(status==3){
                        return "completing"
                    }else{
                        return "processing"
                    }
                },



                dateConverter:function (date) {
                  return  moment(date).format("dddd, MMMM Do YYYY, h:mm a")
                },

                getTimedifference:function (order_date) {
                    let x = moment.utc(order_date).local()
                    return x.fromNow();
                },
                getDeadlineClass:function (order_date) {
                    let x = moment.utc(order_date).local();
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

                }
            }
        });

        Thunder.connect("157.230.213.22:8080", "MhPN3ItPqy", ["orders","homepro_user_{{Auth::id()}}"], {log: true});
        Thunder.listen(function(message) {
            window.av_orders.getClientOrders();

        });
    </script>
    @endsection