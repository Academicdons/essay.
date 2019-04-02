@extends('layouts.index')

@section('style')
    <style type="text/css">
        .academic-input{
            background: white !important;
            min-height: 50px !important;
            border-radius: 7px !important;
            border: 1px solid darkblue;
            color: black;
        }

        .step-area{
            background: #f5fafe !important;
            border-radius: 15px;
        }

        .step-area label{
            margin: 0px !important;
            color: gray;
            font-size: 13px;
        }

        .flat{
            border-radius: 0px !important;
        }

        .curve-left{
            border-radius: 5px 0px 0px 5px !important;
        }
        .input-group-prepend, .input-group-append, .input-group-text{
            background: white !important;
            border-color: darkblue;
            color: darkblue;

        }

        #upload-area{
            min-height: 80px;
            width: 100%;
            border: 1px dashed #36ceff;
            border-radius: 15px;
            text-align: center;
            padding: 10px;
            font-size: 14px;
        }
        .active-upload{
            /*display: none;*/
        }
        .error-text{
            color: red;
        }
    </style>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/css/tempusdominus-bootstrap-4.min.css" />
    @endsection

@section('content')

    <section class="place-order mt-5 mb-5">


        <div class="container">
            <h3>Place your order</h3>

            <form action="{{route('customer.orders.store')}}" method="post" onsubmit="return submitOrderForm()">
                @csrf
                <input type="hidden" name="id" value="">
                <input type="hidden" name="tz" id="tz">
                <input type="hidden" name="tz_offset" id="tz_offset">
                <div class="row">

                    <div class="col-sm-4">
                        <div class="step-area p-3">

                            <div class="form-group">
                                <label for="">Type of paper</label>
                                <select name="essay_type" class="form-control academic-input" onchange="getDisciplines(this.value)">
                                        @foreach($groups as $group)
                                            <option value="{{$group->id}}" {{($group->id == old('id'))?$group->id:""}}>{{$group->name}}</option>
                                        @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="topic">Topic</label>
                                <input type="text" name="topic" class="form-control academic-input" id="topic" value="">
                                <span class="error-text" id="topic_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="">Select your subject</label>
                                <select name="discipline" id="discipline" class="form-control academic-input">

                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Spacing</label>
                                <select name="spacing" id="spacing" onchange="updateBySpacing(this.value)" class="form-control academic-input">
                                    <option value="0" selected>Single</option>
                                    <option value="1">Double</option>
                                </select>
                            </div>


                            <div class="form-group">
                                <label for="">Number of Words</label>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span onclick="updateWords(+50)" class="input-group-text" id="basic-addon1">+</span>
                                            </div>
                                            <input id="number_of_words" name="number_of_words" onchange="updateByWords(this.value)" type="number" value="550" class="form-control academic-input flat" style="text-align: center" placeholder="required words" aria-label="Words" aria-describedby="basic-addon1">
                                            <div class="input-group-append">
                                                <span onclick="updateWords(-50)" class="input-group-text" id="basic-addon1">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pt-2">
                                        {{--(<span id="total_pages"></span>) Total Pages--}}
                                    </div>
                                </div>

                            </div>







                            <div class="form-group">
                                <label for="">Deadline</label>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input name="date_input" type="text" id="date-input" class="form-control academic-input curve-left" placeholder="">

                                            <div class="input-group-append" data-target="#date-input" data-toggle="datetimepicker">
                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                            </div>
                                        </div>
                                        <span class="error-text" id="date_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="input-group">
                                            <input type="text" name="time_input" id="time-input" class="form-control academic-input curve-left" placeholder="">
                                            <div class="input-group-append" data-target="#time-input" data-toggle="datetimepicker">
                                                <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                                            </div>
                                        </div>
                                        <span class="error-text" id="time_error"></span>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="col-sm-4">

                        <div class="step-area p-3">
                            <span class="mb-2 font-weight-bold">Type of service</span> <br>
                            <input type="radio" value="1" name="type_of_service">Writing from scratch <br>
                            <input type="radio" value="2" name="type_of_service">Rewriting <br>
                            <input type="radio" value="3" name="type_of_service">Editing <br>
                            <span class="error-text" id="service_type_error"></span>
                            <br>

                            <div class="form-group">
                                <label for="">Number of pages</label>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span onclick="updatePages(1)" class="input-group-text" id="basic-addon1">+</span>
                                            </div>
                                            <input type="number" onchange="updateByPages(this.value)" id="number_pages" name="number_pages" value="1" class="form-control academic-input flat" style="text-align: center" placeholder="0" aria-label="Username" aria-describedby="basic-addon1">
                                            <div class="input-group-append">
                                                <span onclick="updatePages(-1)" class="input-group-text" id="basic-addon1">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pt-2">
                                    </div>
                                </div>
                            </div>

                            <span class="mb-2 mt-2 font-weight-bold">Writer quality</span> <br>

                            <div class="row">
                                <div class="col-sm-4">
                                    <input type="radio" value="1" class="custom-radio" name="writer_quality">Standard <br>
                                    <input type="radio" value="2" name="writer_quality">Premium <br>
                                    <input type="radio" value="3" name="writer_quality">Platinum <br>
                                    <span class="error-text" id="writer_quality_error"></span>
                                </div>
                                <div class="col-sm-8">

                                    <p class="triangle-border">

                                        <small>
                                            <strong>Standard</strong>-General level language<br>
                                            <strong>Premium</strong>-College level language
                                            <strong>Platinum</strong>Experts with PHD and rated higher than 9.5 <br>
                                        </small>

                                    </p>
                                </div>
                            </div>



                            <div class="form-group mt-3">
                                <label for="">Number of sources</label>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="input-group mb-3">
                                            <div class="input-group-prepend">
                                                <span onclick="updateSources(1)" class="input-group-text" id="basic-addon1">+</span>
                                            </div>
                                            <input type="number" onchange="evaluateCost()" id="number_of_sources" name="number_of_sources" value="0" class="form-control academic-input flat" style="text-align: center" placeholder="0" aria-label="Username" aria-describedby="basic-addon1">
                                            <div class="input-group-append">
                                                <span onclick="updateSources(-1)" class="input-group-text" id="basic-addon1">-</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 pt-2">
                                    </div>
                                </div>

                            </div>

                            <div class="form-group">
                                <label for="format_of_citation">Format of citation</label>
                                <select name="paper_type" id="paper_type" class="form-control academic-input">
                                    @foreach($papers as $paper)
                                        <option value="{{$paper->id}}" {{(old('paper_type')==$paper->id)?"selected":""}}>{{$paper->name}}</option>
                                        @endforeach
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="col-sm-4">

                        <div class="step-area p-3">

                            <div class="form-group">
                                <label for="instructions">Instructions for your paper</label>
                                <textarea name="instructions" class="form-control" id="instructions"></textarea>
                                <span class="error-text" id="instructions_error"></span>
                            </div>

                            <div class="form-group">
                                <label for="education_level">Education Level</label>
                                <select name="education_level" class="form-control academic-input" onchange="getEdPriceFactor(this.value)" id="education_level">
                                    @foreach($education as $ed)
                                        <option value="{{$ed->id}}" {{(old('education_level')==$ed->id)?"selected":""}}>{{$ed->name}}</option>
                                        @endforeach
                                </select>
                            </div>


                            <div class="form-group" id="upload-area">
                                <i class="fa fa-upload"></i>
                                <p>Drop files here <br>
                                    or click to upload</p>
                                <input type="file" multiple="multiple" style="display: none;"></div>

                            <div class="active-upload" style="display: none">
                                <div class="progress">
                                    <div class="progress-bar" style="width:0%">0%</div>
                                </div>
                            </div>

                            <h6><u>Attached files:</u></h6>
                            <div class="session-files">




                            </div>

                            <div class="form-group p-2">
                                <p class="text-center m-2" for="" style="color: orange;font-size: 30px;font-weight: bold;">
                                    <span id="amount">

                                    </span>
                                    <br>
                                    <button type="submit"  onclick="evaluateCost()" class="button">Order Now</button>

                                </p>
                            </div>

                        </div>

                    </div>

                </div>
            </form>
        </div>

    </section>


    @endsection

@section('script')


    <script type="text/javascript" src="{{asset('js/resumable.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/jstz.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.18.0/axios.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.1/js/tempusdominus-bootstrap-4.min.js"></script>



    <script type="text/javascript">

        window.base_price = 10;
        window.ed_factor =1;



        var r = new Resumable({
            @if(old('id')==null)
            target: '{{url('/upload_order_files')}}'
            @else
            target: '{{url('/upload_order_files_main')}}'
            @endif
        });
        r.assignBrowse(document.getElementById('upload-area'));

        r.on('fileProgress', function(file){
            var p =(r.progress()*100).toFixed(2);
            $('.progress-bar').css('width',p+"%")
            $('.progress-bar').text(p + "%")
        });

        r.on('complete', function(){
            $('.active-upload').hide()
            loadSeddionFiles()
        });

        r.on('fileAdded', function(file, event){
            $('.active-upload').show()
            r.upload();
        });

        function loadSeddionFiles() {

                    @if(old('id')==null)
            var url='{{url('get_session_files')}}'
            axios.get(url)
                .then(function (res) {
                    $('.session-files').html('');
                    $.each(res.data,function (key,value) {
                        console.log(value.display_name)
                        var file = "<div class=\"file p-2 border-bottom\">\n" +
                            "                                <span><i class=\"fa fa-file\"></i></span>\n" +
                            "                                <span class=\"file-name\">"+value.display_name+"</span>\n" +
                            "                                <span class=\"pull-right\"><a onclick=\"deleteFile('"+value.id+"')\" href=\"javascript:;\" class=\"text-danger\"><i class=\"fa fa-trash\"></i></a></span>\n" +
                            "                            </div>"

                        $('.session-files').append(file);
                    })
                })
                    @else

            var url='{{url('order_files')}}'+'/'+{{old('id')}}
                axios.get(url)
                    .then(function (res) {
                        $('.file-list').html('');
                        $.each(res.data,function (key,value) {
                            console.log(value.display_name)
                            var file = "<div class=\"file p-2 border-bottom\">\n" +
                                "                                <span><i class=\"fa fa-file\"></i></span>\n" +
                                "                                <span class=\"file-name\" style=\"padding-right:40px\">"+value.display_name+"</span>\n" +
                                "                                <span class=\"pull-right\"><a onclick=\"deleteFile('"+value.id+"')\" href=\"javascript:;\" class=\"text-danger\"><i class=\"fa fa-trash\"></i></a></span>\n" +
                                "                            </div>";

                            $('.session-files').append(file);
                        })
                    })

            @endif

        }

        $(function () {
            loadSeddionFiles()

            /*
            configure onchange for form
             */

            $('form').change(function() {
                evaluateCost()
            })

            /*
            preload the active disciplines
             */

            getDisciplines($("select[name='essay_type']").val())
            getEdPriceFactor($("select[name='education_level']").val())

            /*
            configure timezone
             */
            var tz = jstz.determine();

            $('#tz').val(tz.name());


        })

        function deleteFile(id){
            var url = '{{url('delete_order_upload')}}'+"/"+id;
            axios.get(url)
                .then(function(res){
                    loadSeddionFiles();
                })
        }
        /*
        Configure the time concious inputs
         */
        $(function () {
            $('#date-input').datetimepicker({
                format: 'L',
                minDate:moment.now(),
                useCurrent:true
            });
            $('#date-input').on('input', function() {
                evaluateCost()
            });

            $('#time-input').datetimepicker({
                format: 'LT',
                minDate:moment.now(),
                useCurrent:true
            });
            $('#date-input').on('input', function() {
                evaluateCost()
            });

        });

        function getDisciplines(group) {
            let url = '{{url('get_disciplines')}}'+"/"+group
            axios.get(url)
                .then(function (res) {
                    $('#discipline').html('')
                    $.each(res.data.disciplines,function(key,value){
                        let choosen = ""
                        if('{{old('discipline')}}' == value.id){
                            choosen = "selected"
                        }
                        $('#discipline').append('<option value="'+value.id+'"'+ choosen +'>'+value.name+'</option>')
                    })

                    window.base_price = res.data.group.base_price
                })
        }

        function getEdPriceFactor(ed) {
            let url = '{{url('get_ed_factor')}}'+"/"+ed
            axios.get(url)
                .then(function (res) {
                    window.ed_factor = res.data;
                });
        }


        function updateBySpacing(spacing) {
            var words =  $('#number_of_words').val()
            updateByWords(words)

        }

        function updateByWords(words) {
            var spacing = $('#spacing').val();
            var pages = 0;
            if(spacing==0){
                pages = Math.round(words / 550)
                if(pages==0)pages=1;
            }else{
                pages = Math.round(words / 275)
            }
            $('#number_pages').val(pages)
            evaluateCost()

        }

        function updateByPages(pages) {
            var spacing = $('#spacing').val();
            var words = 0;
            if(spacing==0){
                words = pages * 550
            }else{
                words = pages * 275;
            }
            $('#number_of_words').val(words)
            evaluateCost()
        }



        function updateWords(delta) {
            var number_of_words = $('#number_of_words').val();
            if(number_of_words<50){
                return;
            }
            if(number_of_words<=1 && delta<=0){
                return
            }else{
                number_of_words=+number_of_words+delta;
                $('#number_of_words').val(number_of_words);
                //show the no of pages
            }
            updateByWords(number_of_words)
        }

        function updateSources(delta) {
            var number_of_sources = $('#number_of_sources').val();
            if(number_of_sources<=0 && delta<=0){
                return
            }else{
                number_of_sources=+number_of_sources+delta;
                $('#number_of_sources').val(number_of_sources);
            }
            evaluateCost()
        }

        function updatePages(delta) {
            var number_of_pages = $('#number_pages').val();
            if(number_of_pages<=0 && delta<=0){
                return
            }else{
                number_of_pages=+number_of_pages+delta;
                $('#number_pages').val(number_of_pages);
            }
            updateByPages(number_of_pages)
        }



        function evaluateCost() {


            var type_of_service = $("input[name='type_of_service']:checked").val();
            var writer_quality = $("input[name='writer_quality']:checked").val()
            var deadline_date = $('#date-input').val();
            var deadline_time = $('#time-input').val();
            var education_level = $('#education_level').val();
            var topic = $('#topic').val();
            var instructions = $('#instructions').val();
            var number_of_words = $('#number_of_words').val();

            /*
            valiadtion critereas to the form
             */

            if (validate(type_of_service,writer_quality,deadline_date,deadline_time,topic,instructions)){

                var deadline = deadline_date+" "+deadline_time;
                var hours = moment(deadline,"MM/DD/YYYY hh:mm A").diff(moment().format(),'hours');
                console.log(hours);

                var time_amt = getAmountInTime(hours)*window.base_price;

                console.log(time_amt);

                /*
                Consider the education level
                 */
                var price_per_page = ed_factor  * time_amt;
                var pages = Math.round(number_of_words/275);
                if(pages == 0)
                    pages=1;
                $('#amount').html("$ "+(price_per_page*pages));
                $('#cost').val(price_per_page*pages);

            }


        }

        function submitOrderForm() {
            var type_of_service = $("input[name='type_of_service']:checked").val();
            var writer_quality = $("input[name='writer_quality']:checked").val()
            var deadline_date = $('#date-input').val();
            var deadline_time = $('#time-input').val();
            var education_level = $('#education_level').val();
            var topic = $('#topic').val();
            var instructions = $('#instructions').val();
            var number_of_words = $('#number_of_words').val();


            /*
            valiadtion critereas to the form
             */

            if (validate(type_of_service,writer_quality,deadline_date,deadline_time,topic,instructions)) {
                return true
            }

            return false
        }



        function getAmountInTime(hours) {

            if (hours<20)
                return 1.25
            else if (hours<72)
                return 1
            else
                return 0.75
        }

        function  validate(ts,wq,dd,dt,tp,ins) {
            $('.error-text').each(function() {
                $(this).text("")
            });
            if(tp === undefined || tp ===''){
                $('#topic_error').text("Provide the topic of your work")
                return false
            }
            else if(ins === undefined || ins ===''){
                $('#instructions_error').text("Outline instructions on how you want your work done")
                return false
            }

            else if(dt === undefined || dt ===''){
                $('#time_error').text("Select a time for the deadline")
                return false
            }

            else if(dd === undefined || dd ===''){
                $('#date_error').text("Select a deadline date")
                return false
            }

            else if(ts === undefined){
                $('#service_type_error').text("Choose a service type")
                return false
            }

            else if(wq === undefined){
                $('#writer_quality_error').text("Choose the quality of the writer you want")
                return false
            }else{
                return true;
            }



        }
    </script>


    @endsection