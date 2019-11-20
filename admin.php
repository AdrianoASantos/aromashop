<?php

use \MF\PageAdmin;
use  \MF\Model\User;

$app->get("/admin", function(){
    User::verifyLogin();
    $page = new PageAdmin();

    $page->setTpl("index");
});




?>