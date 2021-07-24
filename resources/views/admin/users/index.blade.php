@extends('layouts.admin')
@section('content')
    <div class="row control-bar">
        <div class="col-md-4 search-bar" >
            <form method="GET" action="{{ route('users.index') }}">
                <div class="navbar-search-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                    <button type="submit" class="btn btn-default">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (auth()->user()->hasPermission('users_create'))

            @include('admin.users.create')

        @endif

    </div>

    @if ($users->count() > 0)
        <div class="profile">
            <h4> {{ __('site.total') }} : {{ $users->total() }}</h4>
            @foreach ($users as $user)
                <div class="col-md-4 col-sm-5">
                    <div class="p-about m-b-20">
                        <div class="pa-padding">
                            <div class="pa-avatar">
                                <img src="{{ $user->image_path }}" alt="" width="100" height="100">
                            </div>

                            <div class="pa-name">{{ $user->name }}</div>
                            <div class="pa-text">{{ $user->email }}</div>
                            <div class="pa-text">{{ $user->phone }}</div>

                            <div class="profile-btn">

                                @if (auth()->user()->hasPermission('users_update'))
                                    <a href="{{ route('users.edit',$user->id) }}" class="btn btn-primary m-r-10">
                                        <i class="zmdi zmdi-border-color"></i>   {{ __('site.edit') }}
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('users_delete'))
                                    <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('users.destroy',$user->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete"> <i class="zmdi zmdi-minus"></i>   {{ __('site.delete') }}</button>
                                    </form>
                                @endif
                            </div>

                        </div>
                        <div class="pa-stat">
                            <div class="row no-gutter">
                            <div class="pas-item col-xs-6">
                                <div class="pas-number">17</div>
                                <div class="pas-text">{{ __('site.workout') }}</div>
                            </div>
                            <div class="pas-item col-xs-6">
                                <div class="pas-number">24</div>
                                <div class="pas-text">{{ __('site.article') }}</div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-12 text-center">
                {{$users->appends(request()->query())->links()}}
                {{--appends(request()->query()) to not to damage the url when using search--}}
            </div>
        </div>
    @else
        <h1 class="text-center">
            {{ __('site.no_data') }}
        </h1>
    @endif


@endsection
