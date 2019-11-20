<?php

use \MF\Model\User;
use \MF\PageAdmin;
use \MF\Model\Order;

$app->get("/admin/orders",function(){
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("orders",array(
        "orders"=>Order::listAllOrders(),
        "search"=>"",
        "pages"=>""
    ));
});

$app->get("/admin/orders/:idorder/status", function($idorder){
    User::verifyLogin();

    $order = new Order();

    $order->get((int)$idorder);

    $page = new PageAdmin();

    $page->setTpl("order-status",array(
        "order"=>$order->getValues(),
        "status"=>$order->listOrderStatus(),
        "msgError"=>"",
        "msgSuccess"=>""
    ));
});

$app->post("/admin/orders/:idorder/status",function($idorder){
    User::verifyLogin();

    $order = new Order();

    $order->get((int)$idorder);
    

    $order->setidstatus($_POST['idstatus']);

    $order->save();

    header("Location: /admin/orders/".$order->getidorder()."/status");
    exit;
});

$app->get("/admin/orders/:idorder", function($idorder){
    User::verifyLogin();

    $order = new Order();

    $order->get((int)$idorder);

    $cart = $order->getCart();

    $page = new PageAdmin();

    $page->setTpl("order",array(
        "order"=>$order->getValues(),
        "products"=>$cart->getProduct(),
        "cart"=>$cart->getValues()
    ));
});









?>
