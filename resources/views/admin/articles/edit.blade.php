@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="m-y-0">{{ __('site.edit_article') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <form class="form-material" action="{{ route('articles.update',$article->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('includes.errors')

                {{-- title --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="title" placeholder="{{ __('site.title') }}" required='required' value="{{ $article->title }}">
                </div>

                {{-- content --}}
                <div class="form-group">
                    <textarea class="form-control" name="content" placeholder="{{ __('site.content') }}" required='required'>{{ $article->content }}</textarea>
                </div>

                {{-- image --}}
                <div class="form-group">
                    <label> {{ __('site.image') }} </label>
                    <input type='file' id="imgInp" name="image" class="form-image " />
                    <img id="image" src="" alt="{{ __('site.pick_image') }}" />
                </div>

                {{-- video --}}
                <div class="form-group">
                    <label> {{ __('site.video') }} </label>
                    <input type="file" name="video" class="file_multi_video" accept="video/*">

                    <video class="video-preview" controls>
                        <source src="" id="video_here">
                        {{ __('site.pick_video') }}
                    </video>
                </div>

                {{-- copied_from --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="copied_from" placeholder="{{ __('site.copied_from') }}" value="{{ $article->copied_from }}">
                </div>
                {{-- category --}}
                <div class="form-group">
                    <select id="form-control-3" name="cat_id" class="custom-select" data-error="This field is required." required='required'>
                        <option value="">{{ __('site.choose_category') }}</option>
                        @foreach ($article_categories as $article_category)
                            <option value="{{ $article_category->id }}" {{ $article->cat_id == $article_category->id ? 'selected' : '' }} >{{ $article_category->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- submit --}}
                <div class="m-y-30">
                    <button type="submit" class="btn btn-success" id="continue">{{ __('site.continue') }}</button>
                </div>

            </form>
            </div>
        </div>
    </div>
</div>


@endsection
