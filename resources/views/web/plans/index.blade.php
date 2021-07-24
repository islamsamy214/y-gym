@extends('layouts.web')
@section('content')

    <div class="container">
        <div class="row control-bar">
            <div class="col-md-4 search-bar" >
                <form method="GET" action="{{ route('web.plans') }}">
                    <div class="navbar-search-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                        <button type="submit" class="btn btn-default">
                            <i class="zmdi zmdi-search"></i>
                        </button>
                    </div>
                </form>
            </div>
            <div class="col-md-6">
                <ul class="nav nav-pills nav-pills-custom nav-justified m-b-15">
                    <li class="{{ $request->search ? '' : 'active' }}">
                        <a href="{{ route('web.plans') }}">
                        {{ __('site.all') }}</a>
                    </li>
                    @foreach ($plan_categories as $plan_category)
                        <li class="{{ $request->search == $plan_category->name ? 'active' : '' }}">
                            <a href="{{ route('web.plans',['search'=>$plan_category->name]) }}">
                            {{ $plan_category->name }}</a>
                        </li>
                    @endforeach
                    <hr>
                </ul>
            </div>
        </div>

        @if ($plans->count() > 0)
            <div class="row">
                @foreach ($plans as $plan)
                    <div class="col-sm-6 col-md-4 plan-card">
                        <div class="panel panel-primary plan-panel-primary">
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
                                    <div class="row">
                                        @if ($plan->workouts->all() != null)

                                            @if (Auth::guard('clients')->user() && Auth::guard('clients')->user()->is_subscribed)
                                                <div class="col-md-6">
                                                    <a href="{{ route('web.plans.show',$plan->id) }}" class="btn btn-primary btn-labeled">{{ __('site.show') }}
                                                        <span class="btn-label btn-label-right">
                                                            <i class="zmdi zmdi-eye"></i>
                                                        </span>
                                                    </a>
                                                </div>
                                                <div class="col-md-6 text-right">

                                                    @if (Auth::guard('clients')->user())
                                                        @if (Auth::guard('clients')->user()->plan_id == $plan->id)
                                                            <a href="{{ route('web.plans.start',['plan_id'=>$plan->id,'client_id'=>Crypt::encrypt(Auth::guard('clients')->user()->id)]) }}" class="btn btn-info btn-labeled">
                                                                {{ __('site.continue') }}
                                                                <span class="btn-label btn-label-right">
                                                                    <i class="zmdi zmdi-arrow-right"></i>
                                                                </span>
                                                            </a>
                                                        @else
                                                            <a href="{{ route('web.plans.start',['plan_id'=>$plan->id,'client_id'=>Crypt::encrypt(Auth::guard('clients')->user()->id)]) }}" class="btn btn-danger btn-labeled">
                                                                {{ __('site.start') }}
                                                                <span class="btn-label btn-label-right">
                                                                    <i class="zmdi zmdi-arrow-right"></i>
                                                                </span>
                                                            </a>
                                                        @endif

                                                    @endif

                                                </div>
                                            @else
                                                <div class="text-center ">{{ __('site.didn\'t_pay') }}</div>
                                            @endif
                                            
                                        @else
                                            <div class="text-center">{{ __('site.it\'s_under_prepration') }}</div>
                                        @endif
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
    </div>
    <div class="fix-footer-position"></div>
@endsection
