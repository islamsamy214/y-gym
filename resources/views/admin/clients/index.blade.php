@extends('layouts.admin')
@section('content')
    <div class="row control-bar">
        <div class="col-md-4 search-bar" >
            <form method="GET" action="{{ route('clients.index') }}">
                <div class="navbar-search-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                    <button type="submit" class="btn btn-default">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (auth()->user()->hasPermission('clients_create'))

            @include('admin.clients.create')

        @endif

    </div>

    @if ($clients->count() > 0)
        <div class="profile">
            <h4> {{ __('site.total') }} : {{ $clients->total() }}</h4>
            @foreach ($clients as $client)
                <div class="col-md-3 col-sm-5">
                    <div class="p-about m-b-20">
                        <div class="pa-padding">
                            <div class="pa-avatar">
                                <img src="{{ $client->image_path }}" alt="" width="100" height="100">
                            </div>

                            <div class="pa-name">{{ $client->name }}</div>
                            <div class="pa-text">{{ $client->email }}</div>
                            <div class="pa-text">{{ $client->phone }}</div>

                            <div class="profile-btn">

                                @if (auth()->user()->hasPermission('clients_update'))
                                    <a href="{{ route('clients.edit',$client->id) }}" class="btn btn-primary m-r-10">
                                        <i class="zmdi zmdi-border-color"></i>   {{ __('site.edit') }}
                                    </a>
                                @endif

                                @if (auth()->user()->hasPermission('clients_delete'))
                                    <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('clients.destroy',$client->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger delete"> <i class="zmdi zmdi-minus"></i>   {{ __('site.delete') }}</button>
                                    </form>
                                @endif
                            </div>

                        </div>

                        <div class="pa-stat">
                            <div class="row no-gutter {{ $client->is_subscribed ? 'status-paid' : 'status-warning' }}">
                            <div class="pas-item col-xs-6">
                                @if ($client->is_subscribed)
                                    <div class="pas-text">{{ __('site.paid_in').' : '.$client->payed_date}}</div>
                                @else
                                    <div class="pas-text">{{ __('site.didn\'t_pay') }}</div>
                                @endif
                            </div>
                            <div class="pas-item col-xs-6">
                                @if ($client->is_subscribed)
                                    <div class="pas-text">{{ __('site.paid_until').' : '.$client->expiry_date}}</div>
                                @else
                                    <a type="button" class="btn btn-default m-w-120 btn-sm" href="{{ route('clients.payment',$client->id) }}"> {{ __('site.pay') }}</a>
                                @endif
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-12 text-center">
                {{$clients->appends(request()->query())->links()}}
                {{--appends(request()->query()) to not to damage the url when using search--}}
            </div>
        </div>
    @else
        <h1 class="text-center">
            {{ __('site.no_data') }}
        </h1>
    @endif


@endsection
