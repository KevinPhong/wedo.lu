<?php
/**
 * PDF credit note invoice header template that will be visible on every page.
 *
 * This template can be overridden by copying it to youruploadsfolder/woocommerce-pdf-invoices/templates/credit-note/simple/yourtemplatename/header.php.
 *
 * HOWEVER, on occasion WooCommerce PDF Invoices will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @author  Bas Elbers
 * @package WooCommerce_PDF_Invoices_Premium/Templates
 * @version 0.0.1
 */

$templater       = WPI()->templater();
$order           = $templater->order;
/** @var BEWPIP_Credit_Note $credit_note */
$credit_note     = $templater->invoice;
$payment_gateway = wc_get_payment_gateway_by_order( $order );
?>

<table cellpadding="0" cellspacing="0">
	<tr class="top">
		<td>
			<?php
			if ( $templater->get_logo_url() ) {
				printf( '<img src="var:company_logo" style="max-height:100px;"/>' );
			} else {
				printf( '<h2>%s</h2>', esc_html( $templater->get_option( 'bewpi_company_name' ) ) );
			}
			?>
		</td>

		<td>
			<?php
			printf( __( 'Credit Note #: %s', 'woocommerce-pdf-invoices' ), $credit_note->get_formatted_number() );
			printf( '<br />' );
			printf( __( 'Date: %s', 'woocommerce-pdf-invoices' ), $credit_note->get_formatted_date() );

			if ( $credit_note->invoice ) {
				printf( '<br />' );
				printf( __( 'Invoice #: %s', 'woocommerce-pdf-invoices' ), $credit_note->invoice->get_formatted_number() );
				printf( '<br />' );
				printf( __( 'Invoice Date: %s', 'woocommerce-pdf-invoices' ), $credit_note->invoice->get_formatted_date() );
			}

			printf( '<br />' );
			printf( __( 'Order #: %s', 'woocommerce-pdf-invoices' ), $order->get_order_number() );
			printf( '<br />' );
			printf( __( 'Order Date: %s', 'woocommerce-pdf-invoices' ), $credit_note->get_formatted_order_date() );

			if ( $payment_gateway ) {
				printf( '<br />' );
				printf( __( 'Payment Method: %s', 'woocommerce-pdf-invoices' ), $payment_gateway->get_title() );

				// Get PO Number from 'WooCommerce Purchase Order Gateway' plugin.
				if ( 'woocommerce_gateway_purchase_order' === BEWPI_WC_Payment_Gateway_Compatibility::get_method_title( $payment_gateway ) ) {
					$po_number = $templater->get_meta( '_po_number' );
					if ( $po_number ) {
						printf( '<br />' );
						printf( __( 'Purchase Order Number: %s', 'woocommerce-pdf-invoices' ), $po_number );
					}
				}
			}

			// Get VAT Number from 'WooCommerce EU VAT Number' plugin.
			$vat_number = $templater->get_meta( '_vat_number' );
			if ( $vat_number ) {
				printf( '<br />' );
				printf( __( 'VAT Number: %s', 'woocommerce-pdf-invoices' ), $vat_number );
			}
			?>
		</td>
	</tr>
</table>
