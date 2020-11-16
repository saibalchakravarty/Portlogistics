<?php

namespace App\Repositories\BtopPlanning;

use App\Models\Plan;
use Exception;
use Log;
use App\Models\PlanTruck;
use App\Models\PlanDetail;
use Carbon\Carbon;

class BtopPlanningRepository {

    /**
     * List Plans based on origin id
     * @author Gaurav Agrawal
     * @param array $allInput ['origin_id','connection']
     * 
     * @return array ['status','result','message']
     */
    public function getPlanningDetailsByBerthAndDate($allInput) {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $planning = new BtopPlanning();
            $planning->setConnection($allInput['connection']);
            $allPlanning = $planning
                ->with(['cargo' => function ($query) {
                    $query->select('id', 'name');
                }, 'vessel' => function ($query) {
                    $query->select('id', 'name');
                }, 'location' => function ($query) {
                    $query->select('id', 'location');
                }, 'consignees' => function ($query) {
                    $query->distinct()->select('consignee_id', 'btop_planning_id', 'name');
                }, 'plots' => function ($query) {
                    $query->select('plot_location_id', 'consignee_id', 'btop_planning_id', 'location');
                }, 'trucks' => function ($query) {
                    $query->select('truck_id', 'truck_no')->where('status', '2');
                }])
                ->where('date_from', '<=', now())
                ->where('date_to', '>=', now());
                $allPlanning = $allPlanning->where('berth_location_id', $allInput['origin_id']);
            $allPlanning = $allPlanning->first();
            $result['status'] = true;
            if (!$allPlanning) {
                $result['message'] = 'No data available!';
                return $result;
            }
            if (!$allPlanning->has('consignees')) {
                $result['message'] = 'No consignee available!';
                return $result;
            }
            if (!$allPlanning->has('plots')) {
                $result['message'] = 'No plots available!';
                return $result;
            }
            if (!$allPlanning->has('trucks')) {
                $result['message'] = 'No trucks available!';
                return $result;
            }
            $result['message'] = 'Planning data fetch successfully.';
            $result['data'] = $allPlanning->toArray();
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = 'Something went wrong';
            $result['data'] = $e->getMessage();
            return $result;
        }
    }

    public function getPlanningInfo($inputs) {
        $response['status'] = true;
        try {
            $planning = new BtopPlanning();
            $planning->setConnection($inputs['connection']);
            if (isset($inputs['plan_id']) && !empty($inputs['plan_id'])) {
                $planning = $planning->where('id', $inputs['plan_id']);
            }
            $planning = $planning->with('vessel')->firstOrFail();
            if ($planning == null) {
                $response['status'] = false;
                $response['message'] = $response['result'] = 'Please provide a valid plan id';
            } else {
                $response['result'] = $planning;
                $response['message'] = 'Record fetched successfully';
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['message'] = 'Something Went Wrong';
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        return $response;
    }

    public function getPlannedTrucksByPlanningId($inputs) {
        $response['status'] = true;
        try {
            $plannedTruck = new PlanTruck();
            $plannedTruck->setConnection($inputs['connection']);
            if (isset($inputs['plan_id']) && !empty($inputs['plan_id'])) {
                $plannedTruck = $plannedTruck->where('plan_id', $inputs['plan_id']);
            }
            if (isset($inputs['truck_id']) && !empty($inputs['truck_id'])) {
                $plannedTruck = $plannedTruck->where('truck_id', $inputs['truck_id']);
            }
            $plannedTrucks = $plannedTruck->get();
            $response['result'] = $plannedTrucks;
            $response['message'] = 'Record fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['message'] = 'Something Went Wrong';
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        return $response;
    }

    public function getPlanningDetailsPlanningId($inputs) {
        $response['status'] = true;
        try {
            $planningDetail = new Plan();
            $planningDetail->setConnection($inputs['connection']);
            if (isset($inputs['plan_id']) && !empty($inputs['plan_id'])) {
                $planningDetail = $planningDetail->where('plan_id', $inputs['plan_id']);
            }
            if (isset($inputs['consignee_id']) && !empty($inputs['consignee_id'])) {
                $planningDetail = $planningDetail->where('consignee_id', $inputs['consignee_id']);
            }
            if (isset($inputs['destination_id']) && !empty($inputs['destination_id'])) {
                $planningDetail = $planningDetail->where('destination_id', $inputs['destination_id']);
            }
            $planningDetails = $planningDetail->get();
            $response['result'] = $planningDetails;
            $response['message'] = 'Record fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['message'] = 'Something Went Wrong';
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        return $response;
    }
    
    /*Planning Listing Using Ajax*/
    public function getListPlannings($auth, $start, $limit, $order = [], $where = '', $filterCondition = [], $additionalCondition = [], $countOnly = false) {
        $data = [];
        $fields = "
            btop_plannings.id,
            vessels.name as vessel_name,
            origins.location as berth_name,
            btop_plannings.date_from,
            btop_plannings.date_to,
            cargos.name as cargo_name,
            btop_plannings.created_at,
            count(btop_planned_trucks.id) as truck_count
        ";
        $joins = "
            INNER JOIN vessels ON vessels.id = btop_plannings.vessel_id
            INNER JOIN locations AS origins ON origins.id = btop_plannings.berth_location_id
            INNER JOIN cargos ON cargos.id = btop_plannings.cargo_id
            LEFT JOIN btop_planned_trucks ON btop_planned_trucks.btop_planning_id = btop_plannings.id
        ";
        try {
            $btopPlanning = new BtopPlanning();
            $btopPlanning->setConnection($auth['connection']);
            $query = "SELECT tbl.* FROM (";
            $query .= " SELECT " .$fields. " FROM btop_plannings ".$joins;
            if(!empty($filterCondition)) {
                $query .= " WHERE ";
                foreach($filterCondition as $key => $value) {
                    if($key > 0) {
                        $query .= " AND ";
                    }
                    if(\DateTime::createFromFormat('d/m/Y H:i', $value['value']) !== FALSE) {
                        $datetime = \Carbon\Carbon::createFromFormat('d/m/Y H:i', $value['value'])->format('Y-m-d H:i:s');
                        if($value['table_field'] == 'btop_plannings.date_from') {
                            $query .= "(btop_plannings.date_from >= '". $datetime."' OR btop_plannings.date_to >= '". $datetime."')";
                        } else if($value['table_field'] == 'btop_plannings.date_to') {
                            $query .= "(btop_plannings.date_from <= '". $datetime."' OR btop_plannings.date_to <= '". $datetime."')";
                        }
                    } else {
                        $query .= $value['table_field'] ." = '". $value['value']."'";
                    }
                }
            }
            $query .= " GROUP BY btop_plannings.id";
            $query .= " ) AS tbl";
            
            //Additional Condition will be added here
            $having = "";
            if(!empty($where)) {
                $having .= " HAVING (tbl.vessel_name like '%".$where."%' OR tbl.berth_name like '%".$where."%' OR tbl.date_from like '%".$where."%' OR tbl.date_to like '%".$where."%' OR tbl.cargo_name like '%".$where."%' OR tbl.created_at like '%".$where."%')";
            }
            if(!empty($additionalCondition)) {
                foreach($additionalCondition as $condition) {
                    if(empty($having)) {
                        $having .= " HAVING ";
                    } else {
                        $having .= " AND ";
                    }
                    if($condition['table_field'] == 'truck_count') {
                        $having .= ($condition['value'] == 0) ? "tbl.".$condition['table_field']." = 0" : "tbl.".$condition['table_field']." > 0";
                    }
                }
            }
            $query .= (!empty($having)) ? $having : '';
            
            if(!$countOnly) {
                if(empty($order)) {
                    $query .= " ORDER BY tbl.created_at desc";
                } else {
                    $query .= " ORDER BY tbl.".$order['field']." ".$order['dir'];
                }
            }
            $query .= (!$countOnly && $limit != -1) ? " LIMIT $start, $limit" : '';
            $data = \DB::select(\DB::raw($query));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return $data;
    }
    
    public function getConsigneePlotListByPlanningId($inputs) {
        $response['status'] = true;
        try {
            $planningDetail = new BtopPlanningDetail();
            $planningDetail->setConnection($inputs['connection']);
            $planningDetail = $planningDetail->select(
                'consignees.name as consignee_name',
                \DB::raw('GROUP_CONCAT(destinations.location) AS destination_names')   
            )
            ->join('consignees', 'consignees.id', '=', 'btop_planning_details.consignee_id')
            ->leftJoin('locations as destinations', 'destinations.id', '=', 'btop_planning_details.plot_location_id')
            ->where('btop_planning_details.btop_planning_id', $inputs['planning_id'])
            ->groupBy('btop_planning_details.consignee_id')        
            ->get();
            $response['result'] = $planningDetail;
            $response['message'] = 'Record fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['message'] = 'Something Went Wrong';
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        return $response;
    }
    
    //Delete data from plannings table along with planning_details and btop_planned_trucks
    public function delete($inputs) {
        $response['status'] = true;
        try {
            $planning = new BtopPlanning();
            $planningDetail = new BtopPlanningDetail();
            $plannedTruck = new BtopPlannedTruck();
            $planning->setConnection($inputs['connection']);
            if(isset($inputs['planning_id']) && !empty($inputs['planning_id'])) {
                $planningDetails = $planningDetail->where('btop_planning_id', $inputs['planning_id'])->get();
                if(!$planningDetails->isEmpty()) {
                    foreach($planningDetails as $planning_detail) {
                        $planningDetail::where('id', $planning_detail->id)->firstOrFail()->delete();
                    }
                }
                $plannedTrucks = $plannedTruck->where('btop_planning_id', $inputs['planning_id'])->get();
                if(!$plannedTrucks->isEmpty()) {
                    foreach($plannedTrucks as $planned_truck) {
                        $plannedTruck::where('id', $planned_truck->id)->firstOrFail()->delete();
                    }
                }
                $planning = $planning->findOrFail($inputs['planning_id']);
                $planning = $planning->delete();
                if(!$planning) {
                    $response['status'] = false;
                    $response['result'] = 'Some error occured';
                } else {
                    $response['status'] = true;
                }
            } else {
                $response['status'] = false;
                $response['result'] = 'Please provide a planning id';
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        return $response;
    }
    
    public function save($inputs) {
        $response['status'] = true;
        try {
            $planning = new BtopPlanning();
            $planning->setConnection($inputs['connection']);
            
            if (isset($inputs['id']) && !empty($inputs['id'])) {
                $planning = $planning->where('id', $inputs['id'])->firstOrFail();
            }
            
            $planning->berth_location_id = $inputs['berth_location_id'];
            $planning->cargo_id = $inputs['cargo_id'];
            $planning->vessel_id = $inputs['vessel_id'];
            $planning->date_from = $inputs['date_from'];
            $planning->date_to = $inputs['date_to'];
            if($planning->save()) {
                $response['result'] = $planning;
            } else {
                $response['status'] = false;
                $response['result'] = 'Some error occured';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
        }
        return $response;
    }
    
    public function insertPlanningDetails($auth, $planning_id, $plan_details) {
        $response['status'] = true;
        try {
            $planningDetail = new BtopPlanningDetail();
            $planningDetail->setConnection($auth['connection']);
            $planningDetails = $planningDetail->where('btop_planning_id', $planning_id)->get();
            if(!$planningDetails->isEmpty()) {
                foreach($planningDetails as $planning_detail) {
                    $planningDetail::where('id', $planning_detail->id)->first()->delete();
                }
            }
            $planningDetail = $planningDetail->insert($plan_details);
            if(!$planningDetail) {
                $response['status'] = false;
                $response['result'] = 'Some error occured';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
        }
        return $response;
    }
    
    public function validatePlanningInputs($inputs) {
        $response['status'] = true;
        try {
            $planning = new BtopPlanning();
            $planning->setConnection($inputs['connection']);
            if(isset($inputs['vessel_id']) && !empty($inputs['vessel_id'])) {
                $planning = $planning->where('vessel_id', $inputs['vessel_id']);
            }
            if(isset($inputs['berth_location_id']) && !empty($inputs['berth_location_id'])) {
                $planning = $planning->where('berth_location_id', $inputs['berth_location_id']);
            }
            if(isset($inputs['date_from']) && !empty($inputs['date_from']) && isset($inputs['date_to']) && !empty($inputs['date_to'])) {
                $planning = $planning->whereRaw("((date_from <= '".$inputs['date_from']."' AND date_to >= '".$inputs['date_to']."') OR (date_from BETWEEN '".$inputs['date_from']."' AND '".$inputs['date_to']."') OR (date_to BETWEEN '".$inputs['date_from']."' AND '".$inputs['date_to']."'))");
            }
            if(isset($inputs['id']) && !empty($inputs['id'])) {
                $planning = $planning->where('id','<>', $inputs['id']);
            }
            $planning = $planning->firstOrFail();
            $response['result'] = $planning;
            $response['message'] = 'Record fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        return $response;
    }
    
}
