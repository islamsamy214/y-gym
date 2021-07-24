
<div class="col-md-7 buttons-bar">
    <button type="button" class="btn btn-outline-success m-w-120" data-toggle="modal" data-target="#add-workout">{{ __('site.add_workout') }}</button>

    <div id="add-workout" class="modal fade" tabindex="-1" role="dialog">
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
                            <h3 class="m-y-0">{{ __('site.add_workout') }}</h3>
                            </div>
                            <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 col-md-offset-3">
                                <form class="form-material" action="" id="workout-form" method="POST">
                                    @csrf
                                    {{-- @method('POST') --}}
                                    {{-- @include('includes.errors') --}}

                                    {{-- name --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" required>
                                        <small id="name_error" class="form-text text-danger"></small>
                                    </div>
                                    {{-- muscle --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="muscle" placeholder="{{ __('site.muscle') }}" required>
                                        <small id="muscle_error" class="form-text text-danger"></small>
                                    </div>
                                    {{-- ytb_link --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="ytb_link" placeholder="{{ __('site.ytb_link') }}" required>
                                        <small id="ytb_link_error" class="form-text text-danger"></small>
                                    </div>
                                    {{-- equipment_type --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="equipment_type" placeholder="{{ __('site.equipment_type') }}" required>
                                        <small id="equipment_type_error" class="form-text text-danger"></small>
                                    </div>
                                    {{-- level --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="level" placeholder="{{ __('site.level') }}" required>
                                        <small id="level_error" class="form-text text-danger"></small>
                                    </div>
                                    {{-- exercise_type --}}
                                    <div class="form-group">
                                        <input class="form-control" type="text" name="exercise_type" placeholder="{{ __('site.exercise_type') }}" required>
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

    var formData = new FormData($('#workout-form')[0]);

    $.ajax({
        type: 'POST',
        url:'{{ route("workouts.store") }}',
        data: formData,
        enctype: 'multipart/form-data',
        processData: false,
        contentType: false,
        cache: false,
        success:function (data) {

            if (data.status==true){
                location.reload();
                $("#workout-form")[0].reset();
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
