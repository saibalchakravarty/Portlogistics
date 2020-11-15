<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\City\CityRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Log;

class CityController extends BaseController {

    protected $cityRepository;

    public function __construct(CityRepository $cityRepository) {
        $this->cityRepository = $cityRepository;
    }

    /**
    * @OA\GET(
    *   path="/city",
    *   tags={"City"},
    *   summary="Get list of cities",
    *   description="Return list of cities",
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
        if(isset($inputs['id']) && !empty($inputs['id'])) {
            $auth['id'] = $inputs['id'];
        }
        $response = $this->cityRepository->getCities($auth);
        if(!$response['status']){
           return $this->sendError($response,'No record found !!!', $auth);
        }
        return $this->sendResponse($response['result'],'Records fetched sucessfully', $auth);
    }

}
