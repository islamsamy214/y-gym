
<div class="col-md-7 buttons-bar">
    <button type="button" class="btn btn-outline-success m-w-120" data-toggle="modal" data-target="#add-plan">{{ __('site.add_plan') }}</button>

    <div id="add-plan" class="modal fade" tabindex="-1" role="dialog">
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
                            <h3 class="m-y-0">{{ __('site.add_plan') }}</h3>
                            </div>
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-md-12">
                                <form class="form-material" action="" id="plan-form" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    {{-- @method('POST') --}}
                                    {{-- @include('includes.errors') --}}

                                    {{-- name --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required='required'>
                                        <small id="name_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- duration --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="duration" placeholder="{{ __('site.duration_by_weeks') }}" required='required'>
                                        <small id="duration_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- level --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="level" placeholder="{{ __('site.fitness_level') }}" required='required'>
                                        <small id="level_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- equipments --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="equipments" placeholder="{{ __('site.equipments_needed') }}" required='required'>
                                        <small id="equipments_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- image --}}
                                    <div class="form-group">
                                        <label> {{ __('site.image') }} </label>
                                        <input type='file' id="imgInp" name="image" class="form-image " />
                                        <img id="image" src="" alt="{{ __('site.pick_image') }}" />
                                        <small id="image_error" class="form-text text-danger"></small>
                                    </div>

                                    {{-- category --}}
                                    <div class="form-group">
                                        <select id="form-control-3" name="cat_id" class="custom-select" data-error="This field is required." required='required'>
                                            <option value="" selected="selected">{{ __('site.choose_category') }}</option>
                                            @foreach ($plan_categories as $plan_category)
                                                <option value="{{ $plan_category->id }}">{{ $plan_category->name }}</option>
                                            @endforeach
                                        </select>
                                        <small id="cat_id_error" class="form-text text-danger"></small>
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

    var formData = new FormData($('#plan-form')[0]);

    $.ajax({
        type: 'POST',
        url:'{{ route("plans.store") }}',
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success:function (data) {

            if (data.status==true){
                location.reload();
                $("#plan-form")[0].reset();
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
