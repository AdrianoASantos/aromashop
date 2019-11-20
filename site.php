<?php

use \MF\Page;
use \MF\Model\User;
use \MF\Model\Product;
use \MF\Model\Category;
use \MF\Model\Cart;
use \MF\Model\Address;
use \MF\Model\Order;
use \MF\Model\OrdersStatus;


$app->get("/",function(){
    $product = Product::listAll();

    $c = new Category();

    $c->setdestaque('destaque');

    $p = Product::listFeatured($c);

    $page = new Page();

    $page->setTpl("index",array(
        "product"=>Product::checkList($product),
        "destaque"=>Product::checkList($p)
    ));
});

$app->get("/login", function(){
    $page = new Page();

    $page->setTpl("login",array(
        "error"=>User::getMsgError()
    ));
});

$app->post("/login",function(){
   try {
        User::login($_POST['login'] , $_POST['password']);
   } catch (\Exception $e) {
       User::setMsgError($e->getMessage());
   }
     header("Location: /checkout");
     exit;
    
});

$app->get("/logout",function(){
    User::logout();
    Cart::clearCart();
    header("Location: /");
    exit;
});

$app->get("/register", function(){
    $page = new Page();

    $page->setTpl("register");
});

$app->post("/register", function(){
    $user = new User();

    $user->setdeslogin($_POST['desemail']);

    $user->setinadmin(0);

    $user->setData($_POST);

    $user->save();

    header("location: /login");
    exit;


});

$app->get("/profile", function(){

    User::verifyLogin(false);

    $page = new Page();

    $user = User::getFromSession();
 

    $page->setTpl("/profile",array(
        "user"=>$user->getValues(),
        "error"=>User::getMsgError(),
        "success"=>User::getMsgSuccess()
    ));
});
$app->post("/profile",function(){
    User::verifyLogin(false);

    if(!isset($_POST['desperson']) || $_POST['desperson'] == ''){
		User::setMsgError("Preencha o nome");
		header("Location: /profile");
		exit;
	}

	if(!isset($_POST['desemail']) ||  $_POST['desemail'] == ''){
		User::setMsgError("Preencha o email");
		header("Location: /profile");
		exit;
    }
    
    if(!isset($_POST['nrphone']) || $_POST['nrphone'] == ''){
        User::setMsgError("Prencha o Cellphone");
        header("Location: /profile");
        exit;
    }

    if($_POST['desemail'] !== $user->getdesemail()){
        if(User::checkLoginExists($_POST['desemail']) === true){
            User::setMsgError("Email ja existente ");
            header("Location: /profile");
            exit;
        }
    }

    $user = User::getFromSession();

    $_POST['inadmin'] = $user->getinadmin();
    $_POST['despassword'] = $user->getdespassword();
    $_POST['deslogin'] = $_POST['desemail'];

    

    $user->setData($_POST);

    $user->update();

    header("Location: /profile");
    exit;
});

$app->get("/category/:idcategory", function($idcategory){

    $category = new Category();

    $category->get((int)$idcategory);

    $page = new Page();
   

    $page->setTpl("category",array(
        "product"=>$category->getProduct(),
        "category"=>$category->getValues()
    ));
});

$app->get("/product/:desurl", function ($desurl){
    $product = new Product();

    $product->getFromUrl($desurl);
    
    $page = new Page();
    
    $page->setTpl("product-details",array(
        "product"=>$product->getValues(),
        "category"=>$product->getCategory()
    ));
});

$app->get("/cart", function(){
   
    $cart = Cart::getFromSession();

    $page = new Page();

    $page->setTpl("cart",array(
        "product"=>$cart->getProduct(),
        "cart"=>$cart->getValues()
    ));
});

$app->get("/cart/:idproduct/add", function($idproduct){
    $product = new Product();

    $product->get((int)$idproduct);

    $cart = Cart::getFromSession();

    $cart->addProduct($product);

    header("Location: /cart");
    exit;
});

$app->get("/cart/:idproduct/minus", function($idproduct){
    $product = new Product();

    $product->get((int)$idproduct);

    $cart = Cart::getFromSession();

    $cart->removeProduct($product);

    header("Location: /cart");
    exit;
});

$app->post("/cart/freight",function(){

   $cart = Cart::getFromSession();

   $cart->setfreight($_POST['zipcode']);

   header("location: /cart");
   exit;

});

$app->get("/checkout", function(){
    User::verifyLogin(false);

    $user = User::getFromSession();

    $cart = Cart::getFromSession();

    $address = new Address();
    
    $address->loadFromCep($cart->getdeszipcode());
  
    $page = new Page();

    $page->setTpl("checkout",array(
        "cart"=>$cart->getValues(),
        "products"=>$cart->getProduct(),
        "address"=>$address->getValues(),
        "user"=>$user->getValues(),
        "error"=>User::getMsgError()
    ));
});

$app->post("/checkout", function(){
    User::verifyLogin(false);

    $user = User::getFromSession();

    if(isset($_POST['desfullname']) && $_POST['desfullname'] === ''){
        User::setMsgError("Campo nome não pode ser vazio");
        header("Location: /checkout");
        exit;
    }
    if(isset($_POST['nrphone']) && $_POST['nrphone'] === ''){
        User::setMsgError("Campo phone não pode ser vazio");
        header("Location: /checkout");
        exit;
    }
    if(isset($_POST['desnumber']) && $_POST['desnumber'] === ''){
        User::setMsgError("Campo number house não pode ser vazio");
        header("Location: /checkout");
        exit;
    }
    if(isset($_POST['desaddress']) && $_POST['desaddress'] === ''){
        User::setMsgError("Campo address não pode ser vazio");
        header("Location: /checkout");
        exit;
    }
    if(isset($_POST['descity']) && $_POST['descity'] === ''){
        User::setMsgError("Campo city não pode ser vazio");
        header("Location: /checkout");
        exit;
    }
    if(isset($_POST['deszipcode']) && $_POST['deszipcode'] === ''){
        User::setMsgError("Campo zipcode não pode ser vazio");
        header("Location: /checkout");
        exit;
    }
    $address = new Address();
    $_POST['idperson'] = $user->getidperson();
    
    $address->setData($_POST);
    
    $address->save();

    $cart = Cart::getFromSession();

    $total = $cart->getValues();

    $order = new Order();

    $order->setData(array(
        "iduser"=>$user->getiduser(),
        "idcart"=>$cart->getidcart(),
        "idstatus"=>OrdersStatus::EM_ABERTO,
        "idaddress"=>$address->getidaddress(),
        "vltotal"=>$total['vltotal']
    ));

    $order->save();

    header("Location: /order/".$order->getidorder());
    exit;

});

$app->get("/order/:idorder", function($idorder){
    User::verifyLogin(false);

    $order = new Order();

    $order->get((int)$idorder);

    $page = new Page();

    $page->setTpl("payment",array(
        "order"=>$order->getValues()
    ));
});

$app->get("/boleto/:idorder",function($idorder){
    User::verifyLogin(false);

    $order = new Order();

    $order->get((int)$idorder);

    // DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 10;
	$taxa_boleto = 5.00;
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_cobrado = format_price($order->getvltotal()); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(".", "", $valor_cobrado);
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');
	$dadosboleto["nosso_numero"] = $order->getidorder();  // Nosso numero - REGRA: Máximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $order->getidorder();	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula
	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $order->getdesperson();
	$dadosboleto["endereco1"] = $order->getdesaddress();
	$dadosboleto["endereco2"] = $order->getdescity() . " -  CEP: " . $order->getdeszipcode();
	// INFORMACOES PARA O CLIENTE
	$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Hcode E-commerce";
	$dadosboleto["demonstrativo2"] = "Taxa bancária - R$ 0,00";
	$dadosboleto["demonstrativo3"] = "";
	$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
	$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
	$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: suporte@hcode.com.br";
	$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto Loja Hcode E-commerce - www.hcode.com.br";
	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = "";
	$dadosboleto["aceite"] = "";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "";
	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //
	// DADOS DA SUA CONTA - ITAÚ
	$dadosboleto["agencia"] = "1690"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "48781";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta
	// DADOS PERSONALIZADOS - ITAÚ
	$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157
	// SEUS DADOS
	$dadosboleto["identificacao"] = " Aroma shop";
	$dadosboleto["cpf_cnpj"] = "24.700.731/0001-08";
	$dadosboleto["endereco"] = "Rua Ademar Saraiva Leão, 234 - Alvarenga, 09853-120";
	$dadosboleto["cidade_uf"] = "São Bernardo do Campo - SP";
	$dadosboleto["cedente"] = "AROMASHOP LTDA - ME";
	// NÃO ALTERAR!
	$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "aroma". DIRECTORY_SEPARATOR  . "boletophp" . DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR;
	require_once($path . "funcoes_itau.php");
	require_once($path . "layout_itau.php");
});

$app->get("/profile/orders",function(){
    User::verifyLogin(false);

    $user = User::getFromSession();

    $page = new Page();

    $page->setTpl("profile-orders",array(
        "orders"=>$user->getOrder()
    ));
});

$app->get("/profile/changePassword",function(){
    User::verifyLogin(false);

    $page = new Page();

    $page->setTpl("/profile-password",array(
        "error"=>User::getMsgError(),
        "success"=>User::getMsgSuccess()
    ));
});

$app->post("/profile/changePassword", function(){
    User::verifyLogin(false);

    $user = User::getFromSession();

    if(!isset($_POST['password']) || $_POST['password'] === ''){
        User::setMsgError("Campo senha não pode ser vazio");
        header("Location: /profile/changePassword");
        exit;
    }

    if(!isset($_POST['new-password']) || $_POST['new-password'] === ''){
        User::setMsgError("Campo nova senha não pode ser vazio");
        header("Location: /profile/changePassword");
        exit;
    }

    if(!password_verify($_POST['password'],$user->getdespassword())){
        User::setMsgError("Nova senha não pode ser igual a antiga");
        header("Location: /profile/changePassword");
        exit;
    }

    $user->setdespassword($_POST['new-password']);
    $user->update();

    User::setMsgSuccess("Senha alterada com sucesso");

    header("Location: /profile/changePassword");
    exit;
});

$app->get("/profile/order/:idorder", function($idorder){
    User::verifyLogin(false);

    $page = new Page();

    $order = new Order();

    $cart = Cart::getFromSession();

    $order->get((int)$idorder);

    $page->setTpl("profile-order",array(
        "order"=>$order->getValues(),
        "products"=>$cart->getProduct(),
        "cart"=>$cart->getValues()

    ));

});

$app->get("/payment/:idorder",function($idorder){
    User::verifyLogin(false);

    $order = new Order();

    $order->get((int)$idorder);

    header("Location: /order/".$order->getidorder());
    exit;
});





?>