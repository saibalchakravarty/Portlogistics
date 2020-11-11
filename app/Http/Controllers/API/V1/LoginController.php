<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use JWTAuth;
use JWTException;
use Auth;
use App\Services\LoginService;
use App\Repositories\JwtToken\JwtTokenRepository;
use Validator;
use App\Models\User;
use Log;
use Illuminate\Support\Facades\DB;

class LoginController extends BaseController {

    protected $loginService;
    protected $jwtTokenRepository;

    public function __construct(LoginService $loginService, JwtTokenRepository $jwtTokenRepository) {
        $this->loginService = $loginService;
        $this->jwtTokenRepository = $jwtTokenRepository;
    }

    /**
     * @OA\Post(
     ** path="/logout",
     *  tags={"Auth"},
     *  summary="Logout",
     *  @OA\Parameter(
     *    name="Authorization",
     *    in="header",
     *    required=true,
     *    description="Bearer {access-token}",
     *    @OA\Schema(
     *      type="bearerAuth"
     *         )
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
     **/
    public function logout(Request $request) {
        $allInput = $request->all();
        $param = $this->getAuth($allInput);
        $param['token'] = $request->bearerToken();
        try {
            JWTAuth::invalidate($param['token']);
            $user = DB::table('sessions')->where('user_id',$param['user_id'])->get();
            if(count($user)){
            DB::table('sessions')->where('user_id',$param['user_id'])->delete(); 
        }
        } catch (JWTException $exception) {
            Log::error($exception->getMessage());
            return $this->sendError([$exception->getMessage()],'User can not be logged out!',$param);
        }
        return $this->sendResponse([], 'User successfully signed out',$param);
    }
}
