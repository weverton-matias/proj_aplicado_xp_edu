<?php
/**
 * Invoice List Page
 *
 * The list of Invoices for the Portal
 *
 * @package automattic/jetpack-crm
 * @see     https://jetpackcrm.com/kb/
 * @version 3.0
 */

defined( 'ABSPATH' ) || exit( 0 ); // Don't allow direct access

global $zbs;
$portal = $zbs->modules->portal;

do_action( 'zbs_enqueue_scripts_and_styles' );

$jpcrm_use_invoices = zeroBSCRM_getSetting( 'feat_invs' );

if ( $jpcrm_use_invoices < 0 ) {
	status_header( 404 );
	nocache_headers();
	include get_query_template( '404' );
	die( 0 );
}

$invoice_endpoint = $portal->get_endpoint( ZBS_TYPE_INVOICE );

?>
<style>
.zbs-portal-invoices-list .paid {
	background: green;
	color: white;
	font-weight: 700;
	line-height: 35px;
	border-radius: 0 !important;
}
</style>
<div class="alignwide zbs-site-main zbs-portal-grid">
	<nav class="zbs-portal-nav">
	<?php $portal->render->portal_nav( $invoice_endpoint ); ?>
	</nav>
	<div class="zbs-portal-content zbs-portal-invoices-list">
		<h2><?php esc_html_e( 'Invoices', 'zero-bs-crm' ); ?></h2>
		<div class="zbs-entry-content zbs-responsive-table" style="position:relative;">
			<?php
			$invoices_endpoint = new Automattic\JetpackCRM\Invoices_Endpoint( $portal );
			$invoices_endpoint->list_invoices_html_output();
			?>
		</div>
	</div>
	<div class="zbs-portal-grid-footer"><?php $portal->render->portal_footer(); ?></div>
</div>
