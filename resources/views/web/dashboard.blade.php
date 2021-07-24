@extends('layouts.web')
@section('content')

<div class="head-img">
    <div class="head-img-overlay"></div>
    <div class="overlay-content">
        <img src="{{ asset('images/ovelay-img.png') }}">
        <div class="container">
            <div class="text-center">
                <h1>{{ __('site.the_ultimate_fitness_solution') }}</h1>
                <p>
                    {{ __('site.we_connect_you_with_the_top_experts_in_fitness_to_help_you_build_your_best_body_and_your_best_life_BodyFit_is_our_new_solution_to_help_give_you_what_you_need_from_full_life_changing_programs_to_great_workouts_and_exercise_instruction_you_can_put_into_action_any_day_of_the_week') }}
                </p>
            </div>
        </div>
    </div>
</div>
<div class="fix-img-position"></div>
<div class="container">
    <div class="row description-section">
        <div class="text-center description-header">
            <h1>{{ __('site.what_is_YGYM') }}</h1>
            <p class="d-block">
                {{ __('site.YGYM_is_your_source_for_full_fitness_programs_to_help_you_build_muscle,_lose_fat,_or_become_more_athletic._It’s_loaded_with_nutrition_and_exercise_plans,_follow-along_workout_videos,_and_thousands_of_individual_workouts,_available_through_our_top-rated_fitness_app._Y-GYM_is_everything_you_need_to_transform.') }}
            </p>
        </div>
        <div class="description-content">
            <div class="col-md-6">
                <span class="text-primary"><i class="zmdi zmdi-check-all zmdi-hc-lg"></i></span>
                <h4 class="d-inline">{{ __('site.Workout_Tables_on_All_Articles') }}</h4>
                <p>
                    {{__('site.See_the_killer_workouts_that_accompany_thousands_of_articles_on_Bodybuilding.com._This_includes_muscle-building_workouts_for_every_body_part,_as_well_as_workouts_for_fat_loss,_cardio,_sports_training,_and_plenty_more!')}}
                </p>
            </div>
            <div class="col-md-6">
                <span class="text-primary"><i class="zmdi zmdi-check-all zmdi-hc-lg"></i></span>
                <h4 class="d-inline">{{ __('site.Instructional_Videos') }}</h4>
                <p>
                    {{__('site.Avoid_injury_and_dial_in_your_form_with_in-depth_instructional_videos_covering_more_than_3,000_exercises.')}}
                </p>
            </div>
            <div class="col-md-6">
                <span class="text-primary"><i class="zmdi zmdi-check-all zmdi-hc-lg"></i></span>
                <h4 class="d-inline">{{ __('site.How-To_Images') }}</h4>
                <p>
                    {{__('site.View_our_enormous_library_of_workout_photos_and_see_exactly_how_each_exercise_should_be_performed_before_you_attempt_it.')}}
                </p>
            </div>
            <div class="col-md-6">
                <span class="text-primary"><i class="zmdi zmdi-check-all zmdi-hc-lg"></i></span>
                <h4 class="d-inline">{{ __('site.Step-by-Step_Instructions') }}</h4>
                <p>
                    {{__('site.The_right_cue_can_mean_everything!_Read_through_our_step-by-step_directions_to_ensure_you\'re_doing_each_workout_correctly_every_time.')}}
                </p>
            </div>
        </div>
    </div>
    <div class="contact-section">
        <h1 class="text-center"> {{ __('site.contact_us') }} </h1>
        <form class="form-material row" method="POST" id="contact-form">
            @csrf
            <div class="form-group">
                <input class="form-control" type="text" name="name">
                <label class="floating-label">{{ __('site.full_name') }}</label>
                <small id="name_error" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
                <input class="form-control" type="email" name="email">
                <label class="floating-label">{{ __('site.email') }}</label>
                <small id="email_error" class="form-text text-danger"></small>
            </div>
            <div class="form-group">
                <textarea class="form-control" name="subject"></textarea>
                <label class="floating-label">{{ __('site.subject') }}</label>
                <small id="subject_error" class="form-text text-danger"></small>
            </div>
            <div class="form-group text-center">
                <button id="send" type="submit" class="btn btn-outline-primary m-w-120">
                    <i class="zmdi zmdi-mail-reply"></i>
                    {{ __('site.send') }}
                </button>
            </div>
        </form>
    </div>
</div>
<div class="dashboard-footer-section">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-4 col-sm-12">
                <span>{{ __('site.need_help?') }}</span>
                <a>{{ __('site.help_center') }}</a>
                <a>{{ __('site.live_chat') }}</a>
                <a>{{ __('site.gift_certifications') }}</a>
                <a>{{ __('site.email_support') }}</a>
                <a>{{ __('site.send_us_feedback') }}</a>
            </div>
            <div class="col-md-4 col-sm-12">
                <span>{{ __('site.social_media') }}</span>
                <a><i class="zmdi zmdi-facebook zmdi-hc-3x"></i></a>
                <a><i class="zmdi zmdi-twitter zmdi-hc-3x"></i></a>
                <a><i class="zmdi zmdi-blogger zmdi-hc-3x"></i></a>
                <a><i class="zmdi zmdi-whatsapp zmdi-hc-3x"></i></a>
                <a><i class="zmdi zmdi-youtube-play zmdi-hc-3x"></i></a>
            </div>
            <div class="col-md-4 col-sm-12">
                <span>{{ __('site.join_our_newsletter') }}</span>
                <p>{{ __('site.Be_the_first_to_receive_exciting_news,_features,_and_special_offers_from_Y-GYM.com!') }}</p>
                <div class="input-group">
                    <input class="form-control" type="email" placeholder="{{ __('site.email') }}">
                    <span class="input-group-btn">
                      <label class="btn btn-primary file-upload-btn">
                        <input class="file-upload-input" type="submit" name="send">
                        <i class="zmdi zmdi-caret-right zmdi-hc-lg"></i>
                      </label>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).on('click','#send',function (event) {
        //to prevent all things might run and run only the ajax
        event.preventDefault();

        var formData = new FormData($('#contact-form')[0]);

        $.ajax({
            type: 'POST',
            url:'{{ route("web.dashboard") }}',
            data: formData,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            cache: false,
            success:function (data) {

                if (data.status==true){
                    location.reload();
                    $("#contact-form")[0].reset();
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
 @endsection
