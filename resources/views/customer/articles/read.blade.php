@extends('layouts.index')

@section('style')

    <style>
        .button {
            display: inline-block;
            text-align: center;
            vertical-align: middle;
            padding: 21px 36px;
            border: 1px solid #a12727;
            border-radius: 8px;
            background: #4aff6e;
            background: -webkit-gradient(linear, left top, left bottom, from(#4aff6e), to(#26994b));
            background: -moz-linear-gradient(top, #4aff6e, #26994b);
            background: linear-gradient(to bottom, #4aff6e, #26994b);
            text-shadow: #591717 1px 1px 1px;
            font: normal normal bold 20px arial;
            color: #ffffff;
            text-decoration: none;
        }
        .button:hover,
        .button:focus {
            background: #59ff84;
            background: -webkit-gradient(linear, left top, left bottom, from(#59ff84), to(#2eb85a));
            background: -moz-linear-gradient(top, #59ff84, #2eb85a);
            background: linear-gradient(to bottom, #59ff84, #2eb85a);
            color: #ffffff;
            text-decoration: none;
        }
        .button:active {
            background: #2c9942;
            background: -webkit-gradient(linear, left top, left bottom, from(#2c9942), to(#26994b));
            background: -moz-linear-gradient(top, #2c9942, #26994b);
            background: linear-gradient(to bottom, #2c9942, #26994b);
        }
        .button:before{
            content:  "\0000a0";
            display: inline-block;
            height: 24px;
            width: 24px;
            line-height: 24px;
            margin: 0 4px -6px -4px;
            position: relative;
            top: 0px;
            left: 0px;
            background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABgAAAAYCAYAAADgdz34AAAACXBIWXMAAA7EAAAOxAGVKw4bAAABi0lEQVRIib2VTUpDQQzHfw4PEelSpCsRBRfq6oEX8ASew2v0CB7BlXgATyBVKiJdKn7golQURKi0VJ26mIyN03nt9FUMhMnLZCbJ/yUZgHNgIPwBHAHLgPkjpg68A13l6NRvasOSMhlQEa4C9+IkV4aUlQ1ggY5wG7gSgw3Z81RKziKe75SDCrNRb45hFt7RPnAAfAL9GR00TaCwDDPIKE8ZsAhsjoPoEdgq6WAPOATOvAP9c1pAD1iS744KwibKPrDLECJ/4QsuxarS24htEeWyNsLm8N8eptVgL7W5vIOfDKxigAflQOtT5BUcvG2gFYPIArcirwf6FNlH3wT6uhRjlbQW6FNoR9YLwOjDOs1rWXNcN6dCNA/siq7h92MRGn6P8Wn5BjVmYpVkcCV6DLzhxvkk7uLekxOG0JpwFsFo4ywUZBkjg+sjq++JHc6AGvAqXMPhW0Rj7WMQ1XBYfgkPRFf0LI6zH8kgA55xeObAthx4UlGZVPtpa9zTNHPp/yEyTP7J4eNeaP8N3MOiAZAY+OMAAAAASUVORK5CYII=") no-repeat left center transparent;
            background-size: 100% 100%;
        }
    </style>

@endsection


@section('content')


    <div class="container">
        <div class="row mt-5 mb-5">
            <div class="col-sm-12 border-right border-left">

                <h3 class="mt-3 mb-3">{{$article->title}}</h3>
                <p class="text-light-blue">{{$article->created_at->diffForHumans()}}</p>
                <p class="mb-5">
                    {!! $article->description !!}
                </p>

                <p class="text-center">
                    <a class="button" href="#">Order your paper now</a>

                </p>

            </div>
        </div>
    </div>

    @endsection