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
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/vendor.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cosmos.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/application.min.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/material-design-iconic-font/2.2.0/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" href="{{ asset('css/y-gym.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}"></script>

  </head>
  <body class="layout layout-header-fixed layout-left-sidebar-fixed">
    <div class="site-overlay"></div>
    <div class="site-header web-nav-header">
      <nav class="navbar navbar-default container">
        <div class="navbar-header">
          <a class="navbar-brand left-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" alt="" height="25">
            <span>Y-GYM</span>
          </a>

          <button class="navbar-toggler visible-xs-block" type="button" data-toggle="collapse" data-target="#navbar">
            <span class="hamburger"></span>
          </button>
        </div>
        <div class="navbar-collapsible">
          <div id="navbar" class="navbar-collapse collapse">

            @php

            $urlArr = explode('/',$_SERVER['REQUEST_URI']);

            if(isset($urlArr[2])){
                $urlArrArr = explode('?',$urlArr[2]);
            }else{
                $urlArr[2] = '';
                $urlArrArr = explode('?',$urlArr[2]);
            }


            @endphp

            <ul class="nav navbar-nav navbar-left left-li">
                <li class="web-header {{ $urlArr[2] == '' ? 'active' : '' }}">
                    <a href="{{ route('web.dashboard') }}">{{ __('site.home') }}</a>
                </li>

                <li class="web-header {{ $urlArr[2] == 'articles' ? 'active' : '' }}">
                    <a href="{{ route('web.articles') }}">{{ __('site.articles') }}</a>
                </li>

                <li class="web-header {{ $urlArr[2] == 'plans' ? 'active' : '' }}">
                    <a href="{{ route('web.plans') }}">{{ __('site.plans') }}</a>
                </li>

                <li class="web-header {{ $urlArr[2] == 'workouts' ? 'active' : '' }}">
                    <a href="{{ route('web.workouts') }}">{{ __('site.workouts') }}</a>
                </li>

            </ul>

            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @if(Auth::guard('clients')->user())

                <li class="nav-table dropdown web-header text-center">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="nav-cell p-r-10">
                        <img class="img-circle" src="{{ Auth::guard('clients')->user()->image_path }}" alt="" width="32" height="32">
                        </span>
                        <span class="nav-cell">{{ Auth::guard('clients')->user()->name }}
                        <span class="caret"></span>
                        </span>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                        <a href="{{ route('web.clients.index') }}">
                            <i class="zmdi zmdi-account-o m-r-10"></i> {{ __('site.profile') }}</a>
                        </li>

                        <li role="separator" class="divider"></li>

                        <li>
                            <a class="dropdown-item" href="{{ route('web.logout') }}"
                                onclick="event.preventDefault();
                                document.getElementById('logout-form').submit();">
                                <i class="zmdi zmdi-power m-r-10"></i> {{ __('site.logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('web.logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>

                @else

                <li class="nav-table dropdown web-header text-center">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                        <span class="nav-cell p-r-10">
                            <span class="caret"></span>
                            {{ __('site.account') }}
                        </span>

                        <span class="nav-cell nav-icon">
                            <i class="zmdi zmdi-account-circle"></i>
                        </span>

                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="{{ route('web.login') }}">{{ __('site.login') }}</a>
                        </li>

                        <li role="separator" class="divider"></li>

                        <li>
                            <a class="nav-link" href="{{ route('web.register') }}">{{ __('site.register') }}</a>
                        </li>
                    </ul>
                </li>
                @endguest
                {{-- language --}}
                <li class="nav-table dropdown web-header">
                    <a href="#" class="dropdown-toggle text-center" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="hidden-md-up m-l-15 p-r-10">
                            <span class="caret"></span>
                            {{ __('site.language') }}
                        </span>
                        <span class="nav-cell nav-icon">
                            <i class="zmdi zmdi-map"></i>
                        </span>
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

            </ul>
          </div>
        </div>
      </nav>
    </div>
    @if (!$urlArr[2] == '')
    <div class="header-position-fixer"></div>
    @endif
