<?php

namespace MF\Model;

use \MF\DB\Sql;
use \MF\Model;


class Order extends Model{


    public function save(){
        $sql = new Sql();

        $results = $sql->select("CALL sp_order_save(:idorder,:idcart,:iduser,:idstatus,:idaddress,:vltotal)",array(
            ":idorder"=>$this->getidorder(),
            ":idcart"=>$this->getidcart(),
            ":iduser"=>$this->getiduser(),
            ":idstatus"=>$this->getidstatus(),
            ":idaddress"=>$this->getidaddress(),
            ":vltotal"=>$this->getvltotal()
        ));

        if(count($results)> 0){
            $this->setData($results[0]);
        }
    }

    public function get($idorder){
        $sql = new Sql();

        $results = $sql->select("select * from tb_orders a 
        inner join tb_ordersstatus b using(idstatus)
        inner join tb_carts c using(idcart)
        inner join tb_users e on e.iduser = a.iduser
        inner join tb_address d on d.idaddress = a.idaddress
		inner join tb_persons f on f.idperson = d.idperson
        where a.idorder = :idorder",array(
            ":idorder"=>$idorder
        ));
        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }
    public function getCart():Cart
	{
		$cart = new Cart();
		$cart->get((int)$this->getidcart());
		return $cart;
	}

    public function detailsOrder($idorder){
        $sql = new Sql();

        $results = $sql->select("select e.desproduct,e.vlprice from tb_orders a 
        inner join tb_ordersstatus b using(idstatus)
        inner join tb_carts c using(idcart)
        inner join tb_cartsproducts d on d.idcart = c.idcart
        inner join tb_products e on e.idproduct = d.idproduct
        where a.idorder = :idorder",array(
            ":idorder"=>$idorder
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public static function listAllOrders(){
        $sql = new Sql();

        $results = $sql->select("
        select * from
            tb_orders a 
            inner join tb_ordersstatus b using(idstatus)
            inner join tb_carts c using(idcart)
            inner join tb_users d on d.iduser = a.iduser
            inner join tb_address e using(idaddress)
            inner join tb_persons f on f.idperson = d.idperson
        ");
        return $results;
    }

    public function listOrderStatus(){
        $sql = new Sql();

        $results = $sql->select("select * from tb_ordersstatus");
        return $results;
    }

    public function updateStatus(){
        $sql = new Sql();

        $sql->query("update tb_ordersstatus set desstatus = :desstatus where idstatus = :idstatus",array(
            ":desstatus"=>$this->getdesstatus(),
            ":idstatus"=>$this->getidstatus()
        ));
    }

}




?>