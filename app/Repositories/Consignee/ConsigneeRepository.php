<?php

namespace App\Repositories\Consignee;

use App\Models\Consignee;
use App\Libraries\CustomExceptionLibrary;
use Exception;
use Log;
use Config;

class ConsigneeRepository
{
    protected $exception_msg,$empty_err_msg;
    public function __construct()
    {
        $this->exception_msg = Config::get('constants.exception_msg');
        $this->empty_err_msg = Config::get('constants.empty_err_msg');
    }
    /**
     * @description Get all consignees details
     * @author Gaurav Agrawal
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','result']
     */
    public function getAllConsignees($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            $consignees = $consignee->get();
            $result['status'] = true;
            if (!count($consignees)) {
                $result['message'] = $this->empty_err_msg;
            }else{
                $result['message'] = 'Consignee fetched successfully.';
                $result['data'] = $consignees;
            }
            unset($consignees,$consignee);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = $this->exception_msg;
            $result['data'] = $e->getMessage();
            return $result;
        }
    }

    /**
     * @description Save consignee details
     * @author Gaurav Agrawal
     * @param array $allInput ['name','description','user_array','user_id','connection','created_by']
     * @return array ['status','message','data']
     * 
     */
    public function storeConsignee($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            $consignee = $consignee->create($allInput);
            $result['status'] = true;
            $result['message'] = 'Consignee saved successfully.';
            unset($consignee);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = $this->exception_msg;
            $result['data'] = $e->getMessage();
            unset($consignee);
            return $result;
        }
    }

    /**
     * @description Delete consignee details
     * @author Gaurav Agrawal
     * @param array $allInput ['id','connection']
     * @return array ['status','message','data']
     * 
     */
    public function deleteConsigneeById($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            $consignees = $consignee->findOrFail($allInput['id']);
            $consignees = $consignees->delete();
            if(!$consignees){
                $result['message'] = $this->empty_err_msg;
            }else{
                $result['status'] = true;
                $result['message'] ='Consignee deleted successfully';    
            }
            unset($consignees,$consignee);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $errors = new CustomExceptionLibrary();
            $exceptions = $errors->handleException($e,'Consignee');
            $result['data'] = $exceptions['result'];
            $result['message'] = $exceptions['message'];
            unset($consignees,$consignee);
            return $result;
        }
    }

    /**
     * @description Get consignee details by consignee id
     * @author Gaurav Agrawal
     * @param array $allInput ['id','connection']
     * @return array ['status','message','data']
     * 
     */
    public function getConsigneeById($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            $consignee = $consignee->where('id', $allInput['id'])->firstOrFail();
            if ($consignee == null) {
                $result['message'] = $this->empty_err_msg;
            }else {
                $result['status'] = true;
                $result['message'] = 'Consignee fetch successfully.';
                $result['data'] = $consignee->toArray();
            }
            unset($consignee);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = $this->exception_msg;
            $result['data'] = $e->getMessage();
            unset($consignee);
            return $result;
        }
    }

    /**
     * @description Update consignee details
     * @author Gaurav Agrawal
     * @param array $allInput ['id','name','description','user_array','user_id','connection','updated_by']
     * @return array ['status','message','data']
     * 
     */
    public function updateConsigneeById($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            if(empty($allInput['description'])){
                $allInput['description'] = '';
            }
            $consignee = $consignee->where('id', $allInput['id'])
                ->update(['name' => $allInput['name'], 'description' => $allInput['description'], 'updated_by' => $allInput['updated_by']]);
            $result['status'] = true;
            $result['message'] = 'Consignee updated successfully.';
            unset($consignee);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = $this->exception_msg;
            $result['data'] = $e->getMessage();
            unset($consignee);
            return $result;
        }
    }

    /**
     * @description Check exist consignee
     * @author Gaurav Agrawal
     * @param array $allInput ['id','connection']
     * @return array ['status','message','data']
     * 
     */
    public function checkExistsConsigneeById($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            if (!$consignee->where('id', $allInput['id'])->exists()) {
                $result['message'] = 'Consignee not found';
                return $result;
            }
            $result['status'] = true;
            $result['message'] = '';
            unset($consignee);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = $this->exception_msg;
            $result['data'] = $e->getMessage();
            unset($consignee);
            return $result;
        }
    }

    /**
     * @description Check unique consignee name
     * @author Gaurav Agrawal
     * @param array $allInput ['name','description','user_array','user_id','connection','created_by']
     * @return array ['status','message','result']
     * 
     */
    public function checkUniqueConsigneeName($allInput)
    {
        $result['status'] = false;
        $result['data'] = [];
        try {
            $consignee = new Consignee();
            $consignee->setConnection($allInput['connection']);
            $existName = $consignee->where('name', '=', $allInput['name'])->count();
            if (!empty($allInput['id'])) {
                $existName = $consignee->where('name', '=', $allInput['name'])
                    ->where('id', '<>', $allInput['id'])->count();
            }
            if ($existName > 0) {
                $result['message'] = 'Validation failed';
                $result['data'] = ['Name already exist.'];
                return $result;
            }
            $result['status'] = true;
            $result['message'] = '';
            unset($consignee,$existName);
            return $result;
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $result['message'] = $this->exception_msg;
            $result['data'] = $e->getMessage();
            unset($consignee,$existName);
            return $result;
        }
    }
}
