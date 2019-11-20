<?php

use \MF\Model\User;
use \MF\PageAdmin;

$app->get("/admin/users", function(){
    User::verifyLogin();

    $page = new PageAdmin();

    $page->setTpl("users",array(
        "users"=>User::listAll(),
        "search"=>"",
        "pages"=>""
    ));
});
$app->get("/admin/users/create", function(){
    User::verifyLogin();
    $page = new PageAdmin();

    $page->setTpl("users-create");
});

$app->post("/admin/users/create", function(){
    User::verifyLogin();
    $user = new User();

    $user->setData($_POST);

    $user->save();

    header("location: /admin/users");
    exit;
});


$app->get("/admin/users/:iduser", function($iduser){
    User::verifyLogin();
    $user = new User();

    $user->get((int)$iduser);

    $page = new PageAdmin();

    $page->setTpl("users-update",array(
        "user"=>$user->getValues()
    ));
});

$app->post("/admin/users/:iduser" ,function($iduser){
    User::verifyLogin();
    $user = new User();

    $user->get((int)$iduser);

    $_POST['inadmin'] = (isset($_POST['inadmin']))? 1: 0;

    $user->setData($_POST);

    $user->update();

    header("location: /admin/users");
    exit;
});


$app->get("/admin/users/:iduser/password", function($iduser){
    User::verifyLogin();
    $user = new User();

    $user->get((int)$iduser);

    $page = new PageAdmin();

    $page->setTpl("users-password",array(
        "user"=>$user->getValues(),
        "msgError"=>User::getMsgError(),
        "msgSuccess"=>User::getMsgSuccess()
    ));
});


$app->post("/admin/users/:iduser/password", function($iduser){
    User::verifyLogin();

    $user = new User();

    $user->get((int)$iduser);

    if(!$_POST['despassword'] || $_POST['despassword'] === ""){
        User::setMsgError("o campo nova senha não pode ser vazio!");
        header("location: /admin/users/".$user->getiduser()."/password");
        exit;
    }

    if(!$_POST['despassword-confirm'] || $_POST['despassword-confirm'] === ""){
        User::setMsgError("O campo de confirmação da nova senha não pode ser vazia");
        header("Location: /admin/users/".$user->getiduser()."/password");
        exit;
    }

    if($_POST['despassword'] !== $_POST['despassword-confirm']){
        User::setMsgError("Nova senha ou confirmação de senha estao incorretas");
        header("Location: /admin/users/".$user->getiduser()."/password");
        exit;
    }


    $user->setPassword($_POST['despassword']);

    User::setMsgSuccess("Senha alterada com sucesso");

    header("Location: /admin/users/".$user->getiduser()."/password");
    exit;

});

$app->get("/admin/login", function(){
    $page = new PageAdmin([
        "header"=>false,
        "footer"=>false
    ]);

    $page->setTpl("login");
}); 

$app->post("/admin/login", function(){
    User::login($_POST['login'],$_POST['password']);
    
    header("Location: /admin");
    exit;
});

$app->get("/admin/logout",function(){
    User::logout();

    header("Location: /admin/login");
    exit;
})





?>