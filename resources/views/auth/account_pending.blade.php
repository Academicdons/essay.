@extends('layouts.index')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5 mb-5 p-5">
                    <div class="alert alert-info">
                        <p class="font-weight-bold">
                            Hello {{Auth::user()->name}},
                        </p>
                        Your account is pending administrator approval. Kindly be patient as we review your test.

                        <p class="font-weight-bold mt-3">Thank you for your patience.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
