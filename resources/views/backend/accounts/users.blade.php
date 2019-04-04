@extends('layouts.admin')

@section('style')
    <link rel="stylesheet" href="{{asset('bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
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
                <h3>Users unpaid amounts</h3>
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
                                    <a href="{{route('admin.accounts.invoice',$account['user_id'])}}" class="btn btn-warning"><i class="fa fa-cloud-download"></i>invoice</a>
                                </td>
                            </tr>
                            @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        
    </section>
    
    @endsection