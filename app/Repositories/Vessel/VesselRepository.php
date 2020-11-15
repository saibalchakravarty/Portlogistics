<?php

namespace App\Repositories\Vessel;

use Illuminate\Http\Request;
use App\Models\Vessel;
use Exception;
use Log;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;
use App\Libraries\CustomExceptionLibrary;
use Config;

class VesselRepository
{
    protected $exception_msg,$empty_err_msg;
    public function __construct()
    {
        $this->exception_msg = Config::get('constants.exception_msg');
        $this->empty_err_msg = Config::get('constants.empty_err_msg');
    }
    /**
     * @description Get all Vessels
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','vessel']
     */
    public function getAllVessel($allInput)
    {
        $fetch['status'] = true;
        try {
            $vessels = new Vessel();
            $vessels->setConnection($allInput['connection']);
            $vessels = $vessels->select('*');
            $vessels = $vessels->get();
            $fetch['message'] = 'Vessel fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage);
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($vessels);
            return $fetch;
        }
        $fetch['vessel'] = $vessels;
        unset($vessels);
        return $fetch;
    }

    /**
     * @description Save Vessel
     * @author
     * @param array $param ['name','description','loa','beam','draft','user_array','created_by','connection'] 
     * @return array ['status','message']
     */
    public function store($allInput)
    {
        $fetch['status'] = true;
        $fetch['result'] = [];
        try {
            $vessels = new Vessel();
            $vessels->setConnection($allInput['connection']);
            $vesselSave = $vessels->create($allInput);
            if (!$vesselSave) {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            } else {
                $fetch['message'] = 'Vessel data saved successfully';
            }
            unset($vessels,$vesselSave);
            return $fetch;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($vessels,$vesselSave);
            return $fetch;
        }
    }

    /**
     * @description Update Vessel
     * @author
     * @param array $param ['id','name','description','loa','beam','draft','user_array','updated_by','connection'] 
     * @return array ['status','message']
     */
    public function update($allInput)
    {
        $fetch['status'] = true;
        $fetch['result'] = [];
        try {
            $vesselUpdate = new Vessel();
            $vesselUpdate->setConnection($allInput['connection']);
            $vesselUpdate = $vesselUpdate->where('id', $allInput['id']);
            if($vesselUpdate->count()){
                $vesselUpdate->update([
                    'name'              => $allInput['name'],
                    'description'       => $allInput['description'],
                    'loa'               => $allInput['loa'],
                    'beam'              => $allInput['beam'],
                    'draft'             => $allInput['draft'],
                    'updated_by'        => $allInput['updated_by']
                ]);
                $fetch['message'] = 'Vessel data updated successfully';
                
            }else{
                $fetch['message'] = $this->empty_err_msg;
            }    
            unset($vesselUpdate);
            return $fetch;
        } catch (Exception $e) {
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            Log::error($e->getMessage());
            unset($vesselUpdate);
            return $fetch;
        }
    }

     /**
     * @description Delete Vessel details by vessel id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function destroy($allInput)
    {
        $fetch['status'] = true;
        $fetch['result'] = [];
        try {
            $vessels = new Vessel();
            $vessels->setConnection($allInput['connection']);
            $vessel = $vessels->findOrFail($allInput['id']);
            $vessel = $vessel->delete();
            if (!$vessel) {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            } else {
                $fetch['message'] = 'Vessel deleted successfully';
            }
            unset($vessels, $vessel);
            return $fetch;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $errors = new CustomExceptionLibrary();
            unset($vessels, $vessel);
            return $errors->handleException($e, 'Vessel');
        }
    }

    /**
     * @description Get Vessel details by vessel id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function edit($allInput)
    {
        $fetch['status'] = true;
        try {
            $vesselData = new Vessel();
            $vesselData->setConnection($allInput['connection']);
            $vesselData = $vesselData->where('id', $allInput['id']);
            $vesselData = $vesselData->firstOrFail();
            if (!$vesselData) {
                $fetch['status'] = false;
                $fetch['message'] = $this->empty_err_msg;
            } else {
                $fetch['message'] = 'Vessel edited successfully';
                $fetch['result'] =  $vesselData->toArray();
            }
            unset($vesselData);
            return $fetch;
        } catch (Exception $e) {
            $fetch['status'] = false;
            Log::error($e->getMessage());
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = $this->exception_msg;
            unset($vesselData);
            return $fetch;
        }
    }

    public function getVesselNameByVesselId($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $vessels = new Vessel();
            $vessels->setConnection($allInput['connection']);
            $vesselName = $vessels->where('id', $allInput['vessel_id'])->firstOrFail()->name;
            $result['status'] = true;
            $result['data'] = $vesselName;
            $result['message'] = '';
            unset($vessels, $vesselName);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['data'] = $e->getMessage();
            $result['message'] = $this->exception_msg;
            unset($vessels, $vesselName);
            return $result;
        }
    }

    public function searchVesselsByKeyword($inputs)
    {
        $response['status'] = true;
        try {
            $vessel = new Vessel();
            $vessel->setConnection($inputs['connection']);
            $vessels = $vessel->select('id', 'name')->where('name', 'like', '%' . $inputs['keyword'] . '%')->get();
            if ($vessels->isEmpty()) {
                $response['status'] = false;
                $response['result'] = $this->empty_err_msg;
            } else {
                $response['status'] = true;
                $response['result'] = $vessels;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        unset($vessels, $vessel);
        return $response;
    }

    public function storeOrFetchVesselsByName($inputs)
    {
        $response['status'] = true;
        try {
            $obj = new Vessel();
            $obj->setConnection($inputs['connection']);
            $vessel = $obj->where('name', $inputs['vessel_name'])->first();
            if ($vessel == null) {
                $obj->name = $inputs['vessel_name'];
                if ($obj->save()) {
                    $response['status'] = true;
                    $response['result'] = $obj;
                } else {
                    $response['status'] = false;
                    $response['result'] = $this->exception_msg;
                }
            } else {
                $response['status'] = true;
                $response['result'] = $vessel;
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
        }
        unset($obj, $vessel);
        return $response;
    }
}
