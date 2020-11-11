<?php

use Illuminate\Support\Facades\Auth;
use App\Models\AccessList;
use App\Models\RoleAcces;


function menuAccess ()
{
	$userId = Auth::user()->id;
    $userRoleId = Auth::user()->role_id;
    $organizationId = Auth::user()->organization_id;
	$accessListObj = new AccessList();
	$roleAccessObj = new RoleAcces();
	$dataArr = array();
	$key = 'roleCache-'.$organizationId.':'.$userRoleId;
	$getData = cache($key);
	if(!empty($getData))
	{
		$dataArr = $getData[$organizationId][$userRoleId];
	}
	else
	{
		//First check the Logged In Role have some menu access or not, if Yes then get the access_id
		$chkRoleExist = $roleAccessObj->where('user_role_id', $userRoleId)->pluck('access_id')->toArray(); 
		if(count($chkRoleExist) > 0)
		{
			 //Get All Parents
			 $parents = $accessListObj->select('id','hierarchy','display_name')->whereIn('id', $chkRoleExist)->where('hierarchy', 'P')->get()->toArray();
			 if(!empty($parents)) {
				 foreach($parents as $parentKey => $parentVal) {
					 $dataArr[$parentKey] = $parentVal;
					 $childArr=[];
					 $childs = $accessListObj->select('id','hierarchy','display_name')->whereIn('id', $chkRoleExist)->where('hierarchy', 'C')->where('parent_id', $parentVal['id'])->get()->toArray();
					 if(!empty($childs)) {
						 foreach($childs as $childkey => $childVal) {
							 $childArr[$childkey] = $childVal;
							 $subchildArr=[];
							 $subchilds = $accessListObj->select('id','hierarchy','display_name')->whereIn('id', $chkRoleExist)->where('hierarchy', 'S')->where('parent_id', $childVal['id'])->get()->toArray();
							 if(!empty($subchilds)) {
								 foreach($subchilds as $subchildkey => $subchildVal) {
									 $subchildArr[$subchildkey] = $subchildVal;
								 }
							 }
							 $childArr[$childkey]['subchild']=$subchildArr;
						 }
					 }
					 $dataArr[$parentKey]['child'] = $childArr;
				 }		
			}
			$seconds = config('constants.cache_time');
		    $cacheRole = array();
		    $cacheRole[$organizationId][$userRoleId] = $dataArr;
			cache([$key => $cacheRole], $seconds);
			/* $getAccessListDetails = $accessListObj->whereIn('id',$chkRoleExist)->get();
			if(count($getAccessListDetails) > 0 )
			{
				foreach($getAccessListDetails as $menu)
				{
					if($menu->hierarchy == 'P')
					{
						$dataArr['parent'][] = $menu->display_name;
						$dataArr['parent'][] = $menu->id;
					}
					if($menu->hierarchy == 'C')
					{
						$dataArr['child'][] = $menu->display_name;
						$dataArr['child'][] = $menu->id;
					}
					
				}	
		        $seconds = config('constants.cache_time');
		        $cacheRole = array();
		        $cacheRole[$organizationId][$userRoleId] = $dataArr;
				cache([$key => $cacheRole], $seconds);     
			} */
		
		}
	}
	return $dataArr;
}