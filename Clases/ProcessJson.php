<?php
namespace Clases;

use Clases\Conect;

class ProcessJson extends Conect{
    private const FILE = "data-1.json";
    private $tempCity = [];
    private $tempType = [];
    private $mapValue = "";
    public $jsonData;
    private $usingDb = true;

    public function loadFile(){
        if(!$this->usingDb){
            $data = file_get_contents("../".self::FILE);
            if($data){
                $this->jsonData = $data;
                return true;
            }else{
                return false;
            }
        }else{
            return true;
        }
    }

    public function getAll(){
        if(!$this->usingDb){
            return $this->jsonData;
        }else{
            $data = self::getAllData();
            return ($data)?json_encode($data):[];
        }
    }
    public function getBienes(){
        if(!$this->usingDb){
            return $this->jsonData;
        }else{
            $data = self::getMyItems();
            return ($data)?json_encode($data):[];
        }
    }

    public function getCities(){
        $this->tempCity = [];
        if(!$this->usingDb){
            $data = array_map([$this,'mapCity'],json_decode($this->jsonData,true));
        }else{
            $data = self::getAllData();
            $data = ($data) ? array_map([$this,'mapCity'],$data) : [];
        }
        return json_encode(array_filter($data));
    }

    public function getTypes(){
        $this->tempType = [];
        if(!$this->usingDb){
            $data = array_map([$this,'mapType'],json_decode($this->jsonData,true));
        }else{
            $data = self::getAllData();
            $data = ($data) ? array_map([$this,'mapType'],$data) : [];
        }
        return json_encode(array_filter($data));
    }

    public function guardaPropiedad($id){
        if(self::saveItem($id)){
            return json_encode(['code'=>200]);
        }else{
            return json_encode(['code'=>400]);
        }
    }

    private function mapCity($item){
        if(!in_array($item['Ciudad'],$this->tempCity)){
            array_push($this->tempCity,$item['Ciudad']);
            return $item['Ciudad'];
        }
    }

    private function mapType($item){
        if(!in_array($item['Tipo'],$this->tempType)){
            array_push($this->tempType,$item['Tipo']);
            return $item['Tipo'];
        }
    }

    public function getFilter($data){
        $city = $data['city'];
        $type = $data['type'];
        $filter = false;

        if($city!='na'&&$type=='na'){
            $filter = "WHERE Ciudad = '$city'";
        }else if($city!='na'&& $type!='na'){
            $filter = "WHERE Ciudad = '$city' AND Tipo = '$type'";
        }else if($city=='na'&& $type!='na'){
            $filter = "WHERE Tipo = '$type'";
        }else{
            return self::getFilterData();
        }
        if($filter){
            return self::getFilterData($filter);
        }else{
            return false;
        }
    }

}

?>
