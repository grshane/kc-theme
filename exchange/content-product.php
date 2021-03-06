<?php
/**
 * Custom template for displaying the a single
 * exchange product.
 *
 * @since 0.4.0
 * @version 1.0.0
 * @link http://ithemes.com/codex/page/Exchange_Template_Updates
 * @package IT_Exchange
 *
 * WARNING: Do not edit this file directly. To use
 * this template in a theme, simply copy over this
 * file's content to the exchange directory located
 * in your theme.
 */
?>

<?php do_action( 'it_exchange_content_product_before_wrap' ); ?>
    <div id="it-exchange-product" class="it-exchange-wrap">
        <?php it_exchange_get_template_part( 'messages' ); ?>
        <?php do_action( 'it_exchange_content_product_begin_wrap' ); ?>
        <div class="it-exchange-product-standard-content it-exchange-columns-wrapper <?php echo ( ! it_exchange( 'product', 'has-images' ) ) ? ' it-exchange-product-no-images' : 'it-exchange-product-has-images'; ?>">
            <div class="it-exchange-column it-exchange-product-info">
                <?php it_exchange_get_template_part( 'content-product/loops/product-images' ); ?>
                <div class="it-exchange-column-inner">
                    <?php it_exchange_get_template_part( 'content-product/loops/product-info' ); ?>
                </div>
            </div>

        </div>

        <div class="it-exchange-product-advanced-content">
            <?php it_exchange_get_template_part( 'content-product/loops/product-advanced' ); ?>
        </div>
        <?php do_action( 'it_exchange_content_product_end_wrap' ); ?>
    </div>
<?php do_action( 'it_exchange_content_product_after_wrap' ); ?>