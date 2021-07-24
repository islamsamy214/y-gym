@extends('layouts.admin')
@section('content')
    <div class="row control-bar">
        <div class="col-md-4 search-bar" >
            <form method="GET" action="{{ route('article_categories.index') }}">
                <div class="navbar-search-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                    <button type="submit" class="btn btn-default">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (auth()->user()->hasPermission('article_categories_create'))

            @include('admin.article-categories.create')

        @endif

    </div>

    @if ($article_categories->count() > 0)
        <h4> {{ __('site.total') }} : {{ $article_categories->total() }}</h4>

        <div class="table-responsive">
            <table class="table text-center">
              <thead>
                <tr>
                  <th>{{ __('site.article_category_name') }}</th>
                  <th>{{ __('site.created_by') }}</th>
                  <th>{{ __('site.action') }}</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($article_categories as $article_category)
                <tr>

                    <td class="cursor-pointer" onclick="location.href = '{{ route('articles.index',['search'=>$article_category->name]) }}'">
                        {{ $article_category->name }}
                    </td>
                    <td>
                      {{ $article_category->user->name }}
                      <br>
                      <small class="text-muted">{{ $article_category->created_at }}</small>
                    </td>


                    <td class="actions">
                        @if (auth()->user()->hasPermission('article_categories_update'))
                            <a href="{{ route('article_categories.edit',$article_category->id) }}" class="btn btn-primary">
                                <i class="zmdi zmdi-border-color"></i>
                            </a>
                        @endif
                        @if (auth()->user()->hasPermission('article_categories_delete'))
                        <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('article_categories.destroy',$article_category->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete"><i class="zmdi zmdi-delete"></i></button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach

                <div class="col-sm-12 text-center">
                    {{$article_categories->appends(request()->query())->links()}}
                    {{--appends(request()->query()) to not to damage the url when using search--}}
                </div>

              </tbody>
            </table>
          </div>

    @else
        <h1 class="text-center">
            {{ __('site.no_data') }}
        </h1>
    @endif


@endsection
