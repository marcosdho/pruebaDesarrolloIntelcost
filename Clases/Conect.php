<?php
namespace Clases;

    class Conect{
        private const SERVER="localhost";
        private const USERNAME="root";
        private const PASSWORD="";
        private const DATABASE="Intelcost_bienes";
        private const PORT="3306";
        private const PROP_TABLE = "propiedades";
        private const MIS_PROP_TABLE = "mis_propiedades";

        static function db(){
            try{
                $db = new \mysqli(self::SERVER,self::USERNAME,self::PASSWORD,self::DATABASE,self::PORT);
                return $db;
            }catch(Exception $e){
                throw new Exception('Error de conexión', 1);
                
            }
        }

        static function getAllData(){
            $data = self::db()->query('SELECT * FROM propiedades');
            return ($data->num_rows>0) ? $data->fetch_all(MYSQLI_ASSOC):false;
        }

        static function getMyItems(){
            $data = self::db()->query('SELECT a.id as my_id, p.* FROM mis_propiedades as a INNER JOIN propiedades as p ON p.id = a.id');
            return ($data->num_rows>0) ? $data->fetch_all(MYSQLI_ASSOC):false;
        }

        static function saveItem($id){
            if(!self::getItem($id,self::MIS_PROP_TABLE,'id_propiedad')){
                $save = self::db()->query("INSERT INTO mis_propiedades (id_propiedad) VALUE('$id')");
                return ($save) ? true:false;
            }else{
                return false;
            }
        }

        static function getItem($item,$table=self::PROP_TABLE,$field='id'){
            $data = self::db()->query("SELECT * FROM $table WHERE $field = $item");
            return ($data->num_rows>0) ? $data->fetch_all(MYSQLI_ASSOC):false;
        }

        static function getFilterData($filter=""){
            $data = self::db()->query("SELECT * FROM propiedades $filter");
            return ($data->num_rows>0) ? json_encode($data->fetch_all(MYSQLI_ASSOC)):false;
        }

    }
?>