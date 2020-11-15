<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\State\StateRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Log;

class StateController extends BaseController {
    
    protected $stateRepository;
    
    public function __construct(StateRepository $stateRepository){

        $this->stateRepository = $stateRepository;
    }
    
    /**
    * @OA\GET(
    *   path="/state",
    *   tags={"State"},
    *   summary="Get list of states",
    *   description="Return list of states",
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
    
    public function index(Request $request){
        $inputs = $request->all();
        $auth  = $this->getAuth($inputs);
        if(isset($inputs['id']) && !empty($inputs['id'])) {
            $auth['id'] = $inputs['id'];
        }
        $response = $this->stateRepository->getStates($auth);
        if(!$response['status']){
           return $this->sendError($response,'No State found !!!', $auth);
        }
        return $this->sendResponse($response['result'],'Records fetched sucessfully', $auth);
    }
    
}