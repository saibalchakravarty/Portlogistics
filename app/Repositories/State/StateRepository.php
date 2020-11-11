<?php

namespace App\Repositories\State;
use App\Models\State;
use Exception;
use Log;

Class StateRepository {
    /**
     * Get List of states
     * 
     */
    public function getStates($inputs) {
        $response['status'] = true;
        try {
            $state = new State();
            $state->setConnection($inputs['connection']);
            if(isset($inputs['id']) && !empty($inputs['id'])) {
                $state = $state->where('id',$inputs['id']);
            }
            $state = $state->get();
            $response['result'] = $state;
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