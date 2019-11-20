<?php if(!class_exists('Rain\Tpl')){exit;}?><!-- ================ start banner area ================= -->	
<section class="blog-banner-area" id="category">
    <div class="container h-100">
        <div class="blog-banner">
            <div class="text-center">
                <h1>Product Checkout</h1>
                <nav aria-label="breadcrumb" class="banner-breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item active" aria-current="page">Checkout</li>
        </ol>
      </nav>
            </div>
        </div>
</div>
</section>
<!-- ================ end banner area ================= -->


<!--================Checkout Area =================-->
<section class="checkout_area section-margin--small">
<div class="container">
    <div class="billing_details">
        <div class="row">
            <div class="col-lg-8">
                    <?php if( $error != '' ){ ?>
                    <div class="alert alert-danger">
                        <?php echo htmlspecialchars( $error, ENT_COMPAT, 'UTF-8', FALSE ); ?>
                    </div>
                    <?php } ?>
                <h3>Billing Details</h3>
                <form class="row contact_form" action="/checkout" method="post" novalidate="novalidate">
                    <div class="col-md-12 form-group p_star">
                        <label>First Name</label>
                        <input type="text" class="form-control" id="first" name="desfullname" value="<?php echo htmlspecialchars( $user["desperson"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                        <span class="placeholder" data-placeholder="First name"></span>
                    </div>
                    <div class="col-md-6 form-group p_star">
                        <label>Number Phone</label>
                        <input type="text" class="form-control" id="number" name="nrphone" value="<?php echo htmlspecialchars( $user["nrphone"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                        <span class="placeholder" data-placeholder="Phone number"></span>
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <label>Number House</label>
                        <input type="text" class="form-control" id="desnumber" name="desnumber">
                        <span class="placeholder" data-placeholder="Address line 01"></span>
                    </div>
                    
                    <div class="col-md-12 form-group p_star">
                        <label>Address House</label>
                        <input type="text" class="form-control" id="address" name="desaddress" value="<?php echo htmlspecialchars( $address["desaddress"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" >
                    </div>
                    <div class="col-md-12 form-group p_star">
                        <label>Town/City</label>
                        <input type="text" class="form-control" id="city" name="descity" value="<?php echo htmlspecialchars( $address["descity"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                        <span class="placeholder" data-placeholder="Town/City"></span>
                    </div>
                    <div class="col-md-12 form-group">
                        <label>Postcode/Zip</label>
                        <input type="text" class="form-control" id="zip" name="deszipcode" placeholder="Postcode/ZIP" value="<?php echo htmlspecialchars( $address["zipcode"], ENT_COMPAT, 'UTF-8', FALSE ); ?>">
                    </div>
                  
                    <div class="col-md-12 form-group">
                        <div class="creat_account">
                            <input type="checkbox" id="f-option2" name="selector">
                            <label for="f-option2">Create an account?</label>
                        </div>
                    </div>
                
            </div>
            <div class="col-lg-4">
                <div class="order_box">
                    <h2>Your Order</h2>
                    <h6><a href="#"><h4>Product <span>Total</span></h4></a></h6>
                    <?php $counter1=-1;  if( isset($products) && ( is_array($products) || $products instanceof Traversable ) && sizeof($products) ) foreach( $products as $key1 => $value1 ){ $counter1++; ?>
                    <ul class="list">
                        <li><a href="#"><?php echo htmlspecialchars( $value1["desproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>  <span class="last">R$ <?php echo htmlspecialchars( $value1["vlprice"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
                    </ul>
                    <?php } ?>
                    <ul class="list list_2">
                        <li><a href="#">Subtotal <span>R$ <?php echo htmlspecialchars( $cart["vlsubtotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
                        <li><a href="#">Shipping <span>Flat rate: R$ <?php echo htmlspecialchars( $cart["vlfreight"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
                        <li><a href="#">Total <span>R$ <?php echo htmlspecialchars( $cart["vltotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?></span></a></li>
                    </ul>
                   
                    <div class="payment_item">
                        <div class="radion_btn">
                            <input type="radio" id="f-option5" name="selector">
                            <label for="f-option5">Check payments</label>
                            <div class="check"></div>
                        </div>
                        <p>Please send a check to Store Name, Store Street, Store Town, Store State / County,
                            Store Postcode.</p>
                    </div>
                    <div class="payment_item active">
                        <div class="radion_btn">
                            <input type="radio" id="f-option6" name="selector">
                            <label for="f-option6">Paypal </label>
                            <img src="/aroma/img/product/card.jpg" alt="">
                            <div class="check"></div>
                        </div>
                        <p>Pay via PayPal; you can pay with your credit card if you don’t have a PayPal
                            account.</p>
                    </div>
                    <div class="creat_account">
                        <input type="checkbox" id="f-option4" name="selector">
                        <label for="f-option4">I’ve read and accept the </label>
                        <a href="#">terms & conditions*</a>
                    </div>
                    <div class="text-center">
                      <button class="button button-paypal" type="submit">Proceed to Paypal</button>
                    </div>
                </div>
            </div>
        </form>
        </div>
    </div>
</div>
</section>
<!--================End Checkout Area =================-->