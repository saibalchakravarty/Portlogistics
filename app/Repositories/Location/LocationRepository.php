<?php

namespace App\Repositories\Location;

use Illuminate\Http\Request;
use App\Models\Location;
use App\Libraries\CustomExceptionLibrary;
use Exception;
use Log;

class LocationRepository
{

    /**
     * @description Get all location details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','location']
     */
    public function getAllLocation($allInput)
    {
        $fetch['status'] = true;

        try {
            $locations = new Location();
            $locations->setConnection($allInput['connection']);
            $locations = $locations->select('*');
            if (isset($allInput['type']) && !empty($allInput['type'])) {
                $locations = $locations->where('type', $allInput['type']);
            }
            $locations = $locations->get();
            $fetch['message'] = 'Location fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            return $fetch;
        }
        $fetch['location'] = $locations;
        return $fetch;
    }

    /**
     * @description Save location
     * @author
     * @param array $param ['location','description','type','user_array','created_by','connection'] 
     * @return array ['status','message']
     */
    public function store($allInput)
    {
        $fetch['status'] = true;
        try {
            $locations = new Location();
            $locations->setConnection($allInput['connection']);
            $locationSave = $locations->create($allInput);
            if(!$locationSave)
            {
                $fetch['status'] =false;
                $fetch['message'] = 'No Record Found';                  
            }
            else{
                $fetch['message'] = 'Location data saved successfully';
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

    /**
     * @description Update location
     * @author
     * @param array $param ['id','location','description','type','user_array','updated_by','connection'] 
     * @return array ['status','message']
     */
    public function update($allInput)
    {
        $fetch['status'] = true;
        try {
            $locationUpdate = new Location();
            $locationUpdate->setConnection($allInput['connection']);
            $locationUpdate = $locationUpdate->where('id', $allInput['id']);
            $locationUpdate = $locationUpdate->update(['location' => $allInput['location'], 'description' => $allInput['description'], 'type' => $allInput['type'], 'updated_by' => $allInput['updated_by']]);
            if (!$locationUpdate) {
                $fetch['status'] = false;
                $fetch['message'] = 'No Record Found';
            }
            else{
                $fetch['message'] = 'Location data updated successfully';
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
     * @description Delete location details by location id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function destroy($allInput)
    {
        $fetch['status'] = true;
        try {
            $locations = new Location();
            $locations->setConnection($allInput['connection']);
            $location = $locations->findOrFail($allInput['id']);
            $location = $location->delete();
            if (!$location) {
                $fetch['status'] = false;
                $fetch['message'] = 'No Record Found';
            }
            else{
                $fetch['message'] ='Location deleted successfully';    
            }
            return $fetch;
        }catch(Exception $e){
            Log::error($e->getMessage());
            $errors = new CustomExceptionLibrary();
            $fetch = $errors->handleException($e,'Location');
            return $fetch;
        }
    }

    /**
     * @description Get location details by location id
     * @author
     * @param array ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function edit($allInput)
    {
        $fetch['status'] = true;
        try {
            $locationData = new Location();
            $locationData->setConnection($allInput['connection']);
            $locationData = $locationData->where('id',$allInput['id']);
            $locationData = $locationData->firstOrFail();
            if(!$locationData)
            {
                $fetch['status'] = false;
                $fetch['message'] = 'No Record Found';
            }
            else{
                 $fetch['message'] = 'Location Edited Successfully';    
                 $fetch['result'] =  $locationData->toArray(); 
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
    /**
     * Fetch Location by location_id
     * 
     */
    public function getLocationById($allInput, $type)
    {
        $fetch['status'] = true;
        try {
            $locationData = new Location();
            $locationData->setConnection($allInput['connection']);
            $locationData = $locationData->where('id',$allInput['location_id']);
            $locationData = $locationData->where('type',$type);
            $locationData = $locationData->firstOrFail();
            if(!$locationData)
            {
                $fetch['status'] = false;
                $fetch['message'] = 'No Reord Found';
            }
            else{
                 $fetch['message'] = 'Location Data Fetched Successfully';    
                 $fetch['result'] =  $locationData->toArray(); 
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
}
