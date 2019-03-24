@extends('layouts.admin')

@section('content')
    <section class="content-header">
        <h1>
            Blogs
            <small>All</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Blog</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Blog</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.blog.new') }}" class="btn btn-sm btn-info">Add A Blog</a>
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
                                            @foreach($blogs as $blog)
                                                <div class="box-comment">
                                                    <div class="row">
                                                        <div class="col-sm-1" style="padding-right: 0">
                                                            <b>{{ $loop->iteration }}.</b>
                                                        </div>
                                                        <div class="col-sm-11" style="padding-left: 0">
                                                            <div class="comment-text" style="margin-left: 0" >
                                                          <span class="username">
                                                            {{ $blog->title }}
                                                            <span class="text-muted pull-right">


                                                                {{ $blog->created_at->toDayDateTimeString() }}</span>
                      </span><!-- /.username -->
                                                                {{ $blog->description }}



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
    </section>
@stop