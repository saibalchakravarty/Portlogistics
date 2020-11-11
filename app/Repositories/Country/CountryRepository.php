<?php

namespace App\Repositories\Country;
use App\Models\Country;
use Exception;
use Log;

Class CountryRepository {
    /**
     * Get List of countries
     * 
     */
    public function getCountries($inputs) {
        $response['status'] = true;
        try {
            $country = new Country();
            $country->setConnection($inputs['connection']);
            if(isset($inputs['id']) && !empty($inputs['id'])) {
                $country = $country->where('id',$inputs['id']);
            }
            $country = $country->get();
            $response['result'] = $country;
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