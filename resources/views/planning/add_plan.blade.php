@extends('layouts.layout')

@section('content')
<link rel="stylesheet" href="{{css('planning_css')}}">
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
                                    <h2 class="m-0 text-dark">{{$action}} Plan</h2>
                                </div>
                                <div class="action-area"></div>
                            </div>
                            <form id="addPlanForm" novalidate="novalidate">
                                <input type="hidden" name="id" id="planning_id" value="{{(isset($result['planning']['id']) && !empty($result['planning']['id'])) ? $result['planning']['id'] : ''}}">
                                <input type="hidden" id="now" value="{{date('d/m/Y H:i')}}">
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
                                                    <input type="text" class="form-control" name="vessel_name" id="vessel_name" autocomplete="off" value="{{(isset($result['planning']['vessel']['name']) && !empty($result['planning']['vessel']['name'])) ? $result['planning']['vessel']['name'] : ''}}" maxlength="50"/>
                                                    <div id="suggesstion-box"></div>
                                                </td>
                                                <td>
                                                    <select class="form-control select2" style="width:100%;" name="berth_location_id">
                                                        <option value="">Select Berth</option>
                                                        @if(isset($result['berths']) && !empty($result['berths']))
                                                        @foreach($result['berths'] as $berth)
                                                        <option value="{{$berth->id}}" {{(isset($result['planning']['berth_location_id']) && !empty($result['planning']['berth_location_id']) && ($result['planning']['berth_location_id'] == $berth->id)) ? 'selected' : ''}}>{{$berth->location}}</option>
                                                        @endforeach
                                                        @endif            
                                                    </select>
                                                </td>
                                                <td>
                                                    <div class="input-group date" id="from" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#from" name="date_from" id="date_from" value="{{(isset($result['planning']['date_from']) && !empty($result['planning']['date_from'])) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result['planning']['date_from'])->format('d/m/Y H:i') : ''}}" readonly/>
                                                        <div class="input-group-append" data-target="#from" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="input-group date" id="to" data-target-input="nearest">
                                                        <input type="text" class="form-control datetimepicker-input" data-target="#to" name="date_to" id="date_to" value="{{(isset($result['planning']['date_to']) && !empty($result['planning']['date_to'])) ? \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $result['planning']['date_to'])->format('d/m/Y H:i') : ''}}" readonly/>
                                                        <div class="input-group-append" data-target="#to" data-toggle="datetimepicker">
                                                            <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <select class="form-control select2" style="width:100%;" name="cargo_id">
                                                        <option value="">Select Cargo</option>
                                                        @if(isset($result['cargos']) && !empty($result['cargos']))
                                                        @foreach($result['cargos'] as $cargo)
                                                        <option value="{{$cargo->id}}" {{(isset($result['planning']['cargo_id']) && !empty($result['planning']['cargo_id']) && ($result['planning']['cargo_id'] == $cargo->id)) ? 'selected' : ''}}>{{$cargo->name}}</option>
                                                        @endforeach
                                                        @endif                     
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
                                            @if(isset($result['planning']['planning_details']) && !empty($result['planning']['planning_details']))
                                            @foreach($result['planning']['planning_details'] as $key=>$planning_details)
                                            <tr class="planDetailTr">
                                                <td>
                                                    <select class="form-control selCustomer select2" style="width:100%;" name="plan_details[{{$key}}][consignee_id]">
                                                        <option value="">Select Customer</option>
                                                        @if(isset($result['consignees']) && !empty($result['consignees']))
                                                        @foreach($result['consignees'] as $consignee)
                                                        <option value="{{$consignee->id}}" {{(isset($planning_details['consignee_id']) && !empty($planning_details['consignee_id']) && ($planning_details['consignee_id'] == $consignee->id)) ? 'selected' : ''}}>{{$consignee->name}}</option>
                                                        @endforeach
                                                        @endif            
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control selPlot select2" style="width:100%;" name="plan_details[{{$key}}][plot_location_id]">
                                                        <option value="">Select Plot</option>
                                                        @if(isset($result['plots']) && !empty($result['plots']))
                                                        @foreach($result['plots'] as $plot)
                                                        <option value="{{$plot->id}}" {{(isset($planning_details['plot_location_id']) && !empty($planning_details['plot_location_id']) && ($planning_details['plot_location_id'] == $plot->id)) ? 'selected' : ''}}>{{$plot->location}}</option>
                                                        @endforeach
                                                        @endif            
                                                    </select>
                                                </td>
                                                <td >
                                                    <input type="hidden" value="{{(isset($planning_details['id']) && !empty($planning_details['id'])) ? $planning_details['id'] : ''}}" name="plan_details[{{$key}}][id]" class="hdnPlanDetailId"/>
                                                    <a href="javascript:void(0);" class="add_plan_details pl-4"><i class="fa fa-plus-circle text-success" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" class="remove_plan_details pl-2"><i class="fas fa-trash text-danger" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr class="planDetailTr">
                                                <td>
                                                    <select class="form-control selCustomer select2" style="width:100%;" name="plan_details[0][consignee_id]">
                                                        <option value="">Select Customer</option>
                                                        @if(isset($result['consignees']) && !empty($result['consignees']))
                                                        @foreach($result['consignees'] as $consignee)
                                                        <option value="{{$consignee->id}}">{{$consignee->name}}</option>
                                                        @endforeach
                                                        @endif            
                                                    </select>
                                                </td>
                                                <td>
                                                    <select class="form-control selPlot select2" style="width:100%;" name="plan_details[0][plot_location_id]">
                                                        <option value="">Select Plot</option>
                                                        @if(isset($result['plots']) && !empty($result['plots']))
                                                        @foreach($result['plots'] as $plot)
                                                        <option value="{{$plot->id}}">{{$plot->location}}</option>
                                                        @endforeach
                                                        @endif            
                                                    </select>
                                                </td>
                                                <td style="vertical-align: middle;">
                                                    <input type="hidden" value="" name="plan_details[0][id]" class="hdnPlanDetailId"/>
                                                    <a href="javascript:void(0);" class="add_plan_details pl-4"><i class="fa fa-2x fa-plus-circle text-success" aria-hidden="true"></i></a>
                                                    <a href="javascript:void(0);" class="remove_plan_details pl-2"><i class="fas fa-2x fa-trash text-danger" aria-hidden="true"></i></a>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                                <div class="card-footer align-right">
                                    <button type="submit" class="icon-button btn-transparent" title="Save"><i class="fas fa-2x fa-save tooltips text-success"></i></button>
                                    <button type="button" class="icon-button btn-transparent" title="Cancel"><a href="{{url('/plans')}}"><i class="fas fa-2x fa-times-circle tooltips text-danger"></i></a></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>  
@endsection

@push('script')
<script src="{{js('add_plan_js')}}"></script>
@endpush