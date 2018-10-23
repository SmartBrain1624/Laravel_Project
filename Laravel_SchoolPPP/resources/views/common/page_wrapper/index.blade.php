
<html lang="en" >
    @include('common.head.index')
    <body class="m-page--fluid m--skin- m-content--skin-light2 m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default"  >
        <div class="m-grid m-grid--hor m-grid--root m-page">
            @include('common.header.index')
            <div class="m-grid__item m-grid__item--fluid m-grid m-grid--ver-desktop m-grid--desktop m-body">
                @include('common.sidebar.index')

                <div class="m-grid__item m-grid__item--fluid m-wrapper">
{{--                    @include('common.subhead.index')--}}
                    <div class="m-content">
                        @yield('content')
                    </div>
                </div>
            </div>
            {{--@include('common.footer.index')--}}
        </div>
        @include('common.scripts.index')
    </body>
</html>