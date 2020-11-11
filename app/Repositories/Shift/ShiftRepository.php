<?php

namespace App\Repositories\Shift;


use Illuminate\Http\Request;
use App\Models\Shift;
use Exception;
use Log;

class ShiftRepository {

    /**
     * @description Get shift details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array'] 
     * @return array ['status','message','result']
     */
    public function getShifts($inputs) {
        $response['status'] = true;
        $response['result'] = [];
        try {
            $shift = new Shift();
            $shift->setConnection($inputs['connection']);
            if(isset($inputs['id']) && !empty($inputs['id'])) {
                $shift = $shift->where('id',$inputs['id']);
            }
            $shift = $shift->get();
            if(count($shift)){
                $response['result'] = $shift;
            $response['message'] = 'Shifts records fetched successfully';
                
            }else{
                $response['message'] = 'No records found!!!'; 
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
     * Get All shift
     * 
     * @param array $allInput
     * 
     * @return array $result
     * 
    public function getAllShifts($allInput){
        $result['status'] = false;
        $result['data'] = [];
        try {
            $shift = new Shift();
            $shift->setConnection($allInput['connection']);
            $allShifts = $shift->get();
            $result['status'] = true;
            if (!count($allShifts)) {
                $result['message'] = 'No data available!';
                return $result;
            }
            $result['message'] = 'Consignee data fetch successfully.';
            $result['data'] = $allShifts;
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = 'Something went wrong';
            $result['data'] = $e->getMessage();
            return $result;
        }

    }
    
    */
    
}