


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
                    <h1 class="m-0 text-dark">Cargo</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Cargo</li>
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
                    <input type="hidden" id="cargo_id"> 
                    <div class="col-md-12"> 
                        <!-- <?php if(in_array('ADD',$privilegeArr)): ?>
                        <span  class="float-right" id="add_cargo_btn" data-placement="top" title="Add Cargo" style="cursor: pointer;">
                            <i class="fas fa-3x fa-plus-circle tooltips text-primary"></i>
                        </span>  
                        <?php endif; ?>                              
                    </div><br><br><br> -->

                    <div class="card">
                        <div class="card-header border-0">
                            <div class="header-details">
                            <div class="name-area">
                            <h2 class="m-0 text-dark">Cargo</h2>
                            </div>
                            <div class="action-area">
                                
                               
                                <form action="<?php echo e(url('csv-export')); ?>" method="post">
                                    <?php echo csrf_field(); ?>
                                    <input type="hidden" name="key" value = "Cargo">
                                    <button  type="submit" class="btn btn-primary float-right tooltips "><i class="fa fa-file-excel"></i> Export</button>
                                </form>
                              
                                <button id="add_cargo_btn" type="button" class="btn btn-success tooltips " ><i class="fa fa-plus"></i> Add New Cargo</button>
                               
                            </div> 
                            </div>
                            </div>
               
                <!-- /.card-header -->
                <div class="col-md-12 table  p-4">
                    <table id="dtcargo" class="table  table-striped">
                        <thead align="center">
                            <tr>
                              
                                <th>Cargo</th>
                                <th>Description</th> 
                                <th hidden=""></th>                                           
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody align="center">
                        <?php $__currentLoopData = $result['cargo']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            
                            <td><?php echo e($result->name); ?></td>                                    
                            <td><?php echo e($result->instruction); ?></td>
                            <td hidden=""><?php echo e($result->id); ?></td>      
                            <td align="center">
                                
                                    <a href="javascript:void(0);" onclick="editCargo(<?php echo e(($result->id)); ?>)" data-toggle="tooltip" class="edit tooltips" title="Update Cargo"><i class="fas fa-2x fa-edit text-success"></i></a> &nbsp;&nbsp;
                             
                                    <i class='fas fa-2x fa-trash text-danger tooltips delete' data-placement='top' title='Delete Cargo' style='cursor:pointer'></i>
                             
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
        </div>
    </section>
    
    <!-- /.content -->
</div>
<div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Cargo</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
              <form id="add_cargo" method="post">
                  <input type="hidden" name="id" id="hidden_id">
            <div class="modal-body">                
                <div class="card-body">
                  <div class="form-group">
                      <label for="cargo">Cargo<span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter Cargo Name">
                  </div>
                  <div class="form-group">
                    <label for="handling_instruction">Description</label>
                    <textarea id="instruction" name="instruction" class="form-control" rows="3" placeholder="Enter Description"></textarea>
                  </div>                 
                </div>
                <!-- /.card-body --> 
                
              
            </div>
            <div class="modal-footer justify-content">
              <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
              <button id="btncargo" type="submit" class="icon-button" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
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
<script src="<?php echo e(js('cargo_js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/cargo/index.blade.php ENDPATH**/ ?>