<?php

namespace App\Services;

use App\Repositories\Shift\ShiftRepository;
use App\Repositories\Vessel\VesselRepository;
use App\Repositories\Cargo\CargoRepository;
use App\Repositories\Truck\TruckRepository;
use Carbon\Carbon;
use Exception;
use Log;
use File;
use Storage;

class PdfService {

    protected $vesselRepository, $shiftRepository, $cargoRepository, $truckRepository;

    public function __construct(ShiftRepository $shiftRepository, VesselRepository $vesselRepository, CargoRepository $cargoRepository, TruckRepository $truckRepository) {
        $this->shiftRepository = $shiftRepository;
        $this->vesselRepository = $vesselRepository;
        $this->cargoRepository = $cargoRepository;
        $this->truckRepository = $truckRepository;
    }

    public function createPdf($challan, $planning, $organization, $origin, $destination, $auth) {
        $response = []; //Intialize response array
        $pdfData['org_name'] = $organization->name;
        $pdfData['org_address'] = $organization->address;
        $pdfData['origin'] = $origin['location'];
        $pdfData['destination'] = $destination['location'];
        $pdfData['loaded_at'] = $challan['loaded_at'];
        $pdfData['challan_no'] = $challan['challan_no'];
        $pdfData['barcode_path'] = url('/') . '/' . $challan['barcode_path'];
        /*         * *********Get Other Details*********** */
        //Get Shift
        $shift_input = ['connection' => $auth['connection'], 'id' => $challan['shift_id']];
        $shift_response = $this->shiftRepository->getShifts($shift_input);
        if ($shift_response['status']) {
            $pdfData['shift_name'] = $shift_response['result'][0]->name;
            //Get Cargo
            $cargo_input = ['connection' => $auth['connection'], 'id' => $planning->cargo_id];
            $cargo_response = $this->cargoRepository->editCargo($cargo_input);
            if ($cargo_response['status']) {
                $pdfData['cargo_name'] = $cargo_response['result']['name'];
                //Get Vessel
                $vessel_input = ['connection' => $auth['connection'], 'id' => $planning->vessel_id];
                $vessel_response = $this->vesselRepository->edit($vessel_input);
                if ($vessel_response['status']) {
                    $pdfData['vessel_name'] = $vessel_response['result']['name'];
                    //Get Truck
                    $truck_input = ['connection' => $auth['connection'], 'id' => $challan['truck_id']];
                    $truck_response = $this->truckRepository->editTruck($truck_input);
                    if ($truck_response['status']) {
                        $pdfData['truck_no'] = $truck_response['result']['truck_no'];
                        /*                         * ************Generate PDF************ */
                        try {
                            $fileName = $pdfData['challan_no'] . '.pdf';
                            $mpdf = new \Mpdf\Mpdf([]);
                            $html = \View::make('pdf/challan-pdf')->with(['request' => $pdfData])->render();
                            $mpdf->WriteHTML($html);
                            $directory = 'org_' . $auth['user_auth']->organization_id . '/plan_' . $challan['plan_id'] . '_' . $challan['type'] . '/pdf/';
                            $pdf_path = storage_path('app/public/' . $directory);
                            if (!File::exists($pdf_path)) {
                                File::makeDirectory($pdf_path, '0755', true, true);
                            }
                            $filepath = $pdf_path . $fileName;
                            $mpdf->Output($filepath, 'F');
                            $response['data'] = [
                                'shift' => ['id' => $shift_response['result'][0]->id, 'name' => $shift_response['result'][0]->name],
                                'cargo' => ['id' => $cargo_response['result']['id'], 'name' => $cargo_response['result']['name']],
                                'vessel' => ['id' => $vessel_response['result']['id'], 'name' => $vessel_response['result']['name']],
                                'truck' => ['id' => $truck_response['result']['id'], 'truck_no' => $truck_response['result']['truck_no']],
                                'origin' => ['id' => $origin['id'], 'name' => $origin['location']],
                                'destination' => ['id' => $destination['id'], 'name' => $destination['location']],
                                'organization' => ['id' => $organization->id, 'name' => $organization->name, 'address' => $organization->address]
                            ];
                            $response['pdf_path'] = 'storage/' . $directory . $fileName;
                            $response['status'] = true;
                            $response['message'] = 'Challan generated successfully';
                        } catch (Exception $e) {
                            Log::error($e->getMessage());
                            $response = ['status' => false, 'message' => 'Unable to generate challan'];
                        }
                    } else {
                        $response = ['status' => false, 'message' => 'Error in getting truck details'];
                    }
                } else {
                    $response = ['status' => false, 'message' => 'Error in getting vessel details'];
                }
            } else {
                $response = ['status' => false, 'message' => 'Error in getting cargo details'];
            }
        } else {
            $response = ['status' => false, 'message' => 'Error in getting shift details'];
        }
        return $response;
    }

}
