@extends('layouts.admin')
@section('content')

<div class="panel panel-default m-b-0">
    <div class="form-wizard">
        <div class="fw-header">
            <ul class="nav nav-pills">

                @for ($week = 1; $week <= $plan->duration; $week++)

                    <li class="{{ $week == 1 ? 'active' : ''}}"><a id="week-tab-{{ $week }}" href="#week-{{ $week }}" data-toggle="tab" class="link-disabled">{{ __('site.week') }} {{ $week }} <span class="chevron"></span></a></li>

                @endfor

            </ul>
        </div>
        <div class="tab-content p-x-15">


            @for ($week = 1; $week <= $plan->duration; $week++)

                <div class="tab-pane {{ $week == 1 ? 'active' : ''}} row" id="week-{{ $week }}">

                    <h5 class='text-center days-header' > {{ __('site.day') }} : 1</h5>
                    <form action=""  method="post" class="workout-plan-form row text-center form-matrial">
                        @csrf

                        <input type="text" name="week" value="{{ $week }}" hidden/>
                        <input type="text" name="day" class="day-inp" value="1" hidden/>

                        <div class="workout-content">
                        </div>

                        <div class="form-group col-sm-12 text-center">
                            <button class="btn btn-outline-primary add-workout" onclick="addWorkout(event)">
                                {{ __('site.add_workout') }}
                            </button>
                        </div>

                        <div class="col-sm-12 text-center">
                            <button type="submit" class="next btn btn-primary" >{{ __('site.next') }}</button>
                        </div>
                    </form>

                </div>
            @endfor

        </div>

    <div id="bar" class="progress">
        <div class="progress-bar" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>
    </div>
    </div>
</div>

<script>

    var div_childs = 0;

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
                                <input type="text" class="form-control" name="repeats[]" placeholder="{{ __('site.repeats') }}"/>
                            </div>
                            <div class="form-group col-sm-3">
                                <input type="text" class="form-control" name="reps[]" placeholder="{{ __('site.reps') }}"/>
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
    //to prevent all things might run and run only the ajax
    event.preventDefault();
    var formData = new FormData($(this).closest('.workout-plan-form')[0]);

        $.ajax({
            type: 'POST',
            url:'{{ route('plans.set_plan',$plan->id) }}',
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            success:function (data) {

                if (data.day==true){
                    $(".workout-plan-form")[0].reset();
                    $('.workout-content').html('');
                    var day_header = $('.days-header').html().slice(0,-1);
                    $('.days-header').text(day_header+data.next_day);
                    $('.day-inp').val(data.next_day);

                    $('.errors').remove();
                }

                if(data.week==true){
                    $(".workout-plan-form")[0].reset();
                    var day_header = $('.days-header').html().slice(0,-1);
                    $('.days-header').text(day_header+1);
                    $('.day-inp').val(1);
                    document.getElementById('week-tab-'+data.next_week).click();
                }

                if(data.status==true){
                    location.href = '{{ route('plans.index') }}';
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
    });//end of sending form


    $(document).on('click','#select-workouts',function(event){

        event.preventDefault();
        alert('');
    });//end of add select more


</script>


@endsection
