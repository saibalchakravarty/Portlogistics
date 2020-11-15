<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Country\CountryRepository;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Validator;
use Log;

class CountryController extends BaseController {
    
    protected $countryRepository;
    
    public function __construct(CountryRepository $countryRepository){

        $this->countryRepository = $countryRepository;
    }
    
    /**
    * @OA\GET(
    *   path="/country",
    *   tags={"Country"},
    *   summary="Get list of countries",
    *   description="Return list of countries",
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
        $response = $this->countryRepository->getCountries($auth);
        if(!$response['status']){
           return $this->sendError($response,'No countries found !!!', $auth);
        }
        return $this->sendResponse($response['result'],'Records fetched sucessfully', $auth);
    }
    
}