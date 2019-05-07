@extends('layouts.admin')

@section('content')

    <section class="content-header">
        <h1>
            Blog
            <small>New Blog</small>
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
                        <h3 class="box-title">Create/Edit Blog</h3>
                        <div class="box-tools">
                            <a href="{{ route('admin.blog.all_blogs') }}" class="btn btn-sm btn-primary">Back to Blogs</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <form role="form" method="post" action="{{ route('admin.blog.new_blog') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{old('id')}}">

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="title">Title</label>
                                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control">
                                        <p class="text-danger text-sm">{{($errors->has('title')?$errors->first('title'):"")}}</p>
                                    </div>

                                    <div class="form-group">
                                        <label for="description">Description</label>
                                        <textarea rows="12" id="description" class="form-control" name="description">{{old('description')}}</textarea>
                                        <p class="text-danger text-sm">{{($errors->has('description')?$errors->first('description'):"")}}</p>
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