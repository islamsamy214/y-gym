@extends('layouts.web')
@section('content')

    @php
        $client = Auth::guard('clients')->user();
        $plan = $client->plan;
    @endphp

    <div class="profile container">
        <div class="row gutter-sm">
        <div class="col-md-4 col-sm-5">
            <div class="p-about m-b-20">
            <div class="pa-padding">
                <div class="pa-avatar">
                <img src="{{ $client->image_path }}" alt="" width="100" height="100">
                </div>
                <div class="pa-name">{{ $client->name }}
                    @if ($client->email_verified_at)
                        <i class="zmdi zmdi-check-circle text-success m-l-5"></i>
                    @endif
                </div>

            </div>
            <div class="pa-stat">
                <div class="row no-gutter {{ strtotime($client->expiry_date)>=time() ? 'status-paid' : 'status-warning' }}">
                    <div class="pas-item {{ strtotime($client->expiry_date)>=time() ? 'col-xs-6' : 'col-xs-12' }}">
                        @if (strtotime($client->expiry_date)>=time())
                            <div class="pas-text">{{ __('site.paid_in').' : '.$client->payed_date}}</div>
                        @else
                            <div class="pas-text">{{ __('site.didn\'t_pay') }}</div>
                        @endif
                    </div>
                    @if (strtotime($client->expiry_date)>=time())
                        <div class="pas-item col-xs-6">
                                <div class="pas-text">{{ __('site.paid_until').' : '.$client->expiry_date}}</div>
                        </div>
                    @endif

                </div>
            </div>
            </div>

            <div class="p-info m-b-20">
                <h4 class="m-y-0">{{ __('site.contact_info') }}</h4>
                <hr>
                <div class="pi-item">
                    <div class="pii-icon">
                    <i class="zmdi zmdi-phone"></i>
                    </div>
                    <div class="pii-value">{{ $client->phone }}</div>
                    <small> {{ __('site.only_me') }} </small>

                </div>
                <div class="pi-item">
                    <div class="pii-icon">
                    <i class="zmdi zmdi-email"></i>
                    </div>
                    <div class="pii-value">{{ $client->email }}</div>
                </div>

            </div>

        </div>
        <div class="col-md-8 col-sm-7">
            <div class="p-content">
            <ul class="nav nav-tabs nav-tabs-custom" role="tablist">
                <li class="active">
                <a href="#tab-plan" data-toggle="tab" role="tab" aria-expanded="true">{{ __('site.current_plan') }}</a>
                </li>
                <li class="">
                <a href="#tab-edit" data-toggle="tab" role="tab" aria-expanded="false">{{ __('site.edit_my_account') }}</a>
                </li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab-plan" role="tabpanel">

                    <div class="tab-profile plan-card ">
                        @if ($client->plan)
                        <div class="panel panel-primary plan-panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title">{{ $plan->name }}</h3>
                                <div class="panel-subtitle">{{ $plan->planCategory->name }}</div>
                            </div>
                            @if ($plan->image)
                                <div class="panel-body plan-panel-body">
                                    <img src="{{ $plan->image_path }}">
                                </div>
                            @endif
                            <div class="panel-footer">
                                <div class="row">
                                    <div class="col-md-6 col-xs-6">
                                        <div class="panel-detail">{{ __('site.duration') }}</div>
                                        <h4 class="panel-description">{{ $plan->duration.' '.__('site.weaks') }}</h4>

                                        <div class="panel-detail">{{ __('site.fitness_level') }}</div>
                                        <h4 class="panel-description">{{ $plan->level }}</h4>
                                    </div>
                                    <div class="col-md-6 col-xs-6">
                                        <div class="panel-detail">{{ __('site.workouts_per_week') }}</div>
                                        <h4 class="panel-description">{{ $plan->workouts->count() }} {{ __('site.workouts') }}</h4>

                                        <div class="panel-detail">{{ __('site.equipments_needed') }}</div>
                                        <h4 class="panel-description">{{ $plan->equipments }}</h4>
                                    </div>
                                    <div class="row">
                                        @if ($plan->workouts->all() != null)
                                            <div class="col-md-6">
                                                <a href="{{ route('web.plans.show',$plan->id) }}" class="btn btn-primary btn-labeled">{{ __('site.show') }}
                                                    <span class="btn-label btn-label-right">
                                                        <i class="zmdi zmdi-eye"></i>
                                                    </span>
                                                </a>
                                            </div>
                                            <div class="col-md-6 text-right">

                                                @if (Auth::guard('clients')->user())
                                                    @if (Auth::guard('clients')->user()->plan_id == $plan->id)
                                                        <a href="{{ route('web.plans.start',['plan_id'=>$plan->id,'client_id'=>Crypt::encrypt(Auth::guard('clients')->user()->id)]) }}" class="btn btn-info btn-labeled">
                                                            {{ __('site.continue') }}
                                                            <span class="btn-label btn-label-right">
                                                                <i class="zmdi zmdi-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                    @else
                                                        <a href="{{ route('web.plans.start',['plan_id'=>$plan->id,'client_id'=>Crypt::encrypt(Auth::guard('clients')->user()->id)]) }}" class="btn btn-danger btn-labeled">
                                                            {{ __('site.start') }}
                                                            <span class="btn-label btn-label-right">
                                                                <i class="zmdi zmdi-arrow-right"></i>
                                                            </span>
                                                        </a>
                                                    @endif

                                                @endif

                                            </div>
                                        @else
                                            <div class="text-center">{{ __('site.it\'s_under_prepration') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @else

                        <div class="tab-profile plan-card text-center">
                            {{ __('site.you_didn\'t_subscribe_any_plan_yet') }}
                        </div>

                        @endif

                    </div>

                </div>
                <div class="tab-pane" id="tab-edit" role="tabpanel">

                    <div class="tab-profile ">
                        <form class="form-material" action="" id="client-form" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            {{-- name --}}
                            <div class="form-group">
                                <input class="form-control" type="text" name="name" placeholder="{{ __('site.name') }}" value="{{ $client->name }}" required>
                                <small id="name_error" class="form-text text-danger"></small>
                            </div>

                            {{-- email --}}
                            <div class="form-group">
                                <input class="form-control" type="email" name="email" placeholder="{{ __('site.email') }}" value="{{ $client->email }}" required>
                                <small id="email_error" class="form-text text-danger"></small>

                            </div>

                            {{-- phone --}}
                            <div class="form-group">
                                <input class="form-control" type="number" name="phone" placeholder="{{ __('site.phone') }}" value="{{ $client->phone }}" required>
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


                            {{-- submit --}}
                            <div class="m-y-30 text-center">
                                <button type="submit" class="btn btn-primary" id="continue">{{ __('site.continue') }}</button>
                            </div>

                        </form>
                    </div>
                    <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('web.clients.destroy',$client->id) }}">
                        @csrf
                        @method('DELETE')
                        <div class="m-y-30 text-right">
                            <button type="submit" class="btn btn-danger delete">{{ __('site.delete_my_account') }}</button>
                        </div>
                    </form>

                </div>
            </div>
            </div>
        </div>
        </div>
    </div>
    <script>
        $(document).on('click','#continue',function (event) {
            //to prevent all things might run and run only the ajax
            event.preventDefault();

            var formData = new FormData($('#client-form')[0]);

            $.ajax({
                type: 'POST',
                url:'{{ route("web.clients.update",$client->id) }}',
                data: formData,
                enctype: 'multipart/form-data',
                processData: false,
                contentType: false,
                cache: false,
                success:function (data) {

                    if (data.status==true){
                        location.href = '{{ route("web.clients.index") }}';
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
