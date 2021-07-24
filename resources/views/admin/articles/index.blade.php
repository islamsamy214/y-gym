@extends('layouts.admin')
@section('content')
    <div class="row control-bar">
        <div class="col-md-4 search-bar" >
            <form method="GET" action="{{ route('articles.index') }}">
                <div class="navbar-search-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                    <button type="submit" class="btn btn-default">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (auth()->user()->hasPermission('articles_create'))

            @include('admin.articles.create')

        @endif

    </div>
    @if ($articles->count() > 0)
        <h4> {{ __('site.total') }} : {{ $articles->total() }}</h4>


        <div class="row">

            @foreach ($articles as $article)
                <div class="col-sm-6 col-md-4">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <div class="panel-tools">

                            </div>
                            <h3 class="panel-title">{{ $article->title }}</h3>
                            <div class="panel-subtitle">{{ $article->articleCategory->name }}</div>
                        </div>
                    <div class="panel-body article-panel-body">

                        <p>{{ $article->content }}</p>

                    </div>
                    <div class="panel-footer article-panel-footer text-right">

                        <button type="button" class="btn btn-primary m-w-120" data-toggle="modal" data-target="#article-{{ $article->id }}">{{ __('site.read_more') }}</button>
                        <div id="article-{{ $article->id }}" class="modal fade text-center" tabindex="-1" role="dialog">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                <div class="modal-header bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">
                                        <i class="zmdi zmdi-close"></i>
                                    </span>
                                    </button>
                                    <h4 class="modal-title">{{ $article->title }}</h4>
                                </div>
                                <div class="modal-body article-modal-body">
                                    @if ($article->image)
                                        <img class="col-md-{{ $article->video ? '6' : '12' }}" src="{{ $article->image_path }}"/>
                                    @endif
                                    @if ($article->video)
                                        <video class="col-md-{{ $article->image ? '6' : '12' }}" src="{{ $article->video_path }}" controls></video>
                                    @endif
                                    <p class="col-md-12">{{ $article->content }}</p>
                                    <h4 class="col-md-12 text-left"> {{__('site.copied_from') . " : " . $article->copied_from }} </h4>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" data-dismiss="modal" class="btn btn-default">{{ __('site.close') }}</button>
                                    @if (auth()->user()->hasPermission('articles_update') || auth()->user()->id == $article->user_id)
                                        <a href="{{ route('articles.edit',$article->id) }}" class="btn btn-primary">
                                            <i class="zmdi zmdi-border-color"></i>
                                            {{ __('site.edit') }}
                                        </a>
                                    @endif
                                    @if (auth()->user()->hasPermission('articles_delete') || auth()->user()->id == $article->user_id)
                                    <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('articles.destroy',$article->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete">
                                            <i class="zmdi zmdi-delete"></i>
                                            {{ __('site.delete') }}
                                        </button>
                                    </form>
                                    @endif
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-12 text-center">
                {{$articles->appends(request()->query())->links()}}
                {{--appends(request()->query()) to not to damage the url when using search--}}
            </div>
        </div>
    @else
        <h1 class="text-center">
            {{ __('site.no_data') }}
        </h1>
    @endif


@endsection
