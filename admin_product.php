<?php

use \MF\PageAdmin;
use \MF\Model\Product;
use \MF\Model\User;


$app->get("/admin/products", function(){
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("products",array(
        "products"=>Product::listAll(),
        "search"=>"",
        "pages"=>""
    ));
});

$app->get("/admin/product/create",function(){
    User::verifyLogin();
    
    $page = new PageAdmin();
    
    $page->setTpl("product-create");
});

$app->post("/admin/product/create", function(){
    User::verifyLogin();
    
    $product = new Product();

    $product->setData($_POST);

    $product->save();

    header("Location: /admin/products");
    exit;
});

$app->get("/admin/product/:idproduct", function($idproduct){
    User::verifyLogin();

    $product = new Product();

    $product->get((int)$idproduct);

    $page = new PageAdmin();

    $page->setTpl("products-update", array(
        "product"=>$product->getValues()
    ));
});

$app->post("/admin/product/:idproduct", function ($idproduct){
    User::verifyLogin();

    $product = new Product();

    $product->get((int)$idproduct);

    $product->setData($_POST);

    $product->update();

    $product->setPhoto($_FILES['file']);

    header("Location: /admin/products");
    exit;
});







?>