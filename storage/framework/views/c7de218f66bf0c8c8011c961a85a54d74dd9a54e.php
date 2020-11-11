

<?php $__env->startSection('content'); ?>
<?php 
     $privilegeArr = isset( $result['privileges']['display_name'])? $result['privileges']['display_name']:array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Organization Information</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Organization</li>
                    </ol>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.content-header -->
    <?php if($status!='failed'): ?>
     <?php //dd($result);?>
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">                   
                        <div class="card">
                        <h2 style="
    padding: 1rem;
">Organization Information</h2>
                            <!--name and information card header-->                       
                            <form id="organisationForm"  novalidate="novalidate">
                                 <input type="hidden" name="org_type" value="org_info">
                                <?php echo csrf_field(); ?>
                                <div class="card-header">
                                    <div class="col-sm-6">
                                        <h4>Name and Information &nbsp;&nbsp;
                                            
                                                <button type="button" class="btn tooltips" id="orgNameEdit" name="orgNameEdit" visibility="hidden" title="Update Organization" data-target="right"><i class="fas fa-pencil-alt"></i></button>
                                                <button type="submit" class="btn tooltips" id="orgNameSave" name="orgNameSave" visibility="hidden" title="Update Organization" data-target="right"><i class="fas fa-save"></i></button>
                                           
                                        </h4>    
                                    </div>
                                </div>
                                <!-- /.name and information card header -->
                                <fieldset id="disableOrg" disabled="disabled">
                                    <!-- /.name and information card body -->
                                    <div class="row">
                                        <div class="col-sm-4">
                                    <div class="card-body">
                                        <input type="text" class="text-line" id="id" name="id" value="<?php echo e($result['organization']['organization']->id); ?>" hidden/> 
                                        <div class="form-group">
                                            <label for="name">Organization Name<!-- <span class="text-danger">*</span> --></label><br>
                                            <input type="text" class="text-line w-75" id="name" name="name" value="<?php echo e($result['organization']['organization']->name); ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="mobile_no">Phone<!-- <span class="text-danger">*</span> --></label><br>
                                            <input type="text" class="text-line w-75" id="mobile_no" name="mobile_no" value="<?php echo e($result['organization']['organization']->mobile_no); ?>"/>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email<!-- <span class="text-danger">*</span> --></label><br>
                                            <input type="text" class="text-line w-75" id="email" name="email" value="<?php echo e($result['organization']['organization']->email); ?>" readonly/>
                                        </div>
                                        <div class="form-group">
                                            <label for="address">Address<!-- <span class="text-danger">*</span> --></label><br>
                                            <input type="text" class="text-line w-75" id="address" name="address" value="<?php echo e($result['organization']['organization']->address); ?>"/>
                                        </div>
                                    </div>  
                                        </div>
                                    <div class="col-sm-4">
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label for="name">Primary Contact</label>
                                            </div>
                                            <div class="form-group">                                                
                                                <label for="primary_contact">Name<!-- <span class="text-danger">*</span> --></label><br>
                                                <input type="text" class="text-line w-75" id="primary_contact" name="primary_contact" value="<?php echo e($result['organization']['organization']->primary_contact); ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="primary_mobile_no">Phone<!-- <span class="text-danger">*</span> --></label><br>
                                                <input type="text" class="text-line w-75" id="primary_mobile_no" name="primary_mobile_no" value="<?php echo e($result['organization']['organization']->primary_mobile_no); ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="primary_email">Email<!-- <span class="text-danger">*</span> --></label><br>
                                                <input type="text" class="text-line w-75" id="primary_email" name="primary_email" value="<?php echo e($result['organization']['organization']->primary_email); ?>"/>
                                            </div>
                                        </div>  
                                    </div>
                                        
                                        <div class="col-sm-4">
                                        <div class="card-body">
                                            <div class="form-group">
                                              <label for="name">Secondary Contact</label>  
                                            </div>                                            
                                            <div class="form-group">
                                                <label for="secondary_contact">Name<!-- <span class="text-danger">*</span> --></label><br>
                                                <input type="text" class="text-line w-75" id="secondary_contact" name="secondary_contact" value="<?php echo e($result['organization']['organization']->secondary_contact); ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="secondary_mobile_no">Phone<!-- <span class="text-danger">*</span> --></label><br>
                                                <input type="text" class="text-line w-75" id="secondary_mobile_no" name="secondary_mobile_no" value="<?php echo e($result['organization']['organization']->secondary_mobile_no); ?>"/>
                                            </div>
                                            <div class="form-group">
                                                <label for="secondary_email">Email<!-- <span class="text-danger">*</span> --></label><br>
                                                <input type="text" class="text-line w-75" id="secondary_email" name="secondary_email" value="<?php echo e($result['organization']['organization']->secondary_email); ?>"/>
                                            </div>
                                        </div>  
                                    </div>
                                        
                                    </div>
                                    
                                    <!-- /.name and information card body -->
                                </fieldset>
                                
                                
                            </form>
                            <form id="currency" novalidate="novalidate">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="org_type" value="org_rate">
                                <!--currency and rates card header-->
                                <div class="card-header">
                                    <div class="col-sm-6">
                                        <h4>Currency and Rates &nbsp;&nbsp;
                                          
                                                <button type="button" class="btn tooltips" id="currencyEdit" name="currencyEdit" title="Update Organization Currency Rate" data-target="right"><i class="fas fa-pencil-alt"></i></button>
                                                <button type="submit" class="btn tooltips" id="currencySave" name="currencySave" visibility="hidden" title="Update Organization Currency Rate" data-target="right"><i class="fas fa-save"></i></button>
                                            
                                        </h4>                                       
                                    </div>
                                </div>
                                <!-- /.currency and rates card header -->
                                <fieldset id="disableCurrency" disabled="disabled">
                                    <!-- /.currency and rates card body -->
                                    <div class="card-body">
                                    
                                        <div class="form-group">
                                            <input type="text" class="text-line" id="id" name="id" value="<?php echo e($result['organization']['organization']->id); ?>" hidden/>
                                            <label for="currency_id">Currency<!-- <span class="text-danger">*</span> --></label><br>
                                            <select class="text-line" id="currency_id" name="currency_id">
                                                <option></option>
                                                <?php if(!empty($result['currencies']['currencies'])): ?>
                                                <?php $__currentLoopData = $result['currencies']['currencies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencies): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($currencies ->id); ?>" <?php echo e((isset($result['organization']['organization']->currency_id) && !empty($result['organization']['organization']->currency_id) && ($result['organization']['organization']->currency_id == $currencies ->id)) ? 'selected' : ''); ?>><?php echo e($currencies ->currency); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="currency_code">Rates per Trip<!-- <span class="text-danger">*</span> --></label><br>
                                            <select  id="currency_code" name="currency_code" class="text-line readonly" disabled>
                                                <option></option>
                                                <?php if(!empty($result['currencies']['currencies'])): ?>
                                                <?php $__currentLoopData = $result['currencies']['currencies']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currencies): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($currencies ->id); ?>" <?php echo e((isset($result['organization']['organization']->currency_id) && !empty($result['organization']['organization']->currency_id) && ($result['organization']['organization']->currency_id == $currencies ->id)) ? 'selected' : ''); ?>><?php echo e($currencies ->currency_code); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select> 
                                            <input type="text" class="text-line" id="rate_per_trip" name="rate_per_trip" value="<?php echo e($result['organization']['organization']->rate_per_trip); ?>"/>  
                                        </div>
                                    </div>
                                    <!-- /.currency and rates card body -->
                                </fieldset>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
    </section>
    <!-- /.content -->
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('style'); ?>
<link href="<?php echo e(css('text_line_css')); ?>" rel="stylesheet">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(js('organization_js')); ?>"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/organization/index.blade.php ENDPATH**/ ?>