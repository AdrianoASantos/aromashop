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
        <div class="col-md-10">
            <?php if( $success != '' ){ ?>
            <div class="alert alert-success">
                <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?>
            </div>
            <?php } ?>
            <?php if( $error != '' ){ ?>
            <div  class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
            </div>
            <?php } ?>
            <form action="/profile/changePassword" method="POST">
                 <div class="col-md-12 form-group">
                   <input type="password" class="form-control" id="password" name="password" placeholder="Senha Atual" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Password'">
                 </div>
                <div class="col-md-12 form-group">
                     <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Nova senha" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nova senha'">
                 </div>
                 <div class="text-center">
                    <button type="submit" class="button button-paypal" href="#">Update</button>
                 </div>
            </form>
        </div>  
        </div>
    </div>
</div>