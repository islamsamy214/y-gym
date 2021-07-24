
<div class="col-md-7 buttons-bar">
    <button type="button" class="btn btn-outline-success m-w-120" data-toggle="modal" data-target="#add-user">{{ __('site.add_user') }}</button>

    <div id="add-user" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">
                        <i class="zmdi zmdi-close"></i>
                        </span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="text-center">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                            <h3 class="m-y-0">{{ __('site.add_user') }}</h3>
                            </div>
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                <form class="form-material" action="" id="user-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @method('POST') --}}

                                    {{-- @include('includes.errors') --}}

                                    {{-- name --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required>
                                        <small id="name_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- email --}}
                                    <div class="form-group">
                                        <input class="form-control" type="email" name="email" placeholder="{{ __('site.email') }}" required>
                                        <small id="email_error" class="form-text text-danger"></small>

                                    </div>

                                    {{-- phone --}}
                                    <div class="form-group">
                                        <input class="form-control" type="number" name="phone" placeholder="{{ __('site.phone') }}" required>
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
                                        $models = ['users', 'clients','article_categories', 'plan_categories', 'articles', 'workouts', 'plans'];
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
                                                                <input class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $model.'_'.$permission }}">
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
                                        <button type="button" data-dismiss="modal" class="btn btn-default">{{ __('site.close') }}</button>
                                    </div>

                                </form>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer"></div>
            </div>
        </div>
    </div>
</div>

<script>
$(document).on('click','#continue',function (event) {
    //to prevent all things might run and run only the ajax
    event.preventDefault();

    var formData = new FormData($('#user-form')[0]);

    $.ajax({
        type: 'POST',
        url:'{{ route("users.store") }}',
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success:function (data) {

            if (data.status==true){
                location.reload();
                $("#user-form")[0].reset();
            }

        },
        error:function (data) {
            var errors = data.responseJSON;
            $.each( errors.errors, function( key, value ) {
                $('#'+key+"_error").text(value[0]);
            });
        },
    });
});
</script>
