<?php

namespace App\Traits;

trait CustomTrait {
    public function getDataFromJsonResponse($jsonResponse = null) {
        $arrResult = [];
        if(null != $jsonResponse) {
            $jsonData = $jsonResponse->getData();
            if (is_object($jsonData)) {
                $arrResponse = get_object_vars($jsonData);
                if($arrResponse['status'] == 'success' && $arrResponse['status_code'] == 200 && !empty($arrResponse['result'])) {
                    $arrResult = $arrResponse['result']; 
                }
            }
        }
        return $arrResult;
    }
    
    public function getHashPassCode($password = '') {
        if(!empty($password)) {
            $password_length = strlen($password);
            $salt = config('constants.app_salt');
            $m = substr($password, 0, 4) . $salt . substr($password, 4, ($password_length-4)) . $salt;
            $passcode = password_hash($m, PASSWORD_BCRYPT);
            $strlen = strlen($passcode);
            if ($strlen == 31) {
                $passcode = '0' . $passcode;
            }
            return $passcode;
        }
        return false;
    }
    
    public function getFilterConditions($filterString = '') {
        $filterCondition = [];
        if(!empty($filterString)) {
            $filterConditionArr = explode('&',urldecode($filterString));
            foreach($filterConditionArr as $filterParam) {
                $condition = explode('=',urldecode($filterParam));
                if($condition[1] != '') {
                    $filterCondition[] = ['table_field' => $condition[0], 'value' => $condition[1]];
                }
            }
        }
        return $filterCondition;
    }
    
    public function checkIfPairExist($arr = []) {
       if(!empty($arr)) {
           foreach($arr as $k=>$v) {
               foreach($v as $k1 => $v1) {
                   if($k1 == 'id') {
                       unset($arr[$k][$k1]);
                   }
               }
           }
           return count($arr) !== count(array_unique($arr, SORT_REGULAR));
       } else {
           return false;
       }
   }
    
}