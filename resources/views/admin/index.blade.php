@include('admin.layout.head')
@yield('customcss')
<!-- loader Start -->
<div id="loading">
    <div id="loading-center"></div>
</div>
<!-- Wrapper Start -->
<div class="wrapper">
    <!-- Sidebar  -->
    @include('admin.component.Sidebar')
    @include('admin.component.navbar')
    @yield('conten')
</div>
<!-- Wrapper END -->
<!-- loader END -->
@include('admin.layout.footer')

@if (!empty($config['js']))
    @foreach ($config['js'] as $js)
        <script src="{{ asset($js) }}"></script>
    @endforeach
@endif

@yield('customjs')

@include('admin.layout.foot')
