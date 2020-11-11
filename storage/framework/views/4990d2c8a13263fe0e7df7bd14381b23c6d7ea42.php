

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(css('planning_css')); ?>">
<?php
$action = (isset($result['planning']) && !empty($result['planning'])) ? 'Edit' : 'Add';
?>
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
                                    <h2 class="m-0 text-dark"><?php echo e($action); ?> Plan</h2>
                                </div>
                                <div class="action-area"></div>
                            </div>
                            <form id="addPlanForm" novalidate="novalidate">
                                <input type="hidden" name="id" id="planning_id" value="<?php echo e((isset($result['planning']['id']) && !empty($result['planning']['id'])) ? $result['planning']['id'] : ''); ?>">
                                <input type="hidden" id="now" value="<?php echo e(date('d/m/Y H:i')); ?>">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th width="20%">Vessel</th>
                                                <th width="18%">Berth</th>
                                                <th width="22%">From</th>
                                                <th width="22%">To</th>
                                                <th width="18%">Cargo</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <input type="text" class="form-control" name="vessel_name" id="vessel_name" autocomplete="off" value="<?php echo e((isset($result['planning']['vessel']['name']) && !empty($result['planning']['vessel']['name'])) ? $result['planning']['vessel']['name'] : ''); ?>" maxlength="50"/>
                                                    <div id="suggesstion-box"></div>
                                                </td>
                                                <td>
                                                    <select class="form-control select2" style="width:100%;" name="berth_location_id">
                                                        <option value="">Select Berth</option>
                                                        <?php if(isset($result['berths']) && !empty($result['berths'])): ?>
                                                        <?php $__currentLoopData = $result['berths']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $berth): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($berth->id); ?>" <?php echo e((isset($result['planning']['berth_location_id']) && !empty($result['planning']['berth_location_id']) && ($result['planning']['berth_location_id'] == $berth->id)) ? 'selected' : ''); ?>><?php echo e($berth->location); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>            
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group date" id="from" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#from" name="date_from" id="date_from" value="<?php echo e((isset($result['planning']['date_from']) && !empty($result['planning']['date_from'])) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result['planning']['date_from'])->format('d/m/Y H:i') : ''); ?>" readonly/>
                                                        <div class="input-group-append" data-target="#from" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date" id="to" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#to" name="date_to" id="date_to" value="<?php echo e((isset($result['planning']['date_to']) && !empty($result['planning']['date_to'])) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result['planning']['date_to'])->format('d/m/Y H:i') : ''); ?>" readonly/>
                                                        <div class="input-group-append" data-target="#to" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-control select2" style="width:100%;" name="cargo_id">
                                                        <option value="">Select Cargo</option>
                                                        <?php if(isset($result['cargos']) && !empty($result['cargos'])): ?>
                                                        <?php $__currentLoopData = $result['cargos']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cargo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($cargo->id); ?>" <?php echo e((isset($result['planning']['cargo_id']) && !empty($result['planning']['cargo_id']) && ($result['planning']['cargo_id'] == $cargo->id)) ? 'selected' : ''); ?>><?php echo e($cargo->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>                     
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <hr>
                                    <table class="table" style="width: 50%;" id="planDetailTbl">
                                        <thead>
                                            <tr>
                                                <th width="40%">Customer Name</th>
                                                <th width="40%">Plots</th>
                                                <th width="20%"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if(isset($result['planning']['planning_details']) && !empty($result['planning']['planning_details'])): ?>
                                            <?php $__currentLoopData = $result['planning']['planning_details']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$planning_details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="planDetailTr">
                                                <td>
                                                    <select class="form-control selCustomer select2" style="width:100%;" name="plan_details[<?php echo e($key); ?>][consignee_id]">
                                                        <option value="">Select Customer</option>
                                                        <?php if(isset($result['consignees']) && !empty($result['consignees'])): ?>
                                                        <?php $__currentLoopData = $result['consignees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($consignee->id); ?>" <?php echo e((isset($planning_details['consignee_id']) && !empty($planning_details['consignee_id']) && ($planning_details['consignee_id'] == $consignee->id)) ? 'selected' : ''); ?>><?php echo e($consignee->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>            
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control selPlot select2" style="width:100%;" name="plan_details[<?php echo e($key); ?>][plot_location_id]">
                                                        <option value="">Select Plot</option>
                                                        <?php if(isset($result['plots']) && !empty($result['plots'])): ?>
                                                        <?php $__currentLoopData = $result['plots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($plot->id); ?>" <?php echo e((isset($planning_details['plot_location_id']) && !empty($planning_details['plot_location_id']) && ($planning_details['plot_location_id'] == $plot->id)) ? 'selected' : ''); ?>><?php echo e($plot->location); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>            
                                                    </select>
                                                </td>
                                                <td >
                                                    <input type="hidden" value="<?php echo e((isset($planning_details['id']) && !empty($planning_details['id'])) ? $planning_details['id'] : ''); ?>" name="plan_details[<?php echo e($key); ?>][id]" class="hdnPlanDetailId"/>
                                                    <a href="javascript:void(0);" class="add_plan_details pl-4"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" class="remove_plan_details pl-2"><i class="fas fa-trash text-danger" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php else: ?>
                                            <tr class="planDetailTr">
                                                <td>
                                                    <select class="form-control selCustomer select2" style="width:100%;" name="plan_details[0][consignee_id]">
                                                        <option value="">Select Customer</option>
                                                        <?php if(isset($result['consignees']) && !empty($result['consignees'])): ?>
                                                        <?php $__currentLoopData = $result['consignees']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $consignee): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($consignee->id); ?>"><?php echo e($consignee->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>            
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control selPlot select2" style="width:100%;" name="plan_details[0][plot_location_id]">
                                                        <option value="">Select Plot</option>
                                                        <?php if(isset($result['plots']) && !empty($result['plots'])): ?>
                                                        <?php $__currentLoopData = $result['plots']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($plot->id); ?>"><?php echo e($plot->location); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php endif; ?>            
                                                    </select>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <input type="hidden" value="" name="plan_details[0][id]" class="hdnPlanDetailId"/>
                                                    <a href="javascript:void(0);" class="add_plan_details pl-4"><i class="fa fa-2x fa-plus-circle text-success" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" class="remove_plan_details pl-2"><i class="fas fa-2x fa-trash text-danger" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer align-right">
                                    <button type="submit" class="icon-button btn-transparent" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
                                    <button type="button" class="icon-button btn-transparent" title="Cancel"><a href="<?php echo e(url('/plans')); ?>"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></a></button>
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
<script src="<?php echo e(js('add_plan_js')); ?>"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\mycodebox\htdocs\gitbucket\resources\views/planning/add_plan.blade.php ENDPATH**/ ?>