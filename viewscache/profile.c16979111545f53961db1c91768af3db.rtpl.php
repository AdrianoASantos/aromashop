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
                    <button class="close" type="button" data-dismiss="alete" aria-hidden="true">x</button>
                    <?php echo htmlspecialchars( $success, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                </div>
                <?php } ?>
                <?php if( $error != '' ){ ?>
                <div  class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                </div>
                <?php } ?>
                <form action="/profile" method="POST">
                     <div class="col-md-12 form-group">
                       <input type="text" class="form-control" id="name" name="desperson" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'" value="<?php echo htmlspecialchars( $user["desperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                     </div>
                    <div class="col-md-12 form-group">
                         <input type="text" class="form-control" id="email" name="desemail" placeholder="Email Address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email Address'" value="<?php echo htmlspecialchars( $user["desemail"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                     </div>
                      <div class="col-md-12 form-group">
                         <input type="text" class="form-control" id="email" name="nrphone" placeholder="Phone" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Phone'" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                     </div>
                     <div class="text-center">
                        <button type="submit" class="button button-paypal" href="#">Update</button>
                     </div>
                </form>
            </div>  
            </div>
        </div>
    </div>