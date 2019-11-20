<?php if(!class_exists('Rain\Tpl')){exit;}?><section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Check you Profile</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Profile</li>
        </ol>
      </nav>
            </div>
        </div>
</div>
</section>

<div class="container">
    <div class="row">
        <div class="col-md-2">
                <div class="list-group" id="menu">
                        <a href="/profile" class="list-group-item list-group-item-action">Editar Dados</a>
                        <a href="/profile/changePassword" class="list-group-item list-group-item-action">Alterar Senha</a>
                        <a href="/profile/orders" class="list-group-item list-group-item-action">Meus Pedidos</a>
                        <a href="/logout" class="list-group-item list-group-item-action">Sair</a>
                </div>
        </div>
        <div class="col-md-9">
                
            <div class="cart-collaterals">
                <h2>Meu Pedido</h2>
            </div>

            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Endereço</th>
                        <th>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $counter1=-1;  if( isset($orders) && ( is_array($orders) || $orders instanceof Traversable ) && sizeof($orders) ) foreach( $orders as $key1 => $value1 ){ $counter1++; ?>
                    <tr>
                        <th scope="row"><?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                        <td>R$<?php echo htmlspecialchars( $value1["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["desstatus"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>, <?php echo htmlspecialchars( $value1["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - CEP: <?php echo htmlspecialchars( $value1["deszipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td style="width:222px;">
                            <a class="btn btn-success" href="/payment/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Imprimir Boleto</a>
                            <a class="btn btn-default" href="/profile/order/<?php echo htmlspecialchars( $value1["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Detalhes</a>
                        </td>
                    </tr>
                    <?php }else{ ?>
                    <div class="alert alert-info">
                        Nenhum pedido foi encontrado.
                    </div>
                    <?php } ?>
                </tbody>
            </table>

        </div> 
        </div>
    </div>
</div>