<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="icon" href="<?php echo e(URL::asset('favicon.ico')); ?>" type="image/x-icon"/>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
        <title>Port Logistics</title>

        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome Icons -->
        <link rel="stylesheet" href="<?php echo e(theme('plugins/fontawesome-free/css/all.min.css')); ?>">
        <!-- overlayScrollbars -->
        <link rel="stylesheet" href="<?php echo e(theme('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(theme('plugins/select2/css/select2.min.css')); ?>">
        <!-- DataTable CSS -->
        <link rel="stylesheet" href="<?php echo e(theme('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(theme('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(theme('plugins/datatables-select/css/select.bootstrap4.min.css')); ?>">
        <!-- Jquery UI -->
        <link rel="stylesheet" href="<?php echo e(theme('plugins/jquery-ui/jquery-ui.css')); ?>">
        <!-- Theme style -->
        <link rel="stylesheet" href="<?php echo e(theme('dist/css/adminlte.min.css')); ?>">
        <link rel="stylesheet" href="<?php echo e(css('custom')); ?>">
        <link rel="stylesheet" href="<?php echo e(theme('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')); ?>">

        <link rel="stylesheet" href="<?php echo e(css('app_css')); ?>">
        <link rel="stylesheet" href="<?php echo e(css('bootstrap_multiselect_css')); ?>">
        
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.17.1/dist/sweetalert2.min.css">
        <style type="text/css">

        </style>
        <?php echo $__env->yieldPushContent('style'); ?>
    </head>

    <body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
    <div id="sectionLoader">
            <div class="loader">
            <div class="loader-item"></div>
                <div><h2>Processing...</h2></div>
            </div>
        </div>
        <div class="wrapper">
            <?php if(Auth::check()): ?>
            <?php echo $__env->make('layouts.components.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                <?php if(Auth::User()->auth_browser == false): ?>
                <?php echo $__env->make('layouts.components.leftmenu', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endif; ?>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
            <!-- Main Footer -->
            <?php echo $__env->make('layouts.components.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        </div>
        <!-- ./wrapper -->

        <!-- REQUIRED SCRIPTS -->
        <!-- jQuery -->
        <script src="<?php echo e(theme('plugins/jquery/jquery.min.js')); ?>"></script>
        <!-- Bootstrap -->
        <script src="<?php echo e(theme('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/select2/js/select2.full.min.js')); ?>"></script>
        <!-- DataTable CSS -->
        <script src="<?php echo e(theme('plugins/datatables/jquery.dataTables.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/datatables-responsive/js/dataTables.responsive.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/datatables-responsive/js/responsive.bootstrap4.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/datatables-select/js/dataTables.select.min.js')); ?>"></script>
        <!-- Datetimepicker -->
        <script src="<?php echo e(theme('plugins/moment/moment.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/jquery-ui/jquery-ui.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/jquery-validation/jquery.validate.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/jquery-validation/additional-methods.min.js')); ?>"></script>
        <!-- overlayScrollbars -->
        <script src="<?php echo e(theme('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
        <!-- AdminLTE App -->
        <script src="<?php echo e(theme('dist/js/adminlte.js')); ?>"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
        <script src="<?php echo e(theme('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')); ?>"></script>
        <script src="<?php echo e(theme('plugins/moment/moment.min.js')); ?>"></script>
        <!--<script src="<?php echo e(theme('dist/js/pages/dashboard2.js')); ?>"></script>-->
        <script>
            var APP_URL = <?php echo json_encode(url('/')); ?>;
        </script>
        <script src="<?php echo e(js('app_js')); ?>"></script>
        <script src="<?php echo e(js('bootstrap_multiselect_js')); ?>"></script>
        <?php echo $__env->yieldPushContent('script'); ?>
    </body>
</html><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/layouts/layout.blade.php ENDPATH**/ ?>