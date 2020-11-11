<?php $request = app('Illuminate\Http\Request'); ?>

<!-- Main Sidebar Container -->
<?php
    $menues = menuAccess(); // Coming From Helper : MenuAccessHelper.php
?>
<aside class="main-sidebar sidebar-dark-default elevation-4" >
    <!-- Brand Logo -->
    <!-- <div id="logoBox">
        <a href="<?php echo e(route('home')); ?>" class="brand-link">
            <img src="<?php echo e(theme('dist/img/Logo.png')); ?>" alt="Port Logistic Logo" class="brand-image elevation-3">
        </a>
    </div> -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="<?php echo e(route('home')); ?>" class="nav-link <?php echo e(request()->is('home') ? 'active' : ''); ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <?php if(isset($menues) && !empty($menues)): ?>
                <?php $__currentLoopData = $menues; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parentMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                    <?php if($parentMenu['display_name'] == 'CHALLANS'): ?>  
                        <?php if(isset($parentMenu['child']) && !empty($parentMenu['child'])): ?>                          
                        <?php $__currentLoopData = $parentMenu['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($childMenu['subchild']) && !empty($childMenu['subchild'])): ?>
                            <?php $__currentLoopData = $childMenu['subchild']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subchildMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(($childMenu['display_name'] == 'CHALLAN') && ($subchildMenu['display_name'] == 'CHALLAN LIST')): ?>
                                <!-- Challan Menu -->
                                <li class="nav-item">
                                    <a href="<?php echo e(url('challans')); ?>" class="nav-link <?php echo e(request()->is('challans') ? 'active' : ''); ?>">
                                        <i class=" nav-icon fas fa-receipt"></i>
                                        <p>Challans</p>
                                    </a>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($parentMenu['display_name'] =='PLANNING'): ?>
                    <?php if(isset($parentMenu['child']) && !empty($parentMenu['child'])): ?>                          
                        <?php $__currentLoopData = $parentMenu['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if(isset($childMenu['subchild']) && !empty($childMenu['subchild'])): ?>
                            <?php $__currentLoopData = $childMenu['subchild']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subchildMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if(($childMenu['display_name'] == 'PLANNING') && ($subchildMenu['display_name'] == 'PLANNING LIST')): ?>
                                <!-- Planning Menu -->
                                <li class="nav-item <?php echo e(request()->is('plans') ? 'menu-open' : ''); ?>">
                                    <a href="javascript:void(0)" class="nav-link ">
                                        <i class=" nav-icon fas fa-list-alt"></i>
                                        <p>Planning</p>
                                    </a>
                                    <ul class="nav nav-treeview">
                                        <li class="nav-item <?php echo e((url()->full()==url('plans')) ? 'menu-open' : ''); ?> ">
                                            <a href="<?php echo e(url('plans')); ?>" class="nav-link <?php echo e((url()->full()==url('plans')) ? 'active' : ''); ?>">
                                                <i class=" nav-icon fa fa-landmark"></i>
                                                <p>Berth To Plot</p>
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="javascript:void(0)" class="nav-link">
                                                <i class=" nav-icon fa fa-landmark"></i>
                                                <p>Plot To Plot</p>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($parentMenu['display_name'] =='ADMINISTRATOR'): ?>
                        <!-- Admin Menu -->
                        <li class="nav-item <?php echo e($request->segment(1) == 'admin' ? 'menu-open' : ''); ?> ">
                            <a href="#" class="nav-link <?php echo e($request->segment(1) == 'admin' ? 'active' : ''); ?>">
                                <i class="nav-icon fas fa-tools"></i>
                                <p>
                                    Administration
                                </p>
                            </a>  
                            <?php if(isset($parentMenu['child']) && !empty($parentMenu['child'])): ?>                          
                            <?php $__currentLoopData = $parentMenu['child']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $childMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <ul class="nav nav-treeview">
                                    <?php if(isset($childMenu['subchild']) && !empty($childMenu['subchild'])): ?>
                                    <?php $__currentLoopData = $childMenu['subchild']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subchildMenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(($childMenu['display_name'] == 'ORGANIZATION') && ($subchildMenu['display_name'] == 'DETAILS')): ?>
                                            <li class="nav-item <?php echo e(request()->is('organization') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('organization')); ?>" class="nav-link <?php echo e(request()->is('organization') ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fa fa-landmark"></i>
                                                    <p>Organization</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'USERS') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item <?php echo e(request()->is('users') ? 'menu-open' : ''); ?> ">                                    
                                                <a href="<?php echo e(url('users')); ?>" class="nav-link <?php echo e((request()->is('users') || request()->is('users')) ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fas fa-user"></i>
                                                    <p>Users</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'DEPARTMENT') && ($subchildMenu['display_name'] == 'LIST')): ?>                                       
                                            <li class="nav-item <?php echo e(request()->is('department') ? 'menu-open' : ''); ?> "> 
                                                <a href="<?php echo e(url('department')); ?>" class="nav-link <?php echo e(request()->is('department') ? 'menu-open' : ''); ?> ">
                                                    <i class=" nav-icon fas fa-users"></i>
                                                    <p>Departments</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'LOCATIONS') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item <?php echo e(request()->is('location') ? 'menu-open' : ''); ?> "> 
                                                <a href="<?php echo e(url('location')); ?>" class="nav-link <?php echo e($request->segment(2) == 'location' ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fas fa-map-marker-alt"></i>
                                                    <p>Locations</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'CARGO') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item <?php echo e(request()->is('cargo') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('cargo')); ?>" class="nav-link <?php echo e(request()->is('cargo') ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fas fa-shipping-fast"></i>
                                                    <p>Cargo</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'VESSEL') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item <?php echo e(request()->is('vessel') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('vessel')); ?>" class="nav-link <?php echo e($request->segment(2) == 'vessel' ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fas fa-ship"></i>
                                                    <p>Vessels</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'ROLES & PRIVILEGES') && ($subchildMenu['display_name'] == 'LIST')): ?>

                                            <li class="nav-item <?php echo e(request()->is('role') ? 'menu-open' : ''); ?> ">


                                                <a href="<?php echo e(url('role')); ?>" class="nav-link <?php echo e(request()->is('role') ? 'active' : ''); ?>">        
                                                    <i class=" nav-icon fas fa-user-secret"></i>
                                                    <p>Roles & Privileges</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'TRUCKS') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item <?php echo e(request()->is('truck') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('truck')); ?>" class="nav-link <?php echo e(request()->is('admin/truck') ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fa fa-truck"></i>
                                                    <p>Trucks</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <?php if(($childMenu['display_name'] == 'TRUCKING COMPANY') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item <?php echo e(request()->is('truck-company') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('truck-company')); ?>" class="nav-link <?php echo e(request()->is('admin/truck-company') ? 'active' : ''); ?>">
                                                    <i class=" nav-icon fas fa-truck"></i>
                                                    <p>Trucking Company</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                        <!--Updated by Gaurav Agrawal on 28-10-2020 to modify api for consignee -->
                                        <?php if(($childMenu['display_name'] == 'CONSIGNEE') && ($subchildMenu['display_name'] == 'LIST')): ?>
                                            <li class="nav-item  <?php echo e(request()->is('consignee') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('consignee')); ?>" class="nav-link <?php echo e(request()->is('consignee') ? 'active' : ''); ?>">                       
                                                    <i class=" nav-icon fas fa-receipt"></i>
                                                    <p>Consignee</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endif; ?>
                                        <?php if($childMenu['display_name'] == 'CACHELIST'): ?>
                                            <li class="nav-item  <?php echo e(request()->is('admin/clear-cache') ? 'menu-open' : ''); ?> ">
                                                <a href="<?php echo e(url('admin/clear-cache')); ?>" class="nav-link <?php echo e(request()->is('admin/clear-cache') ? 'active' : ''); ?>">                                       
                                                    <i class="nav-icon fas fa-cog"></i>
                                                    <p>Cache Settings</p>
                                                </a>
                                            </li>
                                        <?php endif; ?>
                                </ul>                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </li>
                    <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/layouts/components/leftmenu.blade.php ENDPATH**/ ?>