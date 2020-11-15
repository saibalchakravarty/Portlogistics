<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Repositories\Organization\OrganizationRepository;
use App\Repositories\Currency\CurrencyRepository;
use App\Http\Requests\OrganizationNameRequest;
use App\Http\Requests\OrganizationRateRequest;
use Illuminate\Http\Request;
use Log;

class OrganizationController extends BaseController
{
    protected $organizationRepository,$currencyRepository;
    public function __construct(OrganizationRepository $organizationRepository,CurrencyRepository $currencyRepository)
    {
        $this->organizationRepository = $organizationRepository;
        $this->currencyRepository = $currencyRepository;
    }

    /**
    * @OA\GET(
    *   path="/organization",
    *   tags={"Organization"},
    *   summary="Get list of organizations",
    *   description="Returns list of organizations",
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
    public function getOrganization(Request $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput);
        $param['view'] = 'organization.index';
        if($request->id)
        {
            $param['id'] = $request->id;
        }
        else
        {
            $param['id'] = $param['user_auth']['organization_id'];
        }
        $data['organization'] = $this->organizationRepository->getOrganization($param);
        $data['currencies'] = $this->currencyRepository->getCurrencies($param);
        $data['privileges'] =   isset( $allInput['privilege_array'] )? $allInput['privilege_array'] : "";
        if(!$data['organization']['status']){
           return $this->sendError($data,'No record found !!!', $param);
        }
        return $this->sendResponse($data,'Organization data fetched sucessfully', $param);
    }

     /**
     * @OA\Put(
     ** path="/organization/{id}",
     *  tags={"Organization"},
     *  summary="Organization",
     *  @OA\Parameter(
     *    description="ID of organization",
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
     *  description="Update organization name",
     *  @OA\JsonContent(
     *  required={"name","mobile_no","address","primary_contact","primary_mobile_no","primary_email", "currency_id","rate_per_trip","org_type"},
     *  @OA\Property(property="name", type="string", format="text", example="Orissa Stevedores"),
     *  @OA\Property(property="mobile_no", type="string", format="number", example="7665434456"),
     *  @OA\Property(property="address", type="string", format="text", example="Paradeep port"),
     *  @OA\Property(property="primary_contact", type="string", format="text", example="Paradeep port"),
     *  @OA\Property(property="primary_mobile_no", type="string", format="number", example="8787877878"),
     *  @OA\Property(property="primary_email", type="string", format="email", example="test@gmail.com"),
      *  @OA\Property(property="currency_id", type="integer", format="int", example=1),
     *  @OA\Property(property="rate_per_trip", type="number", format="double", example=123.00),
     *  @OA\Property(property="org_type", type="string", format="text", example="org_info|org_rate"),
     *  @OA\Property(property="secondary_contact", type="string", format="text", example=""),
     *  @OA\Property(property="secondary_mobile_no", type="string", format="text", example=""),
     *  @OA\Property(property="secondary_email", type="string", format="email", example=""),
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
    public function updateOrganizationDetails(OrganizationNameRequest $request)
    {
        $allInput = $request->all();
        $param  = $this->getAuth($allInput); 
        $allInput['updated_by'] = $param['user_id'];
        $allInput['created_by'] = $param['user_id'];
        $allInput['connection'] = $param['connection'];
        $allInput['id'] = $request->id;
        $response = $this->organizationRepository->updateDetails($allInput);
        if(!$response['status']){
            return $this->sendError($response,'Something went wrong',$param);
        }
        return $this->sendResponse([],$response['message'],$param);
    }
}
