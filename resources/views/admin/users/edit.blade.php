@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="m-y-0">{{ __('site.edit_user') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <form class="form-material" action="{{ route('users.update',$user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('includes.errors')

                {{-- name --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required value="{{ $user->name }}">
                    <small id="name_error" class="form-text text-danger"></small>
                </div>

                {{-- email --}}
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="{{ __('site.email') }}" required value="{{ $user->email }}">
                    <small id="email_error" class="form-text text-danger"></small>

                </div>

                {{-- phone --}}
                <div class="form-group">
                    <input class="form-control" type="number" name="phone" placeholder="{{ __('site.phone') }}" required value="{{ $user->phone }}">
                    <small id="phone_error" class="form-text text-danger"></small>

                </div>

                {{-- password --}}
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="{{ __('site.password') }}" required>
                    <small id="password_error" class="form-text text-danger"></small>

                </div>

                {{-- password_confirmation --}}
                <div class="form-group">
                    <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('site.password_confirmation') }}" required>
                    <small id="password_confirmation_error" class="form-text text-danger"></small>

                </div>

                {{-- image --}}
                <div class="form-group">
                    <label> {{ __('site.image') }} </label>
                    <input type='file' id="imgInp" name="image" class="form-image " />
                    <img id="image" src="" alt="{{ __('site.pick_image') }}" />
                    <small id="image_error" class="form-text text-danger"></small>

                </div>

                {{-- permissions --}}
                @php
                    $models = ['users', 'articles_category', 'workouts_category', 'articles', 'workouts', 'plans'];
                    $permissions = ['create','read','update','delete'];
                @endphp
                <div class="form-group">
                    <ul class="nav nav-tabs nav-tabs-custom m-b-15">

                        @foreach ($models as $index=>$model)
                            <li class="{{ $index == 0 ? 'active' : '' }}">
                                <a href="#{{ $model }}" role="tab" data-toggle="tab">
                                    {{ __('site.'.$model) }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                    <div class="tab-content">
                        @foreach ($models as $index=>$model)
                            <div role="tabpanel" class="tab-pane fade in {{ $index == 0 ? 'active' : '' }}" id="{{ $model }}">
                                <div class="custom-controls-stacked">
                                    @foreach ($permissions as $permission)
                                        <label class="custom-control custom-control-primary custom-checkbox active">
                                            <input class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $model.'_'.$permission }}" {{ $user->hasPermission($model.'_'.$permission) ? 'checked' : ''}}>
                                            <span class="custom-control-indicator"></span>
                                            <span class="custom-control-label">{{ __('site.'.$permission) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <small id="permissions_error" class="form-text text-danger"></small>

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
