@include('includes.adminHeader')
    <div class="site-main">
        @include('includes.adminSidebar')
        <div class="site-content">

            @include('includes.messages')
            @yield('content')
            @include('includes.delete')

        </div>
        @include('includes.adminFooter')

