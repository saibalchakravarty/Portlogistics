<?php

namespace App\Http\Controllers\API\V1;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Repositories\Shift\ShiftRepository;

class ShiftController extends BaseController
{
    protected $shiftRepository;

    public function __construct(ShiftRepository $shiftRepository)
    {
        $this->shiftRepository = $shiftRepository;
    }

    /**
    * @OA\Get(
    *   path="/shifts",
    *   tags={"Shift"},
    *   summary="Shift",
    *   description="Returns list of shifts",
    *   @OA\Response(
    *       response=200,
    *       description="Success",
    *       @OA\MediaType(
    *           mediaType="application/json",
    *        )
    *       ),
    *   security={{ "apiAuth": {} }}
    *     )
    */
    public function index(Request $request) {
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs);
        if (isset($inputs['id']) && !empty($inputs['id'])) {
            $auth['id'] = $inputs['id'];
        }
        $response = $this->shiftRepository->getShifts($auth);
        if($response['status'] == false){
           return $this->sendError($response['result'],$response['message'], $auth);
        }
        return $this->sendResponse($response['result'],$response['message'], $auth);
    } 
}
