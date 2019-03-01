@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            Announcement
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Announcement</li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Create/Edit Announcement</h3>
                        <div class="box-tools">
                            <a href="" class="btn btn-sm btn-primary">Back to Announcement</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <form role="form" method="post" action="{{ route('admin.announce.store') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{old('id')}}">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                                        <span class="form-control-feedback text-danger text-sm">{{($errors->has('title')?$errors->first('title'):"")}}</span>
                                    </div>

                                    <div class="form-group">
                                        <label for="news_article">News Article</label>
                                        <textarea rows="12" id="news_article" class="form-control" name="news_article">{{old('news_article')}}</textarea>
                                        <span class="form-control-feedback text-danger text-sm">{{($errors->has('news_article')?$errors->first('news_article'):"")}}</span>
                                    </div>
                                </div>
                            </div>

                            <Button class="btn btn-primary" type="submit">Submit</Button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('script')
    <script src="{{ asset('bower_components/ckeditor/ckeditor.js') }}"></script>

    <script>
        $(function () {
            CKEDITOR.replace('notes')
        })
    </script>
@stop