<?php

namespace App\Services;
use App\Repositories\Cargo\CargoRepository;
use Auth;
use Log;

class CargoService {

    protected $cargoRepository;

    public function __construct(CargoRepository $cargoRepository){
        $this->cargoRepository = $cargoRepository;
    }
    /**
     * @description Get all cargos
     * @author
     * @param array $param ['user_id','user_auth','browser','connection','cache_array','view'] 
     * @return array ['status','message','cargo']
     */
    public function getAllCargos($param){
        return $this->cargoRepository->getAllCargo($param);    
    }

    /**
     * @description Save Cargo
     * @author
     * @param array $param ['name','instruction','user_array','created_by','connection'] 
     * @return array ['status','message']
     */
    public function saveCargo($param){
        return $this->cargoRepository->saveCargo($param);
    }

     /**
     * @description Delete Cargo details by cargo id
     * @author
     * @param array $param ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function deleteCargo($param){
        return $this->cargoRepository->deleteCargo($param);
    }

    /**
     * @description Get Cargo details by cargo id
     * @author
     * @param array $param ['id',user_array','user_id','connection'] 
     * @return array ['status','message','result']
     */
    public function editCargo($param){
       return $this->cargoRepository->editCargo($param);
    }

    /**
     * @description Update Cargo
     * @author
     * @param array $param ['id','name','instruction','user_array','updated_by','connection'] 
     * @return array ['status','message']
     */
    public function updateCargo($param){
       return $this->cargoRepository->updateCargo($param);
    }
}
