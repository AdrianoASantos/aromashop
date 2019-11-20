<?php

namespace MF\Model;

use MF\DB\Sql;
use MF\Model;

class Product extends Model{

    public static function listAll(){
        $sql = new Sql();

        return $sql->select("select * from tb_products a inner join tb_description_product b using(iddescription) order by a.desproduct");
  
    }

    public static function listFeatured(Category $category){
        $sql = new Sql();

        return $sql->select(
            "select * from tb_products a
            inner join tb_categoriesproducts b using(idproduct)
            inner join tb_categories c on c.idcategory = b.idcategory
            where c.descategory = :destaque
            ",array(
                ":destaque"=>$category->getdestaque()
            ));
    }
    public function save(){
        $sql = new Sql();

        $results = $sql->select("CALL sp_products_save(:desproduct,:vlprice,:vlwidth,:vlheight,:vllength,:vlweight,:desurl,:desdescription)",array(
            ":desproduct"=>$this->getdesproduct(),
            ":vlprice"=>$this->getvlprice(),
            ":vlwidth"=>$this->getvlwidth(),
            ":vlheight"=>$this->getvlheight(),
            ":vllength"=>$this->getvllength(),
            ":vlweight"=>$this->getvlweight(),
            ":desurl"=>$this->getdesurl(),
            ":desdescription"=>$this->getdesdescription()
        ));
        if(count($results) > 0 ){
            $this->setData($results[0]);
        }

    }

    public static function checkList($list){
        foreach ($list as &$row) {
            $p = new Product();
            $p->setData($row);
            $row = $p->getValues();
        }
        return $list;
    }

    public function get($idproduct){
        $sql = new sql();

        $results  = $sql->select("select * from tb_products a inner join tb_description_product b using(iddescription) where idproduct = :idproduct",array(
            ":idproduct"=>$idproduct
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public function getFromUrl($desurl){
        $sql = new Sql();

        $results = $sql->select("select * from tb_products a inner join tb_description_product b using(iddescription)
        where desurl = :desurl",array(
            ":desurl"=>$desurl
        ));

            $this->setData($results[0]);
    }

    public function getCategory(){
        $sql = new Sql();

        return $sql->select("select * from tb_categories a 
        inner join tb_categoriesproducts b on a.idcategory = b.idcategory
        where b.idproduct = :idproduct",array(
            ":idproduct"=>$this->getidproduct()
        ));

    }

    public function update(){
        $sql = new Sql();

        $results = $sql->select("CALL sp_productsupdate_save(:desproduct,:vlprice,:vlwidth,:vlheight,:vllength,:vlweight,:desurl,:desdescription,:idproduct)",array(
            ":desproduct"=>$this->getdesproduct(),
            ":vlprice"=>$this->getvlprice(),
            ":vlwidth"=>$this->getvlwidth(),
            ":vlheight"=>$this->getvlheight(),
            ":vllength"=>$this->getvllength(),
            ":vlweight"=>$this->getvlweight(),
            ":desurl"=>$this->getdesurl(),
            ":desdescription"=>$this->getdesdescription(),
            ":idproduct"=>$this->getidproduct()
        ));

        if(count($results)> 0){
            $this->setData($results[0]);
        }
    }


    //metodo para checar se existe uma foto do produto
    public function checkPhoto(){
        if(file_exists(
            $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR .
            "aroma" .DIRECTORY_SEPARATOR . 
            "img" . DIRECTORY_SEPARATOR .
            "product" . DIRECTORY_SEPARATOR . 
            $this->getidproduct() . ".jpg"
        )){
            $url = "/aroma/img/product/" . $this->getidproduct() . ".jpg"; 
        }else{
            $url = "/aroma/img/product.jpg";
        }
        return $this->setdesphoto($url);
    }

    //metodo para a criação de uma imagem 
    public function setPhoto($file){
        $extension = explode('.', $file['name']);
		$extension = end($extension);
		switch ($extension) {
			case "jpg":
			case "jpeg":
			$image = imagecreatefromjpeg($file["tmp_name"]);
			break;
			case "gif":
			$image = imagecreatefromgif($file["tmp_name"]);
			break;
			case "png":
			$image = imagecreatefrompng($file["tmp_name"]);
			break;
		}
		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 
			"aroma" . DIRECTORY_SEPARATOR .  
			"img" . DIRECTORY_SEPARATOR . 
			"product" . DIRECTORY_SEPARATOR . 
			$this->getidproduct() . ".jpg";
		imagejpeg($image, $dist);
		imagedestroy($image);
		$this->checkPhoto();
    }

    //metodo para a sobrecarga do valores contidos no objeto
    public function getValues(){
        $this->checkPhoto();

        $values = parent::getValues();

        return $values;
    }

}






?>