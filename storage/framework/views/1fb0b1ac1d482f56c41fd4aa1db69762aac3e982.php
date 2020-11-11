

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(css('challan_css')); ?>">

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                   
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Challan</li>
                    </ol>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                            <div class="header-details">
                            <div class="name-area">
                            <h2 class="m-0 text-dark">Challans</h2>
                            </div>
                             <div class="action-area">
                           <button class="btn btn-info float-right tooltips filterBtn " ><i class="fa fa-filter"></i> Filter</button> 
                           <a href="javascript:void(0)" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</a>
                             <div class="filterBox">
                             <form id="filterChallanForm" style="margin-top: 1rem">
                                    <input type="hidden" name="challans.is_deposit" id="challan_is_deposit"/>
                                    <div class="row mb20">
                                        <div class="col-12 mb-1">
                                            <div class="input-group date" id="currentdatediv" data-target-input="nearest">
                                                <input type="text" class="form-control datetimepicker-input filterable-txt" data-target="#currentdatediv" name="challans.created_at" placeholder="Created At" value="<?php echo e(date('Y-m-d')); ?>" id="created_at"/>
                                                <div class="input-group-append" data-target="#currentdatediv" data-toggle="datetimepicker">
                                                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <select class="form-control select2 filterable-drp" name="challans.shift_id" id="shift_id">
                                                <option value="">All Shift</option>
                                                <?php if(!empty($shifts)): ?>
                                                <?php $__currentLoopData = $shifts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $shift): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($shift->id); ?>"><?php echo e($shift->name); ?></option>    
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endif; ?>
                                            </select>
                                        </div>
                                        <div class="col-12 mb-1">
                                            <div class="input-group date">
                                                <input type="text" class="form-control filterable-txt" name="challans.challan_no" placeholder="Challan No." id="challan_no"/>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="button" class="btn btn-info" id="filterBtn">Filter</button>
                                            <button type="button" class="btn btn-default" id="clearBtn">Reset</button>
                                        </div>
                                    </div>
                                </form>
                             </div> 
                             </div> 
                            
                            </div>  
                            
                                <div class="row challan-filter-section" data-default="">
                                    <div class="col-4 p-0">
                                        <button class="btn m-0 reconcile-status-btn">
                                            <div class="info-box bg-warning challan-info-box active" style="background: #ca7900 !important;">
                                                <div class="info-box-content allign-center">
                                                    <h3 id="total_challan_cnt">0</h3>
                                                    <p>Total Challans Issued</p>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                        </button>
                                    </div>    

                                    <div class="col-4 p-0 challan-filter-box">
                                        <button class="btn m-0 reconcile-status-btn" data-default="1">
                                            <div class="info-box bg-success challan-info-box">
                                                <div class="info-box-content allign-center">
                                                    <h3 id="reconcile_challan_cnt">0</h3>
                                                    <p>Challans Reconciled</p>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                        </button>
                                    </div>    
                                    <div class="col-4 p-0">  
                                        <button class="btn m-0 reconcile-status-btn" data-default="0">
                                            <div class="info-box bg-danger challan-info-box">
                                                <div class="info-box-content allign-center">
                                                    <h3 id="not_reconcile_challan_cnt">0</h3>
                                                    <p>Challans Not Reconciled</p>
                                                </div>
                                                <!-- /.info-box-content -->
                                            </div>
                                        </button>    
                                    </div>
                                       
                                </div>
                    
                            <div class="header-details">
                            <div class="name-area">
                            
                            </div>
                             <div class="action-area">
                           
                             <button class="btn btn-success float-right tooltips" onclick="reconcileSelectedChallans()"><i class="fa 
                             fa-check-circle"></i> Reconcile</button>  
                             <!-- <button class="btn btn-success float-right tooltips" disabled><i class="fa 
                             fa-check-circle"></i> Reconcile</button>   -->

                             </div> 
                            </div>  
                           
                            
                            
               
                            <table class="table" id="challanTbl">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Challan Number</th>
                                        <th>Type</th>
                                        <th>Truck/Dumper Number</th>
                                        <th>Origin</th>
                                        <th>Cargo</th>
                                        <th>Trip Started At</th>
                                        <th>Trip Ended At</th>
                                        <th>Shift</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script type='text/javascript'>
    var token = '<?php echo e(csrf_token()); ?>';
</script>
<script src="<?php echo e(js('challan_js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/challans/index.blade.php ENDPATH**/ ?>