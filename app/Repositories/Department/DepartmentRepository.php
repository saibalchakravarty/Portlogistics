<?php

namespace App\Repositories\Department;
use App\Libraries\CustomExceptionLibrary;
use App\Models\Department;
use Exception;
use Log;
use Config;

class DepartmentRepository
{
    protected $exception_msg,$empty_err_msg;
    public function __construct()
    {
        $this->exception_msg = Config::get('constants.exception_msg');
        $this->empty_err_msg = Config::get('constants.empty_err_msg');
    }
    /**
     * Get departments by Id
     * 
     */
    public function getDepartments($inputs)
    {
        $response['status'] = true;
        try {
            $department = new Department();
            $department->setConnection($inputs['connection']);
            if (isset($inputs['id']) && !empty($inputs['id'])) {
                $department = $department->where('id', $inputs['id']);
            }
            $department = $department->get();
            $response['result'] = $department;
            $response['message'] = 'Records responseed successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = $this->exception_msg;
            unset($department);
            return $response;
        }
        unset($department);
        return $response;
    }

    /**
     * @description Get all departments details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','result']
     */
    public function getAllDepartments($inputs)
    {
        $response['status'] = true;
        try {
            $department = new Department();
            $department->setConnection($inputs['connection']);
            $department = $department->select('*');
            $department = $department->get();
            $response['message'] = 'Department data fetched successfully'; 
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = $this->exception_msg;
            unset($department);
            return $response;
        }
        $response['department'] = $department;
        unset($department);
        return $response;
    }

    /**
     * @description Save department details
     * @author
     * @param array $param ['name','description','user_array','created_by','user_id','connection'] 
     * @return array ['status','message']
     */
    public function store($inputs)
    {
        $response['status'] = true;
        try {
            $department = new Department();
            $department->setConnection($inputs['connection']);
            $department = $department->create($inputs);
            if(!$department)
            {
                $response['status'] =false;
                $response['message'] = $this->empty_err_msg;                  
            }
            else{
                $response['message'] = 'Department data saved successfully';
            }
            unset($department);
            return $response;
        } catch (Exception $e) {
            $response['status'] = false;
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
            $response['message'] = $this->exception_msg;
            unset($department);
            return $response;
        }
    }

    /**
     * @description Get department details by department id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function edit($inputs)
    {
        $response['status'] = true;
        try {
            $department = new Department();
            $department->setConnection($inputs['connection']);
            $department = $department->where('id',$inputs['id']);
            $department = $department->firstOrFail();
            if(!$department)
            {
                $response['status'] = false;
                $response['message'] = $this->empty_err_msg;
            }
            else{
                 $response['message'] = 'Department Edited Successfully';    
                 $response['result'] =  $department->toArray(); 
            }
            unset($department);
            return $response;
        } catch (Exception $e) {
            $response['status'] = false;
            Log::error($e->getMessage());
            $response['result'] = $e->getMessage();
            $response['message'] = $this->exception_msg;
            unset($department);
            return $response;
        }
    }

    /**
     * @description Update department details
     * @author
     * @param array $param ['id','name','description','user_array','updated_by','user_id','connection'] 
     * @return array ['status','message']
     */
    public function update($inputs)
    {
        $response['status'] = true;
        try {
            $department = new Department();
            $department->setConnection($inputs['connection']);
            $department = $department->where('id', $inputs['id']);
            $department = $department->update(['name' => $inputs['name'], 'description' => $inputs['description'], 'updated_by' => $inputs['updated_by']]);
            if (!$department) {
                $response['status'] = false;
                $response['message'] = $this->empty_err_msg;
            }
            else{
                $response['message'] = 'Department data updated successfully';
            }
            unset($department);
            return $response;
        } catch (Exception $e) {
            $response['status'] = false;
            $response['result'] = $e->getMessage();
            $response['message'] = $this->exception_msg;
            Log::error($e->getMessage());
            unset($department);
            return $response;
        }
    }

    /**
     * @description Delete department details
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function destroy($inputs)
    {
        $response['status'] = true;
        try {
            $department = new Department();
            $department->setConnection($inputs['connection']);
            $department = $department->findOrFail($inputs['id']);
            $department = $department->delete();
            if (!$department) {
                $response['status'] = false;
                $response['message'] = $this->empty_err_msg;
            }
            else{
                $response['message'] ='Department deleted successfully';    
            }
            unset($department);
            return $response;
        }catch(Exception $e){
            Log::error($e->getMessage());
            $errors = new CustomExceptionLibrary();
            unset($department);
            return $errors->handleException($e, 'Department');
        }
    }
}
