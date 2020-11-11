<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Location\LocationRepository;
use App\Http\Requests\LocationRequest;
use Illuminate\Http\Request;

class LocationController extends BaseController
{
    protected $locationRepository;
    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;
    }

    /**
    * @OA\GET(
    *   path="/location",
    *   tags={"Location"},
    *   summary="Get list of locations",
    *   description="Returns list of locations",
    *   @OA\Response(
    *       response=200,
    *       description="Success",
    *       @OA\MediaType(
    *           mediaType="application/json",
    *        )
    *      ),
    *   security={{ "apiAuth": {} }}
    *     )
    */
    public function getAllLocation(Request $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); 
        $param['view'] = 'location.index';
        $location = $this->locationRepository->getAllLocation($param);  
        $location['privileges'] =   isset( $allInput['privilege_array'] )? $allInput['privilege_array'] : "";
        //dd($param);
        if ($location['status'] == false)
        {
            return $this->sendError($location,'No record found !!!', $param);
        } else {
            return $this->sendResponse($location,'Location data fetched sucessfully', $param);
        }
    }

    /**
     * @OA\Post(
     ** path="/location",
     *  tags={"Location"},
     *  summary="Location",
     *  @OA\RequestBody(
     *  required=true,
     *  description="Pass location details",
     *  @OA\JsonContent(
     *  required={"location","description","type"},
     *  @OA\Property(property="location", type="string", format="text", example="CQ-8"),
     *  @OA\Property(property="description", type="string", format="text", example="Plot type location"),
     *  @OA\Property(property="type", type="string", format="text", example="Handle with care"),
     *  ),
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */
    public function storeLocation(LocationRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        //dd($allInput);
        $response = $this->locationRepository->store($allInput);
        if($response['status'] == false)
        {
            return $this->sendError($response,'Something went wrong',$param);
        }
        return $this->sendResponse([],$response['message'],$param);
    }
    /**
     * @OA\Put(
     ** path="/location/{id}",
     *  tags={"Location"},
     *  summary="Location",
     *  description="Update location details",
     *  @OA\Parameter(
     *    description="ID of location",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     * )
     * ),
     *  @OA\RequestBody(
     *  required=true,
     *  description="Update location details",
     *  @OA\JsonContent(
     *  required={"id","location","description","type"},
     *  @OA\Property(property="id", type="integer", format="number", example=1),
     *  @OA\Property(property="location", type="string", format="text", example="CQ-8"),
     *  @OA\Property(property="description", type="string", format="text", example="Plot type location"),
     *  @OA\Property(property="type", type="string", format="text", example="Handle with care"),
     *  ),
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */ 
    public function updateLocation(LocationRequest $request)
    {   
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); 
        $allInput['updated_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $response = $this->locationRepository->update($allInput);
        if($response['status'] == false){
            return $this->sendError($response,'Something went wrong',$param);
        }
        return $this->sendResponse([],$response['message'],$param);
    }

    /**
     * @OA\Delete(
     ** path="/location/{id}",
     *  tags={"Location"},
     *  summary="Location",
     *  description="Delete location details",
     *  @OA\Parameter(
     *    description="ID of location",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     *  )
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *   )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */ 
    public function destroyLocation(LocationRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $allInput['connection'] = $param['connection'];
        $response = $this->locationRepository->destroy($allInput);
        if($response['status'] == false){
            return $this->sendError($response,'Something went wrong',$param);
        }
        return $this->sendResponse([],$response['message'],$param);   
    }

    /**
     * @OA\Get(
     ** path="/location/{id}",
     *  tags={"Location"},
     *  summary="Location",
     *  description="Edit location details",
     *  @OA\Parameter(
     *    description="ID of location",
     *    in="path",
     *    name="id",
     *    required=true,
     *    example="1",
     *  @OA\Schema(
     *    type="integer",
     *    format="int64"
     * )
     * ),
     *  @OA\Response(
     *  response=200,
     *  description="Success",
     *  @OA\MediaType(
     *  mediaType="application/json",
     *  )
     *  ),
     * security={{ "apiAuth": {} }}
     *)
     */ 
    public function editLocation(LocationRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); 
        $allInput['connection'] = $param['connection'];
        $response = $this->locationRepository->edit($allInput);
        if($response['status'] == false){
            return $this->sendError($response,'Record not found',$param);
        }
        return $this->sendResponse($response['result'],$response['message'],$param);
    }
}