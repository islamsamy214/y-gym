@extends('layouts.admin')
@section('content')
    <div class="row control-bar">
        <div class="col-md-4 search-bar" >
            <form method="GET" action="{{ route('plans.index') }}">
                <div class="navbar-search-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                    <button type="submit" class="btn btn-default">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (auth()->user()->hasPermission('plans_create'))

            @include('admin.plans.create')

        @endif

    </div>

    @if ($plans->count() > 0)
        <h4> {{ __('site.total') }} : {{ $plans->total() }}</h4>


        <div class="row">

            @foreach ($plans as $plan)
                <div class="col-sm-6 col-md-4">
                    <div class="panel panel-info plan-panel-info">
                        <div class="panel-heading">

                            <h3 class="panel-title">{{ $plan->name }}</h3>
                            <div class="panel-subtitle">{{ $plan->planCategory->name }}</div>
                        </div>
                        @if ($plan->image)
                            <div class="panel-body plan-panel-body">
                                <img src="{{ $plan->image_path }}">
                            </div>
                        @endif
                        <div class="panel-footer">
                            <div class="row">
                                <div class="col-md-6 col-xs-6">
                                    <div class="panel-detail">{{ __('site.duration') }}</div>
                                    <h4 class="panel-description">{{ $plan->duration.' '.__('site.weaks') }}</h4>

                                    <div class="panel-detail">{{ __('site.fitness_level') }}</div>
                                    <h4 class="panel-description">{{ $plan->level }}</h4>
                                </div>
                                <div class="col-md-6 col-xs-6">
                                    <div class="panel-detail">{{ __('site.workouts_per_week') }}</div>
                                    <h4 class="panel-description">{{ $plan->workouts->count() }} {{ __('site.workouts') }}</h4>

                                    <div class="panel-detail">{{ __('site.equipments_needed') }}</div>
                                    <h4 class="panel-description">{{ $plan->equipments }}</h4>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <h5>{{ __('site.created_by').' : '.$plan->user->name }}</h5>
                                </div>
                                <div class="col-md-8">
                                    <div class="text-right">
                                        @if ($plan->workouts->all() != null)
                                            <a href="{{ route('plans.edit_plan',$plan->id) }}" class="btn btn-info btn-labeled">{{ __('site.continue') }}
                                                <span class="btn-label btn-label-right">
                                                    <i class="zmdi zmdi-arrow-right"></i>
                                                </span>
                                            </a>
                                        @else
                                            <a href="{{ route('plans.show',$plan->id) }}" class="btn btn-info btn-labeled">{{ __('site.continue') }}
                                                <span class="btn-label btn-label-right">
                                                    <i class="zmdi zmdi-arrow-right"></i>
                                                </span>
                                            </a>
                                        @endif

                                        <a href="{{ route('plans.edit',$plan->id) }}" class="btn btn-warning btn-labeled">{{ __('site.edit') }}
                                            <span class="btn-label btn-label-right">
                                                <i class="zmdi zmdi-border-color"></i>
                                            </span>
                                        </a>

                                        @if (auth()->user()->hasPermission('plan_categories_delete'))
                                        <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('plans.destroy',$plan->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-labeled delete">{{ __('site.delete') }}
                                                <span class="btn-label btn-label-right">
                                                    <i class="zmdi zmdi-delete"></i>
                                                </span>
                                            </button>
                                        </form>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            @endforeach

            <div class="col-sm-12 text-center">
                {{$plans->appends(request()->query())->links()}}
                {{--appends(request()->query()) to not to damage the url when using search--}}
            </div>
        </div>
    @else
        <h1 class="text-center">
            {{ __('site.no_data') }}
        </h1>
    @endif


@endsection
