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
                                @if (Auth::guard('clients')->user())

                                    @if ((Auth::guard('clients')->user()->plan_id == $plan->id) && Auth::guard('clients')->user()->week == $week && Auth::guard('clients')->user()->day >= $day )
                                        <span class="text-primary" style="margin-left: 5px"><i class="zmdi zmdi-check-all zmdi-hc-lg"></i></span>
                                    @endif

                                @endif

                            </div>
                            <div class="col-md-6 text-right">
                                <a class="btn btn-primary btn-sm" href="{{ route('web.plans.show.day',[$plan->id,$week,$day]) }}"> {{ __('site.show') }} </a>
                                @if (Auth::guard('clients')->user())
                                    <a class="btn btn-danger btn-sm" href="{{ route('web.plans.start.day',['plan_id'=>$plan->id,'week'=>$week,'day'=>$day,'client_id'=>Crypt::encrypt(Auth::guard('clients')->user()->id)]) }}"> {{ __('site.start') }} </a>
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>
    @endfor

@endsection
