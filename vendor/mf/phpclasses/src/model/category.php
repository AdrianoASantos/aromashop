<?php

namespace MF\Model;

use \MF\DB\Sql;
use \MF\Model;
use \MF\Model\Product;

class Category extends Model{

    public static function listAll(){
        $sql = new Sql();

        return $sql->select("select * from tb_categories order by descategory");
        Category::updateFile();
    }

    public function get($idcategory){
        $sql = new Sql();

        $results = $sql->select("select * from tb_categories where idcategory = :idcategory",array(
            ":idcategory"=>$idcategory
        ));
        $this->setData($results[0]);
    }

    public function save(){
        $sql = new Sql();

        $results = $sql->select("CALL sp_categories_save(:idcategory,:descategory)",array(
            ":idcategory"=>$this->getidcategory(),
            ":descategory"=>$this->getdescategory()
        ));

        if(count($results) > 0){
            $this->setData($results[0]);
        }
        Category::updateFile();
    }

    public function delete(){
        $sql = new Sql();

        $sql->select("delete from tb_categories where idcategory = :idcategory",array(
            ":idcategory"=>$this->getidcategory()
        ));
    }

    public function getProduct($related = true){
        $sql = new Sql();

        if($related){
            $results = $sql->select(
                "select * from tb_products where idproduct in(
                    select a.idproduct from tb_products a
                    inner join tb_categoriesproducts b on
                    a.idproduct = b.idproduct 
                    where b.idcategory = :idcategory
                )",array(
                    ":idcategory"=>$this->getidcategory()
                )
            );
           
        }else{
            $results = $sql->select("
                select * from tb_products where idproduct not in(
                    select a.idproduct from tb_products a
                    inner join tb_categoriesproducts b on 
                    a.idproduct = b.idproduct 
                    where b.idcategory = :idcategory
                )
            ",array(
                ":idcategory"=>$this->getidcategory()
            ));
        }
        return Product::checkList($results);
        
    }

    public function addProductFeatured(Product $product){
        $sql = new Slq();

        $results = $sql->select("insert int0 tb_productsFeatured(idcategory,idproduct)",array(
            ":idcategory"=>$this->getidcategory(),
            ":idproduct"=>$product->getidproduct()
        ));
        if(count($results)> 0){
            $this->setData($results[0]);
        }
    }

    public function removeProductFeatured(Product $product){
        $sql = new Sql();

        $results = $sql->select("delete from tb_productsFeatured where idcategory = :idcategory and idproduct = :idproduct",array(
            ":idcategory"=>$this->getidcategory(),
            ":idproduct"=>$product->getidproduct()
        ));
        if(count($results)> 0){
            $this->setData($results[0]);
        }
    }


    public function addProduct(Product $product){
        $sql = new Sql();

        $results = $sql->select(
            "insert into tb_categoriesproducts(idcategory,idproduct)values(:idcategory,:idproduct)",array(
                ":idcategory"=>$this->getidcategory(),
                ":idproduct"=>$product->getidproduct()
            )
        );
        if(count($results) > 0){
            $this->setData($results[0]);
        }
    }

    public function removeProduct(Product $product){
        $sql = new Sql();

        $results = $sql->select("delete from tb_categoriesproducts where idcategory = :idcategory and idproduct = :idproduct",array(
            ":idcategory"=>$this->getidcategory(),
            ":idproduct"=>$product->getidproduct()
        ));

        if(count($results)> 0){
            $this->setData($results[0]);
        }
    }

    public static function updateFile(){
        $categories = Category::listAll();
		$html = [];
		foreach ($categories as $row) {
			array_push($html, '<a href="/category/'.$row['idcategory'].'" class="nav-link dropdown-toggle" role="button" aria-haspopup="true"
            aria-expanded="false">'.$row['descategory'].'</a>');
		}
		file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views"  .DIRECTORY_SEPARATOR. "site". DIRECTORY_SEPARATOR ."categories-menu.html", implode('', $html));
    }

}







?>