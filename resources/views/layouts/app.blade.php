<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kalpak Online</title>
    @include('components.css')
    <!-- End layout styles -->
    <link rel="shortcut icon" href="{{ asset('/assets/images/favicon.png') }}" />
</head>

<body>
    <script src="{{ asset('/assets/js/preloader.js') }}"></script>
    <div class="body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        @include('layouts.sidebar')
        <!-- partial -->
        <div class="main-wrapper mdc-drawer-app-content">
            <!-- partial:partials/_navbar.html -->
            @include('layouts.header')
            <!-- partial -->
            @yield('content')
        </div>
    </div>
    @include('components.js')

    @if (session('success'))
        <script>
            $(document).ready(function() {
                toastr.options = {
                    "closeButton": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "timeOut": "3000",
                    "extendedTimeOut": "1000",
                    "showDuration": "300",
                    "hideDuration": "300",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
                toastr.success("{{ session('success') }}");

               
            });
        </script>
    @endif
<script>
   $(document).ready(function() {
    $('#all-table-common').DataTable({
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        lengthMenu: [5, 10, 25, 50, 100],
        pageLength: 10,
        language: {
            lengthMenu: "Show _MENU_ entries",
            search: "_INPUT_",
            searchPlaceholder: "Search...",
            paginate: {
                previous: "&laquo;",
                next: "&raquo;"
            }
        },
        dom:
            "<'row mb-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" + // top: length menu + search box
            "<'table-responsive'tr>" + // table
            "<'row mt-3'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>" // bottom: info + pagination
    });
});

</script>

</body>

</html>
