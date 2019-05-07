@extends('writer.profile.profile')

@section('body')

    <div class="row">
        <div class="col-sm-12 text-right">
            <div class="btn-group" role="group" aria-label="Basic example">
                <button type="button" onclick="location.href='{{route('writer.profile.index')}}';" class="btn btn-outline-info"><i class="fa fa-user"></i> Basic information</button>
                <button type="button" onclick="location.href='{{route('writer.profile.payments')}}';" class="btn btn-outline-success"><i class="fa fa-money"></i> Payment information</button>
            </div>
        </div>
        <div class="col-sm-12 mt-3">
            <h6>Disciplines</h6>
            <hr>
            <div class="row">
                @foreach($disciplines as $discipline)
                    <div class="col-sm-4">
                        <p class="font-weight-bold"><input type="checkbox"> {{$discipline->name}}</p>
                    </div>
                    @endforeach
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <button class="btn-primary btn-sm btn">Update disciplines</button>
                </div>
            </div>
            <hr>
        </div>
    </div>

@endsection