<html>

<head>
    <!-- Tell the browser to be responsive to screen width -->
    <link href="http://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style>
        .col-sm-6{
            width: 49%;
            margin-left: 0px;
            margin-right:0px;
            float: left;

        }
        .col-sm-6r{
            width: 49%;
            margin-left: 0px;
            margin-right:0px;
            float: right;
        }

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

        body{
            padding: 0px!important;
            font-size: 110%;
        }
    </style>
</head>

<body>

<div class="container-fluid">

    <div class="pt-3 pb-3">
        <div class="row p-3">
            <div class="col-sm-6">
                <img src="{{asset('images/logo2.png')}}" width="150px" alt="">
            </div>
            <div class="col-sm-6r text-right">
                <h1>INVOICE</h1>
                <div>
                    Automated billing department
                    <br>
                    Homework pro writers
                    <br>
                    info@homeworkprowriters.com
                </div>

            </div>
        </div>

        <div class="clearfix"></div>
        <div class="line"></div>

        <div class="row">

            <div class="col-sm-6">
                <h5 class="font-weight-bold">To:</h5>
                <div>
                    {{$user->name}}
                    <br>
                    {{$user->phone_number}}
                    <br>
                    {{$user->email}}

                </div>
            </div>
            <div class="col-sm-6r text-right">

                <table style="float: right">
                    <tr>
                        <td><span class="font-weight-bold">Invoice Number:</span></td><td class="pl-3">{{uniqid()}}</td>
                    </tr>
                    <tr>
                        <td><span class="font-weight-bold">Invoice Date:</span></td><td class="pl-3">{{$date}}</td>
                    </tr>
                    <tr>
                    </tr>
                    <tr>
                        <td><span class="font-weight-bold"></span></td><td class="pl-3"></td>
                    </tr>
                </table>
            </div>

        </div>

        <div class="clearfix"></div>

        <table class="table mt-4 particulars">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Order id</th>
                    <th>Title</th>
                    <th>Salary</th>
                    <th>Bonus/Fines</th>
                    <th>Amount</th>
                </tr>
            </thead>

            <tbody>
            @php($total = 0)
                @foreach($orders as $order)
                <tr>
                    <td>#</td>
                    <td>{{$order->order_no}}</td>
                    <td>{{str_limit($order->title)}}</td>
                    <td>{{$order->salary}}</td>
                    <td>{{$order->bargains_sum}}</td>
                    <td>{{$order->amount}}</td>
                </tr>
                    @php($total+=$order->total)
                @endforeach



                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><span class="font-weight-bold">TOTAL</span></td>
                    <td><span class="font-weight-bold">{{$total}}</span></td>
                </tr>

            </tbody>
        </table>

    </div>

</div>

</body>

</html>