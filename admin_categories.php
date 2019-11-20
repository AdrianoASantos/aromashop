<?php

use \MF\Model\Category;
use \MF\PageAdmin;
use \MF\Model\User;
use \MF\Model\Product;


$app->get("/admin/categories", function(){
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("categories",array(
        "categories"=>Category::listAll(),
        "search"=>"",
        "pages"=>""
    ));
});

$app->get("/admin/categories/create", function(){
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function(){
    User::verifyLogin();

    $category = new Category();

    $category->setData($_POST);

    $category->save();

    header("Location: /admin/categories");
    exit;
});


$app->get("/admin/categories/:idcategory", function ($idcategory){
    User::verifyLogin();

    $category = new Category();

    $category->get((int)$idcategory);

    $page = new PageAdmin();

    $page->setTpl("categories-update",array(
        "category"=>$category->getValues()
    ));
});

$app->post("/admin/categories/:idcategory", function($idcategory){
    $category = new Category();

    $category->get((int)$idcategory);

    $category->setData($_POST);

    $category->save();

    header("Location: /admin/categories");
    exit;
});

$app->get("/admin/categories/:idcategory/delete", function($idcategory){
    $category = new Category();

    $category->get((int)$idcategory);

    $category->delete();

    header("Location: /admin/categories");
    exit;
});


$app->get("/admin/categories/:idcategory/product",function($idcategory){
    User::verifyLogin();

    $category = new Category();

    $category->get((int)$idcategory);

    $page = new PageAdmin();

    $page->setTpl("categories-product",array(
        "category"=>$category->getValues(),
        "productsNotRelated"=>$category->getProduct(false),
        "productsRelated"=>$category->getProduct()
    ));
});

$app->get("/admin/categories/:idcategory/products/:idproduct/add",function($idcategory,$idproduct){
    User::verifyLogin();

    $category = new Category();

    $category->get((int)$idcategory);

    $product = new Product();

    $product->get((int)$idproduct);

    $category->addProduct($product);

    header("Location: /admin/categories/".$category->getidcategory()."/product");
    exit;
});

$app->get("/admin/categories/:idcategory/products/:idproduct/remove",function($idcategory,$idproduct){
    User::verifyLogin();

    $category = new Category();

    $category->get((int)$idcategory);

    $product = new Product();

    $product->get((int)$idproduct);

    $category->removeProduct($product);

    header("Location: /admin/categories/".$category->getidcategory()."/product");
    exit;
});

?>