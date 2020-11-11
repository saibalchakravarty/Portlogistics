<?php
namespace App\Repositories\JwtToken;
use App\Models\JwtToken;
use Exception;
use Log;
class JwtTokenRepository
{
    /**
     * Get JWT Token By User
     * @param  string $currentUserId
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function getJwtTokenByUserId($userId)
    {
        try {
            $tokenArray = JwtToken::where('user_id', $userId)->first();
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return $tokenArray;
    }
    
    /**
     * Insert or Update JWT token for User
     * @param array $data
     * 
     * @return \Illuminate\Http\JsonResponse 
     * 
    */
    public function insertOrUpdateJwtTokenByUserId($data)
    {
        try {
            JWTToken::updateOrCreate(['user_id'=>$data['userId']],['token'=>$data['userToken'],'expiry_time'=>$data['expiry_time']]);
        } catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }

    /**
     * Verify Token by token
     * 
     * @param string $token
     * 
     * @return Array
     */
    public function existToken($token)
    {
        try {
            $existToken = JwtToken::where('token', $token)->first();
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
    /**
     * Delete Token after logout
     * 
     * @param string currentuserid
     */
    public function deleteTokenByUserId($currentUserId)
    {
        try {
            $deleteToken = JWTToken::where('user_id', $currentUserId)->delete();
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return true;
    }
    public function checkIfExistJwtToken($data)
    {
        try {
            $tokenArray = JwtToken::select('token');
            if(!empty($data['token']))
            {
                $tokenArray = $tokenArray->where('token', $data['token']);                
            }
            if(!empty($data['user_id']))
            {
                $tokenArray = $tokenArray->where('user_id', $data['user_id']);                
            }
            // if(!empty($data['mobile_number']))
            // {
            //     $tokenArray = $tokenArray->where('mobile_number', $data['mobile_number']);                
            // }
            $tokenArray = $tokenArray->first();
            if(!empty($tokenArray))
            {
                $tokenArray = $tokenArray->toArray();
                $tokenArray = $tokenArray['token'];
            }
            else
            {
                return false;
            }
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
            return false;
        }
        return $tokenArray;       
    }

    public function getUserByToken($all){
        $data['status'] =false;
         try {
            $existToken = JwtToken::where('token', $all['token']);
            if(!empty($all['user_id']))
            {
                $existToken = $existToken->where('user_id', $all['user_id']);                
            }
            $existToken = $existToken->first();
            if(!empty($existToken)){
                $data['status'] = true;
                $data['user'] = $existToken;
            }
        }
        catch (Exception $e) {
            Log::error($e->getMessage());
        }
       return $data;

    }
}