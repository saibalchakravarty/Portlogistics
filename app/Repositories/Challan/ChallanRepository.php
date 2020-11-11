<?php

namespace App\Exceptions;

namespace App\Repositories\Challan;

use App\Models\Challan;
use Exception;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use DB;
use App\Http\Controllers\DateTime;

Class ChallanRepository {

    /**
     * Fetch List of challans for mobile api
     * 
     */
    public function getInboundChallanList($inputs) {
        $response['status'] = true;
        try {
            $challans = new Challan();
            $challans->setConnection($inputs['connection']);
            $challans = $challans::with('shift');
            if (isset($inputs['planning_id']) && !empty($inputs['planning_id'])) {
                $challans = $challans->where('btop_planning_id', $inputs['planning_id']);
            }
            if (isset($inputs['location_id']) && !empty($inputs['location_id'])) {
                $challans = $challans->where('destination_location_id', $inputs['location_id']);
            }
            if (isset($inputs['truck_id']) && !empty($inputs['truck_id'])) {
                $challans = $challans->where('truck_id', $inputs['truck_id']);
            }
            $challans = $challans->where('status', 1);
            $challans = $challans->whereNotNull('loaded_at');
            $challans = $challans->firstOrFail();
            if(empty($challans))
            {
                $response['status'] = false;
                $response['message'] = 'No Record Found';
            }
            else{
                $response['result'] = $challans;
                $response['message'] = 'Challan Records fetched successfully';
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = 'Something Went Wrong';
            return $response;
        }
        return $response;
    }

    /**
     * Fetch List of challans for datatable
     * 
     */
    public function getListChallans($auth, $start, $limit, $order = [], $where = '', $filterCondition = [], $countOnly = false) {
        $data = [];
        $fields = "
            challans.id,
            challans.challan_no,
            IF(challans.type = 1, 'Berth to Plot', 'Plot to Berth') as type,
            trucks.truck_no,
            locations.location as origin,
            cargos.name as cargo_name,
            btop_plannings.date_from,
            btop_plannings.date_to,
            shifts.name as shift_name,
            IF(challans.status = 1, 'Unload Pending', 'Unloaded') as status,
            challans.is_deposit,
            challans.pdf_path,
            challans.created_at
        ";
        $joins = "
            INNER JOIN `trucks` ON `trucks`.`id` = `challans`.`truck_id`
            INNER JOIN `locations` ON `locations`.`id` = `challans`.`origin_location_id`
            INNER JOIN `cargos` ON `cargos`.`id` = `challans`.`cargo_id`
            INNER JOIN `shifts` ON `shifts`.`id` = `challans`.`shift_id`
            INNER JOIN `btop_plannings` ON `btop_plannings`.`id` = `challans`.`btop_planning_id`
        ";
        try {
            $challans = new Challan();
            $challans->setConnection($auth['connection']);
            $query = "SELECT tbl.* FROM (";
            $query .= " SELECT " .$fields. " FROM challans ".$joins;
            if(!empty($filterCondition)) {
                $query .= " WHERE ";
                foreach($filterCondition as $key => $value) {
                    if($key > 0) {
                        $query .= " AND ";
                    }
                    if(\DateTime::createFromFormat('Y-m-d', $value['value']) !== FALSE) {
                        $query .= "DATE(". $value['table_field'] .") = '". $value['value']."'";
                    } else {
                        $query .= $value['table_field'] ." = '". $value['value']."'";
                    }
                }
            }
            $query .= " ) AS tbl";
            if(!empty($where)) {
                $query .= " HAVING tbl.challan_no like '%".$where."%' OR tbl.type like '%".$where."%' OR tbl.truck_no like '%".$where."%' OR tbl.origin like '%".$where."%' OR tbl.cargo_name like '%".$where."%' OR tbl.shift_name like '%".$where."%' OR tbl.status like '%".$where."%'";
            }
            if(!$countOnly) {
                if(!empty($order)) {
                    $query .= " ORDER BY tbl.".$order['field']." ".$order['dir'];
                } else {
                    $query .= " ORDER BY tbl.created_at desc";
                }
            }
            $query .= (!$countOnly && $limit != -1) ? " LIMIT $start, $limit" : '';
            $data = DB::select(DB::raw($query));
        } catch (Exception $e) {
            Log::error($e->getMessage());
        }
        return $data;
    }

    public function getReconciledCounts($auth, $filterCondition) {
        $response['status'] = true;
        try {
            $challan = new Challan();
            $challan->setConnection($auth['connection']);
            foreach($filterCondition as $filter) {
                if((!in_array($filter['table_field'], ['challans.is_deposit'])) && !empty($filter['value'])) { //'challans.challan_no', 
                    if(\DateTime::createFromFormat('Y-m-d', $filter['value']) !== FALSE) {
                        $challan = $challan->whereDate($filter['table_field'], $filter['value']);
                    } else {
                        $challan = $challan->where($filter['table_field'], $filter['value']);
                    }    
                }
            }
            $challans = $challan->get();
            $reconciledCount = 0;
            $notReconciledCount = 0;
            if(!$challans->isEmpty()) {
                foreach($challans as $value) {
                    if($value->is_deposit == '1') {
                        $reconciledCount++;
                    } else {
                        $notReconciledCount++;
                    }
                }
            }
            $data['reconciledCount'] = $reconciledCount;
            $data['notReconciledCount'] = $notReconciledCount;
            $data['totalChallanCount'] = $notReconciledCount + $reconciledCount;
            $response['result'] = $data;
        } catch (Exception $e) {
            $response['status'] = false;
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
            $response['message'] = 'Something Went Wrong';
        }
        return $response;
    }

    public function reconcileChallan($inputs) {
        $response['status'] = true;
        try {
            $challan = new Challan();
            $challan->setConnection($inputs['connection']);
            foreach($inputs['challan_ids'] as $id) {
                $challan = $challan->where('id', $id)->first();
                if($challan->is_deposit == '0') {
                    $challan->is_deposit = '1';
                    $challan->updated_by = $inputs['user_id'];
                    $challan->save();
                }
            }
            $response['message'] = 'Reconciled successfully';
            $response['result'] = 'Reconciled successfully';
            return $response;
        } catch (Exception $e) {
            $response['status'] = false;
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
            $response['message'] = 'Something Went Wrong';
            return $response;
        }
    }

    /**
     * Update Challan table for end trip api
     * 
     */
    public function updateChallanTableForEndTrip($allInput) {
        //dd($allInput);
        $fetch['status'] = true;
        try {
            $challan = new Challan();
            $challan->setConnection($allInput['connection']);
            $challan = $challan->where('destination_location_id', $allInput['location_id']);
            $challan = $challan->where('btop_planning_id', $allInput['planning_id']);
            $challan = $challan->where('truck_id', $allInput['truck_id']);
            $challan = $challan->update(['status' => 2, 'unloaded_at' => Carbon::now(), 'unloaded_by' => $allInput['user_id'], 'updated_by' => $allInput['user_id']]);
            if (!$challan) {
                $fetch['status'] = false;
                $fetch['message'] = 'No Record Found';
            } else {
                $fetch['message'] = 'Challan data updated successfully';
            }
            return $fetch;
        } catch (Exception $e) {
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            Log::error($e->getMessage());
            return $fetch;
        }
    }

    /**
     * Fetch Location by id
     * 
     */
    public function getChallanByInput($allInput) {
        $fetch['status'] = true;
        try {
            $challan = new Challan();
            $challan->setConnection($allInput['connection']);
            $challan = $challan->where('destination_location_id', $allInput['location_id']);
            $challan = $challan->where('btop_planning_id', $allInput['planning_id']);
            $challan = $challan->where('truck_id', $allInput['truck_id']);
            $challan = $challan->firstOrFail();
            if (!$challan) {
                $fetch['status'] = false;
                $fetch['message'] = 'No Record Found';
            } else {
                $fetch['message'] = 'Challan data fetched successfully';
                $fetch['result'] = $challan->toArray();
            }
            return $fetch;
        } catch (Exception $e) {
            $fetch['status'] = false;
            Log::error($e->getMessage());
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            return $fetch;
        }
    }

    /* For Scan Challan API */

    public function getChallanDetails($inputs) {
        $response['status'] = true;
        try {
            $challans = new Challan();
            $challans->setConnection($inputs['connection']);
            $challans = $challans::with('btop_planning')->with('origin')->with('destination')->with('truck')->with('shift')->with('cargo');
            if (isset($inputs['challan_no']) && !empty($inputs['challan_no'])) {
                $challans = $challans->where('challan_no', $inputs['challan_no']);
            }
            $challans = $challans->firstOrFail();
            if ($challans == null) {
                $response['status'] = false;
                $response['message'] = 'Please provide a valid challan no.';
            } else {
                $response['result'] = $challans;
                $response['message'] = 'Records fetched successfully';
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['message'] = $e->getMessage();
        }
        return $response;
    }

    /**
     * Update scan challan status
     * 
     */
    public function updateChallanScanStatus($inputs) {
        $response['status'] = true;
        try {
            $challan = new Challan();
            $challan->setConnection($inputs['connection']);
            $challan = $challan->where('destination_location_id', $inputs['location_id']);
            $challan = $challan->where('challan_no', $inputs['challan_no']);
            $challan = $challan->update(['is_scanned' => '1']);
            if (!$challan) {
                $response['status'] = false;
                $response['message'] = 'No Record Found';
            } else {
                $response['message'] = 'Challan scanned successfully';
            }
        } catch (Exception $e) {
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = 'Something Went Wrong';
            Log::error($e->getMessage());
        }
        return $response;
    }

    public function getFilteredChallans($inputs) {
        $response['status'] = true;
        try {
            $challans = new Challan();
            $challans->setConnection($inputs['connection']);
            if (isset($inputs['planning_id']) && !empty($inputs['planning_id'])) {
                $challans = $challans->where('btop_planning_id', $inputs['planning_id']);
            }
            if (isset($inputs['location_id']) && !empty($inputs['location_id'])) {
                $challans = $challans->where('destination_location_id', $inputs['location_id']);
            }
            if (isset($inputs['truck_id']) && !empty($inputs['truck_id'])) {
                $challans = $challans->where('truck_id', $inputs['truck_id']);
            }
            if (isset($inputs['origin_location_id']) && !empty($inputs['origin_location_id'])) {
                $challans = $challans->where('origin_location_id', $inputs['origin_location_id']);
            }
            if (isset($inputs['destination_location_id']) && !empty($inputs['destination_location_id'])) {
                $challans = $challans->where('destination_location_id', $inputs['destination_location_id']);
            }
            if (isset($inputs['consignee_id']) && !empty($inputs['consignee_id'])) {
                $challans = $challans->where('consignee_id', $inputs['consignee_id']);
            }
            if (isset($inputs['status']) && !empty($inputs['status'])) {
                $challans = $challans->where('status', $inputs['status']);
            }
            $challans = $challans->get();
            $response['result'] = $challans;
            $response['message'] = 'Records fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = 'Something Went Wrong';
            return $response;
        }
        return $response;
    }

    public function saveChallan($inputs) {
        $response['status'] = true;
        try {
            $challan = new Challan();
            $challan->setConnection($inputs['connection']);
            
            if (isset($inputs['id']) && !empty($inputs['id'])) {
                $challan = $challan->where('id', $inputs['id'])->first();
            }
            
            $challan->btop_planning_id = $inputs['btop_planning_id'];
            $challan->origin_location_id = $inputs['origin_location_id'];
            $challan->destination_location_id = $inputs['destination_location_id'];
            $challan->truck_id = $inputs['truck_id'];
            $challan->shift_id = $inputs['shift_id'];
            $challan->cargo_id = $inputs['cargo_id'];
            $challan->consignee_id = $inputs['consignee_id'];
            $challan->challan_no = $inputs['challan_no'];
            $challan->type = $inputs['type'];
            $challan->status = $inputs['status'];
            $challan->is_deposit = $inputs['is_deposit'];
            $challan->is_scanned = $inputs['is_scanned'];
            $challan->created_by = $inputs['created_by'];
            $challan->loaded_at = $inputs['loaded_at'];
            $challan->barcode_path = $inputs['barcode_path'];
            $challan->pdf_path = $inputs['pdf_path'];
            if ($challan->save()) {
                $response['message'] = 'Challan information saved successfully';
                $response['result'] = $challan;
            } else {
                $response['status'] = false;               
                $response['message'] = 'No Record Found';
            }
            return $response;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
            $response['message'] = 'Something Went Wrong';
            return $response;
        }
    }

}
