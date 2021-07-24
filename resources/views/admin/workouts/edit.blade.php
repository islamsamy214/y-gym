@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="m-y-0">{{ __('site.edit_workout') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <form class="form-material" action="{{ route('workouts.update',$workout->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('includes.errors')

                {{-- name --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required value="{{ $workout->name }}">
                    <small id="name_error" class="form-text text-danger"></small>
                </div>
                {{-- muscle --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="muscle" placeholder="{{ __('site.muscle') }}" required value="{{ $workout->muscle }}">
                    <small id="muscle_error" class="form-text text-danger"></small>
                </div>
                {{-- ytb_link --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="ytb_link" placeholder="{{ __('site.ytb_link') }}" required value="{{ $workout->ytb_link }}">
                    <small id="ytb_link_error" class="form-text text-danger"></small>
                </div>
                {{-- equipment_type --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="equipment_type" placeholder="{{ __('site.equipment_type') }}" value="{{ $workout->equipment_type }}">
                    <small id="equipment_type_error" class="form-text text-danger"></small>
                </div>
                {{-- level --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="level" placeholder="{{ __('site.level') }}" value="{{ $workout->level }}">
                    <small id="level_error" class="form-text text-danger"></small>
                </div>
                {{-- exercise_type --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="exercise_type" placeholder="{{ __('site.exercise_type') }}" value="{{ $workout->execrcise_type }}">
                    <small id="exercise_type_error" class="form-text text-danger"></small>
                </div>
                {{-- image --}}
                <div class="form-group">
                    <label> {{ __('site.image') }} </label>
                    <input type='file' id="imgInp" name="image" class="form-image " />
                    <img id="image" src="" alt="{{ __('site.pick_image') }}" />
                    <small id="image_error" class="form-text text-danger"></small>
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
