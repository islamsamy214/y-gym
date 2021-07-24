@extends('layouts.web')
@section('content')

    <div class="form-wizard">
        <div class="fw-header">
            <ul class="nav nav-pills">

                @foreach ($workouts as $index=>$workout)

                    <li class="{{ $index == 0 ? 'active' : '' }}"><a href="#tab{{ $index }}" data-toggle="tab">{{ __('site.workout') }} : {{ $index + 1 }} <span class="chevron"></span></a></li>

                @endforeach

            </ul>
        </div>
        <div class="tab-content p-x-15">

            @foreach ($workouts as $index => $workout)
                <div class="tab-pane {{ $index == 0 ? 'active' : '' }} text-center" id="tab{{ $index }}">
                    <h2 class="m-t-0 m-b-30">{{ __('site.workout') }} : {{ $index + 1 }}</h2>
                    <div class="container">
                        <div class="row">
                            <div class="col-md-4">
                                <img src="{{ $workout['workout_attr']->image_path }}" alt="" width="64" class="img-thumbnail">
                                <h3 class="d-inline" style="margin-left: 5px ">{{ $workout['workout_attr']->name }}</h3>
                            </div>
                            <div class="col-md-4">
                                <h3>{{ $workout['reps'].' x '.$workout['repeats'] }}</h3>
                            </div>
                            <div class="col-md-4">
                                <h3><button type="button" class="btn btn-primary m-w-120" data-toggle="modal" data-target="#primaryModal{{ $workout['workout_attr']->id }}">{{ __('site.video') }}</button></h3>
                                <div id="primaryModal{{ $workout['workout_attr']->id }}" class="modal fade" tabindex="-1" role="dialog" style="display: none;">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">
                                                    <i class="zmdi zmdi-close"></i>
                                                </span>
                                            </button>
                                                <h4 class="modal-title">{{ $workout['workout_attr']->name }}</h4>
                                            </div>
                                            <div class="modal-body">
                                                <iframe width="560" height="315" src="{{ $workout['workout_attr']->ytb_link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-dismiss="modal" class="btn btn-primary">{{ __('site.close') }}</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="fw-footer">
            <ul class="pager wizard">
            <li class="previous first" style="display:none"><a href="#">{{ __('site.first') }}</a></li>
            <li class="previous"><a href="#">{{ __('site.pervious') }}</a></li>
            <li class="next last" style="display:none"><a href="#">{{ __('site.last') }}</a></li>
            <li class="next"><a href="#">{{ __('site.next') }}</a></li>
            </ul>
        </div>
        <div id="bar" class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
        </div>
    </div>

@endsection
