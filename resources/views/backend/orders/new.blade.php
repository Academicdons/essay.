@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('bstpick/css/bootstrap-datetimepicker.css')}}">
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

    <section class="content" id="content_area">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                <div class="box-header">
                    <h3 class="box-title">Create/Edit Order</h3>
                    <div class="box-tools">
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-sm btn-primary">Back to Orders</a>
                    </div>
                </div>
                <div class="box-body">

                    <form role="form" method="post" action="{{ route('admin.orders.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="id" value="{{old('id')}}">
                        <input type="hidden" name="tz" id="tz">

                        <div class="row">
                            <div class="col-sm-6">

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" id="title" class="form-control" name="title" value="{{old('title')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('title')?$errors->first('title'):"")}}</span>
                                        </div>

                                    </div>

                                    <div class="col-sm-6">
                                        <div class="form-group">

                                            <label for="">Spacing</label>

                                            <select name="spacing" id="spacing" class="form-control academic-input"  v-model="selected">
                                                <option value="0" {{ old('spacing') == 0?"selected":'' }}>Single</option>
                                                <option value="1" {{ old('spacing') == 1?"selected":'' }}>Double</option>
                                                                                                     </select>
                                        </div>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="no_pages">No. of Pages</label>
                                            <input type="text" id="no_pages" class="form-control" v-on:change="calculatePages" name="no_pages" v-model="no_of_pages" value="{{old('no_pages')}}" readonly>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('no_pages')?$errors->first('no_pages'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="no_words">No. of Words</label>
                                            <input type="number" id="no_of_words" v-model="no_words"  class="form-control"  name="no_words" :onkeyup="calculatePages()" value="">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('no_words')?$errors->first('no_words'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Number of Sources</label>
                                            <input type='number' value="{{old('no_of_sources')}}" name="no_of_sources"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="cpp">CPP</label>
                                            <input type="text" id="cpp" class="form-control" name="cpp" value="{{old('cpp')}}">
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('cpp')?$errors->first('cpp'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="order_assign_type">Order Assign Type</label>
                                            <select name="order_assign_type" id="order_assign_type" class="form-control">
                                                <option value="1" {{ old('order_assign_type') == 1?"selected":'' }}>Bid</option>
                                                <option value="2" {{ old('order_assign_type') == 2?"selected":'' }}>Take</option>
                                                <option value="3" {{ old('order_assign_type') == 3?"selected":'' }}>Manual</option>
                                            </select>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('order_assign_type')?$errors->first('order_assign_type'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="order_assign_type">Writer quality</label>
                                            <select name="writer_quality" id="writer_quality" class="form-control">
                                                <option value="1" {{ old('writer_quality') == 0?"selected":'' }}>Standard</option>
                                                <option value="2" {{ old('writer_quality') == 1?"selected":'' }}>Premium</option>
                                                <option value="3" {{ old('writer_quality') == 2?"selected":'' }}>Platinum</option>
                                            </select>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('writer_quality')?$errors->first('writer_quality'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="order_assign_type">Type of service</label>
                                            <select name="type_of_service" id="type_of_service" class="form-control">
                                                <option value="1" {{ old('type_of_service') == 0?"selected":'' }}>Write from scratch</option>
                                                <option value="2" {{ old('type_of_service') == 1?"selected":'' }}>Rewrite</option>
                                                <option value="3" {{ old('type_of_service') == 2?"selected":'' }}>Editing</option>
                                            </select>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('type_of_service')?$errors->first('type_of_service'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="order_assign_type">Disciplines</label>
                                            <select name="discipline" id="discipline" class="form-control">
                                                    @foreach($disciplines as $dis)
                                                        <option value="{{$dis->id}}" {{ old('discipline') == $dis->id?"selected":'' }}>{{$dis->name}}</option>
                                                        @endforeach

                                            </select>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('discipline')?$errors->first('discipline'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="order_assign_type">Paper type</label>
                                            <select name="paper_type" id="paper_type" class="form-control">
                                                @foreach($papers as $pap)
                                                    <option value="{{$pap->id}}" {{ old('paper_type') == $pap->id?"selected":'' }}>{{$pap->name}}</option>
                                                @endforeach
                                            </select>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('paper_type')?$errors->first('paper_type'):"")}}</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="order_assign_type">Education level</label>
                                            <select name="education_level" id="education_level" class="form-control">
                                                @foreach($educations as $eds)
                                                    <option value="{{$eds->id}}" {{ old('education_level') == $eds->id?"selected":'' }}>{{$eds->name}}</option>
                                                @endforeach

                                            </select>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('education_level')?$errors->first('education_level'):"")}}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="">Deadline</label>
                                            <div class='input-group date' id='deadline'>
                                                <input type='text' name="deadline" value="{{old('deadline')}}" class="form-control" />
                                                <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                            </div>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('deadline')?$errors->first('deadline'):"")}}</span>
                                        </div>

                                    </div>
                                    <div class="col-sm-6">

                                        <div class="form-group">
                                            <label for="">Bid expiry</label>
                                            <div class='input-group date' id='bid_expiry'>
                                                <input type='text' name="bid_expiry" value="{{old('bid_expiry')}}" class="form-control" />
                                                <span class="input-group-addon">
                                                <span class="fa fa-calendar"></span>
                                            </span>
                                            </div>
                                            <span class="form-control-feedback text-danger text-sm">{{($errors->has('bid_expiry')?$errors->first('bid_expiry'):"")}}</span>
                                        </div>

                                    </div>
                                </div>


                            </div>


                            <div class="col-sm-6">


                                <div class="form-group">
                                    <label for="notes">Notes</label>
                                    <textarea rows="12" id="notes" class="form-control" name="notes">{{old('notes')}}</textarea>
                                    <span class="form-control-feedback text-danger text-sm">{{($errors->has('notes')?$errors->first('notes'):"")}}</span>
                                </div>

                            </div>
                        </div>

                        <Button class="btn btn-primary pull-right" type="submit">Submit</Button>
                    </form>
                </div>
            </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('bower_components/moment/moment.js') }}"></script>
    <script src="{{asset('bstpick/js/bootstrap-datetimepicker.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jstz.min.js')}}"></script>
    <script>
        var  content=new Vue({
            el:'#content_area',
            data:{
                no_of_pages:'{{old('no_pages')}}',
                no_words:'{{old('no_words')}}',
                selected:'{{ old('spacing')}}',
            },
            created:function(){
                this.calculatePages()
            },
            methods:{

                calculatePages:function () {
                    //calculate the words here
                    let no_of_words = $('#no_of_words').val()
                    var rawPages;
                    if (this.selected==0){
                        rawPages=Math.round(no_of_words/550);
                    } else{
                        rawPages=Math.round(no_of_words/275);
                    }
                    if (rawPages===0){
                        rawPages=1
                    }
                    this.no_of_pages=rawPages
                },

            }
        })
    </script>


    <script>
        $(function () {
            CKEDITOR.replace('notes')
            var tz = jstz.determine();

            $('#tz').val(tz.name());
        });

        $(function () {

            $('#deadline').datetimepicker({
                format:'DD/MM/YYYY H:mm:ss'
            });

            $('#bid_expiry').datetimepicker({
                format:'DD/MM/YYYY H:mm:ss'
            });


            /*
            parse deadline to local time
             */
            @if(old('deadline')!=null)
              var deadline=moment.utc('{{old('deadline')}}').local().format("dddd,Do M-YYYY, h:mm:ss a")
              $('#deadline').data("DateTimePicker").date(deadline)
            @endif

            @if(old('bid_expiry')!=null)
            var bid_expiry=moment.utc('{{old('bid_expiry')}}').local().format("dddd,Do M-YYYY, h:mm:ss a")
            $('#bid_expiry').data("DateTimePicker").date(bid_expiry)
            @endif

        });

    </script>

@stop