<?php

namespace App\Repositories\Truck;

use Illuminate\Http\Request;
use App\Libraries\CustomExceptionLibrary;
use App\Models\Truck;
use Exception;
use Log;
use Config;

class TruckRepository 
{
    protected $exception_msg,$empty_err_msg;
    public function __construct()
    {
        $this->exception_msg = Config::get('constants.exception_msg');
        $this->empty_err_msg = Config::get('constants.empty_err_msg');
    }
    /**
     * @description Get all trucks details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','result']
     */
    public function getAllTrucks($allInput) {        
        $fetch['status'] = true;       
        try{
        $trucks = new Truck();
        $trucks->setConnection($allInput['connection']);
        $trucks = $trucks->select('trucks.*','truck_companies.name');
        $trucks = $trucks->leftJoin('truck_companies', 'trucks.truck_company_id', '=', 'truck_companies.id');
        $trucks = $trucks->get();
        $fetch['message'] ='Trucks fetched successfully';
        }catch(Exception $e){
            Log::error($e->getMessage());
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($trucks);
            return $fetch;
        }
        $fetch['trucks'] = $trucks;
        unset($trucks);
        return $fetch;
    }

    /**
     * @description Save truck details
     * @author
     * @param array $param ['truck_no','truck_company_id','user_array','created_by','connection'] 
     * @return array ['status','message']
     */
    public function saveTruck($allInput) {       
        $fetch['status'] = true;
        try{   
            $trucks = new Truck();
            $trucks->setConnection($allInput['connection']);
            $trucks = $trucks->create($allInput);
            if(!$trucks)
            {
                $fetch['status'] = false;   
                $fetch['message'] = $this->empty_err_msg;               
            }
            else{
                 $fetch['message'] = 'Truck data saved successfully';
            }
            unset($trucks);
            return $fetch;

        }catch(Exception $e){
            $fetch['status'] = false;
            Log::error($e->getMessage());
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($trucks);
            return $fetch;
        }  
        
    }

    /**
     * @description Get truck details by truck id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function editTruck($allInput) 
    {
        $fetch['status'] = true;
        try{
            $trucks = new Truck();
            $trucks->setConnection($allInput['connection']);
            $trucks = $trucks->where('id',$allInput['id']);
            $trucks = $trucks->firstOrFail();
            if(!$trucks)
            {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            }
            else{
                 $fetch['message'] = 'Truck data edited successfully';    
                 $fetch['result'] =  $trucks->toArray(); 
            }
            unset($trucks);
            return $fetch;
            }catch(Exception $e){
                $fetch['status'] =false;
                Log::error($e->getMessage());
                $fetch['result'] = $e->getMessage();
                $fetch['message'] = $this->exception_msg;
                unset($trucks);
                return $fetch;
            }
        
    }
    
    /**
     * @description Update truck details
     * @author
     * @param array $param ['id','truck_no','truck_company_id','user_array','created_by','connection'] 
     * @return array ['status','message']
     */
    public function updateTruck($allInput) 
    {        
        $fetch['status'] =true;
        try{
            $trucks = new Truck();
            $trucks->setConnection($allInput['connection']);
            $trucks = $trucks->where('id', $allInput['id']);
            $trucks = $trucks->update([
                    'truck_no' => $allInput['truck_no'],
                    'truck_company_id' => $allInput['truck_company_id'],
                    'updated_by' => $allInput['updated_by']
                ]);
            if(!$trucks)
            {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            }
            else{
                $fetch['message'] = 'Truck data updated successfully';
            }
            unset($trucks);
            return $fetch;
        }catch(Exception $e){
            $fetch['status'] =false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            Log::error($e->getMessage());
            unset($trucks);
            return $fetch;
        }
    }
    /**
     * @description Delete truck details by truck id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function deleteTruck($allInput) 
    {       
        $fetch['status'] =true;           
        try{
            $trucks = new Truck();
            $trucks->setConnection($allInput['connection']);
            $trucks = $trucks->findOrFail($allInput['id']);
            $trucks = $trucks->delete();
            if(!$trucks)
            {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            }
            else{
                $fetch['message'] ='Truck deleted successfully';    
            }
            unset($trucks);
            return $fetch;
        }catch(Exception $e){
            Log::error($e->getMessage());
            $errors = new CustomExceptionLibrary();
            $fetch = $errors->handleException($e, 'Truck');
            unset($trucks);
            return $fetch;
        }
        
    }

}
