<?php //* Mind this opening PHP tag
/**
 *  Single invoice template
 *
 *  @author     Ren Ventura
 *  @link       http://www.engagewp.com/create-invoices-gravty-forms-wordpress
 */
//* Define running total global variable
$running_total = 0;
//* Remove post info, post meta, breadcrumbs and title (Genesis specific hooks)
remove_action( 'genesis_entry_header', 'genesis_do_post_title' );
remove_action( 'genesis_entry_header', 'genesis_post_info', 12 );
remove_action( 'genesis_entry_footer', 'genesis_post_meta' );
remove_action( 'genesis_before_loop', 'genesis_do_breadcrumbs' );
// Output invoice details
add_action( 'genesis_entry_content', 'rv_invoice_details', 999 ); // (Genesis specific hook)
function rv_invoice_details() {
    //* Set variables
    $invoice_id = get_the_title();
    $name = get_field( 'invoice_client_name' );
    $email = get_field( 'invoice_client_email' );
    $invoice_date = get_field( 'invoice_date' );
    $invoice_due_date = get_field( 'invoice_due_date' );
?>

    <div class="invoice">

        <h2>Invoice Number <?php echo $invoice_id; ?></h2>

        <p>Bill to: <strong><?php echo $name; ?></strong></p>
        <p>Invoice Date: <?php echo $invoice_date;?></p>
        <p>Invoice Due: <strong><?php echo $invoice_due_date;?></strong></p>

        <?php if ( have_rows( 'invoice_services' ) ): //* Start the table if services are listed ?>

            <table class="services">

                <tr>

                    <th>Service</th>
                    <th style="text-align: right">Price</th>

                </tr>

                <?php while ( have_rows( 'invoice_services' ) ) : the_row(); ?>

                    <?php
                        //* Set repeater variables
                        $service_name = get_sub_field( 'invoice_service_name' );
                        $service_amount = '$' . number_format( get_sub_field( 'invoice_service_amount' ), 2 );
                    ?>

                    <?php //* Output a details row for each service ?>

                    <tr class="service">

                        <td class="name"><?php echo $service_name; ?></td>
                        <td class="amount"><?php echo $service_amount; ?></td>

                    </tr>

                    <?php
                        global $running_total;
                        $running_total += get_sub_field( 'invoice_service_amount' );
                    ?>

                <?php endwhile; ?>

            </table>

        <?php else : echo 'No services listed'; ?>

        <?php endif; ?>

    </div>

    <div class="payment-form">

        <?php echo do_shortcode( '[gravityform id="21" name="Invoice" title="false" description="false"]' ); ?>

    </div>

<?php }
add_filter( 'gform_field_value_client_name', 'gf_filter_client_name' );
function gf_filter_client_name() {
    return esc_attr( get_field( 'invoice_client_name' ) );
}
add_filter( 'gform_field_value_invoice_amount', 'gf_filter_amount' );
function gf_filter_amount() {
    global $running_total;
    return esc_attr( number_format( $running_total, 2 ) );
}
genesis(); // (Genesis specific function)