<?php
namespace App\Services;


class BtopPlanningService {

    /**
     * Prepare Custom Array Planning Data
     * 
     * @param array $planningArray planning data
     * 
     * @return array $customArrayData
     */
    public function prepareCustomData($planningArray)
    {
        $customArrayData = [];
        $customArrayData['id'] = $planningArray['id'];
        $customArrayData['berth_location_id'] = $planningArray['berth_location_id'];
        $customArrayData['date_from'] = $planningArray['date_from'];
        $customArrayData['date_to'] = $planningArray['date_to'];
        $customArrayData['location'] = $planningArray['location']['location'];
        $customArrayData['cargo'] = ['id' => $planningArray['cargo']['id'], 'name' => $planningArray['cargo']['name']];
        $customArrayData['vessel'] = ['id' => $planningArray['vessel']['id'], 'name' => $planningArray['vessel']['name']];
        foreach ($planningArray['consignees'] as $consignee) {
            $customArrayData['consignees'][] = ['consignee_id' => $consignee['consignee_id'], 'name' => $consignee['name']];
        }
        foreach ($planningArray['plots'] as $plot) {
            $customArrayData['plots'][] = ['consignee_id' => $plot['consignee_id'], 'plot_location_id' => $plot['plot_location_id'], 'location' => $plot['location']];
        }
        foreach ($planningArray['trucks'] as $truck) {
            $customArrayData['trucks'][] = ['id' => $truck['truck_id'], 'truck_no' => $truck['truck_no']];
        }
        return $customArrayData;
    }

    /**
     * Prepare Custom Array Planning Data
     * 
     * @param array $valueArray planning array data
     * 
     * @return array $customArrayData
     */
        // public function prepareChallanData($valueArray)
        // {
        //     $challanData['date_from'] = $valueArray['date_from'];
        //     $challanData['date_to'] = $valueArray['date_to'];
        //     $challanData['location'] = $valueArray['location']['location'];
        //     $challanData['cargo'] = $valueArray['cargo']['name'];
        //     $challanData['vessel'] = $valueArray['vessel']['name'];
        //     foreach ($valueArray['consignees'] as $consignee) {
        //         $challanData['consignees'][] = ['consignee_id' => $consignee['consignee_id'], 'name' => $consignee['name']];
        //     }
        //     foreach ($valueArray['plots'] as $plot) {
        //         $challanData['plots'][] = ['consignee_id' => $plot['consignee_id'], 'plot_location_id' => $plot['plot_location_id'], 'location' => $plot['location']];
        //     }
        //     foreach ($valueArray['trucks'] as $truck) {
        //         $challanData['trucks'][] = ['id' => $truck['truck_id'], 'truck_no' => $truck['truck_no']];
        //     }
        //     return $challanData;
        // }
}