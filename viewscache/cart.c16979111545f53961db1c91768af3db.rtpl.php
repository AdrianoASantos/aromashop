<?php if(!class_exists('Rain\Tpl')){exit;}?>
  <!--================Cart Area =================-->
  <section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">

                <form action="/checkout" method="post">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Product</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                       <?php $counter1=-1;  if( isset($product) && ( is_array($product) || $product instanceof Traversable ) && sizeof($product) ) foreach( $product as $key1 => $value1 ){ $counter1++; ?>
                        <tr>
                            <td>
                                <div class="media">
                                    <div class="d-flex">
                                        <img src="<?php echo htmlspecialchars( $value1["desphoto"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" alt="" class="img-fluid" width="50">
                                    </div>
                                    <div class="media-body">
                                        <p></p>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <h5>R$ <?php echo format_price($value1["vlprice"]); ?> </h5>
                            </td>
                            <td>
                                <div class="product_count">
                                    <input type="text" name="qty" id="sst" maxlength="12" value="<?php echo htmlspecialchars( $value1["nrtotal"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" title="Quantity:"
                                        class="input-text qty">
                                    <button onclick="window.location.href = '/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/add'" var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;
                                        class="increase items-count" type="button"><i class="lnr lnr-chevron-up"></i></button>
                                    <button onclick="window.location.href = '/cart/<?php echo htmlspecialchars( $value1["idproduct"], ENT_COMPAT, 'UTF-8', FALSE ); ?>/minus'" var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst) result.value--; return false; class="reduced items-count" type="button"><i class="lnr lnr-chevron-down"></i></button>
                                </div>
                            </td>
                            <td>
                                <h5>R$ <?php echo format_price($value1["vltotal"]); ?></h5>
                            </td>
                        </tr>
                       <?php } ?>
                       
                        <tr class="bottom_button">
                            <td>
                                <a class="button" href="#">Update Cart</a>
                            </td>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="cupon_text d-flex align-items-center">
                                    <input type="text" placeholder="Coupon Code">
                                    <a class="primary-btn" href="#">Apply</a>
                                    <a class="button" href="#">Have a Coupon?</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td>

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Frete</h5>
                                <br>
                                <h5>Subtotal</h5>
                                
                            </td>
                            <td>
                                <h5>R$ <?php echo format_price($cart["vlfreight"]); ?></h5>
                                <br>
                                <h5>R$ <?php echo format_price($cart["vlsubtotal"]); ?></h5>
                                
                            </td>
                        </tr>
                        <tr class="shipping_area">
                            <td class="d-none d-md-block">

                            </td>
                            <td>

                            </td>
                            <td>
                                <h5>Shipping</h5>
                            </td>
                            <td>
                                <div class="shipping_box">
                                    <h6>Calculate Shipping <i class="fa fa-caret-down" aria-hidden="true"></i></h6>
                                    <input type="text" placeholder="Postcode/Zipcode" name="zipcode">
                                    <input type="submit" formmethod="post" formaction="/cart/freight" value="CÁLCULAR" class="button">
                                </div>
                            </td>
                        </tr>
                        <tr class="out_button_area">
                            <td class="d-none-l">

                            </td>
                            <td class="">

                            </td>
                            <td>

                            </td>
                            <td>
                                <div class="checkout_btn_inner d-flex align-items-center">
                                    <a class="gray_btn" href="#">Continue Shopping</a>
                                    <a class="primary-btn ml-2" href="/checkout">Proceed to checkout</a>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
</section>
<!--================End Cart Area =================-->
