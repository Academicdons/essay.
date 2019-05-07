@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <style>
        .line{
            width: 100%;
            height: 2px;
            background: grey;
            margin-top: 20px;
            margin-bottom: 10px;
        }

        .particulars{
            margin-left: 0px !important;
            margin-right: 0px !important;
        }

        .particulars thead{
            background: green !important;
            color: white !important;

        }
        .particulars tbody tr:last-child {

            border-top:2px solid #c0c0c0 !important;
            font-size: 27px;
            padding-top: 15px;
        }
    </style>
@endsection

@section('content')
    <section class="content-header">
        <h1>
            Accounts management
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Accounts</li>
        </ol>
    </section>

    <section class="content">
        
        <div class="box">
            <div class="box-header">
                <h3>Users current assignments accounts</h3>
            </div>
            <div class="box-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Salary</th>
                            <th>Bonus/Fines</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($accounts as $key=>$account)
                            <tr>
                                <td>#</td>
                                <td>{{$account['username']}}</td>
                                <td>{{$account['email']}}</td>
                                <td>{{$account['salary']}}</td>
                                <td>{{$account['bargains']}}</td>
                                <td>{{$account['amount']}}</td>
                                <td>
                                    <a href="{{route('admin.accounts.invoice',$account['user_id'])}}" class="btn btn-xs btn-warning"><i class="fa fa-cloud-download"></i> pdf</a>
                                    <a href="javascript:;" onclick="loadAccounts({{$account['user_id']}})" class="btn btn-xs btn-success"><i class="fa fa-eye"></i> preview</a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </section>

    <!-- Modal -->
    <div class="modal fade" id="invoiceModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="invoice_body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
    
    @endsection

    @section('script')

        <script>
            function loadAccounts(user_id) {
                
                let url = '{{route('admin.accounts.preview')}}'+"?user="+user_id
                axios.get(url)
                    .then(res=>{
                        $('#invoiceModal').modal('show');
                        $('#invoice_body').html(res.data)
                    })
                    .catch(res=>{

                    })

            }
        </script>

        @endsection