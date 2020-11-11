<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        
        <meta charset="utf-8"/>
        <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>"/>
        <title>Port Logistics</title>
        <link rel="stylesheet" href="<?php echo e(theme('plugins/icheck-bootstrap/icheck-bootstrap.min.css')); ?>"/>
        <link rel="stylesheet" href="<?php echo e(theme('plugins/fontawesome-free/css/all.min.css')); ?>"/>
        <link rel="stylesheet" href="<?php echo e(theme('plugins/overlayScrollbars/css/OverlayScrollbars.min.css')); ?>"/>
        <link rel="stylesheet" href="<?php echo e(theme('dist/css/adminlte.min.css')); ?>"/>
        <link rel="stylesheet" href="<?php echo e(css('custom')); ?>"/>
        <style>
            .login-body-custom{
                background-image:url("<?php echo e(images('login_bg')); ?>");
            }
        </style>

    </head>

    <body class="login-page login-body-custom">
        <!-- Start Flash Message -->
        <?php if(\Session::has('success')): ?>
        <div class="alert alert-success">
            <?php echo \Session::get('success'); ?>

        </div>
        <?php endif; ?>
        <?php if(\Session::has('error')): ?>
        <div class="alert alert-danger">
            <?php echo \Session::get('error'); ?>

        </div>
        <?php endif; ?>
      
        <!-- End Flash Message -->
        <div class="login-box">
            <!-- <div class="login-logo">
                <a href="javascript:void(0);">
                    <img src="<?php echo e(theme('dist/img/Logo.png')); ?>" height="50"/>
                </a>
            </div> -->
            <div class="">
                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </body>
    <script src="<?php echo e(theme('plugins/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(theme('plugins/bootstrap/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(theme('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')); ?>"></script>
    <script src="<?php echo e(theme('dist/js/adminlte.js')); ?>"></script>
</html><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/layouts/app.blade.php ENDPATH**/ ?>