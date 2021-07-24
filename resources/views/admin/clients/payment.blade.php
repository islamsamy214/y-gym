@extends('layouts.admin')
@section('content')
    <form class="form-material" id="form" method="POST" action="{{ route("clients.payment",$client_id) }}">
        @csrf
        @method('POST')
        <div class="form-group">
            <input class="form-control" type="number" name="months" placeholder="{{ __('site.months') }}">
            @error('months')
                <small id="months_error" class="text-danger">{{ $message }}</small>
            @enderror
            
        </div>

        <div class="form-group">
            <input class="form-control" type="text" name="offers" placeholder="{{ __('site.offers_code') }}">
            <small id="offers_error" class="text-danger"></small>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-success">{{ __('site.continue') }}</button>
        </div>
    </form>
@endsection