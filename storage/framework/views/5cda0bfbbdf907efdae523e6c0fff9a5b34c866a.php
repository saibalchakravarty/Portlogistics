
<?php $__env->startSection('content'); ?>

<div class="content-wrapper">
     <div class="content-header">
      <!--  <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">

                </div>

            </div>
        </div>-->
    </div>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- general form elements -->
                    <div class="card">
                            <div class="card-header border-0">
                            <div class="header-details">
                            <div class="name-area">
                            <h2 class="m-0 text-dark">Add Truck</h2>
                            </div>
                            <div class="action-area">
                            </div>
                            </div>
                    </div>
                        <form id="addTruckForm" method="post" action="<?php echo e(url('plan/truck')); ?>">
                            <?php echo csrf_field(); ?>
                            <input type="hidden" name="planning_id" id="planning_id" value="<?php echo e($response['planning_details']['result']['id']); ?>">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Vessel</th>
                                            <th>Berth</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Cargo</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><?php echo e($response['planning_details']['result']['vessel']['name']); ?></td>
                                            <td><?php echo e($response['planning_details']['result']['location']['location']); ?></td>
                                            <td><?php echo e(date('d/m/Y H:i',strtotime($response['planning_details']['result']['date_from']))); ?></td>
                                            <td><?php echo e(date('d/m/Y H:i',strtotime($response['planning_details']['result']['date_to']))); ?></td>
                                            <td><?php echo e($response['planning_details']['result']['cargo']['name']); ?></td>
                                        </tr>
                                    </tbody>
                                </table>


                                <table class="table" style="width: 60%;" id="planTruckDetailTbl">
                                    <thead>
                                        <tr>
                                            <th width="40%">Truck Number</th>
                                            <th width="40%">Trucking Company</th>
                                            <th width="20%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(count($response['truck_details']['result']) > 0): ?>
                                        <?php $__currentLoopData = $response['truck_details']['result']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $truck_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="planTruckDetailTr">
                                            <td>
                                                <select class="form-control select2 cmb_truck" disabled="">
                                                    <option value="">Select Truck</option>
                                                    <?php if(count($response['all_truck_details']['trucks']) > 0): ?>
                                                        <?php $__currentLoopData = $response['all_truck_details']['trucks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all_truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option trucking_company_id="<?php echo e($all_truck->truck_company_id); ?>" trucking_company_name="<?php echo e($all_truck->name); ?>" value="<?php echo e($all_truck->id); ?>" <?php echo e((isset($truck_details->truck_id) && !empty($truck_details->truck_id) && ($truck_details->truck_id == $all_truck->id)) ? 'selected' : ''); ?>><?php echo e($all_truck->truck_no); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>                                                
                                                <input type="hidden" class="hdn_truck_id" id="hdn_<?php echo e($key); ?>" name="trucks[<?php echo e($key); ?>][truck_id]" value="<?php echo e((isset($truck_details->truck_id) && !empty($truck_details->truck_id)) ? $truck_details->truck_id : ''); ?>" />
                                                <input type="hidden" class="truck_company_id" name="trucks[<?php echo e($key); ?>][truck_company_id]" value="<?php echo e($truck_details->truck->truckCompany->id); ?>">
                                            </td>
                                            <td>
                                                <span class="pl-2 trucking_company"><?php echo e($truck_details->truck->truckCompany->name); ?></span>
                                            </td>
                                            <td>
                                                <input type="hidden" value="<?php echo e((isset($truck_details['id']) && !empty($truck_details['id'])) ? $truck_details['id'] : ''); ?>" name="trucks[<?php echo e($key); ?>][id]" class="hdnPlanDetailId"/>
                                                <a href="javascript:void(0);" class="add_plan_details pl-4"><i class="fa fa-2x fa-plus-circle text-success" aria-hidden="true"></i></a>
                                                <a href="javascript:void(0);" class="remove_plan_details pl-2"  status_id="<?php echo e($truck_details->status); ?>"><i class="fas fa-2x fa-trash text-danger" aria-hidden="true"></i></a>
                                            </td>
                                        </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php else: ?>
                                        <tr class="planTruckDetailTr">
                                            <td>
                                                <select class="form-control uppercase select2 cmb_truck truck" name="trucks[0][truck_id]">
                                                    <option value="">Select Truckkkkkkk</option>
                                                    <?php if(count($response['all_truck_details']['trucks']) > 0): ?>
                                                        <?php $__currentLoopData = $response['all_truck_details']['trucks']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $all_truck): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option  trucking_company_name="<?php echo e($all_truck->name); ?>" value="<?php echo e($all_truck->id); ?>"><?php echo e($all_truck->truck_no); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>
                                                <input type="text" class="truck_company_id" name="trucks[0][truck_company_id]">
                                            </td>
                                            <td>
                                                <span class="trucking_company"></span>
                                                <span class="truckDetails"></span>
                                            </td>
                                            <td>
                                                <input type="text" value="" name="trucks[0][id]" class="hdnPlanDetailId"/>
                                                <a href="javascript:void(0);" class="add_plan_details pl-4"><i class="fa fa-2x fa-plus-circle text-success" aria-hidden="true" title="Add More"></i></a>
                                                <a href="javascript:void(0);" class="remove_plan_details pl-2" status_id=""><i class="fas fa-2x fa-trash text-danger" aria-hidden="true" title="Delete"></i></a>
                                            </td>
                                        </tr>
                                        <?php endif; ?>
                                    </tbody>

                                </table>
                                <div class="modal-footer justify-end">
                                <button id="btn_add_truck" type="submit" class="icon-button btn-transparent"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
                                <a href="<?php echo e(url('plans')); ?>" class="icon-button btn-transparent"><i class="fas fa-2x fa-times-circle tooltips text-danger "></i></a>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('script'); ?>
<script type='text/javascript'>
    var token = '<?php echo e(csrf_token()); ?>';
    var truck_company = <?php echo json_encode($response['truck_companies']['truck_company']) ?>;
    console.log(truck_company);
</script>
<script src="<?php echo e(js('add_truck_js')); ?>"></script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/planning/truck/create.blade.php ENDPATH**/ ?>