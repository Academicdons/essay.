@extends('layouts.writer')

@section('page')
    Available orders
@endsection

@section('style')
    <link href="{{asset('plugins/jasny-bootstrap/css/jasny-bootstrap.css')}}" rel="stylesheet" />

    <style type="text/css">

        .table-striped tr:nth-child(odd){
            background: lightgrey !important;
        }



        .order h4 span{
            font-weight: bold;
        }

        .order h4{
            font-weight: bold;
        }

        .order .col-sm-4:nth-child(1){
            padding-right: 0px !important;
        }

        .order .col-sm-4:nth-child(2){
            padding-right: 2px !important;
            padding-left: 2px !important;
        }

        .order .col-sm-4:nth-child(3){
            padding-left: 0px !important;
        }

        .table-sm th,td{
            padding: 5px !important;
        }

    </style>

@endsection


@section('content')


    <section class="container content" id="profile_content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Profile</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="col-md-8 col-lg-8 col-sm-12">

                                @if(count($errors->all())>0)

                                    <div class="alert alert-danger">

                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                            @endforeach
                                    </div>
                                    @endif
                                <form method="post" action="{{route('writer.update_profile')}}">
                                    @csrf
                                <input type="hidden" name="id" value="{{old('id')}}">
                                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                    <label for="name">Name</label>
                                    <input class="form-control" type="text" name="name" value="{{old('name')}}" id="name">
                                    <span class="text-danger">{{($errors->has('name'))?$errors->first('name'):""}}</span>

                                </div>

                                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                    <label for="email">Email</label>
                                    <input class="form-control" type="email" name="email" value="{{old('email')}}" id="email">
                                    <span class="text-danger">{{($errors->has('email'))?$errors->first('email'):""}}</span>

                                </div>

                                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                    <label for="phone_number">Phone Number</label>
                                    <input class="form-control" type="text" name="phone_number" value="{{old('phone_number')}}" id="phone_number">
                                    <span class="text-danger">{{($errors->has('phone_number'))?$errors->first('phone_number'):""}}</span>

                                </div>


                                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                    <label for="password">Password</label>
                                    <input class="form-control" type="password" name="password" id="password">
                                    <span class="text-danger">{{($errors->has('password'))?$errors->first('password'):""}}</span>

                                </div>

                                <div class="form-group col-md-6 col-lg-6 col-sm-12">
                                    <label for="password_confirmation">Password Confirmation</label>
                                    <input class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                                    <span class="text-danger">{{($errors->has('password_confirmation'))?$errors->first('password_confirmation'):""}}</span>

                                </div>
                                <div class="form-group col-md-8 col-lg-8 col-sm-12">
                                    <button class="btn btn-success" type="submit">Update</button>
                                </div>

                                </form>
                            </div>

                            <div class="col-md-4 col-sm-12 col-lg-4">



                                {{--<div class="tab-pane " id="picture_tab">--}}

                                    <div class="box-body">
                                        @if(count($errors->all())>0)
                                            <div class="alert-danger">
                                                @foreach($errors->all() as $error)
                                                    <li>{{$error}}</li>
                                                @endforeach
                                            </div>

                                        @endif

                                        <form role="form" name="businessPic" method="post" action="{{route('writer.update_user_profile')}}" enctype="multipart/form-data">
                                            {{csrf_field()}}
                                            <div class="form-group">
                                                <div class="fileinput fileinput-new" data-provides="fileinput">
                                                    <div class="fileinput-new thumbnail">
                                                        <img   alt="..."   src="{{asset('uploads/user_pictures/'. old('avatar'))}}" class="img img-responsive">

                                                    </div>
                                                    <div class="fileinput-preview fileinput-exists thumbnail"  ></div>
                                                    <div id="image_btn">
                                                                            <span class="btn btn-default btn-file">
                                                                                <span class="fileinput-new">Select image</span>
                                                                                <span class="fileinput-exists">Change</span>
                                                                                <input type="file"  class="img img-responsive" name="user_pic" ></span>
                                                        <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
                                                        <input type="submit"  class="btn btn-success fileinput-exists">

                                                    </div>
                                                </div>
                                            </div>

                                        </form>

                                    </div>


                                {{--</div>--}}
                            </div>

                        </div>


                    </div>
                </div>


                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Disciplines</h3>
                        <button class="btn btn-primary  pull-right" data-toggle="modal" data-target="#disciplineModal" @click="getDisciplines">Add Discipline</button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="col-md-12 col-sm-12 col-lg-12">
                            <div class="col-md-8 col-lg-8 col-sm-12">

                                @if(count($errors->all())>0)

                                    <div class="alert alert-danger">

                                        @foreach($errors->all() as $error)
                                            <li>{{$error}}</li>
                                        @endforeach
                                    </div>
                                @endif




                            </div>

                            <div class="row">

                            @foreach($disciplines as $discipline)
                                    <div class="col-md-6 col-lg-6 col-sm-12">
                                        <li>{{$discipline->Discipline->name}}  <a href="{{route('writer.delete_user_discipline',$discipline->id)}}"> <span class="fa fa-trash "></span></a> </li>
                                    </div>

                                @endforeach
                            </div>

                    </div>


                    </div>
                </div>
            </div>
        </div>



        <div class="modal" id="disciplineModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Select Discipline to Add</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <form method="post" action="{{route('writer.update_disciplines')}}">

                            @csrf
                        <table class="table table-responsive table-striped">
                            <thead>
                            <tr>
                                <td>Name</td>
                                <td>Action</td>
                            </tr>
                            </thead>

                            <tbody>

                            <tr v-for="discipline in all_disciplines">
                            <td>@{{ discipline.name }}</td>
                            <td>
                                <input type="checkbox" :value="discipline.id" name="selected_disciplines[]">
                            </td>

                            </tr>
                            </tbody>
                        </table>

                        <button class="btn btn-success">Submit</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </section>
    @endsection
@section('script')
    <script src="{{asset('plugins/holder-master/holder.js')}}" type="text/javascript"></script>
    <script src="{{asset('plugins/jasny-bootstrap/js/jasny-bootstrap.js')}}"></script>

    <script>

        let content=new Vue({

            el:'#profile_content',
            data:{
                all_disciplines:[]
            },
            methods:{
                getDisciplines:function () {
                    let url='{{route('writer.get_all_disciplines')}}';
                    let me=this;
                    axios.get(url)
                        .then(res=>{
                            console.log(res.data.all_disciplines);
                            me.all_disciplines=res.data.all_disciplines

                        });
                }

            }
        })
    </script>
@endsection