

<?php $__env->startSection('content'); ?>
<div class="row">
<div class="col-md-6 col-sm-12 loginbox-left-bar">
<div>
<h4 class="text-center">Welcome to</h4>
<h1 class="text-center"> Port Logistics</h1>
<h5 class="text-center">v1.0</h5>
</div>
<div class="app-user-brand">
<h2>Stevedores Ltd.</h2>
<h5>101,Infocity,Bhubaneswar</h5>
</div>
</div>
<div class="col-md-6 col-sm-12  loginbox-right-bar">

<div class=" ">
    <h3 class="card-title ftext-center">Sign in to start your session</h3><br><br>
</div>
<div style="width: 65%;">
    <form method="POST" action="<?php echo e(route('login')); ?>">
        <?php echo csrf_field(); ?>
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                   value="<?php echo e(old('email')); ?>" placeholder="Email" autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope "></span>
                </div>
            </div>
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback">
                <strong><?php echo e($message); ?></strong>
            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" placeholder="Password"/>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock "></span>
                </div>
            </div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
            <div class="invalid-feedback">
                <strong><?php echo e($message); ?></strong>
            </div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>
        <div class="row">
           
            <div class="col-12">
                <button type=submit class="btn btn-block btn-flat btn-primary">
                    <span class="fas fa-sign-in-alt"></span>&nbsp;<?php echo e(__('Sign In')); ?>

                </button>
            </div> 
            <div class="col-12">
                <!-- <div class="icheck-primary">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember" <?php echo e(old('remember') ? 'checked' : ''); ?>>
                           <label class="form-check-label" for="remember"><?php echo e(__('Remember Me')); ?></label>
                </div> -->
                <?php if(Route::has('password.request')): ?>

        <a  href="<?php echo e(route('password.request')); ?>"><p
         style="margin-top: 1rem; text-align:center;">Forgot Password?</p>
        </a>
    
    <?php endif; ?>
            </div>
        </div>
    </form>
</div>
<div class=" ">
    
</div>


</div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/auth/login.blade.php ENDPATH**/ ?>