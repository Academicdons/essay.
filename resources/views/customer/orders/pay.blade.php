@extends('layouts.index')

@section('style')


    @endsection

@section('content')

    <div class="container pt-5 pb-5">

        <div class="row pt-3 pb-3 justify-content-center">
            <img src="{{asset('images/logo.png')}}"  width="240px" height="170px" alt="">
        </div>

        <div class="row mt-5 mb-5 justify-content-center" id="paybuttons">

        </div>

    </div>

    @endsection



@section('script')
    <script src="https://www.paypal.com/sdk/js?client-id=ASjp_tVTIhR9EWEq-OMNcBYV-6blTi1WW--qertlTExyaTZO8S8g9xfUFH2d5ZzUfeKPC6kM9CID6ovd"></script>
    <script>

        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{$order->amount}}'
                        }
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    return fetch('{{route('customer.orders.pay.process')}}', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            orderRef:'{{$order->id}}'
                        })
                    }).then(function (response) {
                        response.json().then(function(data) {
                            if(data.success){
                                window.location = '{{route('customer.orders.list')}}'
                            }else{
                                alert('Could not verify your payment. Please try again')
                            }
                        });
                    });
                });
            }
        }).render('#paybuttons');
        
    </script>

@endsection