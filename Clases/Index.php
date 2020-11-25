<?php
namespace Clases;

include('../vendor/autoload.php');

use Clases\ProcessJson;

class Index extends ProcessJson{

    public function __construct(){
        $this->loadFile();
    }
}
$ini = new Index();

$filters = $_GET;

if(count($filters)){
    if(isset($_GET['cities'])){
        echo $ini->getCities();
    }
    if(isset($_GET['types'])){
        echo $ini->getTypes();
    }
    if(isset($_GET['save'])){
        echo $ini->guardaPropiedad($_GET['id']);
    }
    if(isset($_GET['filter'])){
        echo $ini->getFilter($_GET);
    }
    if(isset($_GET['bienes'])){
        echo $ini->getBienes();
    }
}else{
    echo $ini->getAll();
}


?>