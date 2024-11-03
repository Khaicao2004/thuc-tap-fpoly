<script>
    const PATH_ROOT = '{{ asset('
            theme / admin ') }}'
</script>
<!-- JAVASCRIPT -->
<script src="{{ asset('theme/admin/assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('theme/admin/assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('theme/admin/assets/js/plugins.js') }}"></script>

<script type='text/javascript' src='theme/admin/assets/libs/choices.js/public/assets/scripts/choices.min.js'></script>
<script type='text/javascript' src='theme/admin/assets/libs/flatpickr/flatpickr.min.js'></script>

@yield('script-libs')

<!-- App js -->
<script src="{{ asset('theme/admin/assets/js/app.js') }}"></script>

@yield('scripts')

@php
    session()->forget('success');
    session()->forget('error');
@endphp