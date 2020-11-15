

<?php $__env->startSection('content'); ?>
<?php 
     $privilegeArr = isset( $result['privileges']['display_name'])? $result['privileges']['display_name']:array();
	//dd($privilegeArr);
?>
<!-------------------------------- 
	Author : Ashish Barick
	Module : Roles & Privileges
 --------------------------------->

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <!-- <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-dark">Roles & Privileges</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Administration</a></li>
                        <li class="breadcrumb-item active">Roles & Privileges</li>
                    </ol>
                </div>
            </div>
        </div> -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container">
            <div class="container-fluid">
            	<div class="row">
		          <div class="col-12">
		            <!-- Role box -->
		            <div class="card card-outline card-primary">
		            	<div class="card-header">
		                	<h2 style="font-size: 1.75rem;" class="card-title">Roles & Privileges</h2>
		                	<div class="card-tools">
			                  	<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
			                    <i class="fas fa-minus"></i>
			                  	</button>
		                	</div>
		              	</div>
		              	<div class="card-body">
		              		<form id="frmRole" name="frmRole">
				              	<div class="row">
					              	<div class="col-md-2">
					              		<label>Role : </label>
					              	</div>
					              	<div class="col-md-6">
						                <div class="form-group">
						                 	<select class="form-control select2" id="cmbRole" name="cmbRole"  style="width: 100%;">
							                    <option value="">Select Role</option>
							                    <?php $__currentLoopData = $result[0]['role']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
							                    <option value="<?php echo e($data->id); ?>"><?php echo e($data->name); ?></option>
							                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
						                  	</select>
						                </div>
						            </div>
						            <div class= "col-md-4">
						              	<div class="form-group" style="cursor: pointer;">
						              		
					            				<span id="btnRoleAdd"><i class="fas fa-2x fa-plus-circle tooltips text-primary" data-placement="top" title="Add Roles & Privilege" ></i></span>&nbsp;&nbsp;
					            			
							            		<span id="btnRoleEdit"><i class="fas fa-2x fa-edit tooltips text-warning" data-placement="top" title="Update Roles & Privilege" id="btnRoleEdit"></i></span> &nbsp;&nbsp;
							            
							            		<span id="btnRoleDelete"><i class="fas fa-2x fa-trash tooltips text-danger" data-placement="top" title="Delete Roles & Privilege" id="btnRoleDelete"></i></span>
							            	
							            </div>
							        </div>
						        </div>	<!-- End Role Row -->	
						          <!--  Vessels Modal for ADD/EDIT -->
					            <div class="modal fade" id="modal-role">
					                <div class="modal-dialog">
					                    <div class="modal-content">
					                        <div class="modal-header">
					                            <h4 class="modal-title" id="mdlRoleTitle">Add Role</h4>
					                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					                                <span aria-hidden="true">&times;</span>
					                            </button>
					                        </div>

					                        <div class="modal-body">
					                            
				                                <input type="hidden" id="id" name="id">
				                                <div class="form-group">
				                                    <label for="VesselsInput">Role <span class="text-danger">*</span></label>
				                                    <input type="text" class="form-control tooltips" id="name" name="name" placeholder="Enter Role" data-placement="top" >
				                                </div>
				                                
				                                <div class="modal-footer justify-content">
				                                	<div class="form-group">
					                                    <button type="button" class="icon-button" data-dismiss="modal" title="Cancel"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></button>
					                                    <button type="Submit" class="icon-button" data-placement="top" title="Save" id="btnRoleSubmit"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
					                                </div>
				                                </div>
					                        </div>
					                    </div>
					                    <!-- /.modal-content -->
					                </div>
					                <!-- /.modal-dialog -->
					            </div>
					            <!-- /.Vessels Modal -->
					        </form>		            
				        </div>
		              <!-- /. Role card-body -->
		            </div>
		            <!-- /.Role card -->
		          </div>
		        </div><!--/. Role Row -->
		       
		        <!-- Privileges Part -->
		        <form id="frmPrivilege" name="frmPrivilege">
	                <div class="row">
	                    <div class="col-12">
	                        <div class="card card-primary">
	                            <div class="card-header ">
	                                <div class="row">
	                                	<div class="col-6 text-center" style="border-right: solid 1px #D3D3D3;">
	                                		<label>Screen</label>
	                                	</div>
	                                	<div class="col-6 text-center">
	                                		<label>Privilege</label>
	                                	</div>
	                                </div>

	                            </div>
	                            
	                            <!-- /.card-header -->
	                            <div class="card-body">
									<div class="col-12" style="border-bottom: solid 1px #D3D3D3;">
	                                	<?php $__currentLoopData = $result[1]['menu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $parent): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
											<div class="card">
												<div class="card-header">
													<div class="card-title"><?php echo e($parent->display_name); ?></div>
												</div>
												<div class="card-body">
													<?php $__currentLoopData = $parent->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
													<div class="row">
														<!-- Screen Body -->
														<div class="col-6"  style="border-right: solid 1px #D3D3D3;border-bottom: solid 1px #D3D3D3;">
															<label><?php echo e($child->display_name); ?></label>
														</div>
														<!-- /Screen Body End -->
														<!-- Privileges Body -->
														
														<div class="col-6 text-center" style="border-bottom: solid 1px #D3D3D3;">
															<?php $__currentLoopData = $child->subChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subchild): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
															<div class="row">
																<div class="col-6">
																	<label><?php echo e($subchild->display_name); ?></label>
																</div>
																<div class="col-6">
																	<div class="form-group clearfix">
																		<div class="icheck-primary d-inline">
																			<input type="checkbox" class="chkPrivilege" id="chk<?php echo e($subchild->id); ?>" name= "chkPrivilege[]" value="<?php echo e($parent->id.','. $child->id.','.$subchild->id); ?>"> 
																		</div>  
																	</div>
																</div>
															</div>
															<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
														</div>
														
														<!-- /Privileges Body End -->
													</div>
													<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
												</div>
											</div>
	                                	<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	                                </div>
	                                <!-- /Privileges Row -->
	                            </div>
	                            <!-- /.card-body -->
	                        </div>
	                        <!-- /.card -->
	                        <div class="card">
	                        	<div class="card-body">
	                        		<div class="row text-center">
									
	                        			<button class="btn btn-primary btn-block" type="button" id="btnSubmitPrivilege" >Submit</button>
	                        	
									</div>
	                        	</div>
	                        </div>
	                    </div>
	                    <!-- /.col -->
	                </div>
	                <!-- /.row -->
	            </form><!-- /Privilege Form -->
            </div>
            <!-- /.container-fluid -->
          
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php $__env->stopSection(); ?>

<?php $__env->startPush('script'); ?>
<script src="<?php echo e(js('roleprivileges_js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/rolePrivileges/index.blade.php ENDPATH**/ ?>