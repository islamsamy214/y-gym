@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="m-y-0">{{ __('site.edit_plan_category') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <form class="form-material" action="{{ route('plan_categories.update',$plan_category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('includes.errors')

                {{-- name --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required value="{{ $plan_category->name }}">
                    <small id="name_error" class="form-text text-danger"></small>
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
