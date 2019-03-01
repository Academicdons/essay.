@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Announcements
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Announcements</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Announcements</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.announce.new') }}" class="btn btn-sm btn-info">Add Announcement</a>
                        </div>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box box-widget">
                                        <div class="box-header with-border">

                                        </div>
                                        <div class="box-body box-comments">
                                            @foreach(\App\Models\Announcement::all() as $announce)
                                                <div class="box-comment">
                                                    <div class="row">
                                                        <div class="col-sm-1" style="padding-right: 0">
                                                            <b>{{ $loop->iteration }}.</b>
                                                        </div>
                                                        <div class="col-sm-11" style="padding-left: 0">
                                                            <div class="comment-text" style="margin-left: 0" >
                                                          <span class="username">
                                                            {{ $announce->title }}
                                                            <span class="text-muted pull-right">{{ $announce->created_at }}</span>
                      </span><!-- /.username -->
                                                                {{ $announce->news_article }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="disciplinesModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" style="z-index: 100000000000;" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="box">
                        <div class="box-header">
                            <div class="box-title" id="album_name"></div>
                        </div>

                        <div class="box-body">
                            <form method="POST" action="{{ route('admin.discipline.add') }}">
                                @csrf

                                <input type="hidden" name="id" value="{{ old('id') }}">

                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label text-md-right">Name</label>

                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>

                                        @if ($errors->has('name'))
                                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="col-md-6 offset-md-4">
                                        <button type="submit" class="btn btn-primary">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop