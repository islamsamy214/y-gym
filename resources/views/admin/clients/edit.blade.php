@extends('layouts.admin')
@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
    <h3 class="m-y-0">{{ __('site.edit_client') }}</h3>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
            <form class="form-material" action="{{ route('clients.update',$client->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                @include('includes.errors')

                {{-- name --}}
                <div class="form-group">
                    <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required value="{{ $client->name }}">
                </div>

                {{-- email --}}
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="{{ __('site.email') }}" required value="{{ $client->email }}">
                </div>

                {{-- phone --}}
                <div class="form-group">
                    <input class="form-control" type="number" name="phone" placeholder="{{ __('site.phone') }}" required value="{{ $client->phone }}">
                </div>

                {{-- password --}}
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="{{ __('site.password') }}" required>
                </div>

                {{-- password_confirmation --}}
                <div class="form-group">
                    <input class="form-control" type="password" name="password_confirmation" placeholder="{{ __('site.password_confirmation') }}" required>
                </div>

                {{-- image --}}
                <div class="form-group">
                    <label> {{ __('site.image') }} </label>
                    <input type='file' id="imgInp" name="image" class="form-image " />
                    <img id="image" src="" alt="{{ __('site.pick_image') }}" />
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
