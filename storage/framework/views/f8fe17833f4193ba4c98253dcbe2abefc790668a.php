

<?php $__env->startSection('content'); ?>
<?php
$privilegeArr = isset($result['privileges']['display_name']) ? $result['privileges']['display_name'] : array();
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">

    </div>
    <!-- /.content-header -->
    <?php if($status!='failed'): ?>
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">

                    <div class="card">
                        <div class="card-header border-0">
                            <div class="header-details">
                                <div class="name-area">
                                    <h2 class="m-0 text-dark">Users</h2>
                                </div>
                                <div class="action-area">


                                    <form action="<?php echo e(url('csv-export')); ?>" method="post">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="key" value="Users">
                                        <button type="submit" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</button>
                                    </form>


                                    <a href="<?php echo e(url('user')); ?>" class="btn btn-success tooltips" data-placement="top">
                                        <i class="fa fa-plus"></i> Add New User
                                    </a>

                                </div>
                            </div>
                        </div>

                        <!-- /.card-header -->
                        <div class="col-md-12 table p-4">
                           <table id="userlisttbl" class="table table-striped table-responsive">

                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th width="15%"> User Name</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>Email</th>
                                        <th>Department</th>
                                        <th>Role</th>
                                        <th>Is Active</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $result['result']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($result->id); ?></td>
                                        <td><?php echo e($result->first_name); ?> <?php echo e($result->last_name); ?></td>
                                        <td><?php echo e($result->mobile_no); ?></td>
                                        <td><?php echo e(!empty($result->address1) ? $result->address1 : ''); ?><br /><?php echo e(!empty($result->address2) ? $result->address2 : ''); ?></td>
                                        <td><?php echo e($result->email); ?></td>
                                        <td><?php echo e($result->department->name); ?></td>
                                        <td><?php echo e($result->userRole->name); ?></td>
                                        <td><?php echo e(($result->is_active) ? 'Active' : 'Inactive'); ?></td>


                                        <td align="center">
                                            <a class="btn" title="Update User" href="<?php echo e(url('user/'.$result->id)); ?>"><i class="fas fa-user-edit"></i></a>
                                        </td>

                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(js('user_list_js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/users/index.blade.php ENDPATH**/ ?>