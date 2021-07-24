@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="m-y-0">{{ __('site.edit_plan') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <form class="form-material" action="{{ route('plans.update',$plan->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                @include('includes.errors')

                {{-- name --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required='required' value="{{ $plan->name }}">
                </div>

                {{-- duration --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="duration" placeholder="{{ __('site.duration_by_weaks') }}" required='required' value="{{ $plan->duration }}">
                    <small id="duration_error" class="form-text text-danger"></small>
                </div>

                {{-- level --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="level" placeholder="{{ __('site.fitness_level') }}" required='required' value="{{ $plan->level }}">
                    <small id="level_error" class="form-text text-danger"></small>
                </div>

                {{-- equipments --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="equipments" placeholder="{{ __('site.equipments_needed') }}" required='required' value="{{ $plan->equipments }}">
                    <small id="equipments_error" class="form-text text-danger"></small>
                </div>

                {{-- image --}}
                <div class="form-group">
                    <label> {{ __('site.image') }} </label>
                    <input type='file' id="imgInp" name="image" class="form-image " />
                    <img id="image" src="" alt="{{ __('site.pick_image') }}" />
                </div>

                {{-- category --}}
                <div class="form-group">
                    <select id="form-control-3" name="cat_id" class="custom-select" data-error="This field is required." required='required'>
                        <option value="">{{ __('site.choose_category') }}</option>
                        @foreach ($plan_categories as $plan_category)
                            <option value="{{ $plan_category->id }}" {{ $plan->cat_id == $plan_category->id ? 'selected' : '' }} >{{ $plan_category->name }}</option>
                        @endforeach
                    </select>
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
