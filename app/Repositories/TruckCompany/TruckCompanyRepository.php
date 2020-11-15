<?php

namespace App\Repositories\TruckCompany;

use Illuminate\Http\Request;
use App\Models\TruckCompany;
use App\Libraries\CustomExceptionLibrary;
use Exception;
use Log;
use Config;

class TruckCompanyRepository
{
    protected $exception_msg,$empty_err_msg;
    public function __construct()
    {
        $this->exception_msg = Config::get('constants.exception_msg');
        $this->empty_err_msg = Config::get('constants.empty_err_msg');
    }
    /**
     * @description Get all trucking companies details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','result']
     */
    public function getAllTruckCompanies($allInput)
    {
        $fetch['status'] = true;

        try {
            $truckCompanies = new TruckCompany();
            $truckCompanies->setConnection($allInput['connection']);
            $truckCompanies = $truckCompanies->select('*');
            $truckCompanies = $truckCompanies->get();
            $fetch['message'] = 'Trucking Company fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($truckCompanies);
            return $fetch;
        }
        $fetch['truck_company'] = $truckCompanies;
        unset($truckCompanies);
        return $fetch;
    }

    /**
     * @description Save trucking company details
     * @author
     * @param array $param ['name','email','mobile_no','contact_name','contact_mobile_no','user_array','created_by','connection'] 
     * @return array ['status','message']
     */
    public function saveTruckCompany($allInput)
    {
        $fetch['status'] = true;
        try {
            $truckCompanies = new TruckCompany();
            $truckCompanies->setConnection($allInput['connection']);
            $truckCompanies = $truckCompanies->create($allInput);
            if(!$truckCompanies)
            {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;                  
            }
            else{
                 $fetch['message'] = 'Trucking Company saved successfully';
            }
            unset($truckCompanies);
            return $fetch;
        } catch (Exception $e) {
            $fetch['status'] = false;
            Log::error($e->getMessage());
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($truckCompanies);
            return $fetch;
        }
    }

    /**
     * @description Get trucking company details by trucking company id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function editTruckCompany($allInput)
    {

        $fetch['status'] = true;
        try {
            $truckCompanies = new TruckCompany();
            $truckCompanies->setConnection($allInput['connection']);
            $truckCompanies = $truckCompanies->where('id',$allInput['id']);
            $truckCompanies = $truckCompanies->firstOrFail();
            if(!$truckCompanies)
            {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            }else{
                $fetch['message'] = 'Truck Company fetched Successfully';    
                $fetch['result'] =  $truckCompanies->toArray();
            }
            unset($truckCompanies);
            return $fetch;
            }catch(Exception $e){
                $fetch['status'] =false;
                Log::error($e->getMessage());
                $fetch['result'] = $e->getMessage();
                $fetch['message'] = $this->exception_msg;
                unset($truckCompanies);
                return $fetch;
            } 
    }

    /**
     * @description Update trucking company details
     * @author
     * @param array $param ['id','name','email','mobile_no','contact_name','contact_mobile_no','user_array','updated_by','connection'] 
     * @return array ['status','message']
     */
    public function updateTruckCompany($allInput)
    {
        $fetch['status'] = true;
        try {
            $truckCompanies = new TruckCompany();
            $truckCompanies->setConnection($allInput['connection']);
            $truckCompanies = $truckCompanies->where('id', $allInput['id']);
            $truckCompanies = $truckCompanies->update([
                'name' => $allInput['name'],
                'email' => $allInput['email'],
                'mobile_no' => $allInput['mobile_no'],
                'contact_name' => $allInput['contact_name'],
                'contact_mobile_no' => $allInput['contact_mobile_no'],
                'updated_by' => $allInput['updated_by']
            ]);
            if (!$truckCompanies) {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            }
            else{
                $fetch['message'] = 'Trucking Company updated successfully';
            }
            unset($truckCompanies);
            return $fetch;
        } catch (Exception $e) {
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            Log::error($e->getMessage());
            unset($truckCompanies);
            return $fetch;
        }
    }
    /**
     * @description Delete trucking company details by trucking company id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function deleteTruckCompany($allInput)
    {

        $fetch['status'] = true;

        try {
            $truckCompanies = new TruckCompany();
            $truckCompanies->setConnection($allInput['connection']);
            $truckCompanies = $truckCompanies->findOrFail($allInput['id']);
            $truckCompanies = $truckCompanies->delete();
            if(!$truckCompanies) {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            }else{
                $fetch['message'] ='Trucking company deleted successfully';    
            }
            unset($truckCompanies);
            return $fetch;
        }catch(Exception $e){
            Log::error($e->getMessage());
            $errors = new CustomExceptionLibrary();
            unset($truckCompanies);
            return $errors->handleException($e, 'Trucking Company');
        }
    }
}
