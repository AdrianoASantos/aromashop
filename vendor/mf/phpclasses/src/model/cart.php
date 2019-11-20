<?php

namespace MF\Model;

use \MF\DB\Sql;
use \MF\Model;
use \MF\Model\User;

class Cart extends Model{

    const SESSION = "Cart";

    public static function getFromSession()
	{
		$cart = new Cart();
		if (isset($_SESSION[Cart::SESSION]) && (int)$_SESSION[Cart::SESSION]['idcart'] > 0) {
			$cart->get((int)$_SESSION[Cart::SESSION]['idcart']);
		} else {
            $cart->getFromSessionID();
            
			if (!(int)$cart->getidcart() > 0) {
				$data = [
					'dessessionid'=>session_id()
				];
				if (User::checkLogin(false)) {
					$user = User::getFromSession();
					
					$data['iduser'] = $user->getiduser();	
                }
                
                $cart->setData($data);
            
				$cart->save();
				$cart->setToSession();
			}
		}
		return $cart;
	}

    public function setToSession(){
        $_SESSION[Cart::SESSION] = $this->getValues();
    }

    public function clearCart(){
        $_SESSION[Cart::SESSION] = null;
    }

    public function save(){
        $sql = new Sql();

        $results = $sql->select("CALL sp_carts_save(:idcart,:dessessionid,:iduser,:deszipcode,:vlfreight,:nrdays)",array(
            ":idcart"=>$this->getidcart(),
            ":dessessionid"=>$this->getdessessionid(),
            ":iduser"=>$this->getiduser(),
            ":deszipcode"=>$this->getdeszipcode(),
            ":vlfreight"=>$this->getvlfreight(),
            ":nrdays"=>$this->getnrdays()      
        ));
        $this->setData($results[0]);
    }

    public function getFromSessionID(){
        $sql = new Sql();

        $results = $sql->select("select * from tb_carts where dessessionid = :dessessionid",array(
            ":dessessionid"=>session_id()
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public function get(int $idcart){
        $sql = new Sql();

        $results = $sql->select("select * from tb_carts where idcart = :idcart",array(
            ":idcart"=>$idcart
        ));

        if(count($results) > 0) {
            $this->setData($results[0]);
        }
    }

    public function getProduct(){
        $sql = new Sql();

        $results = $sql->select("
            select b.idproduct , b.desproduct,b.vlprice,b.vlwidth , b.vlheight , b.vllength, b.vlweight, b.desurl ,
            count(*) as nrtotal , sum(b.vlprice) as vltotal
            from tb_cartsproducts a 
            inner join tb_products b on a.idproduct = b.idproduct 
            where idcart = :idcart and dtremoved is null 
            group by b.idproduct , b.desproduct,b.vlprice,b.vlwidth , b.vlheight , b.vllength, b.vlweight, b.desurl
            order by b.desproduct
        ",array(
            ":idcart"=>$this->getidcart()
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }

        return Product::checkList($results);
    }

    public function addProduct(Product $product){
        $sql = new Sql();

        $sql->query("insert into tb_cartsproducts(idcart,idproduct)values(:idcart,:idproduct)",array(
            ":idcart"=>$this->getidcart(),
            ":idproduct"=>$product->getidproduct()
        ));
    }

    public function removeProduct(Product $product,$all = false){

        $sql = new Sql();

        if($all === true){
            $sql->query("UPDATE tb_cartsproducts SET dtremoved = now()
             where idcart = :idcart and idproduct = :idproduct and 
            dtremoved is null",array(
                ":idcart"=>$this->getidcart(),
                ":idproduct"=>$product->getidproduct()
            ));
        }else{
            $sql->query("UPDATE tb_cartsproducts SET dtremoved = NOW()
            where idcart = :idcart AND idproduct = :idproduct AND 
            dtremoved IS NULL limit 1",array(
                ":idcart"=>$this->getidcart(),
                ":idproduct"=>$product->getidproduct()
            ));
        }
    }

    public function getProductsTotals(){
        $sql = new Sql();

        $results = $sql->select("
            select SUM(vlprice) as vlprice, SUM(vlwidth) as vlwidth, SUM(vlheight) as vlheight, SUM(vllength) as vllength, SUM(vlweight) as vlweight , COUNT(*) as nrtotal
            from tb_products a
            inner join tb_cartsproducts b 
            on a.idproduct = b.idproduct 
            where b.idcart = :idcart and dtremoved is null
        ",array(
            ":idcart"=>$this->getidcart()
        ));

        if(count($results) > 0){
           return $results[0];
        }else{
            return [];
        }
    }

    public function getCalculateTotals(){

        $this->updatefreight();
        
        $total = $this->getProductsTotals();

        $this->setvlsubtotal($total['vlprice']);
        $this->setvltotal($total['vlprice']+ (float)$this->getvlfreight());
    }

    public function updatefreight(){
        if($this->getdeszipcode() != ''){
            $this->setdeszipcode($this->getdeszipcode());
        }
    }

    public function getValues(){
        $this->getCalculateTotals();

        $value = parent::getValues();

        return $value;
    }

    public function setfreight($zipcode){
        $zipcode = str_replace('-', '', $zipcode);
		$totals = $this->getProductsTotals();
		if ($totals['nrtotal'] > 0) {
			if ($totals['vlheight'] < 2) $totals['vlheight'] = 2;
			if ($totals['vllength'] < 16) $totals['vllength'] = 16;
			$qs = http_build_query([
				'nCdEmpresa'=>'',
				'sDsSenha'=>'',
				'nCdServico'=>'40010',
				'sCepOrigem'=>'09853120',
				'sCepDestino'=>$zipcode,
				'nVlPeso'=>$totals['vlweight'],
				'nCdFormato'=>'1',
				'nVlComprimento'=>$totals['vllength'],
				'nVlAltura'=>$totals['vlheight'],
				'nVlLargura'=>$totals['vlwidth'],
				'nVlDiametro'=>'0',
				'sCdMaoPropria'=>'S',
				'nVlValorDeclarado'=>$totals['vlprice'],
				'sCdAvisoRecebimento'=>'S'
			]);
			$xml = simplexml_load_file("http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?".$qs);
			$result = $xml->Servicos->cServico;
			if ($result->MsgErro != '') {
				Cart::setMsgError($result->MsgErro);
			} else {
				Cart::clearMsgError();
			}
            $this->setnrdays($result->PrazoEntrega);
			$this->setvlfreight(Cart::formatValueToDecimal($result->Valor));
			$this->setdeszipcode($zipcode);
			$this->save();
			return $result;
		} else {
		}
    }

    public static function formatValueToDecimal($value):float{
        $value = str_replace(".",",",$value);
        return str_replace(",",".",$value);
    }

}













?>