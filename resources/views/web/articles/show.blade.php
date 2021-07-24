@extends('layouts.web')
@section('content')
    @for ($week = 1; $week <= $plan->duration; $week++)
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-full-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Week {{ $week }}</h3>
                </div>
                <div class="panel-body">
                    @for ($day = 1; $day <= 7; $day++)
                        <div class='workout-days row'>
                            <div class="col-md-6">
                                {{ __('site.day') }} {{ $day }}
                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('web.plans.show.day',[$plan->id,$week,$day]) }}"> {{ __('site.show') }} </a>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @endfor

@endsection
