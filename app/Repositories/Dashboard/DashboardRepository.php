<?php

namespace App\Repositories\Dashboard;

use Illuminate\Http\Request;
use App\Models\BtopPlanning;
use App\Models\BtopPlanningDetail;
use App\Models\Challan;
use App\Models\Shift;
use Exception;
use Log;
use DB;
use Carbon\Carbon;

Class DashboardRepository
{

	/**
	 * @description Get dashboard details
	 * @author
	 * @param array ['connection','date','vessel','cargo','customer'] 
	 * @return array ['status','message','organization']
	 */
	public function dashboardDetails($allInput)
	{
		$dataArr = array();
		$dataArr['status'] = true;
		try 
		{
			$shift = new Shift();
            $shift->setConnection($allInput['connection']);
            $shifts = $shift->get();
            $planning = new BtopPlanning();
			$planningFilter = '';
			$consigneeFilter = '';
			
			$planning->setConnection($allInput['connection']);
			$planning->where('date_from',date_format(date_create($allInput['date']), 'yy-m-d'));
			if($allInput['vessel'] != 'all' && $allInput['cargo'] != 'all')
			{
				$planning->whereIn('vessel_id',$allInput['vessel'])->orWhereIn('cargo_id',$allInput['cargo']);
			}
			if($allInput['vessel'] != 'all' && $allInput['cargo'] == 'all')
			{
				$planning->whereIn('vessel_id',$allInput['vessel']);
			}
			if($allInput['vessel'] == 'all' && $allInput['cargo'] != 'all')
			{
				$planning->whereIn('cargo_id',$allInput['cargo']);
			}
			$planningId = $planning->distinct('id')->pluck('id')->toArray();
			$planningDetail = new BtopPlanningDetail();
			$planningDetail->setConnection($allInput['connection']);
			if($allInput['customer'] != 'all')
			{
				$planningDetail->whereIn('consignee_id',$allInput['customer']);
			}
			$planningDetailId = $planningDetail->distinct('id')->pluck('id')->toArray();

			$planningIds = array_unique( array_merge( $planningId , $planningDetailId ) );

			$ttcArr = [];
			$ntuArr = [];
			$caArr = [];
			foreach($shifts as $shift)
			{
				$challan = new Challan();
				$challan->setConnection($allInput['connection']);
				$dataArr['ttc'][$shift->type] = $challan->where('shift_id',$shift->id)
									->where('status',2)
									->whereNotNull('unloaded_by')
									->where('type',1)
									->whereIn('btop_planning_id',$planningIds)->count();

				$dataArr['ntu'][$shift->type] = $challan->where('shift_id',$shift->id)
									->where('status',2)
									->whereNotNull('unloaded_by')
									->where('type',1)
									->whereIn('btop_planning_id',$planningIds)->distinct('truck_id')->count();
				$dataArr['ca'][$shift->type] = $challan->where('shift_id',$shift->id)
									->where('status',2)
									->where('is_deposit',1)
									->where('type',1)
									->whereIn('btop_planning_id',$planningIds)->count();
			}
		} catch (Exception $e) {
	        Log::error($e->getMessage());
	        $dataArr['status'] = false;
			$dataArr['result'] = $e->getMessage();
			$dataArr['message'] = 'Something Went Wrong';
	        return $dataArr;
	    }
		return $dataArr;
	}

	public function getDetails($allInput){
		/*For BTP details
		@author: Saibal Chakravarty
		@descripyion: Details to fetch from 
		@param array ['connection','date','vessel','cargo','customer'] 
		*/
		try {
		$dataArr = array();
		$dataArr['status'] = true;

		$challans = new Challan();
		$challans = $challans->leftJoin('btop_plannings','challans.btop_planning_id','btop_plannings.id');
		if (array_key_exists('vessel', $allInput) && $allInput['vessel'] != 'all') {
			$challans = $challans->whereIn('btop_plannings.vessel_id',$allInput['vessel']);
		}
		
		if (array_key_exists('customer', $allInput) && $allInput['customer'] != 'all') {
			$challans = $challans->whereIn('challans.consignee_id',$allInput['customer']);
		}
		if (array_key_exists('cargo', $allInput) && $allInput['cargo'] != 'all') {
			$challans = $challans->whereIn('challans.cargo_id',$allInput['cargo']);
		}
		if (array_key_exists('date', $allInput) && $allInput['date']!=null) {
			$date =	Carbon::parse($allInput['date'])->format('Y-m-d');
			// $start = Carbon::parse($date)->startOfDay(); 
			// $end = Carbon::parse($date)->endOfDay();	
			$challans = $challans->where(function ($query) use($date) {
				$query->whereDate('challans.loaded_at',$date)
				->orWhereDate('challans.unloaded_at',$date);
			});
		}
		
		 $c = $challans;

  		$shifts = Shift::get();


		foreach ($shifts as $shift) {
			$c =clone $challans;
		$dataArr['ttc'][$shift->type] = $c->where('challans.shift_id', $shift->id)
					->where('challans.status', 2)
					->whereNotNull('challans.unloaded_by')
					->where('challans.type', 1)
					->count();
					$d =clone $challans;
				$dataArr['ntu'][$shift->type] = $d->where('challans.shift_id', $shift->id)
					->where('challans.status', 2)
					->whereNotNull('challans.unloaded_by')
					->where('challans.type', 1)
					->distinct('challans.truck_id')->count();
					$e =clone $challans;
				$dataArr['ca'][$shift->type] = $e->where('challans.shift_id', $shift->id)
					->where('challans.status', 2)
					->where('challans.is_deposit', 1)
					->where('challans.type', 1)
					->count();
		}
		
	} catch (Exception $e) {
		Log::error($e->getMessage());
		$dataArr['status'] = false;
		$dataArr['result'] = $e->getMessage();
		$dataArr['message'] = 'Something Went Wrong';
		return $dataArr;
	}
		return $dataArr;
	}
}
