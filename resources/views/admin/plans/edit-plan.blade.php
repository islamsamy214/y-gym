@extends('layouts.admin')
@section('content')

    @for ($week = 1; $week <= $plan->duration; $week++)
        <div class="col-sm-6 col-md-4">
            <div class="panel panel-full-info">
                <div class="panel-heading">
                    <h3 class="panel-title">Week {{ $week }}</h3>
                </div>
                <div class="panel-body">
                    @for ($day = 1; $day <= 7; $day++)
                        <div class='workout-days row'>
                            <div class="col-md-6">
                                {{ __('site.day') }} {{ $day }}
                            </div>
                            <div class="col-md-6 text-right">
                                <button class="btn btn-info btn-sm" type="button" data-toggle="modal" data-target="#day-{{ $day }}-week-{{ $week }}" onclick="updateDivChilds({{ $day }},{{ $week }})"> {{ __('site.edit') }} </button>
                            </div>
                        </div>
                    @endfor
                </div>
            </div>
        </div>

        @for ($day = 1; $day <= 7; $day++)

            <div id="day-{{ $day }}-week-{{ $week }}" class="modal fade" tabindex="-1" role="dialog">
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
                                    <h3 class="m-y-0">{{ __('site.day').' : '.$day }}</h3>
                                    </div>
                                    <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                        <form class="workout-plan-form row text-center form-matrial" action="" method="POST">
                                            @csrf
                                            <input type="text" name="week" value="{{ $week }}" hidden/>
                                            <input type="text" name="day" class="day-inp" value="{{ $day }}" hidden/>

                                            {{-- workout-content --}}
                                            <div class="form-group">
                                                <div class="workout-content">
                                                    @foreach ($plan->workouts as $workout)

                                                        @if ($workout->pivot->day == $day && $workout->pivot->week == $week)
                                                            <div data-div_childs="{{ $workout->pivot->order }}" class="workout-content-{{ $workout->pivot->order }}" id="workout-content-day-{{ $day }}-week-{{ $week }}">
                                                                <div class="form-group col-sm-5">
                                                                    <select name="workout_ids[]" class="custom-select form-control">
                                                                        <option value="">{{ __('site.choose_workout') }}</option>
                                                                        @foreach ($workouts as $oriWorkout)
                                                                            <option value="{{ $oriWorkout->id }}" {{ $oriWorkout->id == $workout->pivot->workout_id ? 'selected = "selected"' : '' }}>{{ $oriWorkout->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="form-group col-sm-3">
                                                                    <input type="text" class="form-control" name="repeats[]" placeholder="{{ __('site.repeats') }}" value="{{ $workout->pivot->repeats }}"/>
                                                                </div>
                                                                <div class="form-group col-sm-3">
                                                                    <input type="text" class="form-control" name="reps[]" placeholder="{{ __('site.reps') }}" value="{{ $workout->pivot->reps }}"/>
                                                                </div>
                                                                <div class="form-group col-sm-1">
                                                                    <button class="btn btn-danger" div-class-name = "workout-content-{{ $workout->pivot->order }}" onclick="deleteWorkout(event,this)">
                                                                        <i class="zmdi zmdi-delete"></i>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                        @endif

                                                    @endforeach
                                                </div>
                                            </div>

                                            {{-- add-workout-content --}}
                                            <div class="form-group col-sm-12 text-center">
                                                <button class="btn btn-outline-primary" onclick="addWorkout(event)">
                                                    {{ __('site.add_workout') }}
                                                </button>
                                            </div>

                                            {{-- submit --}}
                                            <div class="m-y-30">
                                                <button type="submit" class="btn btn-info next">{{ __('site.continue') }}</button>
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
        @endfor
    @endfor
    <script>
        $("select").select2();

        var day , week, div_childs;

        function updateDivChilds(day,week){
            var div_content = document.getElementById('workout-content-day-'+day+'-week-'+week+'');
            var div_childs = div_content.dataset.div_childs ;
            var day = day;
            var week = week;
        }

        function addWorkout(event){
            event.preventDefault();
            div_childs += 1;
            var content =
                        `
                            <div class="workout-content-`+div_childs+`">
                                <div class="form-group col-sm-5">
                                    <select name="workout_ids[]" class="custom-select form-control">
                                        <option value="" selected="selected">{{ __('site.choose_workout') }}</option>
                                        @foreach ($workouts as $workout)
                                            <option value="{{ $workout->id }}">{{ $workout->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="text" class="form-control" name="repeats[]" placeholder="{{ __('site.repeats') }}" value=""/>
                                </div>
                                <div class="form-group col-sm-3">
                                    <input type="text" class="form-control" name="reps[]" placeholder="{{ __('site.reps') }}" value=""/>
                                </div>
                                <div class="form-group col-sm-1">
                                    <button class="btn btn-danger" div-class-name = "workout-content-`+div_childs+`" onclick="deleteWorkout(event,this)">
                                        <i class="zmdi zmdi-delete"></i>
                                    </button>
                                </div>
                            </div>

                        `;

            $('.workout-content').append(content);
            $("select").select2();

        }

        function deleteWorkout(event,btn){
            event.preventDefault();
            var div_class_name = btn.getAttribute('div-class-name');
            btn.closest('.'+div_class_name).remove()
        }
        $(document).on('click','.next',function (event) {
            event.preventDefault();
            var formData = new FormData($(this).closest('.workout-plan-form')[0]);

            $.ajax({
                type: 'POST',
                url:'{{ route('plans.update_plan',$plan->id) }}',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success:function (data) {

                    if(data.status==true){
                        location.reload();
                    }

                },
                error:function (data) {
                    var errors = data.responseJSON;

                    var html = `
                                <div class="errors alert-danger col-md-6 col-md-offset-3 text-center"></div>
                                `;

                    $('.errors').remove();
                    $('.workout-plan-form').append(html);

                    $.each( errors.errors, function( key, value ) {
                        // $('#'+key+"_error").text(value[0]);
                        $('.errors').text(value);
                    });
                },
            });
        });
    </script>

@endsection
