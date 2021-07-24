@if(session('success'))
    <div class="alert alert-success alert-dismissable" role="alert" id="success-alert">
        <button type="button" class="close" data-dismiss="alert" id="success-btn" aria-label="Close">
        <span aria-hidden="true">
            <i class="zmdi zmdi-close"></i>
        </span>
        </button>
        <span class="alert-icon">
        <i class="zmdi zmdi-check"></i>
        </span>
        {{session('success')}}
    </div>
@endif
{{-- don't forget the js and css --}}
