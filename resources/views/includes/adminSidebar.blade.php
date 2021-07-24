<div class="site-left-sidebar">
    <div class="sidebar-backdrop"></div>
    <div class="custom-scrollbar">
      <ul class="sidebar-menu">
        <li class="menu-title">{{ __('site.adminstrative') }}</li>

        @php

        $urlArr = explode('/',$_SERVER['REQUEST_URI']);

        if(isset($urlArr[3])){
            $urlArrArr = explode('?',$urlArr[3]);
        }else{
            $urlArr[3] = '';
            $urlArrArr = explode('?',$urlArr[3]);
        }

        @endphp

        <li class="{{ $urlArrArr[0] == '' ? 'active': '' }}">
          <a href="{{ route('admin.dashboard') }}">
            <span class="menu-icon">
                <i class="zmdi zmdi-home"></i>
            </span>
            <span class="menu-text">{{ __('site.dashboard') }}</span>
          </a>
        </li>

        @if (auth()->user()->hasPermission('users_read'))
        <li class="{{ $urlArrArr[0] == 'users' ? 'active': '' }}">
            <a href="{{ route('users.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-account"></i>
              </span>
              <span class="menu-text">{{ __('site.users') }}</span>
            </a>
        </li>
        @endif

        @if (auth()->user()->hasPermission('clients_read'))
        <li class="{{ $urlArrArr[0] == 'clients' ? 'active': '' }}">
            <a href="{{ route('clients.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-accounts-alt"></i>
              </span>
              <span class="menu-text">{{ __('site.clients') }}</span>
            </a>
        </li>
        @endif

        <li class="menu-title">{{ __('site.public') }}</li>
        @if (auth()->user()->hasPermission('article_categories_read'))
        <li class="{{ $urlArrArr[0] == 'article_categories' ? 'active': '' }}">
            <a href="{{ route('article_categories.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-layers"></i>
              </span>
              <span class="menu-text">{{ __('site.article_categories') }}</span>
            </a>
        </li>
        @endif

        @if (auth()->user()->hasPermission('plan_categories_read'))
        <li class="{{ $urlArrArr[0] == 'plan_categories' ? 'active': '' }}">
            <a href="{{ route('plan_categories.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-layers"></i>
              </span>
              <span class="menu-text">{{ __('site.plan_categories') }}</span>
            </a>
        </li>
        @endif

        @if (auth()->user()->hasPermission('articles_read'))
        <li class="{{ $urlArrArr[0] == 'articles' ? 'active': '' }}">
            <a href="{{ route('articles.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-file-text"></i>
              </span>
              <span class="menu-text">{{ __('site.articles') }}</span>
            </a>
        </li>
        @endif

        @if (auth()->user()->hasPermission('plans_read'))
        <li class="{{ $urlArrArr[0] == 'plans' ? 'active': '' }}">
            <a href="{{ route('plans.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-developer-board"></i>
              </span>
              <span class="menu-text">{{ __('site.plans') }}</span>
            </a>
        </li>
        @endif

        @if (auth()->user()->hasPermission('workouts_read'))
        <li class="{{ $urlArrArr[0] == 'workouts' ? 'active': '' }}">
            <a href="{{ route('workouts.index') }}">
              <span class="menu-icon">
                <i class="zmdi zmdi-run"></i>
              </span>
              <span class="menu-text">{{ __('site.workouts') }}</span>
            </a>
        </li>
        @endif

      </ul>
    </div>
  </div>
