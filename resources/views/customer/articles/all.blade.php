@extends('layouts.index')

@section('style')


@endsection


@section('content')

    <div class="container mb-5">
            @foreach($articles->chunk(3) as $group)
            <div class="row mt-3">
                @foreach($group as $article)
                        <div class="col-sm-4">
                            <div class="card">

                                <div class="card-body">
                                    <div class="article-head p-1">
                                        <h5>{{$article->title}}</h5>
                                        <p class="small">{{$article->created_at->diffForHumans()}}</p>
                                    </div>
                                    <div class="small">
                                        {!! str_limit($article->description,300) !!}}
                                    </div>
                                    <div class="buttons mt-2">
                                        <a href="{{route('read_article',$article->title)}}" class="float-right btn btn-outline-success btn-sm">Read article</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    @endforeach
        </div>
        @endforeach
    </div>

@endsection