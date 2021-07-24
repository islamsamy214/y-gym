<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="description" content="">
    <title>Y-GYM</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-32x32.png') }}" sizes="32x32">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon-16x16.png') }}" sizes="16x16">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,400i,500,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cosmos.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/application.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="{{ asset('css/y-gym.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>

  </head>
  <body class="layout layout-header-fixed layout-left-sidebar-fixed">
    <div class="site-overlay"></div>
    <div class="site-header">
      <nav class="navbar navbar-default">
        <div class="navbar-header">
          <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="" height="25">
            <span>Y-GYM</span>
          </a>
          <button class="navbar-toggler left-sidebar-toggle pull-left visible-xs" type="button">
            <span class="hamburger"></span>
          </button>

          <button class="navbar-toggler pull-right visible-xs-block" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="more"></span>
          </button>
        </div>
        <div class="navbar-collapsible">
          <div id="navbar" class="navbar-collapse collapse">
            <button class="navbar-toggler left-sidebar-collapse pull-left hidden-xs" type="button">
              <span class="hamburger"></span>
            </button>

            <ul class="nav navbar-nav navbar-right">
                <li class="nav-table dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="nav-cell nav-icon">
                        <i class="zmdi zmdi-map"></i>
                        </span>
                        <span class="hidden-md-up m-l-15">{{ __('site.language') }}</span>
                    </a>
                    <div class="dropdown-menu custom-dropdown dropdown-notifications dropdown-menu-right">
                        <div class="dropdown-header">
                            <span>{{ __('site.language') }}</span>
                        </div>

                        @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                            <div class="n-items">
                                <div class="custom-scrollbar">
                                    <div class="n-item n-link" onclick="location.href='{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}'" rel="alternate" hreflang="{{ $localeCode }}">
                                        {{ $properties['native'] }}
                                    </div>
                                </div>
                            </div>

                        @endforeach
                    </div>
                </li>
                <li class="nav-table dropdown hidden-sm-down">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                    <span class="nav-cell p-r-10">
                    <img class="img-circle" src="{{ auth()->user()->image_path }}" alt="" width="32" height="32">
                    </span>
                    <span class="nav-cell">{{ auth()->user()->name }}
                    <span class="caret"></span>
                    </span>
                </a>
                <ul class="dropdown-menu">
                    {{-- <li>
                        <a href="#">
                            <i class="zmdi zmdi-account-o m-r-10"></i> {{ __('site.profile') }}
                        </a>
                    </li>

                    <li role="separator" class="divider"></li> --}}

                    <li>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"
                            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                            <i class="zmdi zmdi-power m-r-10"></i> {{ __('site.logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
                </li>
            </ul>
          </div>
        </div>
      </nav>
    </div>
