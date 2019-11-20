<?php if(!class_exists('Rain\Tpl')){exit;}?><section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Check you Order</h1>
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
        <div class="col-md-12">
                <div class="list-group" id="menu">
                        <a href="/profile" class="list-group-item list-group-item-action">Editar Dados</a>
                        <a href="/profile/changePassword" class="list-group-item list-group-item-action">Alterar Senha</a>
                        <a href="/profile/orders" class="list-group-item list-group-item-action">Meus Pedidos</a>
                        <a href="/logout" class="list-group-item list-group-item-action">Sair</a>
                </div>
        </div>
            <!-- title row -->
            <div class="row ml-2">
                <div class="col-xs-2">
                <h2 class="page-header">
                    <img src="/aroma/img/logo.png" alt="Logo">
                    <small class="pull-right">Date: <?php echo date('d/m/Y'); ?></small>
                </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info ml-5 mt-3">
                <div class="col-sm-4 invoice-col">
                De
                <address>
                    <strong>HCODE</strong><br>
                    Rua Ademar Saraiva Leão, 234 - Alvarenga<br>
                    São Bernardo do Campo - SP<br>
                    Telefone: (11) 3171-3080<br>
                    E-mail: suporte@hcode.com.br
                </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                Para
                <address>
                    <strong><?php echo htmlspecialchars( $order["desperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong><br>
                    <?php echo htmlspecialchars( $order["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br>
                    <?php echo htmlspecialchars( $order["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br>
                    <?php if( $order["nrphone"] && $order["nrphone"]!='0' ){ ?>Telefone: <?php echo htmlspecialchars( $order["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?><br><?php } ?>
                    E-mail: <?php echo htmlspecialchars( $order["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>
                </address>
                </div>
                <!-- /.col -->
                <div class="col-md-4 invoice-col">
                <b>Pedido #<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?></b><br>
                <br>
                <b>Emitido em:</b> <?php echo formatDate($order["dtregister"]); ?><br>
                <b>Pago em:</b> <?php echo formatDate($order["dtregister"]); ?>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        
            <!-- Table row -->
            <div class="row">
                <div class="col-md-12 table-responsive ml-5 mt-5">
                    <p class="lead">Descrição</p>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Qtd</th>
                        <th>Produto</th>
                        <th>Código #</th>
                        <th>Subtotal</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                    <tr>
                        <td><?php echo htmlspecialchars( $value1["nrtotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td><?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                        <td>R$<?php echo format_price($order["vltotal"]); ?></td>
                    </tr>
                    <?php } ?>
                    </tbody>
                </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        
            <div class="row ml-5 mt-5">
                <!-- accepted payments column -->
                <div class="col-md-12">
    
                    <p class="lead">Forma de Pagamento</p>
                    
                    <table class="table">
                        <tbody>
                        <tr>
                            <th style="width:180px;">Método de Pagamento:</th>
                            <td>Boleto</td>
                        </tr>
                        <tr>
                            <th>Parcelas:</th>
                            <td>1x</td>
                        </tr>
                        <!--
                        <tr>
                            <th>Valor da Parcela:</th>
                            <td>R$100,00</td>
                        </tr>
                        -->
                        </tbody>
                    </table>
    
                </div>
                <!-- /.col -->
                <div class="col-md-12">
                <p class="lead">Resumo do Pedido</p>
        
                <div class="table-responsive">
                    <table class="table">
                    <tbody><tr>
                        <th style="width:50%">Subtotal:</th>
                        <td>R$<?php echo format_price($cart["vlsubtotal"]); ?></td>
                    </tr>
                    <tr>
                        <th>Frete:</th>
                        <td>R$<?php echo format_price($cart["vlfreight"]); ?></td>
                    </tr>
                    <tr>
                        <th>Total:</th>
                        <td>R$<?php echo format_price($cart["vltotal"]); ?></td>
                    </tr>
                    </tbody></table>
                </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
            <!-- this row will not appear when printing -->
           
        </div>
        <div class="row justify-content-center">
                <div class="row no-print">
                        <div class="col-md-12">
                            <button type="button" onclick="window.open('/order/<?php echo htmlspecialchars( $order["idorder"], ENT_COMPAT, 'UTF-8', FALSE ); ?>')" class="btn btn-default pull-left btn-lg btn-block " style="margin-left: 5px;">
                                <i class="fa fa-barcode"></i> Boleto
                            </button>
                            <button type="button" onclick="window.print()" class="btn btn-lg btn-block btn-primary pull-right" style="margin-right: 5px;">
                                <i class="fa fa-print"></i> Imprimir
                            </button>
                        </div>
                </div>
        </div>
    </div>
</div>