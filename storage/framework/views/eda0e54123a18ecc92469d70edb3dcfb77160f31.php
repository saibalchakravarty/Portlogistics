


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
                    <h1 class="m-0 text-dark">Trucks</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Trucks</li>
                    </ol>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.content-header -->
    <?php if($status!='failed'): ?>
    <!-- Main content -->
    <section class="content">
        <div class="container">
            <div class="container-fluid">
                <div class="row">
                    <input type="hidden" id="truck_id">
                    <div class="col-md-12">
                        <!-- <?php if(in_array('ADD',$privilegeArr)): ?>
                        <span  class="float-right" id="add_trucks_btn" data-placement="top" title="Add Truck" style="cursor: pointer;">
                            <i class="fas fa-3x fa-plus-circle tooltips text-primary"></i>
                        </span>
                         <?php endif; ?>
                    </div><br><br><br> -->

                    <div class="card">
                            <div class="card-header border-0">
                            <div class="header-details">
                            <div class="name-area">
                            <h2 class="m-0 text-dark">Trucks</h2>
                            </div>
                            <div class="action-area">
                               
                               
                                 <form action="<?php echo e(route('csv-export')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="key" value = "Trucks">
                                    <button  type="submit" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</button>
                                </form>
                               
                                <button id="add_trucks_btn" type="button" class="btn btn-success tooltips " ><i class="fa fa-plus"></i> Add New Truck</button>
                              
                            </div> 
                            </div>
                            </div>
               
                    <!-- /.card-header -->
                    <div class="col-md-12 table">
                        <table id="trucks" class="table">
                            <thead align="center">
                                <tr>
                                   
                                    <th>Truck/Dumper No</th>
                                    <th>Trucking Company</th>
                                    <th hidden="">Action</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody align="center">  
                            <?php $__currentLoopData = $result['trucks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                
                                <td><?php echo e(strtoupper($truck->truck_no)); ?></td>                                    
                                <td><?php echo e($truck->name); ?></td> 
                                 <td hidden=""><?php echo e($truck->id); ?></td>    
                                <td>
                                   
                                        <a href="javascript:void(0);" onclick="return editTruck('<?php echo e($truck->id); ?>')" data-toggle="tooltip" class="edit tooltips" title='Update Truck'><i class="fas fa-2x fa-edit text-success"></i></a> &nbsp;&nbsp;
                                 
                                        <i class='fas fa-2x fa-trash text-danger tooltips delete' data-placement='top' title='Delete Truck' style='cursor:pointer'></i>
                                   
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
</div>
<?php endif; ?>

<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Trucks</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <form id="add_trucks" method="post">
                  <input type="hidden" name="id" id="hidden_id">
            <div class="modal-body"> 
               <?php  //dd($result);?> 
                <div class="card-body">
                    <div class="form-group">
                        <label for="truck_no">Truck/Dumper No<span class="text-danger">*</span></label>
                        <input type="text" class="form-control uppercase" id="truck_no" name="truck_no" placeholder="Enter Trucks/Dumper No">
                    </div>
                    <div class="form-group">
                        <label for="truck_company_id">Trucking Company<span class="text-danger">*</span></label>
                        <select class="form-control" id="truck_company_id" name="truck_company_id">
                            <option value="">Select Trucking Company</option>
                            <?php if(!empty($result['trucking_company'])): ?>
                            <?php $__currentLoopData = $result['trucking_company']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trucking_company): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($trucking_company->id); ?>" <?php echo e((isset($result['trucks']->truck_company_id) && !empty($result['trucks']->truck_company_id) && ($result['trucks']->truck_company_id == $trucking_company->id)) ? 'selected' : ''); ?>><?php echo e($trucking_company->name); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>                                                                  
                        </select>
                    </div>
                </div>
                <!-- /.card-body -->                
            </div>
            <div class="modal-footer justify-content">
              <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
              <button id="trucks_btn" type="submit" class="icon-button" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
            </div>
              </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>

<!-- /.content-wrapper -->

<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script src="<?php echo e(js('truck_js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/truck/index.blade.php ENDPATH**/ ?>