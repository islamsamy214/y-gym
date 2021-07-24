@extends('layouts.admin')
@section('content')
    <div class="row control-bar">
        <div class="col-md-4 search-bar" >
            <form method="GET" action="{{ route('workouts.index') }}">
                <div class="navbar-search-group">
                    <input type="text" name="search" class="form-control" placeholder="{{ __('site.search') }}" value="{{ $request->search }}">
                    <button type="submit" class="btn btn-default">
                        <i class="zmdi zmdi-search"></i>
                    </button>
                </div>
            </form>
        </div>

        @if (auth()->user()->hasPermission('workouts_create'))

            @include('admin.workouts.create')

        @endif

    </div>

    @if ($workouts->count() > 0)
        <h4> {{ __('site.total') }} : {{ $workouts->total() }}</h4>

        <div class="table-responsive">
            <table class="table text-center">
              <thead>
                <tr>
                    <th>{{ __('site.image') }}</th>
                    <th>{{ __('site.workout_name') }}</th>
                    <th>{{ __('site.muscle') }}</th>
                    <th>{{ __('site.equipment_type') }}</th>
                    <th>{{ __('site.level') }}</th>
                    <th>{{ __('site.exercise_type') }}</th>
                    <th>{{ __('site.created_by') }}</th>
                    <th>{{ __('site.action') }}</th>
                </tr>
              </thead>
              <tbody>

                @foreach ($workouts as $workout)
                <tr class="cursor-pointer" data-toggle="modal" data-target="#modal-{{ $workout->id }}"">
                    <div class="col-lg-2 col-sm-4 col-xs-6 m-y-5">
                        <div id="modal-{{ $workout->id }}" class="modal fade" tabindex="-1" role="dialog">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header bg-danger">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">
                                            <i class="zmdi zmdi-close"></i>
                                        </span>
                                    </button>
                                        <h4 class="modal-title">{{ $workout->name }}</h4>
                                    </div>
                                    <div class="modal-body">
                                        <iframe width="560" height="315" src="{{ $workout->ytb_link }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" data-dismiss="modal" class="btn btn-danger">{{ __('site.close') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <td><img src="{{ $workout->image_path }}" class="img-thumbnail workout-image" /></td>
                    <td>{{ $workout->name }}</td>
                    <td>{{ $workout->muscle }}</td>
                    <td>{{ $workout->equipment_type }}</td>
                    <td>{{ $workout->level }}</td>
                    <td>{{ $workout->exercise_type }}</td>
                    <td>
                      {{ $workout->user->name }}
                      <br>
                      <small class="text-muted">{{ $workout->created_at }}</small>
                    </td>


                    <td class="actions">
                        @if (auth()->user()->hasPermission('workouts_update'))
                            <a href="{{ route('workouts.edit',$workout->id) }}" class="btn btn-primary">
                                <i class="zmdi zmdi-border-color"></i>
                            </a>
                        @endif
                        @if (auth()->user()->hasPermission('workouts_delete'))
                        <form class="d-inline" method="POST" onsubmit="deleteConfirmation(this, event)" action="{{ route('workouts.destroy',$workout->id) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger delete"><i class="zmdi zmdi-delete"></i></button>
                        </form>
                        @endif
                    </td>

                </tr>
                @endforeach
              </tbody>
            </table>
            <div class="col-sm-12 text-center">
                {{$workouts->appends(request()->query())->links()}}
                {{--appends(request()->query()) to not to damage the url when using search--}}
            </div>
          </div>

    @else
        <h1 class="text-center">
            {{ __('site.no_data') }}
        </h1>
    @endif


@endsection
