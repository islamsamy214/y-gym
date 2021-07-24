@extends('layouts.web')
@section('content')
<div class="container">
    <ul class="list-group day-workouts-list">

        <li class="list-group-item row">
            <div class="col-md-3">{{ __('site.image') }}</div>
            <div class="col-md-6 text-center">{{ __('site.name') }}</div>
            <div class="col-md-3 text-right">{{ __('site.reps') }}</div>
        </li>

        @foreach ($workouts as $workout)
            <li class="list-group-item row">
                <div class="col-md-3"><img src="{{ $workout['workout_atrr']->image_path }}" class="img-thumbnail" width="64"></div>
                <div class="col-md-6 text-center">{{ $workout['workout_atrr']->name }}</div>
                <div class="col-md-3 text-right">{{ $workout['repeats'] }} x {{ $workout['reps'] }}</div>
            </li>
        @endforeach

    </ul>
</div>
@endsection
