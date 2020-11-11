<?php

namespace App\Repositories\City;
use App\Models\City;
use Exception;
use Log;

Class CityRepository {
    /**
     * Get List of cities
     * 
     */
    public function getCities($inputs) {
        $response['status'] = true;
        try {
            $city = new City();
            $city->setConnection($inputs['connection']);
            if(isset($inputs['id']) && !empty($inputs['id'])) {
                $city = $city->where('id',$inputs['id']);
            }
            $city = $city->get();
            $response['result'] = $city;
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
}