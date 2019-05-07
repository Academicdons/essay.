<div class="pt-3 pb-3">
    <div class="row">
        <div class="col-sm-6">
            <img src="{{asset('images/logo2.png')}}" width="150px" alt="">
        </div>
        <div class="col-sm-6 text-right">
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
        <div class="col-sm-6 text-right">

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
                <td>{{$loop->iteration}}</td>
                <td>{{$order->order_no}}</td>
                <td>{{str_limit($order->title,60)}}</td>
                <td>${{number_format($order->salary,2)}}</td>
                <td>${{number_format($order->bargains_sum,2)}}</td>
                <td>${{number_format($order->total,2)}}</td>
            </tr>
            @php($total+=$order->total)
        @endforeach

        <tr>
            <th colspan="6"><p class="font-weight-bold">FINES/BONUSES</p></th>
        </tr>


        @foreach($bargains as $bargain)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$bargain->order_no}}</td>
                <td>{{str_limit($bargain->title,60)}}</td>
                <td>
                    @if($bargain->amount<0)
                        <div class="text-danger">fine</div>
                    @else
                        <div class="text-success">bonus</div>
                    @endif
                </td>
                <td>{{$bargain->reason}}</td>
                <td>${{$bargain->amount}}</td>
            </tr>
            @php($total+=$bargain->amount)
        @endforeach

        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td><span class="font-weight-bold">TOTAL</span></td>
            <td><span class="font-weight-bold">${{number_format($total,2)}}</span></td>
        </tr>

        </tbody>
    </table>

</div>
