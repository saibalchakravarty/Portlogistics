<?php

namespace App\Libraries;

class CustomExceptionLibrary
{
   /**
     * @description - fetch list of records for consignee
     * @author - Itishree Nath
     * @param - $exception which are the exceptions catched and passed from repository 
     * @return array - fetch[] array for response
     * @created on - 19-10-2020
     */

    public function handleException($exception, $itemname)
    {
        $fetch['status'] =false;
        if(isset($exception->errorInfo[1]) && $exception->errorInfo[1]==1451){
            $fetch['message'] = 'You cannot delete this '.$itemname.'. It is already in use.';
            $fetch['result'] = $exception->getMessage();
        }
        /**
         * changes made to handle exception when delete if model not found 
         * update by Gaurav Agrawal
         * updated on 23-10-2020
         */
        elseif(!$exception->getCode()){
            $fetch['message'] = 'Resource not found';
            $fetch['result'] = $exception->getMessage(); 
        }
        // end of comment
        else{
            $fetch['result'] = $exception->getMessage();
            $fetch['message'] = 'Something Went Wrong';
        }
        return $fetch;
    }
}