@include('includes.webHeader')
    <div class="site-main">

            @include('includes.messages')
            @yield('content')
            @include('includes.delete')

        @include('includes.webFooter')

