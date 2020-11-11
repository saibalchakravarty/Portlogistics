<?php

namespace App\Repositories\Organization;

use Illuminate\Http\Request;
use App\Models\Organization;
use Exception;
use Log;

class OrganizationRepository
{
    /**
     * @description Get all organizations details
     * @author
     * @param array ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','organization']
     */
    public function getOrganization($allInput) 
    {
        $fetch['status'] = true;
        try{
        $organization = new Organization();
        $organization->setConnection($allInput['connection']);
        $organization = $organization->where('organizations.id',$allInput['id']);
        $organization = $organization->select('organizations.*','currencies.currency');
        $organization = $organization->leftJoin('currencies', 'organizations.currency_id', '=', 'currencies.id');
        $organization = $organization->firstOrFail();
        //dd($organization);
        $fetch['message'] ='Organization fetched successfully';
        }catch(Exception $e){
            Log::error($e->getMessage());
            $fetch['status'] = false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            return $fetch;
        }
        $fetch['organization'] =$organization;
        return $fetch;
    }

    /**
     * @description Update organization details
     * @author
     * @param array ['id','name','mobile_no','address','primary_contact','primary_mobile_no','primary_email','user_id','user_array','created_by','updated_by','connection'] 
     * @return array ['status','message','result']
     */
    public function updateDetails($allInput)
    {
        $fetch['status'] =true;       
        try{
            $organizationUpdate = new Organization();
            $organizationUpdate->setConnection($allInput['connection']);
            $organizationUpdate = $organizationUpdate->where('id', $allInput['id']);
            /**
            * @author : Ashish Barick
            * @description: This two condition because we are handle Org_details and  org_rate in one API. THat's why added handler @$allInput['org_type']
            **/
            //If Request Post for Organization Details Information
            if($allInput['org_type'] == 'org_info')
            {
                $organizationUpdate = $organizationUpdate->update([
                                                'name' => $allInput['name'],
                                                'mobile_no' => $allInput['mobile_no'],
                                                'address' => $allInput['address'],
                                                'primary_contact' => $allInput['primary_contact'],
                                                'primary_mobile_no' => $allInput['primary_mobile_no'],
                                                'primary_email' => $allInput['primary_email'],
                                                'secondary_contact' => $allInput['secondary_contact'],
                                                'secondary_mobile_no' => $allInput['secondary_mobile_no'],
                                                'secondary_email' => $allInput['secondary_email'],
                                                'created_by' =>$allInput['created_by'],
                                                'updated_by' =>$allInput['updated_by']
                                            ]);
                if(!$organizationUpdate)
                {
                    $fetch['status'] = false;
                    $fetch['message'] = 'No Record Found';
                }
                else{
                    $fetch['message'] = 'Organization data updated successfully';
                }

            }
            //If Request Post for Organization Rate
            if($allInput['org_type'] == 'org_rate')
            {
                //dd($allInput);
                $organizationUpdate = $organizationUpdate->update(['currency_id' => $allInput['currency_id'],'rate_per_trip' => $allInput['rate_per_trip'],'created_by' =>$allInput['created_by'],'updated_by' =>$allInput['updated_by']]);
                if(!$organizationUpdate)
                {
                    $fetch['status'] = false;
                    $fetch['message'] = 'No Record Found';
                }
                else{
                    $fetch['message'] = 'Organization Currency and Rates data updated successfully';
                }
            }
            
            return $fetch;
        }catch(Exception $e){
            $fetch['status'] =false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            Log::error($e->getMessage());
            return $fetch;
        }
    }
    
    /**
     * @description Update organization rate
     * @author
     * @param array ['id','currency_id','rate_per_trip','user_id','user_array','created_by','updated_by','connection'] 
     * @return array ['status','message','result']
     */
   /* public function updateRate($allInput)
    {
        $fetch['status'] =true;        
        try{
            $organizationUpdate = new Organization();
            $organizationUpdate->setConnection($allInput['connection']);
            $organizationUpdate = $organizationUpdate->where('id', $allInput['id']);
            $organizationUpdate = $organizationUpdate->update(['currency_id' => $allInput['currency_id'],'rate_per_trip' => $allInput['rate_per_trip'],'created_by' =>$allInput['created_by'],'updated_by' =>$allInput['updated_by']]);
            if(!$organizationUpdate)
            {
                $fetch['status'] = false;
                $fetch['message'] = 'No Record Found';
            }
            else{
                $fetch['message'] = 'Organization Currency and Rates data updated successfully';
            }
            return $fetch;
        }catch(Exception $e){
            $fetch['status'] =false;
            $fetch['result'] = $e->getMessage();
            $fetch['message'] = 'Something Went Wrong';
            Log::error($e->getMessage());
            return $fetch;
        }
    }*/
    
    function getOrganizationById($orgId, $inputs) {
        $response['status'] = true;
        try {
            $organization = new Organization();
            $organization->setConnection($inputs['connection']);
            $organization = $organization->select('id', 'name', 'mobile_no', 'email', 'address','primary_contact','primary_mobile_no','primary_email','secondary_contact','secondary_mobile_no','secondary_email')->where('id', $orgId)->first();
            if($organization == null) {
                $response['status'] = false;
                $response['message'] = 'No organization found';
            } else {
                $response['result'] = $organization;
                $response['message'] = 'Organization details fetched successfully';
            }
        } catch (Exception $e) {
            Log::error($e->getMessage());
            $response['message'] = $e->getMessage();
            $response['status'] = false;
        }
        return $response;
    }

}