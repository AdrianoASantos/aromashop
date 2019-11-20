<?php

namespace MF\Model;

use \MF\DB\Sql;
use \MF\Model;

class Address extends Model{


    public function save(){
        $sql = new Sql();


        $results = $sql->select("
            CALL sp_address_save(:idaddress,:idperson,:desfullname,:nrphone,:desnumber,:desaddress,:descity,:deszipcode)
        ",array(
            ":idaddress"=>$this->getidaddress(),
            ":idperson"=>$this->getidperson(),
            ":desfullname"=>$this->getdesfullname(),
            ":nrphone"=>$this->getnrphone(),
            ":desnumber"=>$this->getdesnumber(),
            ":desaddress"=>$this->getdesaddress(),
            ":descity"=>$this->getdescity(),
            ":deszipcode"=>$this->getdeszipcode()
        ));

        if(count($results)> 0){
            $this->setData($results[0]);
        }
    }

    public static function getFromCep($zipcode){

        $zipcode = str_replace("-","",$zipcode);

        $ch = curl_init();

        CURL_SETOPT($ch,CURLOPT_URL,"http://viacep.com.br/ws/$zipcode/json");

        CURL_SETOPT($ch,CURLOPT_RETURNTRANSFER,true);

        CURL_SETOPT($ch,CURLOPT_SSL_VERIFYPEER,false);

        $data = json_decode(CURL_EXEC($ch),true);
       
        CURL_CLOSE($ch);
        
        return $data;
       
    }

    public function loadFromCep($zipcode){
        $data = Address::getFromCep($zipcode);
    
        if(isset($data['logradouro']) && $data['logradouro']){
            $this->setdesaddress($data['logradouro']);
            $this->setzipcode($data['cep']);
            $this->setdescity($data['localidade']);
        }
    }



}






?>