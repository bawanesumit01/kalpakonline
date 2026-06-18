<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kalpak Online</title>
    <?php echo $__env->make('components.css', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?php echo e(asset('/assets/images/favicon.png')); ?>" />
</head>

<body>
    <script src="<?php echo e(asset('/assets/js/preloader.js')); ?>"></script>
    <div class="body-wrapper">
        <!-- partial:partials/_sidebar.html -->
        <?php echo $__env->make('layouts.sidebar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <!-- partial -->
        <div class="main-wrapper mdc-drawer-app-content">
            <!-- partial:partials/_navbar.html -->
            <?php echo $__env->make('layouts.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <!-- partial -->
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    <?php echo $__env->make('components.js', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <?php if(session('success')): ?>
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
                toastr.success("<?php echo e(session('success')); ?>");

               
            });
        </script>
    <?php endif; ?>
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
<?php /**PATH /home/kalpakon/public_html/resources/views/layouts/app.blade.php ENDPATH**/ ?>