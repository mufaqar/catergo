<div class="menu-cart">
    <div class="cart-box">
        <?php if ( WC()->cart && ! WC()->cart->is_empty() ) : ?>
            <ul>
                <?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item ) :
                    $product = $cart_item['data'];
                    $product_id = $product->get_id();
                    $product_name = $product->get_name();
                    $product_price = WC()->cart->get_product_price( $product );
                    $product_link = $product->is_visible() ? $product->get_permalink( $cart_item ) : '#';
                    $thumbnail = $product->get_image( 'woocommerce_thumbnail' );
                ?>
                    <li>
                        <a href="<?php echo esc_url( $product_link ); ?>">
                            <?php echo $thumbnail; ?>
                        </a>
                        <div class="cart-product">
                            <a href="<?php echo esc_url( $product_link ); ?>">
                                <?php echo esc_html( $product_name ); ?>
                            </a>
                            <span><?php echo wp_kses_post( $product_price ); ?></span>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>

            <div class="shopping-items d-flex align-items-center justify-content-between">
                <span>Subtotal: <?php echo WC()->cart->get_cart_subtotal(); ?></span>
                <span>Total: <?php echo wc_price( WC()->cart->get_total( 'edit' ) ); ?></span>
            </div>

            <div class="cart-button d-flex justify-content-between mb-4">
                <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="theme-btn">
                    View Cart
                </a>
                <a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="theme-btn bg-red-2">
                    Checkout
                </a>
            </div>
        <?php else : ?>
            <p class="text-center py-3 mb-0">Your cart is empty.</p>
        <?php endif; ?>
    </div>

    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-icon position-relative">
        <i class="far fa-shopping-basket"></i>
        <?php if ( WC()->cart && WC()->cart->get_cart_contents_count() > 0 ) : ?>
            <span class="cart-count position-absolute top-0 end-0 translate-middle badge bg-red-2 text-white rounded-circle">
                <?php echo WC()->cart->get_cart_contents_count(); ?>
            </span>
        <?php endif; ?>
    </a>
</div>
