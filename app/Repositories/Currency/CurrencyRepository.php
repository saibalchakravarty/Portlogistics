<?php

namespace App\Repositories\Currency;

use App\Models\Currency;
use App\Models\Organization;
use Exception;
use Log;

class CurrencyRepository
{

    /**
     * @description Get all currencies details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','currencies']
     */
    public function getCurrencies($allInput)
    {
        $fetch['status'] = true;

        try {
            $organization = new Organization();
            $organization->setConnection($allInput['connection']);
            $getCurrencyId = $organization->where('id',$allInput['id'])->first();
            $currencies = new Currency();
            $currencies->setConnection($allInput['connection']);
            $currencies = $currencies->select('*');
            $currencies = $currencies->where('id',$getCurrencyId->currency_id);
            $currencies = $currencies->get();
            $fetch['message'] = 'Currencies fetched successfully';
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            return $fetch;
        }
        $fetch['currencies'] = $currencies;
        return $fetch;
    }
}
