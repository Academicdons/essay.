@extends('layouts.admin')

@section('style')

    <style class="text/css">

        .padding-top{
            padding-top: 15px;
        }

        .border-right{
            border-right: 1px solid #c0c0c0;
        }

        .stat{
            width: 100%;
            padding-top: 10px;
            padding-bottom: 10px;
            text-align: center;
            border-radius: 3px;
        }

        .stat h3,h4,h5{
            margin-top: 7px !important;
            margin-bottom: 7px !important;
        }

        .stat-blue{
            border: 2px solid dodgerblue;
        }

        .stat-blue .label{
            color: forestgreen;
        }

        .stat h3{
            font-weight: bold;
            font-size: 38px;
        }

        .stat h5{
            font-weight: bold;
            font-size: 20px;
        }

        .rating{
            font-size: 30px;
            color: orange;
        }


    </style>
    @endsection

@section('content')
    <section class="content-header">
        <h1>
            Users
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Users</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">All users</h3>
                        <div class="box-tools">
                            <a href="{{route('admin.users.create')}}" class="btn btn-sm btn-info">Add users</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table id="example2" class="table table-bordered table-hover dataTable" role="grid" aria-describedby="example2_info">
                            <thead>
                            <tr role="row">
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">No.</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Email</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Ratings</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Phone numbers</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Orders</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Account</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                    <tr role="row" class="odd">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                        <td>{{ $user->ratings }}</td>
                                        <td>{{ $user->phone_number }}</td>
                                        <td>
                                            @if($user->user_type==1)
                                                {{$user->assignments->count()}}
                                            @else
                                                {{$user->clientOrders->count()}}
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->account_status == 1)
                                                <a href="{{route('admin.users.status',[0,$user->id])}}"><span class="label label-success">active</span></a>
                                            @else
                                                <a href="{{route('admin.users.status',[1,$user->id])}}"><span class="label label-warning">deactivated</span></a>
                                                @endif
                                        </td>
                                        <td>
                                            <a href="{{route('admin.users.edit',[$user->id])}}"><i class="fa fa-edit"></i></a>
                                            <a href="javascript:;" onclick="loadUser('{{$user->id}}')"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                            <tr>
                                <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column descending">No.</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending">Name</th>
                                <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">Action</th>
                            </tr>
                            </tfoot>
                                </table>
                                </div>
                            </div>

                    </div>
                </div>
            </div>
        </div>
        </div>

        <div class="modal fade" id="disciplinesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="z-index: 100000000000;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title" id="album_name"></div>
                        </div>

                        <div class="box-body">
                            <form method="POST" action="{{ route('admin.discipline.add') }}">
                                @csrf

                                <input type="hidden" name="id" id="id" value="{{ old('id') }}">

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

    <div id="profileModal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-lg">

            <!-- Modal content-->
            <div class="modal-content" id="profile">
                <div class="modal-header">

                    <div style="float: left">
                        <img src="{{asset('images/logo2.png')}}" width="25" height="25" alt="">
                        <span class="h3 font-weight-bold">User profile</span>
                    </div>
                    <div style="float: right">
                        <button type="button" class="btn btn-sm btn-info" id="downloadLog" translate>Deactivate</button>
                        <button type="button" class="btn btn-sm btn-success" id="downloadLog" translate>Activate</button>

                    </div>
                </div>
                <div class="modal-body"  v-if="user!=null">

                    <div class="row" style="padding-left: 20px;padding-right: 20px">
                        <div class="col-sm-4 border-right">
                            <h4>Bio information</h4>
                            <img src="https://hips.hearstapps.com/hbz.h-cdn.co/assets/cm/14/52/54991fbc44f03_-_hbz-met-gala-2014-beauty-michelle-williams-promo.jpg" class="img img-responsive" alt="">

                            <h3 class="font-weight-bold text-primary">@{{ user.name }}</h3>
                            <p><i class="fa fa-envelope"></i> @{{ user.email }}</p>
                            <p><i class="fa fa-phone-square"></i> @{{ user.phone_number }}</p>
                            <p><i class="fa fa-calendar"></i> @{{ user.date_of_birth }}</p>

                        </div>
                        <div class="col-sm-8">

                            <h4 class="font-weight-bold">@{{ user.name }}</h4>
                            <p><span class="font-weight-bold">Education level</span> <span class="label label-primary">University</span></p>
                            <h4 class="padding-top">Ratings @{{user.ratings}}</h4>
                            <div class="rating mx-auto"></div>

                            <span class="float-right h3" v-for="star in Math.ceil(user.ratings)"><i class="text-orange fa fa-star"></i></span>
                            <span class="float-right h3" v-for="star in (10-Math.ceil(user.ratings))"><i class="fa fa-star"></i></span>

                            <hr>
                            <h4>User account statistics</h4>


                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="stat stat-blue">
                                        <h5 class="label">Balance</h5>
                                        <h3>$40</h3>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="stat stat-blue">
                                        <h5 class="label">Orders</h5>
                                        <h3>2</h3>
                                    </div>
                                </div>

                                <div class="col-sm-4">
                                    <div class="stat stat-blue">
                                        <h5 class="label">In progress</h5>
                                        <h3>0</h3>
                                    </div>
                                </div>

                            </div>

                            <br>
                            <h4>Payment information</h4>
                            <table class="table table-striped">
                                <tr>
                                    <th>Mpesa name</th><td><span v-if="user.payment_information!=null">@{{ user.payment_information.mpesa_name }}</span></td>
                                    <th>Mpesa number</th><td><span v-if="user.payment_information!=null">@{{ user.payment_information.mpesa_number }}</span></td>
                                </tr>
                                <tr>
                                    <th>Id number</th><td><span v-if="user.payment_information!=null">@{{ user.payment_information.id_number }}</span></td>
                                    <th>Bank name</th><td><span v-if="user.payment_information!=null">@{{ user.payment_information.bank_name }}</span></td>
                                </tr>
                                <tr>
                                    <th>Account number</th><td><span v-if="user.payment_information!=null">@{{ user.payment_information.account_number }}</span></td>
                                </tr>
                            </table>

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
@stop

@section('script')
    <script src="{{asset('js/vue_rate.js')}}"></script>

    <script>

        $(function () {


        })

        function editDiscipline(discipline_id) {
            var base_url = '{{ route('admin.discipline.index') }}';
            var url = base_url + '/edit'+'/'+discipline_id;

            axios.get(url)
                .then(function (res) {
                    console.log(res);

                    $('#id').val(res.data.discipline.id);
                    $('#name').val(res.data.discipline.name);
                    $('#disciplinesModal').modal('show');
                })
        }

        function loadUser(id){
            window.profile_vue.getUserProfile(id);
        }

        window.profile_vue = new Vue({
            el:'#profile',
            data:{
                user:null
            },
            created:function(){
                console.log('ceated-user-profile-vue')
            },
            methods: {
                getUserProfile:function(id){
                    let url = '{{route('admin.users.profile')}}'+"?user="+id;
                    let me = this;
                    axios.get(url)
                        .then(res=>{
                            me.user = res.data;
                            $('#profileModal').modal('show');
                            me.setUpRating(me.user.ratings)
                        })
                },
                setUpRating:function(value){

                }
            }
        })
    </script>
@stop