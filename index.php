<?php

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('degub',true);

require_once("site.php");
require_once("admin.php");
require_once("admin_users.php");
require_once("admin_categories.php");
require_once("admin_product.php");
require_once("admin_orders.php");
require_once("functions.php");

$app->run();




?>