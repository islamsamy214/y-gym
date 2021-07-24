<div class="alert alert-warning alert-delete-warning alert-dismissable text-center" role="alert">
    <div class="alert-icon">
      <i class="zmdi zmdi-alert-triangle"></i>
    </div>
    <div class="alert-message">
      <h3>{{ __('site.confirm_delete') }}</h3>
      <div class="col-xs-6">
        <button type="button" class="btn btn-default m-w-120 warning-close">{{ __('site.no') }}</button>
      </div>
      <div class="col-xs-6">
        <button type="button" class="btn btn-danger m-w-120 warning-continue">{{ __('site.yes') }}</button>
      </div>
    </div>
</div>
{{-- don't forget the js and css --}}
