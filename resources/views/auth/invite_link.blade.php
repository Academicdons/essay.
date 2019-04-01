@extends('layouts.index')

@section('content')
    <div class="container mt-5 mb-5">
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">Invite Link</div>

                    <div class="card-body">




                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')


    <script type="text/javascript">
        $(document).ready(function(){
            $('input[type="checkbox"]').click(function(){
                if($(this).prop("checked") == true){

                    $('#register_button').removeAttr("disabled");
                }
                else if($(this).prop("checked") == false){
                    $('#register_button').attr("disabled", true);

                }
            });
        });
    </script>
@endsection