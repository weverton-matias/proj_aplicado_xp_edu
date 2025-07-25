<?php
/*
!
 * Jetpack CRM
 * https://jetpackcrm.com
 * V1.20
 *
 * Copyright 2020 Automattic
 *
 * Date: 01/11/16
 */
use Automattic\JetpackCRM\Segment_Condition_Exception;

/*
======================================================
	Breaking Checks ( stops direct access )
	====================================================== */
if ( ! defined( 'ZEROBSCRM_PATH' ) ) {
	exit( 0 );
}
/*
======================================================
	/ Breaking Checks
	====================================================== */

/*
======================================================
	Admin AJAX
	====================================================== */

	add_action( 'wp_ajax_jpcrm_hide_woo_promo', 'jpcrm_hide_woo_promo' );
function jpcrm_hide_woo_promo() {
	if ( current_user_can( 'activate_plugins' ) ) {
		$option = update_option( 'jpcrm_hide_woo_promo', 'hide', false );
		wp_send_json_success();
	}
}

	add_action( 'wp_ajax_jpcrm_hide_track_notice', 'jpcrm_hide_track_notice' );
function jpcrm_hide_track_notice() {
	if ( current_user_can( 'activate_plugins' ) ) {
		$option = update_option( 'jpcrm_hide_track_notice', 'hide', false );
		wp_send_json_success();
	}
}

	add_action( 'wp_ajax_jpcrm_hide_feature_alert', 'jpcrm_hide_feature_alert' );
function jpcrm_hide_feature_alert() {
	if ( current_user_can( 'activate_plugins' ) && isset( $_POST['feature_alert'] ) ) {
		$option = 'jpcrm_hide_' . sanitize_text_field( $_POST['feature_alert'] );
		update_option( $option, true, false );
		wp_send_json_success();
	}
}

	// AJAX email template population (as backup)
	add_action( 'wp_ajax_zbs_create_email_templates', 'zbs_create_email_templates' );
function zbs_create_email_templates() {
	check_ajax_referer( 'zbs_create_email_nonce', 'security' );
	// } only allow admin to do this?
	$m = array();
	if ( zeroBSCRM_isZBSAdminOrAdmin() ) {
		zeroBSCRM_checkTablesExist();
		zeroBSCRM_populateEmailTemplateList();
		$m['message'] = 'emails created';
	} else {
		$m['message'] = 'no permissions';
	}
	echo json_encode( $m );
	die( 0 );
}

	// save email template
	add_action( 'wp_ajax_zbs_save_email_status', 'zbs_save_email_status' );
function zbs_save_email_status() {

	$m = array();

	global $wpdb, $ZBSCRM_t;

	// } nonce..
	check_ajax_referer( 'zbs-save-email_active', 'security' );
	if ( zeroBSCRM_isZBSAdminOrAdmin() ) {
		// our variables
		$the_id = (int) sanitize_text_field( $_POST['id'] );
		$a_or_i = sanitize_text_field( $_POST['status'] );

		// the emails are $ZBSCRM_t['system_mail_templates']

		if ( $a_or_i == 'a' ) {
			// turning active

			if ( $wpdb->update(
				$ZBSCRM_t['system_mail_templates'],
				array(
					'zbsmail_active'      => 1,
					'zbsmail_lastupdated' => time(),
				),
				array( // where
					'zbsmail_id' => $the_id,
				),
				array(
					'%d',    // zbs_site
					'%d',    // zbs_team
				),
				array(
					'%d',
				)
			) !== false ) {

				$m['message'] = 'success turned active';
				$m['id']      = $the_id;
				$m['type']    = $a_or_i;

			} else {

				$m['message'] = 'insert failed';
				$m['id']      = $the_id;
				$m['type']    = $a_or_i;

			}
		} elseif ( $a_or_i == 'i' ) {

			if ( $wpdb->update(
				$ZBSCRM_t['system_mail_templates'],
				array(
					'zbsmail_active'      => 0,
					'zbsmail_lastupdated' => time(),
				),
				array( // where
					'zbsmail_id' => $the_id,
				),
				array(
					'%d',    // zbs_site
					'%d',    // zbs_team
				),
				array(
					'%d',
				)
			) !== false ) {

				$m['message'] = 'success turned inactive';
				$m['id']      = $the_id;
				$m['type']    = $a_or_i;

			} else {

				$m['message'] = 'insert failed';
				$m['id']      = $the_id;
				$m['type']    = $a_or_i;

			}
		}
	} else {
		$m['message'] = 'no perms';
	}

	echo json_encode( $m );
	die( 0 );
	// nonce field is zbs-save-email_active
}

	// } General App Helpers - log user closing a modal (see also zeroBSCRM_getCloseState)
	// basically log a dismissed dialog..
	add_action( 'wp_ajax_logclose', 'zeroBSCRM_AJAX_logClose' );
function zeroBSCRM_AJAX_logClose() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-glob-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	if ( zeroBSCRM_permsCustomers() ) {
		// } This is a list of keys that can be "set"
		// } e.g. if this is fired for "pdfinvinstall" it's saying user has X'd the "Want to install PDF invoicing? modal from Invoice builder"
		$potentialClosers = array( 'pdfinvinstall', 'v3prep2997' );
		$potentialKey     = '';
		if ( isset( $_POST['closing'] ) && ! empty( $_POST['closing'] ) && in_array( $_POST['closing'], $potentialClosers ) ) {
			$potentialKey = sanitize_text_field( $_POST['closing'] );
		}

		// } Only has one val, sets as the time...

		// } Brutally add option
		update_option( 'zbs_closers_' . $potentialKey, time(), false );
	}

	header( 'Content-Type: application/json' );
	echo json_encode( array( 'fini' => 1 ) );
	exit( 0 );
}

	/*
	* set_jpcrm_transient
	* Sets a JPCRM transient
	*/
	add_action( 'wp_ajax_jpcrmsettransient', 'jpcrm_set_jpcrm_transient' );
function jpcrm_set_jpcrm_transient() {

	// Check Nonce
	check_ajax_referer( 'jpcrm-set-transient-nonce', 'sec' );

	// Check permissions
	// > Backend JPCRM user or WP Admin
	if ( zeroBSCRM_permsIsZBSUserOrAdmin() ) {

		global $zbs;

		// retrieve data
		$transientKey        = '';
		$transientValue      = '';
		$transientExpiration = 0;

		if ( isset( $_POST['transient-key'] ) && ! empty( $_POST['transient-key'] ) ) {

			$transientKey = sanitize_text_field( $_POST['transient-key'] );

		}

		if ( isset( $_POST['transient-value'] ) && ! empty( $_POST['transient-value'] ) ) {

			$transientValue = sanitize_text_field( $_POST['transient-value'] );

		}

		if ( isset( $_POST['transient-expiration'] ) && ! empty( $_POST['transient-expiration'] ) ) {

			$transientExpiration = (int) sanitize_text_field( $_POST['transient-expiration'] );

		}

		// Check that this transient is on the "allowed list"
		if ( ! empty( $transientKey ) && array_key_exists( $transientKey, $zbs->transients ) ) {

			// within our realm, set
			set_transient( $transientKey, $transientValue, $transientExpiration );

		}
	}

	zeroBSCRM_sendJSONSuccess( array( 'fini' => 1 ) );
}

	// } Feedback
	add_action( 'wp_ajax_markFeedback', 'zeroBSCRM_AJAX_markFeedback' );
function zeroBSCRM_AJAX_markFeedback() {

	if ( zeroBSCRM_permsCustomers() ) {
		$feedbackVal = 'nope';
		if ( isset( $_POST['feedbackgiven'] ) ) {
			$feedbackVal = 'yep';
		}
		update_option( 'zbsfeedback', $feedbackVal, false );
	}
	header( 'Content-Type: application/json' );
	echo json_encode( array( 'fini' => 1 ) );
	exit( 0 );
}

	// } Retrieve list of invoice deets for customer ID
	add_action( 'wp_ajax_getinvs', 'zeroBSCRM_AJAX_getCustInvs' );
function zeroBSCRM_AJAX_getCustInvs() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-glob-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	$ret = array();

	// } If perms?
	if ( zeroBSCRM_permsCustomers() ) {

		// } Retrieve ID
		$cID = -1;
		if ( isset( $_POST['cid'] ) ) {
			$cID = (int) sanitize_text_field( $_POST['cid'] );
		}

		if ( $cID > 0 ) {

			// } Retrieve the customers invoices:
			$ret = zeroBS_getInvoicesForCustomer( $cID, true, 100 );

		}
	}

	header( 'Content-Type: application/json' );
	echo json_encode( $ret );
	exit( 0 );
}

	// } Remove file
	add_action( 'wp_ajax_delFile', 'zeroBSCRM_removeFile' );
function zeroBSCRM_removeFile() {

	// } req
	$res    = false;
	$errors = array();

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	// } Check perms
	if (
		( $_POST['zbsfType'] == 'customer' && zeroBSCRM_permsCustomers() ) ||
		( $_POST['zbsfType'] == 'company' && zeroBSCRM_permsCustomers() ) ||
		( $_POST['zbsfType'] == 'quotes' && zeroBSCRM_permsQuotes() ) ||
		( $_POST['zbsfType'] == 'invoices' && zeroBSCRM_permsInvoices() )
		) {

		// } Retrieve deets
		if ( isset( $_POST['zbsDel'] ) && ! empty( $_POST['zbsDel'] ) ) {

			// } Type? ID?
			if ( isset( $_POST['zbsCID'] ) && ! empty( $_POST['zbsCID'] ) ) {

				$objectID = (int) sanitize_text_field( $_POST['zbsCID'] );
				$fileType = sanitize_text_field( $_POST['zbsfType'] ); // assured as checked by if above (customer, quotes, invoices)
				$zbsDel   = sanitize_text_field( $_POST['zbsDel'] );

				// } potentially csv of to-delete
				if ( strpos( '#' . $zbsDel, ',' ) > 0 ) {
					$delFiles = explode( ',', $zbsDel );
				} else {
					$delFiles = array( $zbsDel );
				}

				if ( count( $delFiles ) > 0 ) {
					foreach ( $delFiles as $delFile ) {

						$deleted = zeroBS_removeFile( $objectID, $fileType, $delFile );
						if ( $deleted !== true ) {
							$errors[] = $deleted;
						}
					}
				}

				$res = true;

			}
		}
	}

	header( 'Content-Type: application/json' );
	echo json_encode(
		array(
			'res'    => $res,
			'errors' => $errors,
		)
	);
	exit( 0 );
}

	// } Filter customers + retrieve count
	add_action( 'wp_ajax_filterCustomers', 'zeroBSCRM_AJAX_filterCustomers' );
function zeroBSCRM_AJAX_filterCustomers() {

	// } req
	$res = false;

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	if ( ! zeroBSCRM_permsCustomers() ) {
		exit( '{processed:-1}' );
	}

	// } Running this auto-pulls POSTED filters + finds customers

		// } Apply filters - it's funky to have to force this :/
		global $zbsCustomerFiltersInEffect;
		$zbsCustomerFiltersInEffect = zbs_customerFiltersGetApplied();

		// } Retrieve
		$res                      = zeroBS__customerFiltersRetrieveCustomerCountAndTopCustomers();
		$res['filters_in_effect'] = $zbsCustomerFiltersInEffect;

	header( 'Content-Type: application/json' );
	echo json_encode( $res );
	exit( 0 );
}

	// Add log
	add_action( 'wp_ajax_zbsaddlog', 'zeroBSCRM_AJAX_addLog' );
function zeroBSCRM_AJAX_addLog() {

	header( 'Content-Type: application/json' );

	// req
	$res = -1;

	// Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce-logs', 'sec' );

	// brutal
	if ( ! zeroBSCRM_permsCustomers() ) {
		exit( '{processed:-1}' );
	}

	global $zbs;

	// Retrieve vars - this allows notes against ALL post types (just by id)
	if ( ! empty( $_POST['zbsnagainstid'] ) ) {
		$zbsNoteAgainstPostID = (int) sanitize_text_field( $_POST['zbsnagainstid'] );
	}
	if ( ! empty( $_POST['zbsntype'] ) ) {
		$zbsNoteType = sanitize_text_field( $_POST['zbsntype'] );
	}
	if ( ! empty( $_POST['zbsnshortdesc'] ) ) {
		$zbsNoteShortDesc = zeroBSCRM_preDBStr( sanitize_text_field( $_POST['zbsnshortdesc'] ) );
	}

	$zbsNoteLongDesc = '';
	if ( ! empty( $_POST['zbsnlongdesc'] ) ) {

		$zbsNoteLongDesc = zeroBSCRM_preDBStr(
			zeroBSCRM_textProcess(
				wp_kses( nl2br( $_POST['zbsnlongdesc'] ), $zbs->acceptable_restricted_html )
			)
		);

	}

	$zbsNoteObjType = '';
	if ( ! empty( $_POST['zbsnobjtype'] ) ) {
		$zbsNoteObjType = zeroBSCRM_textProcess( $_POST['zbsnobjtype'] );
	}

	// optional: logid to overwrite:
	$zbsNoteIDtoUpdate = -1;
	if ( ! empty( $_POST['zbsnoverwriteid'] ) ) {
		$zbsNoteIDtoUpdate = (int) sanitize_text_field( $_POST['zbsnoverwriteid'] );
	}

	$pinned = empty( $_POST['pinned'] ) ? -1 : 1;

	// Validate
	if (
		! empty( $zbsNoteAgainstPostID ) && $zbsNoteAgainstPostID > 0 &&
		! empty( $zbsNoteType ) &&
		! empty( $zbsNoteShortDesc )
	) {

		// Only raw checked... but proceed. (ADD or Update?) (if $zbsNoteIDtoUpdate = -1 it'll add, else it'll overwrite)
		$res = zeroBS_addUpdateLog(
			$zbsNoteAgainstPostID,
			$zbsNoteIDtoUpdate,
			-1,
			array(
				// Anything here will get wrapped into an array and added as the meta vals
				'type'      => $zbsNoteType,
				'shortdesc' => $zbsNoteShortDesc,
				'longdesc'  => $zbsNoteLongDesc,
				'pinned'    => $pinned,
			),
			$zbsNoteObjType
		);

	}

	echo json_encode( array( 'processed' => $res ) );
	exit( 0 );
}

	// Update log
	add_action( 'wp_ajax_zbsupdatelog', 'zeroBSCRM_AJAX_updateLog' );
function zeroBSCRM_AJAX_updateLog() {

	header( 'Content-Type: application/json' );

	// req
	$res = -1;

	// Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce-logs', 'sec' );

	// brutal
	if ( ! zeroBSCRM_permsLogsAddEdit() ) {
		exit( '{processed:-1}' );
	}

	global $zbs;

	// Retrieve vars - this allows notes against ALL post types (just by id)
	if ( ! empty( $_POST['zbsnprevid'] ) ) {
		$zbsNoteID = (int) sanitize_text_field( $_POST['zbsnprevid'] );
	}
	if ( ! empty( $_POST['zbsnagainstid'] ) ) {
		$zbsNoteAgainstPostID = (int) sanitize_text_field( $_POST['zbsnagainstid'] );
	}
	if ( ! empty( $_POST['zbsntype'] ) ) {
		$zbsNoteType = sanitize_text_field( $_POST['zbsntype'] );
	}
	if ( ! empty( $_POST['zbsnshortdesc'] ) ) {
		$zbsNoteShortDesc = zeroBSCRM_preDBStr( sanitize_text_field( $_POST['zbsnshortdesc'] ) );
	}

	$zbsNoteLongDesc = '';
	if ( ! empty( $_POST['zbsnlongdesc'] ) ) {

		$zbsNoteLongDesc = zeroBSCRM_preDBStr(
			zeroBSCRM_textProcess(
				wp_kses( nl2br( $_POST['zbsnlongdesc'] ), $zbs->acceptable_restricted_html )
			)
		);

	}

	$zbsNoteObjType = '';
	if ( ! empty( $_POST['zbsnobjtype'] ) ) {
		$zbsNoteObjType = zeroBSCRM_textProcess( $_POST['zbsnobjtype'] );
	}

	$pinned = empty( $_POST['pinned'] ) ? -1 : 1;

	// Validate
	if (
		! empty( $zbsNoteID ) && $zbsNoteID > 0 &&
		! empty( $zbsNoteAgainstPostID ) && $zbsNoteAgainstPostID > 0 &&
		! empty( $zbsNoteType ) &&
		! empty( $zbsNoteShortDesc )
	) {

		// Only raw checked... but proceed. (Update?) (if $zbsNoteIDtoUpdate = -1 it'll add, else it'll overwrite)
		$newOrUpdatedLogID = zeroBS_addUpdateLog(
			$zbsNoteAgainstPostID,
			$zbsNoteID,
			-1,
			array(
				// Anything here will get wrapped into an array and added as the meta vals
				'type'      => $zbsNoteType,
				'shortdesc' => $zbsNoteShortDesc,
				'longdesc'  => $zbsNoteLongDesc,
				'pinned'    => $pinned,
			),
			$zbsNoteObjType
		);

		$res = $newOrUpdatedLogID;

		// Internal Automator
		if ( ! empty( $res ) ) {
			zeroBSCRM_FireInternalAutomator(
				'log.update',
				array(
					'id'           => $zbsNoteID,
					'logagainst'   => $zbsNoteAgainstPostID,
					'logtype'      => $zbsNoteType,
					'logshortdesc' => $zbsNoteShortDesc,
					'loglongdesc'  => $zbsNoteLongDesc,
				)
			);
		}
	}

	echo json_encode( array( 'processed' => $res ) );
	exit( 0 );
}

	// } Del log
	add_action( 'wp_ajax_zbsdellog', 'zeroBSCRM_AJAX_deleteLog' );
function zeroBSCRM_AJAX_deleteLog() {

	header( 'Content-Type: application/json' );

	// } req
	$res = -1;

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce-logs', 'sec' );

	// } brutal
	// from 2.94.2 uses sub perms
	// if (!zeroBSCRM_permsCustomers()) exit('{processed:-1}');
	if ( ! zeroBSCRM_permsLogsDelete() ) {
		exit( '{processed:-1}' );
	}
	// if (!current_user_can('edit_page', $post_id)) return;

	// } Retrieve vars - this allows notes against ALL post types (just by id)
	if ( isset( $_POST['zbsnid'] ) && ! empty( $_POST['zbsnid'] ) ) {
		$zbsNoteID = (int) sanitize_text_field( $_POST['zbsnid'] );
	}

	// } Validate
	if (
		isset( $zbsNoteID ) &&
		! empty( $zbsNoteID )
	) {

		global $zbs;

		// } Brutal
		$res = $zbs->DAL->logs->deleteLog( array( 'id' => $zbsNoteID ) ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase,WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
	}

	echo json_encode( array( 'processed' => $res ) );
	exit( 0 );
}

	// Pin log
	add_action( 'wp_ajax_jpcrmpinlog', 'jpcrm_ajax_pin_log' );
function jpcrm_ajax_pin_log() {

	// req
	$res = false;

	// Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce-logs', 'sec' );

	if ( ! zeroBSCRM_permsLogsDelete() ) {
		wp_send_json( array( processed => false ) );
	}

	// Retrieve vars - this allows notes against ALL post types (just by id)
	$log_id = ! empty( $_POST['zbsnid'] ) ? (int) $_POST['zbsnid'] : false;

	// Basic validation check
	if ( $log_id > 0 ) {

		global $zbs;

		// Brutal
		$res = $zbs->DAL->logs->set_log_pin_status(
			array(
				'id'     => $log_id,
				'pinned' => 1,
			)
		);

	}

	wp_send_json( array( 'processed' => $res ) );
}

	// Un-Pin log
	add_action( 'wp_ajax_jpcrmunpinlog', 'jpcrm_ajax_unpin_log' );
function jpcrm_ajax_unpin_log() {

	// req
	$res = false;

	// Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce-logs', 'sec' );

	if ( ! zeroBSCRM_permsLogsDelete() ) {
		wp_send_json( array( processed => false ) );
	}

	// Retrieve vars - this allows notes against ALL post types (just by id)
	$log_id = ! empty( $_POST['zbsnid'] ) ? (int) $_POST['zbsnid'] : false;

	// Basic validation check
	if ( $log_id > 0 ) {

		global $zbs;

		// Brutal
		$res = $zbs->DAL->logs->set_log_pin_status(
			array(
				'id'     => $log_id,
				'pinned' => -1,
			)
		);

	}

	wp_send_json( array( 'processed' => $res ) );
}

/*
======================================================
	/ Admin AJAX
====================================================== */

/*
======================================================
	Admin AJAX: Quote Builder
====================================================== */

add_action( 'wp_ajax_zbs_get_quote_template', 'ZeroBSCRM_get_quote_template' );
function ZeroBSCRM_get_quote_template() {

	// } Starting
	$content = array();

	// } Check nonce
	check_ajax_referer( 'quo-ajax-nonce', 'security' );  // nonce..

	// } brutal
	if ( ! zeroBSCRM_permsCustomers() ) {
		exit( '{processed:-1}' );
	}
	if ( ! zeroBSCRM_permsQuotes() ) {
		exit( '{processed:-1}' );
	}

	// } Retrive deets
	$customer_ID = -1;
	if ( isset( $_POST['cust_id'] ) ) {
		$customer_ID = (int) $_POST['cust_id']; // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
	}
	$quote_template_id = -1;
	if ( isset( $_POST['quote_type'] ) ) {
		$quote_template_id = (int) $_POST['quote_type'];
	}

	// <DAL3
	$quote_title = '';
	if ( isset( $_POST['quote_title'] ) ) {
		$quote_title = sanitize_text_field( wp_unslash( $_POST['quote_title'] ) );
	}
	$quote_val = '';
	if ( isset( $_POST['quote_val'] ) ) {
		$quote_val = sanitize_text_field( wp_unslash( $_POST['quote_val'] ) );
	}
	$quote_date = '';
	if ( isset( $_POST['quote_dt'] ) ) {
		$quote_date = sanitize_text_field( wp_unslash( $_POST['quote_dt'] ) );
	}

	$quote_notes = '';

	// } needs at least customer id + template id
	if ( $customer_ID !== -1 && $quote_template_id !== -1 ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

		global $zbs;

		// DEBUG: print_r($_POST['quote_fields']); exit( 0 );
		// DAL3+ takes all quote inputs into account and fills out based on these (quote_fields), not above
		if ( isset( $_POST['quote_fields'] ) && is_array( $_POST['quote_fields'] ) ) {

			// retrieve basics over above
			if ( isset( $_POST['quote_fields']['zbscq_title'] ) && ! empty( $_POST['quote_fields']['zbscq_title'] ) ) {
				$quote_title = sanitize_text_field( wp_unslash( $_POST['quote_fields']['zbscq_title'] ) );
			}
			if ( isset( $_POST['quote_fields']['zbscq_value'] ) && ! empty( $_POST['quote_fields']['zbscq_value'] ) ) {
				$quote_val = sanitize_text_field( wp_unslash( $_POST['quote_fields']['zbscq_value'] ) );
			}
			if ( isset( $_POST['quote_fields']['zbscq_date'] ) && ! empty( $_POST['quote_fields']['zbscq_date'] ) ) {
				$sanitized_date = jpcrm_date_str_to_uts( sanitize_text_field( wp_unslash( $_POST['quote_fields']['zbscq_date'] ) ) );
				$quote_date     = jpcrm_uts_to_date_str( $sanitized_date );
			}
			if ( isset( $_POST['quote_fields']['zbscq_notes'] ) && ! empty( $_POST['quote_fields']['zbscq_notes'] ) ) {
				$quote_notes = sanitize_text_field( wp_unslash( $_POST['quote_fields']['zbscq_notes'] ) );
			}
		}

		// } Fill out rest
		$your_biz_name  = zeroBSCRM_getSetting( 'businessname' );
		$customerName   = zeroBS_getCustomerNameShort( $customer_ID );
		$contact_object = zeroBS_getCustomer( $customer_ID );
		// $customerMeta = zeroBS_getCustomerMeta($customer_ID);
		// $fname = $customerMeta['fname'];
		// $lname = $customerMeta['lname'];
		$bizState = '[STATE]'; // NOT EASILY ACCESSIBLE FROM YOUR SETTINGS... suggest we add to inv settings, addr proper.

		// load templater
		$placeholder_templating = $zbs->get_templating();

		// } Load template
		$quote_template = zeroBS_getQuoteTemplate( $quote_template_id );

		if ( isset( $quote_template ) && is_array( $quote_template ) && isset( $quote_template['content'] ) ) {

			// if no title/value is passed at this point, but there is one seet in quote template, we should use those values
			if ( empty( $quote_title ) && ! empty( $quote_template['title'] ) ) {
				$quote_title = $quote_template['title'];
			}
			if ( empty( $quote_val ) && ! empty( $quote_template['value'] ) ) {
				$quote_val = $quote_template['value'];
			}
			if ( empty( $quote_notes ) && ! empty( $quote_template['notes'] ) ) {
				$quote_notes = $quote_template['notes'];
			}

			// catch empty pass...
			if ( empty( $quote_title ) ) {
				$quote_title = '[QUOTETITLE]';
			}
			if ( empty( $quote_val ) ) {
				$quote_val = '[QUOTEVALUE]';
			}
			if ( empty( $quote_date ) ) {
				$quote_date = jpcrm_uts_to_date_str( time(), get_option( 'date_format' ) );
			}

			// HTML is escaped just prior to the complete HTML in this function being returned
			$working_html = wpautop( $quote_template['content'] );

			// replacements
			$replacements = $placeholder_templating->get_generic_replacements();

			$replacements['quote-title']      = $quote_title;
			$replacements['quote-value']      = zeroBSCRM_formatCurrency( $quote_val );
			$replacements['quote-date']       = $quote_date;
			$replacements['quote-notes']      = $quote_notes;
			$replacements['biz-state']        = $bizState;
			$replacements['contact-fullname'] = $customerName;

			$settings = $zbs->settings->getAll();
			if ( $settings['currency'] && $settings['currency']['strval'] ) {
				$replacements['quote-currency'] = $settings['currency']['strval'];
			}

			// if DAL3, also replace any custom fields
			if ( isset( $_POST['quote_fields'] ) && is_array( $_POST['quote_fields'] ) ) {

				// $cF = $zbs->settings->get('customfields');
				$cF = $zbs->DAL->getActiveCustomFields( array( 'objtypeid' => ZBS_TYPE_QUOTE ) );

				if ( isset( $cF ) && is_array( $cF ) ) { // &&isset($cF['quotes'])

					foreach ( $cF as $k => $f ) { // ['quotes']

						// annoyingly proper key is stored in [3] ?
						$key = '';
						if ( is_array( $f ) && isset( $f[3] ) ) {
							$key = $f[3];
						}

						if ( ! empty( $key ) ) {

							$v = '';
							if ( isset( $_POST['quote_fields'][ 'zbscq_' . $key ] ) ) {
								$v = sanitize_text_field( $_POST['quote_fields'][ 'zbscq_' . $key ] );

								// Here is where we search and replace placeholders for dates with a date string and date time strings), initially checking the value is similar to that of 'yyyy-mm-dd'.
								if ( preg_match( '/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', $v ) ) {

									// Additional date validation to confirm the date is valid, before processing (creating placeholder strings for searching and replacing).
									$date_time = DateTime::createFromFormat( 'Y-m-d', $v );
									if ( $date_time && $date_time->format( 'Y-m-d' ) === $v ) {

										$working_html = jpcrm_process_date_variables( $v, $key, $working_html, $placeholder_str_start = '##QUOTE-' );

									}
								}
							}

							// allow upper or lower to catch various uses
							$working_html = str_replace( '##QUOTE-' . strtoupper( $key ) . '##', $v, $working_html );
							$working_html = str_replace( '##QUOTE-' . strtolower( $key ) . '##', $v, $working_html );
							$working_html = str_replace( '##quote-' . strtolower( $key ) . '##', $v, $working_html );
						}
					}
				}
			}
			$keys_staying_unrendered = array( 'quote-ID', 'quote-url', 'quote-created', 'quote-created_datetime_str', 'quote-created_date_str', 'quote-accepted', 'quote-accepted_datetime_str', 'quote-accepted_date_str', 'quote-lastupdated', 'quote-lastupdated_datetime_str', 'quote-lastupdated_date_str', 'quote-lastviewed', 'quote-lastviewed_datetime_str', 'quote-lastviewed_date_str' );
			$working_html            = $placeholder_templating->replace_placeholders( array( 'global', 'contact', 'quote' ), $working_html, $replacements, array( ZBS_TYPE_CONTACT => $contact_object ), false, $keys_staying_unrendered ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			// } replace the rest (#fname, etc)
			// WH: moved to nice filter :) $working_html = zeroBSCRM_replace_customer_placeholders($customer_ID, $working_html);
			$working_html = apply_filters( 'zerobscrm_quote_html_generate', $working_html, $customer_ID ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			// } set return
			$content['html']           = wp_kses( $working_html, $zbs->acceptable_html );
			$content['template_title'] = $quote_template['title'];
			$content['template_value'] = $quote_template['value'];
			$content['template_notes'] = $quote_template['notes'];

			// } return
			wp_send_json( $content );

		} // / if content

	} // / if vars

	wp_send_json( array( 'error' => 1 ) );
}

// Send a quote via email
add_action( 'wp_ajax_jpcrm_quotes_send_quote', 'jpcrm_ajax_quote_send_email' );
function jpcrm_ajax_quote_send_email() {

	// Check nonce
	check_ajax_referer( 'edit-nonce-quote', 'sec' );

	// Check Permissions
	if ( ! zeroBSCRM_permsCustomers() ) {
		exit( '{processed:-1}' );
	}
	if ( ! zeroBSCRM_permsQuotes() ) {
		exit( '{processed:-1}' );
	}

	// Retrive details
	$quoteID = -1;
	if ( isset( $_POST['qid'] ) ) {
		$quoteID = (int) sanitize_text_field( $_POST['qid'] );
	}
	$target_email = '';
	if ( isset( $_POST['em'] ) ) {
		$target_email = sanitize_text_field( $_POST['em'] );
	}
	$contactID = -1;
	if ( isset( $_POST['cid'] ) ) {
		$contactID = (int) sanitize_text_field( $_POST['cid'] );
	}
	$companyID = -1;
	if ( isset( $_POST['coid'] ) ) {
		$companyID = (int) sanitize_text_field( $_POST['coid'] ); // track if companyID - not wired in via fronend yet, but will work
	}
	$attachAssignedDocs = false;
	$attachAsPDF        = false;
	if ( isset( $_POST['attachassoc'] ) && $_POST['attachassoc'] == 1 ) {
		$attachAssignedDocs = true;
	}
	if ( isset( $_POST['attachpdf'] ) && $_POST['attachpdf'] == 1 ) {
		$attachAsPDF = true;
	}

	// validate the email
	if ( ! zeroBSCRM_validateEmail( $target_email ) || empty( $target_email ) ) {
		zeroBSCRM_sendJSONError( array( 'message' => __( 'Invalid email', 'zero-bs-crm' ) ), 400 );
	}

	// Check id
	if ( $quoteID == -1 ) {
		zeroBSCRM_sendJSONError( array( 'message' => __( 'Invalid parameters', 'zero-bs-crm' ) ), 400 );
	}

	global $zbs;

	// as of 4.0.8 no need to check if the email template is switched to active.. (always is)
	// $active = zeroBSCRM_get_email_status(ZBSEMAIL_NEWQUOTE);

	// retrieve quote
	$quote = $zbs->DAL->quotes->getQuote(
		$quoteID,
		array(
			'withLineItems'    => true,
			'withCustomFields' => true,
			'withAssigned'     => true,
			'withTags'         => true,
			'withOwner'        => true,
			'withFiles'        => true,
		)
	);

	// retrieve assoc records
	// .. this would lead tracking to assign to whomever is assigned the quote, yet we pass this from front-end, arguably this makes more sense, but leaving for us to finalise contact<->company
	// $contactID = -1;  if (is_array($quote) && isset($quote['contact']) && is_array($quote['contact']) && count($quote['contact']) > 0) $contactID = $quote['contact'][0]['id'];
	// $companyID = -1;  if (is_array($quote) && isset($quote['company']) && is_array($quote['company']) && count($quote['company']) > 0) $companyID = $quote['company'][0]['id'];

	// ==========================================================================================
	// =================================== MAIL SENDING =========================================

	// Attachments?
	$attachments = array();
	if ( $attachAssignedDocs ) {
		if ( isset( $quote['files'] ) && is_array( $quote['files'] ) && count( $quote['files'] ) > 0 ) {

			// cycle through files + add as attachments
			// we pass as 2part array so they don't have their funky md5 prefixes..
			foreach ( $quote['files'] as $file ) {

				$filename = basename( $file['file'] );
				// if in privatised system, ignore first hash in name
				if ( isset( $file['priv'] ) ) {

					$filename = substr( $filename, strpos( $filename, '-' ) + 1 );
				}

				$attachments[] = array( $file['file'], 'x' . $filename );

			}
		}
	}

	// Attach as PDF?
	if ( $attachAsPDF ) {

		// make pdf.
		$pdf_path = jpcrm_quote_generate_pdf( $quoteID ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

		// attach it
		if ( $pdf_path !== false ) {

			$attachments[] = array( $pdf_path );

		}

		// NOTE: for security / hygiene, we delete this PDF after email is sent

	}

	// generate html
	$emailHTML = zeroBSCRM_quote_generateNotificationHTML( $quoteID, true );

		// build send array
		$mailArray = array(
			'toEmail'     => $target_email,
			'toName'      => '',
			'subject'     => zeroBSCRM_mailTemplate_getSubject( ZBSEMAIL_NEWQUOTE ),
			'headers'     => zeroBSCRM_mailTemplate_getHeaders( ZBSEMAIL_NEWQUOTE ),
			'body'        => $emailHTML,
			'textbody'    => '',
			'attachments' => $attachments,
			'options'     => array(
				'html' => 1,
			),
		);

		// track if contactID
		if ( $contactID > 0 ) {

			// senderWPID = -12 = new quote email to contact
			$mailArray['tracking'] = array(
				// tracking :D (auto-inserted pixel + saved in history db)
				'emailTypeID'     => ZBSEMAIL_NEWQUOTE,
				'targetObjID'     => $contactID,
				'senderWPID'      => -12,
				'associatedObjID' => $quoteID,
			);

		}

		// track if companyID - not wired in via fronend yet, but will work
		if ( $companyID > 0 ) {

			// senderWPID = -17 = new quote email to company
			$mailArray['tracking'] = array(
				// tracking :D (auto-inserted pixel + saved in history db)
				'emailTypeID'     => ZBSEMAIL_NEWQUOTE,
				'targetObjID'     => $companyID,
				'senderWPID'      => -17,
				'associatedObjID' => $quoteID,
			);

		}

		// Sends email, including tracking, via setting stored route out, (or default if none)
		// and logs trcking :)

		// discern delivery method
		$mailDeliveryMethod = zeroBSCRM_mailTemplate_getMailDelMethod( ZBSEMAIL_NEWQUOTE );
		if ( ! isset( $mailDeliveryMethod ) || empty( $mailDeliveryMethod ) ) {
			$mailDeliveryMethod = -1;
		}

		// send
		$sent = zeroBSCRM_mailDelivery_sendMessage( $mailDeliveryMethod, $mailArray );

		// delete any gen'd pdf's
		if ( $attachAsPDF && $pdf_path !== false ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			// delete the PDF file once it's been read (i.e. emailed)
			wp_delete_file( $pdf_path );

		}

		// =================================== / MAIL SENDING =======================================
		// ==========================================================================================

		if ( $sent ) {

			// send result
			zeroBSCRM_sendJSONSuccess( array( 'message' => 'sent' ) );

		} else {

			// send err
			zeroBSCRM_sendJSONError( array( 'message' => __( 'not sent', 'zero-bs-crm' ) ) );

		}

		exit( 0 );
}

/**
* AJAX: Accept a Quote
* Quotes can be accepted by logged-in users or via easy-access links
*/
add_action( 'wp_ajax_nopriv_zbs_quotes_accept_quote', 'ZeroBSCRM_accept_quote' );
add_action( 'wp_ajax_zbs_quotes_accept_quote', 'ZeroBSCRM_accept_quote' );

function ZeroBSCRM_accept_quote() {
	// We probably want to see all errors:
	ini_set( 'display_errors', 1 );
	ini_set( 'display_startup_errors', 1 );
	error_reporting( E_ALL );

	// } Check nonce
	check_ajax_referer( 'zbscrmquo-nonce', 'sec' );

	$quoteID = isset( $_POST['zbs-quote-id'] ) ? (int) $_POST['zbs-quote-id'] : 0;

	// } Got quote ID?
	if ( empty( $quoteID ) || $quoteID < 0 ) {
		zeroBSCRM_sendJSONError( array( 'noparams' => 1 ), 400 );
	} // / posted data

	// If nonced & has quote id, verify user can 'accept'
	// .. either has quoteHASH which matches ID, (easy access)
	// .. or is logged in client

	// easy access links? (hashed)
	$quoteHash = zeroBSCRM_getSetting( 'easyaccesslinks' ) && isset( $_POST['zbs-quote-hash'] )
		? sanitize_text_field( $_POST['zbs-quote-hash'] )
		: '';

	// Either easy access links are disabled or no hash is supplied
	if ( empty( $quoteHash ) ) {
		$uinfo = wp_get_current_user();

		// validate that this has been posted by the contact associated with the quote
		global $zbs;
		if ( ! $uinfo->ID
			|| zeroBS_getCustomerIDWithEmail( $uinfo->user_email ) !== $zbs->DAL->quotes->getQuoteContactID( $quoteID ) // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase,WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		) {
			zeroBSCRM_sendJSONError( array( 'access' => 1 ), 403 );
		}
	} elseif ( ! zeroBSCRM_quotes_getFromHash( $quoteHash )['success'] ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
		zeroBSCRM_sendJSONError( array( 'hash' => 1 ), 403 );
	}

	// We can accept the quote

	// mark quote as accepted
	zeroBS_markQuoteAccepted( $quoteID );

	// Send notification to creator/owner of quote
	// ..if the email notification for quote acceptence is active..
	if ( zeroBSCRM_get_email_status( ZBSEMAIL_QUOTEACCEPTED ) ) {

		// get owner details
		$quoteOwnerEmail = jpcrm_get_obj_owner_wordpress_email( $quoteID, ZBS_TYPE_QUOTE );

		if ( ! empty( $quoteOwnerEmail ) && zeroBSCRM_validateEmail( $quoteOwnerEmail ) ) {
			zbs_send_quote_accept_email( $quoteID, $quoteOwnerEmail );
		} // / if has owner with valid email

	} // / if email notification active

	// success
	zeroBSCRM_sendJSONSuccess( array( 'success' => 1 ) );
}

/*
======================================================
	/ Admin AJAX: Quote Builder
====================================================== */

/**
 * Sends the notification emal to the quote owner, informing them that
 * the quote has been accepted.
 *
 * @param int    $quoteID The ID of the accepted quote.
 * @param string $quoteOwnerEmail The email address to send the
 *  notification to.
 * @return array An array of one or two elements. The first is a boolean
 *  showing whether the email was successfully sent. The second is any
 *  error messoge.
 */
function zbs_send_quote_accept_email( $quoteID, $quoteOwnerEmail ) {

	$quoteOwnerWPID = zeroBS_getOwner( $quoteID, false, ZBS_TYPE_QUOTE );

	// generate html
	$emailHTML = zeroBSCRM_quote_generateAcceptNotifHTML( $quoteID, '', true );

	// build send array
	$mailArray = array(
		'toEmail'  => $quoteOwnerEmail,
		'toName'   => '',
		'subject'  => zeroBSCRM_mailTemplate_getSubject( ZBSEMAIL_QUOTEACCEPTED ),
		'headers'  => zeroBSCRM_mailTemplate_getHeaders( ZBSEMAIL_QUOTEACCEPTED ),
		'body'     => $emailHTML,
		'textbody' => '',
		'options'  => array(
			'html' => 1,
		),
		'tracking' => array(
			// tracking :D (auto-inserted pixel + saved in history db)
			'emailTypeID'     => ZBSEMAIL_QUOTEACCEPTED,
			'targetObjID'     => $quoteOwnerWPID,
			'senderWPID'      => -11,
			'associatedObjID' => $quoteID, // none
		),
	);

	// Sends email, including tracking, via setting stored route out, (or default if none)
	// and logs trcking :)

	// discern del method
	$mailDeliveryMethod = zeroBSCRM_mailTemplate_getMailDelMethod( ZBSEMAIL_QUOTEACCEPTED );
	if ( ! isset( $mailDeliveryMethod ) || empty( $mailDeliveryMethod ) ) {
		$mailDeliveryMethod = -1;
	}

	// send
	return zeroBSCRM_mailDelivery_sendMessage( $mailDeliveryMethod, $mailArray );
}

/*
======================================================
	Admin AJAX: Front End Forms
====================================================== */

function zbs_lead_form_views() {

	global $zbs;

	// fired via AJAX on page view (uniqued by cookie - test will send on each page refresh...)
	// will not have a nonce available since from another site.
	// only passing a form ID (which is (int) set and then updating a counter
	$form_id    = (int) sanitize_text_field( $_POST['id'] );
	$form_views = $zbs->DAL->forms->add_form_view( $form_id );

	echo json_encode( array( 'view_logged' => 'true' ) );
	exit( 0 );
}
	add_action( 'wp_ajax_nopriv_zbs_lead_form_views', 'zbs_lead_form_views' );
	add_action( 'wp_ajax_zbs_lead_form_views', 'zbs_lead_form_views' );

	// } Handle form submissions interesting to see how this works cross domain...
function zbs_lead_form_capture() {
	/**
	 * At this point, $_GET/$_POST variable are available
	 *
	 * We can do our normal processing here
	 */

	global $zbs;

	// } Declare this...
	$r = array();

	// reCaptcha check first (if present):
	$reCaptcha       = zeroBSCRM_getSetting( 'usegcaptcha' );
	$reCaptchaKey    = zeroBSCRM_getSetting( 'gcaptchasitekey' );
	$reCaptchaSecret = zeroBSCRM_getSetting( 'gcaptchasitesecret' );

	if ( $reCaptcha && ! empty( $reCaptchaKey ) && ! empty( $reCaptchaSecret ) ) {

		// } Assume fail
		$reCaptchaOkay = false;

		// } Retrieve from post
		$possibleCaptchaResponse = '';
		if ( isset( $_POST['recaptcha'] ) && ! empty( $_POST['recaptcha'] ) ) {
			$possibleCaptchaResponse = sanitize_text_field( $_POST['recaptcha'] );
		}

		// } Validate it
		$gSays = wp_remote_post(
			'https://www.google.com/recaptcha/api/siteverify',
			array(
				'method'      => 'POST',
				'timeout'     => 45,
				'redirection' => 5,
				'httpversion' => '1.0',
				'blocking'    => true,
				'headers'     => array(),
				'body'        => array(
					'secret'   => $reCaptchaSecret,
					'response' => $possibleCaptchaResponse,
									// not req 'remoteip' => zeroBSCRM_getRealIpAddr()
				),
				'cookies'     => array(),
			)
		);

		// } Should be a response json obj
		if ( ! empty( $gSays ) ) {
			// } get it
			$gSaysObj = json_decode( wp_remote_retrieve_body( $gSays ) );

			if ( isset( $gSaysObj->success ) && $gSaysObj->success ) {
				$reCaptchaOkay = true;
			}
		}

		// } Fail?
		if ( ! $reCaptchaOkay ) {

			// } AXE IT
			$r['message'] = 'Nope.';
			$r['code']    = 'recaptcha';
			echo json_encode( $r );
			wp_die();

		}
	}

	// } All need this, (if no form id, is dodgy?)
	$zbs_form_id = -1;
	if ( isset( $_POST['zbs_form_id'] ) && ! empty( $_POST['zbs_form_id'] ) ) {
		$zbs_form_id = (int) sanitize_text_field( $_POST['zbs_form_id'] );  // each form has an ID so we can track the conversions
	}

	// } Fail?
	if ( empty( $zbs_form_id ) ) {

		// } AXE IT
		$r['message'] = 'Nope.';
		$r['code']    = 'form';
		echo json_encode( $r );
		wp_die();

	}

	// honeypot
	$zbs_honey = sanitize_text_field( $_POST['zbs_hpot_email'] );  // this should be blank
	if ( $zbs_honey != '' ) {
		// then this is likely a spambot who has filled in the form since its hidden from humans
		$r['message'] = 'This is a honeypot.. something has gone wrong can alert the member on response';
		$r['code']    = 'honey';
		echo json_encode( $r );
		wp_die();
	} else {

		// } Added here: REQUIRE email...
		if ( isset( $_POST['zbs_email'] ) && ! empty( $_POST['zbs_email'] ) && zeroBSCRM_validateEmail( $_POST['zbs_email'] ) ) {

			// } Email is OKAY!
			// } For now do nothing here

		} else {

			// } AXE IT
			$r['message'] = 'Email Required.';
			$r['code']    = 'emailfail';
			echo json_encode( $r );
			wp_die();

		}

		// do our usual processing
		$zbs_form_style = (string) sanitize_text_field( $_POST['zbs_form_style'] );

		// } WH add - filter any not mentioned here
		if ( ! in_array( $zbs_form_style, array( 'zbs_simple', 'zbs_naked', 'zbs_cgrab' ) ) ) {
			$zbs_form_style = '';
		}

		// } NOTE! at this point form id hasn't been validated... could be random number!

		// } "Form x filled out from y" (will be added as note / meta)

			// } form str
			$form_details = zeroBS_getForm( $zbs_form_id );
		if ( isset( $form_details['title'] ) ) {
			$formTitle = $form_details['title'] . ' (#' . $zbs_form_id . ')';
		} else {
			$formTitle = '#' . $zbs_form_id;
		}

			// } pid is now passed, however it will only be passed on embed's
			$pageID = '';
		if ( isset( $_POST['pid'] ) && ! empty( $_POST['pid'] ) ) {
			$pageID = (int) sanitize_text_field( $_POST['pid'] );
		}
			$fromPageName = '';
		if ( ! empty( $pageID ) ) {
			$fromPageName = get_the_title( $pageID );
		}

			// } Form style str
			$formStyle = '';
		if ( $zbs_form_style == 'zbs_simple' ) {
			$formStyle = 'Simple';
		}
		if ( $zbs_form_style == 'zbs_naked' ) {
			$formStyle = 'Naked';
		}
		if ( $zbs_form_style == 'zbs_cgrab' ) {
			$formStyle = 'Content Grab';
		}
			$formStyleStr = '';
		if ( ! empty( $formStyle ) ) {
			$formStyleStr = ' (' . $formStyle . ')';
		}

			// } Could add these:
			// videoTNT_retrieveDom(get_bloginfo('wpurl')).' at '.date("F j, Y, g:i a")
			// videoTNT_getRealIpAddr()

			// } Build str's - refactor at some point... rough first fix
		if ( ! empty( $pageID ) ) {

			// } Shortcode form

				// } Existing user signed a form
				$existingUserFormSourceShort = 'User completed form <i class="fa fa-wpforms"></i>';
				$existingUserFormSourceLong  = 'Form <span class="zbsEmphasis">' . $formTitle . '</span>' . $formStyleStr . ', which was filled out from the page: <span class="zbsEmphasis">' . $fromPageName . '</span> (#' . $pageID . ')';

				// } New User from form
				$newUserFormSourceShort = 'Created from Form Capture <i class="fa fa-wpforms"></i>';
				$newUserFormSourceLong  = 'User created from the form <span class="zbsEmphasis">' . $formTitle . '</span>' . $formStyleStr . ', which was filled out from the page: <span class="zbsEmphasis">' . $fromPageName . '</span> (#' . $pageID . ')';

		} else {

			// } embed

				// } Existing user signed a form
				$existingUserFormSourceShort = 'User completed form <i class="fa fa-wpforms"></i>';
				$existingUserFormSourceLong  = 'Form <span class="zbsEmphasis">' . $formTitle . '</span>' . $formStyleStr . ', which was filled out from an externally embedded form.';

				// } New User from form
				$newUserFormSourceShort = 'Created from Form Capture <i class="fa fa-wpforms"></i>';
				$newUserFormSourceLong  = 'User created from the form <span class="zbsEmphasis">' . $formTitle . '</span>' . $formStyleStr . ', which was filled out from an externally embedded form.';

		}

			// } Actual log var passed
			$fallBackLog = array(
				'type'      => 'Form Filled', // 'form_filled',
				'shortdesc' => $existingUserFormSourceShort,
				'longdesc'  => $existingUserFormSourceLong,
			);

			// } Internal automator overrides - here we pass a "customer.create" note override (so we can pass it a custom str, else we let it fall back to "created by form")
			$internalAutomatorOverride = array(

				'note_override' => array(

					'type'      => 'Form Filled', // 'form_filled',
					'shortdesc' => $newUserFormSourceShort,
					'longdesc'  => $newUserFormSourceLong,

				),

			);

			// TO LATER DO:
			// Log above notes as meta vals... e.g. user has completed form 1, 2, and 5

			// TO LATER DO:
			// COMBINE THE FOLLOWING RETRIEVES... no need to have seperate input gathering...

			switch ( $zbs_form_style ) {

				case 'zbs_simple':
					// simple just has email
					$zbs_email = sanitize_text_field( $_POST['zbs_email'] ); // } This is validated above, but sanitize just in case!
					// have added a new 'form' for 'externals'
					$cID = zeroBS_integrations_addOrUpdateCustomer(
						'form',
						$zbs_email,
						array(

							// } Removed this, as it'll default to lead if it's not already customer!
							// } re-added as temp fix... WH 18/10/16
							// } changed to __() to support translation MS 06/09/19
							'zbsc_status' => __( 'Lead', 'zero-bs-crm' ),

							'zbsc_email'  => $zbs_email,
						),
						'', // ) Customer date (auto)
						// } Fallback log (for customers who already exist)
						$fallBackLog,
						false, // } Extra meta
						// } Internal automator overrides - here we pass a "customer.create" note override (so we can pass it a custom str, else we let it fall back to "created by form")
						$internalAutomatorOverride
					);

					// 2.97.7 - added this:
					// if autolog for contact creation = off, still add the message to form:
					$autoLogCCreation = zeroBSCRM_getSetting( 'autolog_customer_new' );
					if ( $autoLogCCreation <= 0 && $cID > 0 ) {

						// add form log manually
						$zbs->DAL->logs->addUpdateLog( // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
							array(

								// fields (directly)
								'data' => array(

									'objtype'   => ZBS_TYPE_CONTACT,
									'objid'     => $cID,
									'type'      => zeroBSCRM_permifyLogType( 'Form Filled' ),
									'shortdesc' => __( 'Contact added via Form Submit', 'zero-bs-crm' ),
									'longdesc'  => '<blockquote>' . __( 'Contact added via Form Submit', 'zero-bs-crm' ) . '</blockquote>',

								),
							)
						);
					}

					break;

				case 'zbs_naked':
					// } Naked only has name + email?

					// validate these...  (use functions in form save down...)
					$zbs_email = sanitize_text_field( $_POST['zbs_email'] ); // } This is validated above, but sanitize just in case!
					$zbs_fname = sanitize_text_field( $_POST['zbs_fname'] );
					// $zbs_lname = sanitize_text_field($_POST['zbs_lname']);
					// $zbs_notes = "Customer Form Submit Message:\r\n===========\r\n".sanitize_text_field($_POST['zbs_notes'])."\r\n===========\r\n";

					// have added a new 'form' for 'externals'
					zeroBS_integrations_addOrUpdateCustomer(
						'form',
						$zbs_email,
						array(

							// } Removed this, as it'll default to lead if it's not already customer!
							// } re-added as temp fix... WH 18/10/16
							// } changed to __() to support translation MS 06/09/19
							'zbsc_status' => __( 'Lead', 'zero-bs-crm' ),

							'zbsc_email'  => $zbs_email,
							'zbsc_fname'  => $zbs_fname,
						// 'zbsc_lname' => $zbs_lname,
						// 'zbsc_notes' => $zbs_notes,
						),
						'', // ) Customer date (auto)
						// } Fallback log (for customers who already exist)
						$fallBackLog,
						false, // } Extra meta
						// } Internal automator overrides - here we pass a "customer.create" note override (so we can pass it a custom str, else we let it fall back to "created by form")
						$internalAutomatorOverride
					);

					break;
				case 'zbs_cgrab':
					// validate these...  (use functions in form save down...)
					$zbs_email = sanitize_text_field( $_POST['zbs_email'] ); // } This is validated above, but sanitize just in case!
					$zbs_fname = sanitize_text_field( $_POST['zbs_fname'] );
					$zbs_lname = sanitize_text_field( $_POST['zbs_lname'] );
					// Raw: $zbs_notes = "Customer Form Submit Message:\r\n===========\r\n".zeroBSCRM_textProcess($_POST['zbs_notes'])."\r\n===========\r\n";
					// HTML:
						$formMessage = zeroBSCRM_textProcess( $_POST['zbs_notes'] );
						$zbs_notes   = '<blockquote>Customer Form Submit Message:<br />===========<br />' . $formMessage . '<br />===========</blockquote>';

						// } 27/09/16 WH - rather than pass as note field, add to log:

							// } for if user exists:
							$fallBackLog['longdesc'] .= $zbs_notes;

							// } for if user is fresh:
							$internalAutomatorOverride['note_override']['longdesc'] .= $zbs_notes;

					// have added a new 'form' for 'externals'
					$cID = zeroBS_integrations_addOrUpdateCustomer(
						'form',
						$zbs_email,
						array(

							// } Removed this, as it'll default to lead if it's not already customer!
							// } re-added as temp fix... WH 18/10/16
							// } changed to __() to support translation MS 06/09/19
							'zbsc_status' => __( 'Lead', 'zero-bs-crm' ),

							'zbsc_email'  => $zbs_email,
							'zbsc_fname'  => $zbs_fname,
							'zbsc_lname'  => $zbs_lname,
						// } Removed this and added to logs (just above!) 'zbsc_notes' => $zbs_notes,
						),
						'', // ) Customer date (auto)
						// } Fallback log (for customers who already exist)
						$fallBackLog,
						false, // } Extra meta
						// } Internal automator overrides - here we pass a "customer.create" note override (so we can pass it a custom str, else we let it fall back to "created by form")
						$internalAutomatorOverride
					);

					// 2.97.7 - added this:
					// if autolog for contact creation = off, still add the message to form:
					$autoLogCCreation = zeroBSCRM_getSetting( 'autolog_customer_new' );
					if ( $autoLogCCreation <= 0 ) {

						global $zbs;

						// add form log manually
						$zbs->DAL->logs->addUpdateLog( // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
							array(

								// fields (directly)
								'data' => array(

									'objtype'   => ZBS_TYPE_CONTACT,
									'objid'     => $cID,
									'type'      => zeroBSCRM_permifyLogType( 'Form Filled' ),
									'shortdesc' => $fallBackLog['shortdesc'],
									'longdesc'  => $fallBackLog['longdesc'],

									'meta'      => array( 'message' => $formMessage ),

								),
							)
						);
					}

					break;
				default:
					exit( 0 );  // if not one of our cases then die.
			}

			// } TODO we could add some tracking here (e.g. "originated from form x on page y")

			// update the counter for "conversions"
			$zbs->DAL->forms->add_form_conversion( $zbs_form_id );

			// return
			$r['message'] = 'Contact received.';
			$r['code']    = 'success';
			echo json_encode( $r );
			die( 0 );

	}
}
	add_action( 'wp_ajax_nopriv_zbs_lead_form_capture', 'zbs_lead_form_capture' );
	add_action( 'wp_ajax_zbs_lead_form_capture', 'zbs_lead_form_capture' );

	/*
	POST ACTIONS
	add_action( 'admin_post_nopriv_zbs_lead_form_capture', 'zbs_lead_form_capture' );
	add_action( 'admin_post_zbs_lead_form_capture', 'zbs_lead_form_capture' );
	*/

/*
======================================================
	/ Admin AJAX: Front End Forms
====================================================== */

/*
======================================================
	Admin AJAX: Customer Record stuff
====================================================== */

	// } Add/remove aliases
	add_action( 'wp_ajax_addAlias', 'zeroBSCRM_AJAX_addAlias' );
function zeroBSCRM_AJAX_addAlias() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	// } Check perms
	if ( ! zeroBSCRM_permsCustomers() ) {
		header( 'Content-Type: application/json' );
		exit( '{err:1}' ); }

	// } Proceed :)
	$passBack = array();

		$custID = -1;
	if ( isset( $_POST['cid'] ) ) {
		$custID = (int) sanitize_text_field( $_POST['cid'] );
	}
		$alias = '';
	if ( isset( $_POST['aka'] ) ) {
		$alias = sanitize_text_field( $_POST['aka'] );
	}

		// } Any good?
	if ( ! empty( $custID ) && ! empty( $alias ) ) {

		// check if already exists as alias
		if ( zeroBS_canUseCustomerAlias( $alias ) == false ) {

			$passBack['fail'] = 'existing';

		} else {

			// all good, proceed

			$passBack['res'] = zeroBS_addCustomerAlias( $custID, $alias );

			// } For now, no checks :)

		}

		// } Return
		header( 'Content-Type: application/json' );
		echo json_encode( $passBack );
		exit( 0 );

	}

		// err really :o
		header( 'Content-Type: application/json' );
		exit( '[]' );
}
	add_action( 'wp_ajax_removeAlias', 'zeroBSCRM_AJAX_removeAlias' );
function zeroBSCRM_AJAX_removeAlias() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	// } Check perms
	if ( ! zeroBSCRM_permsCustomers() ) {
		header( 'Content-Type: application/json' );
		exit( '{err:1}' ); }

	// } Proceed :)
	$passBack = array();

		$custID = -1;
	if ( isset( $_POST['cid'] ) ) {
		$custID = (int) sanitize_text_field( $_POST['cid'] );
	}
		$aliasID = -1;
	if ( isset( $_POST['akaid'] ) ) {
		$aliasID = (int) sanitize_text_field( $_POST['akaid'] );
	}

		// } Any good?
	if ( ! empty( $custID ) && ! empty( $aliasID ) ) {

		// NOTE: by passing cust + alias id's, rather than just ALIAS id, we do ANOTHER check to make sure
		// that user's deleting smt they mean to (this is also pre-emptive for provider-platform + ownership rights)
		$passBack['res'] = zeroBS_removeCustomerAliasByID( $custID, $aliasID );

		// } For now, no checks :)

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

	}

		// err really :o
		header( 'Content-Type: application/json' );
		exit( '[]' );
}

/*
======================================================
	/ Admin AJAX: Customer Record stuff
====================================================== */

/*
======================================================
	Admin AJAX: List View (API STYLE)
====================================================== */

	// } Update Columns - list view column update
	add_action( 'wp_ajax_updateListViewColumns', 'zeroBSCRM_AJAX_updateListViewColumns' );
function zeroBSCRM_AJAX_updateListViewColumns() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	// } Check perms
	if ( ! zeroBSCRM_isZBSAdminOrAdmin() ) {
		header( 'Content-Type: application/json' );
		exit( '{err:1}' ); }

		global $zbs;

		// } Retrieve type + columns arr
		$listtype    = sanitize_text_field( $_POST['listtype'] );
		$listColumns = $_POST['v']; // NEEDS SANITATION!

		/*
		#} Centralised into ZeroBSCRM.List.Columns.php 30/7/17
		global $zeroBSCRM_columns_customer;
		$defaultColumns = $zeroBSCRM_columns_customer['default'];
		$allColumns = $zeroBSCRM_columns_customer['all'];
		*/
		$customViews = $zbs->settings->get( 'customviews2' );

		// } switch by type
	switch ( $listtype ) {

		case 'customer':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newCustomerColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newCustomerColumns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                                = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// } Update
			$newCustomViews['customer'] = $newCustomerColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'company':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newCoColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newCoColumns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                          = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// } Update
			$newCustomViews['company'] = $newCoColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'quote':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newQuoColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newQuoColumns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                           = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// } Update
			$newCustomViews['quote'] = $newQuoColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'invoice':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newInvColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newInvColumns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                           = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// } Update
			$newCustomViews['invoice'] = $newInvColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'transaction':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newTransColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newTransColumns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                             = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// } Update
			$newCustomViews['transaction'] = $newTransColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'form':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newFormsColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newFormsColumns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                             = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// } Update
			$newCustomViews['form'] = $newFormsColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'segment':
			// } Brutal save over anyway..

			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$newColumns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$newColumns[ $colVal['fieldstr'] ] = array( $colVal['namestr'] );
				$passBack[]                        = array(
					'fieldstr' => $colVal['fieldstr'],
					'namestr'  => $colVal['namestr'],
				);

			}

			// } Update
			$newCustomViews['segment'] = $newColumns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		case 'event':
			// } Use existing (stores all types of custom views - not just this one)
			$newCustomViews = $customViews;
			$passBack       = array();

			// } Build
			$new_task_columns = array(); foreach ( $listColumns as $colKey => $colVal ) {

				$new_task_columns[ $colVal['fieldstr'] ] = array( __( $colVal['namestr'], 'zero-bs-crm' ) );
				$passBack[]                             = array(
					'fieldstr' => __( $colVal['fieldstr'], 'zero-bs-crm' ),
					'namestr'  => __( $colVal['namestr'], 'zero-bs-crm' ),
				);

			}

			// Update
			$newCustomViews['event'] = $new_task_columns;
			$zbs->settings->update( 'customviews2', $newCustomViews );

			// } Return
			header( 'Content-Type: application/json' );
			echo json_encode( $passBack );
			exit( 0 );

			break;

		default:
			// err really :o
			header( 'Content-Type: application/json' );
			exit( '[]' );

			break;

	}

		exit( 0 );
}

	// } Retrieves data sets for list views, with passed params :)
	add_action( 'wp_ajax_retrieveListViewData', 'zeroBSCRM_AJAX_listViewRetrieveData' );
function zeroBSCRM_AJAX_listViewRetrieveData() {

	// } req
	$res = false;

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	global $zbs;

	// } Retrieve params
	$pArray = array();
	if ( isset( $_POST['v'] ) && is_array( $_POST['v'] ) ) {
		$pArray = $_POST['v'];
	}

	// to properly sanitize, we hand-pass each var here, rather than trust the array :)
	// else defaults :)
	$listViewParams = array(
		'listtype'   => ( isset( $pArray['listtype'] ) ) ? sanitize_text_field( $pArray['listtype'] ) : '',
		'columns'    => array(),
		'editinline' => ( isset( $pArray['editinline'] ) ) ? sanitize_text_field( $pArray['editinline'] ) : '',
		'retrieved'  => ( isset( $pArray['retrieved'] ) ) ? false : true, // doesn't look like this is used
		'count'      => ( isset( $pArray['count'] ) ) ? (int) sanitize_text_field( $pArray['count'] ) : 20,
		'pagination' => ( isset( $pArray['pagination'] ) ) ? sanitize_text_field( $pArray['pagination'] ) : true,
		'paged'      => ( isset( $pArray['paged'] ) ) ? (int) sanitize_text_field( $pArray['paged'] ) : 1,
		'filters'    => array(),
		'sort'       => ( isset( $pArray['sort'] ) ) ? sanitize_text_field( $pArray['sort'] ) : false,
		'sortorder'  => ( isset( $pArray['sortorder'] ) ) ? sanitize_text_field( $pArray['sortorder'] ) : false,
		'pagekey'    => ( isset( $pArray['pagekey'] ) ) ? sanitize_text_field( $pArray['pagekey'] ) : '',
	);

	// deal with arrayed items

		// cols
	if ( isset( $_POST['v'] ) && is_array( $_POST['v'] ) && isset( $_POST['v']['columns'] ) && is_array( $_POST['v']['columns'] ) ) {

		foreach ( $_POST['v']['columns'] as $colIndx => $col ) {

			// check
			if ( isset( $col['namestr'] ) && isset( $col['fieldstr'] ) ) { // removed v3.0.5 - think legacy, if no issue by 3.1, kill this comment. : && isset($col['inline'])

				// sanitize + add
				$listViewParams['columns'][] = array(

					'namestr'  => ( isset( $col['namestr'] ) ) ? sanitize_text_field( $col['namestr'] ) : '',
					'fieldstr' => ( isset( $col['fieldstr'] ) ) ? sanitize_text_field( $col['fieldstr'] ) : '',
					'inline'   => ( isset( $col['inline'] ) ) ? (int) sanitize_text_field( $col['inline'] ) : -1,

				);

			}
		}
	} // /cols

		// filters
		// could do with refactoring to account for multi-dimensionality more elegantly
	if ( isset( $_POST['v'] ) && is_array( $_POST['v'] ) && isset( $_POST['v']['filters'] ) && is_array( $_POST['v']['filters'] ) ) {

		foreach ( $_POST['v']['filters'] as $filterIndx => $filter ) {

			// check (if tags, will be 0 indexed index)
			$filterIndexStr = sanitize_text_field( $filterIndx );
			if ( is_array( $filter ) ) {

				foreach ( $filter as $filterSubIndx => $filterSub ) {

					if ( ! is_int( $filterSubIndx ) ) {
						$filterSubIndx = sanitize_text_field( $filterSubIndx );
					}

						// can be an array or a string, so allow multidimension:
					if ( is_array( $filterSub ) ) {

						foreach ( $filterSub as $filterSubSubIndx => $filterSubSub ) {

							if ( ! is_int( $filterSubSubIndx ) ) {
								$filterSubSubIndx = sanitize_text_field( $filterSubSubIndx );
							}

							if ( ! isset( $listViewParams['filters'][ $filterIndexStr ][ $filterSubIndx ] ) || ! is_array( $listViewParams['filters'][ $filterIndexStr ][ $filterSubIndx ] ) ) {
								$listViewParams['filters'][ $filterIndexStr ][ $filterSubIndx ] = array();
							}
							$listViewParams['filters'][ $filterIndexStr ][ $filterSubIndx ][ $filterSubSubIndx ] = sanitize_text_field( $filterSubSub );

						}
					} elseif ( is_string( $filterSub ) ) {

						if ( ! isset( $listViewParams['filters'][ $filterIndexStr ] ) || ! is_array( $listViewParams['filters'][ $filterIndexStr ] ) ) {
							$listViewParams['filters'][ $filterIndexStr ] = array();
						}
							$listViewParams['filters'][ $filterIndexStr ][ $filterSubIndx ] = sanitize_text_field( $filterSub );

					}
				}
			} elseif ( is_string( $filter ) ) {

					// e.g. s = test
					$listViewParams['filters'][ $filterIndexStr ] = sanitize_text_field( $filter );

			}
		}
	}

		// / sanitising

	if ( isset( $listViewParams ) && gettype( $listViewParams ) == 'array' && isset( $listViewParams['listtype'] ) ) {

		// if it's not got columns, do this, for now.
		if ( ! isset( $listViewParams['columns'] ) || ! is_array( $listViewParams['columns'] ) ) {
			$listViewParams['columns'] = array();
		}

		global $zbs;

		// } check perms first
		if ( $listViewParams['listtype'] == 'customer' && ! zeroBSCRM_permsViewCustomers() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}
		if ( $listViewParams['listtype'] == 'company' && ! zeroBSCRM_permsViewCustomers() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}
		if ( $listViewParams['listtype'] == 'segment' && ! zeroBSCRM_permsViewCustomers() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}
		if ( $listViewParams['listtype'] == 'quote' && ! zeroBSCRM_permsViewQuotes() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}
		if ( $listViewParams['listtype'] == 'quotetemplate' && ! zeroBSCRM_permsViewQuotes() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}
		if ( $listViewParams['listtype'] == 'invoice' && ! zeroBSCRM_permsViewInvoices() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}
		if ( $listViewParams['listtype'] == 'transaction' && ! zeroBSCRM_permsViewTransactions() ) {
			zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
		}

		// } Check for screen options (perpage)
		$pageKey  = '';
		$per_page = 20;
		if ( isset( $listViewParams['pagekey'] ) && ! empty( $listViewParams['pagekey'] ) ) {

			// has a key, get screen opts
			$screenOpts = $zbs->global_screen_options( $listViewParams['pagekey'] ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
			if ( is_array( $screenOpts ) ) {

				if ( isset( $screenOpts['perpage'] ) ) {
					$per_page = (int) $screenOpts['perpage'];
				}
				// catch
				if ( $per_page < 1 ) {
					$per_page = 20;
				}
			}
		}

		// } generate a 'col list' quickly (for all type list views)
		$columnsRequired = array();
		foreach ( $listViewParams['columns'] as $col ) {
			$columnsRequired[] = $col['fieldstr'];
		}

		// default return, regardless of type (allows us to keep main generic)
		$res = array(
			'objects'     => array(),
			'objectcount' => -1,
			'paged'       => 1,
		);

		switch ( $listViewParams['listtype'] ) {

			/*
			==============================================================================
			===================== CUSTOMER ============================================== */

			// } Customer list view :)
			case 'customer':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number            = 0;
				$possibleSearchTerm     = '';
				$withQuotes             = false;
				$withTransactions       = false;
				$possibleCoID           = '';
				$possibleTagIDs         = '';
				$possibleQuickFilters   = '';
				$inArray                = '';
				$withTags               = false;
				$withAssigned           = false;
				$withCompany            = false;
				$latestLog              = false;
				$withValues             = false;
				$with_total_group_value = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Catch filters :)

					// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

					// } Tags
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL1:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// DAL2:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

					// } QuickFilters
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['quickfilters'] ) && is_array( $listViewParams['filters']['quickfilters'] ) ) {

					$possibleQuickFilters = array();
					foreach ( $listViewParams['filters']['quickfilters'] as $quickFilter ) {
						$possibleQuickFilters[] = $quickFilter;
					}
				}

					// if with total group value
				if ( $zbs->settings->get( 'show_totals_table' ) == 1 ) {

					$with_total_group_value = true;

				}

					// } Total val present?
				if ( in_array( 'totalvalue', $columnsRequired ) ) {

					$withValues = true;

				}
					// } Quote val present? // ONLY WORKS DAL3
				if ( in_array( 'quotesvalue', $columnsRequired ) ) {

					$withValues = true;

				}
					// } Invoices val present? // ONLY WORKS DAL3
				if ( in_array( 'invoicesvalue', $columnsRequired ) ) {

					$withValues = true;

				}
					// } trans val present? // ONLY WORKS DAL3
				if ( in_array( 'transactionsvalue', $columnsRequired ) ) {

					$withValues = true;

				}

					// } Tags
				if ( in_array( 'tagged', $columnsRequired ) ) {

					$withTags = true;

				}

					// } Quotes
				if ( in_array( 'hasquote', $columnsRequired ) || in_array( 'quotecount', $columnsRequired ) || in_array( 'quotetotal', $columnsRequired ) ) {

					$withQuotes = true;

				}

					// } Trans
				if ( in_array( 'hastransactions', $columnsRequired ) || in_array( 'transactioncount', $columnsRequired ) || in_array( 'transactiontotal', $columnsRequired ) ) {

					$withTransactions = true;

				}

					// } Assigned to
				if ( in_array( 'assigned', $columnsRequired ) ) {

					$withAssigned = true;

				}

					// } Company
				if ( in_array( 'company', $columnsRequired ) ) {

					$withCompany = true;

				}

					// } latest log

					// see if in notcontactedin (quickfilter)
					$hasQuickFilterForLogs = false;
				if ( is_array( $possibleQuickFilters ) && count( $possibleQuickFilters ) > 0 ) {
					foreach ( $possibleQuickFilters as $pqf ) {
						if ( str_starts_with( $pqf, 'notcontactedin' ) ) {
										$hasQuickFilterForLogs = true;
						}
					}
				}

				if ( in_array( 'latestlog', $columnsRequired ) || in_array( 'lastcontacted', $columnsRequired ) || $hasQuickFilterForLogs ) {

					$latestLog = true;

				}

					// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

					// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL2 - allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {
						$sortField = $possSortField;

						// ... though if id...
						if ( $sortField == 'zbsc_id' ) {
							$sortField = 'ID';
						}

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'nameavatar' ) {
							$sortField = 'fullname';
						}
						if ( $sortField == 'name' ) {
							$sortField = 'fullname';
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner';
						}
						if ( $sortField == 'post_id' ) {
							$sortField = 'ID';
						}
						if ( $sortField == 'post_title' ) {
							$sortField = 'zbsc_lname';
						}
						if ( $sortField == 'post_excerpt' ) {
							$sortField = 'zbsc_lname';
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

					// Retrieve data

					/* we need to prepend zbsc_ when not using cf */
					$custFields = $zbs->DAL->getActiveCustomFields( array( 'objtypeid' => ZBS_TYPE_CONTACT ) );

					// needs to check if field name is custom field:
					$sortIsCustomField = false;
				if ( is_array( $custFields ) && array_key_exists( $sortField, $custFields ) ) {
					$sortIsCustomField = true;
				}
				if ( ! $sortIsCustomField && $sortField != 'ID' ) {
					$sortField = 'zbsc_' . $sortField;
				}

					// catch empties
				if ( empty( $sortField ) ) {
					$sortField = 'ID';
				}
				if ( empty( $sortOrder ) ) {
					$sortOrder = 'desc';
				}

					// legacy from dal1
					$page_number = $page_number;
				if ( $page_number < 0 ) {
					$page_number = 0;
				}

					// make ARGS
					$args = array(

						'searchPhrase'     => $possibleSearchTerm,
						'inCompany'        => $possibleCoID,
						'inArr'            => $inArray,
						'quickFilters'     => $possibleQuickFilters,
						'isTagged'         => $possibleTagIDs,
						'ownedBy'          => false,

						'withCustomFields' => true,
						'withQuotes'       => $withQuotes,
						'withInvoices'     => false,
						'withTransactions' => $withTransactions,
						'withLogs'         => false,
						'withLastLog'      => $latestLog,
						'withTags'         => $withTags,
						'withOwner'        => $withAssigned,
						'withValues'       => $withValues,

						'sortByField'      => $sortField,
						'sortOrder'        => $sortOrder,
						'page'             => $page_number,
						'perPage'          => $per_page,

						'ignoreowner'      => zeroBSCRM_DAL2_ignoreOwnership( ZBS_TYPE_CONTACT ),

					);

					$customers = $zbs->DAL->contacts->getContacts( $args );

					$customers = jpcrm_inject_contacts( $customers, $args );

					// } If using pagination, also return total count
					if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

						// make count arguments
						$args = array(

							'searchPhrase' => $possibleSearchTerm,
							'inCompany'    => $possibleCoID,
							'inArr'        => $inArray,
							'quickFilters' => $possibleQuickFilters,
							'isTagged'     => $possibleTagIDs,

							// just count
							'count'        => true,

							'ignoreowner'  => zeroBSCRM_DAL2_ignoreOwnership( ZBS_TYPE_CONTACT ),

						);

						$res['objectcount'] = (int) $zbs->DAL->contacts->getContacts( $args );

					}

					// with total
					if ( $with_total_group_value ) {

						// redo call for total valuesS
						$args = array(

							'searchPhrase'  => $possibleSearchTerm,
							'inCompany'     => $possibleCoID,
							'inArr'         => $inArray,
							'quickFilters'  => $possibleQuickFilters,
							'isTagged'      => $possibleTagIDs,
							'ownedBy'       => false,
							'ignoreowner'   => zeroBSCRM_DAL2_ignoreOwnership( ZBS_TYPE_CONTACT ),

							'onlyObjTotals' => true,

						);

						$res['totals'] = $zbs->DAL->contacts->getContacts( $args );

					}

					// } Tidy

					// glob as used below. not pretty
					global $companyNameCache;
					$companyNameCache = array();

					if ( count( $customers ) > 0 ) {
						foreach ( $customers as $customer ) {
							// DAL3 now processes these in the OBJ class (starting to centralise properly.)
							$res['objects'][] = $zbs->DAL->contacts->listViewObj( $customer, $columnsRequired );
						}
					}
				break;

			/*
			=================== / CUSTOMER ===============================================
			============================================================================= */

			/*
			==============================================================================
			===================== COMPANY =============================================== */

			// } Company list view :) - ADDED BY MIKE
			case 'company':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number          = 0;
				$possibleSearchTerm   = '';
				$possibleTagIDs       = '';
				$possibleQuickFilters = '';
				$withTags             = false;
				$withAssigned         = false;
				$latestLog            = false;
				$withTransactions     = false;
				$withValues           = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Catch filters :)

					// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

					// } Tags
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL2:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// V3+:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

					// } QuickFilters
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['quickfilters'] ) && is_array( $listViewParams['filters']['quickfilters'] ) ) {

					$possibleQuickFilters = array();
					foreach ( $listViewParams['filters']['quickfilters'] as $quickFilter ) {
						$possibleQuickFilters[] = $quickFilter;
					}
				}

					// } Tags
				if ( in_array( 'tagged', $columnsRequired ) ) {

					$withTags = true;

				}

					// } Assigned to
				if ( in_array( 'assigned', $columnsRequired ) ) {

					$withAssigned = true;

				}

				if ( in_array( 'transactioncount', $columnsRequired ) ) {

					$withTransactions = true;

				}

					// } Total val present?
				if ( in_array( 'totalvalue', $columnsRequired ) ) {

					$withValues = true;

				}
					// } Quote val present?
				if ( in_array( 'quotesvalue', $columnsRequired ) ) {

					$withValues = true;

				}
					// } Invoices val present?
				if ( in_array( 'invoicesvalue', $columnsRequired ) ) {

					$withValues = true;

				}
					// } trans val present?
				if ( in_array( 'transactiontotal', $columnsRequired ) || in_array( 'transactionsvalue', $columnsRequired ) ) {

					$withValues = true;

				}

					// } latest log

					// see if in notcontactedin (quickfilter)
					$hasQuickFilterForLogs = false;
				if ( is_array( $possibleQuickFilters ) && count( $possibleQuickFilters ) > 0 ) {
					foreach ( $possibleQuickFilters as $pqf ) {
						if ( str_starts_with( $pqf, 'notcontactedin' ) ) {
										$hasQuickFilterForLogs = true;
						}
					}
				}

				if ( in_array( 'latestlog', $columnsRequired ) || in_array( 'lastcontacted', $columnsRequired ) || $hasQuickFilterForLogs ) {

					$latestLog = true;

				}

					// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

					// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {
						$sortField = $possSortField;

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'nameavatar' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'name' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner'; // TEMP
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}
				// phpcs:disable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				// make ARGS
				$args = array(
					'searchPhrase'     => $possibleSearchTerm,
					'isTagged'         => $possibleTagIDs,
					'quickFilters'     => $possibleQuickFilters,
					'withCustomFields' => true,
					'withInvoices'     => false,
					'withTransactions' => $withTransactions,
					'withLogs'         => false,
					'withLastLog'      => $latestLog,
					'withTags'         => $withTags,
					'withOwner'        => $withAssigned,
					'withValues'       => $withValues,
					'sortByField'      => $sortField,
					'sortOrder'        => $sortOrder,
					'page'             => $page_number,
					'perPage'          => $per_page,
					'ignoreowner'      => zeroBSCRM_DAL2_ignoreOwnership( ZBS_TYPE_COMPANY ),
				);

				$companies = $zbs->DAL->companies->getCompanies( $args ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

				// If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					// make count arguments
					$args               = array(
						'searchPhrase' => $possibleSearchTerm,
						'quickFilters' => $possibleQuickFilters,
						'isTagged'     => $possibleTagIDs,
						// just count
						'count'        => true,
						'ignoreowner'  => zeroBSCRM_DAL2_ignoreOwnership( ZBS_TYPE_COMPANY ),
					);
					$res['objectcount'] = (int) $zbs->DAL->companies->getCompanies( $args ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
				// phpcs:enable WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				}

					// } Tidy
				if ( count( $companies ) > 0 ) {
					foreach ( $companies as $company ) {

											// DAL3 now processes these in the OBJ class (starting to centralise properly.)
											$res['objects'][] = $zbs->DAL->companies->listViewObj( $company, $columnsRequired );

					}
				}
				break;

			/*
			=================== / COMPANY ===============================================
			============================================================================= */

			/*
			==============================================================================
			===================== QUOTE ================================================= */

			// } Quote List View
			case 'quote':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number          = 0;
				$possibleSearchTerm   = '';
				$possibleQuickFilters = '';
				$possibleTagIDs       = '';
				$inArray              = '';
				$withCustomer         = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Catch filters :)

					// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

					// } Tags
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL2:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// V3+:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

					// } QuickFilters
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['quickfilters'] ) && is_array( $listViewParams['filters']['quickfilters'] ) ) {

					$possibleQuickFilters = array();
					foreach ( $listViewParams['filters']['quickfilters'] as $quickFilter ) {
						$possibleQuickFilters[] = $quickFilter;
					}
				}

					// } Assigned to
				if ( in_array( 'customer', $columnsRequired ) ) {

					$withCustomer = true;

				}

					// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

					// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {

						$sortField = $possSortField;

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'nameavatar' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'name' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner'; // TEMP
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

					// } Retrieve data
					// $withFullDetails=false,$perPage=10,$page=0,$withCustomerDeets=false,$searchPhrase='',$inArray=array(),$sortByField='',$sortOrder='DESC',$quickFilters=array()
					$quotes = zeroBS_getQuotes( true, $per_page, $page_number, true, $possibleSearchTerm, $inArray, $sortField, $sortOrder, $possibleQuickFilters, $possibleTagIDs );

					// } If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					$res['objectcount'] = zeroBS_getQuotesCountIncParams( true, $per_page, $page_number, true, $possibleSearchTerm, $inArray, $sortField, $sortOrder, $possibleQuickFilters, $possibleTagIDs );

				}

					// } Tidy
				if ( count( $quotes ) > 0 ) {
					foreach ( $quotes as $quote ) {

											// DAL3 now processes these in the OBJ class (starting to centralise properly.)
											$res['objects'][] = $zbs->DAL->quotes->listViewObj( $quote, $columnsRequired );

					} // / foreach
				}
				break;

			/*
			=================== / QUOTE ==================================================
			============================================================================= */

			/*
			==============================================================================
			===================== INVOICE =============================================== */

			case 'invoice':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number          = 0;
				$possibleCoID         = '';
				$possibleQuickFilters = '';
				$possibleSearchTerm   = '';
				$possibleTagIDs       = '';
				$inArray              = '';
				$withCustomer         = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Filters

					// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

					// } Tags
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL2:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// V3+:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

					// } QuickFilters
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['quickfilters'] ) && is_array( $listViewParams['filters']['quickfilters'] ) ) {

					$possibleQuickFilters = array();
					foreach ( $listViewParams['filters']['quickfilters'] as $quickFilter ) {
						$possibleQuickFilters[] = $quickFilter;
					}
				}

					// } Assigned to
				if ( in_array( 'customer', $columnsRequired ) ) {

					$withCustomer = true;

				}

					// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

					// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {

						$sortField = $possSortField;

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'nameavatar' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'name' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner'; // TEMP
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

					// } Retrieve data
					// MS: $invoices = zeroBS_getInvoicesv2(true,$per_page,$page_number,true,$possibleSearchTerm,$possibleTagIDs,$inArray,$possibleQuickFilters);
					// WH: Moved back to original
					$invoices = zeroBS_getInvoices( true, $per_page, $page_number, $withCustomer, $possibleSearchTerm, $inArray, $sortField, $sortOrder, $possibleQuickFilters, $possibleTagIDs );

					// } If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					$res['objectcount'] = zeroBS_getInvoicesCountIncParams( true, $per_page, $page_number, $withCustomer, $possibleSearchTerm, $inArray, $sortField, $sortOrder, $possibleQuickFilters, $possibleTagIDs );

				}

					// } Tidy
				if ( count( $invoices ) > 0 ) {
					foreach ( $invoices as $invoice ) {

											// DAL3 now processes these in the OBJ class (starting to centralise properly.)
											$res['objects'][] = $zbs->DAL->invoices->listViewObj( $invoice, $columnsRequired );

					} // / foreach
				}
				break;

			/*
			=================== / INVOICE ================================================
			============================================================================= */

			/*
			==============================================================================
			===================== TRANSACTION =========================================== */

			// } Transaction list view :)
			case 'transaction':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number          = 0;
				$possibleSearchTerm   = '';
				$possibleCoID         = '';
				$possibleTagIDs       = '';
				$possibleQuickFilters = '';
				$inArray              = '';
				$withTags             = false;
				$withCustomer         = true;
				$latestLog            = false;
				$external_source_uid  = true;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Catch filters :)

					// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

					// } Tags
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL2:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// V3+:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

					// } QuickFilters
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['quickfilters'] ) && is_array( $listViewParams['filters']['quickfilters'] ) ) {

					$possibleQuickFilters = array();
					foreach ( $listViewParams['filters']['quickfilters'] as $quickFilter ) {
						$possibleQuickFilters[] = $quickFilter;
					}
				}

					// } Tags
				if ( in_array( 'tagged', $columnsRequired ) ) {

					$withTags = true;

				}

					// } Assigned to
				if ( in_array( 'customer', $columnsRequired ) ) {

					$withCustomer = true;

				}

					// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

					// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {

						$sortField = $possSortField;

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'nameavatar' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'name' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner'; // TEMP
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

					// Retrieve data
					$transactions = zeroBS_getTransactions( true, $per_page, $page_number, $withCustomer, $possibleSearchTerm, $possibleTagIDs, $inArray, $sortField, $sortOrder, $withTags, $possibleQuickFilters, $external_source_uid );

					// If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					$res['objectcount'] = zeroBS_getTransactionsCountIncParams( true, $per_page, $page_number, $withCustomer, $possibleSearchTerm, $possibleTagIDs, $inArray, $sortField, $sortOrder, $withTags, $possibleQuickFilters );

				}

					// Tidy
				if ( count( $transactions ) > 0 ) {
					foreach ( $transactions as $transaction ) {

											// DAL3 now processes these in the OBJ class (starting to centralise properly.)
											$res['objects'][] = $zbs->DAL->transactions->listViewObj( $transaction, $columnsRequired );

					} // / foreach
				}
				break;

			/*
			=================== / TRANSACTION ============================================
			============================================================================= */

			/*
			==============================================================================
			===================== FORM ================================================== */

			// } Form list view :) ADDED BY MS - WARY ABOUT WHAT TO COMMENT OUT HERE
			case 'form':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number          = 0;
				$possibleSearchTerm   = '';
				$withQuotes           = false;
				$withTransactions     = false;
				$possibleCoID         = '';
				$possibleTagIDs       = '';
				$possibleQuickFilters = '';
				$inArray              = '';
				$withTags             = false;
				$withAssigned         = false;
				$latestLog            = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

				// } Tags
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL2:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// V3+:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

				// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

				// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {

						$sortField = $possSortField;

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'nameavatar' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'name' ) {
							$sortField = 'fullname'; // TEMP
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner'; // TEMP
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

				// } Retrieve data
				// ($withFullDetails=false,$perPage=10,$page=0,$withQuotes=false,$searchPhrase='',$withTransactions=false,$argsOverride=false,$companyID=false, $hasTagIDs='', $inArr = '')

				// } Retrieve data
				// old
				// $withFullDetails=false,$perPage=10,$page=0,$withCustomerDeets=false, $possibleSearchTerm,$possibleTagIDs,$inArray,$possibleQuickFilters

				// new
				//

				$forms = zeroBS_getForms( false, $per_page, $page_number, $possibleSearchTerm, $inArray, $sortField, $sortOrder, $possibleQuickFilters, $possibleTagIDs );

				// } If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					$res['objectcount'] = zeroBS_getFormsCountIncParams( false, $per_page, $page_number, $possibleSearchTerm, $inArray, $sortField, $sortOrder, $possibleQuickFilters, $possibleTagIDs );

				}

				// } Tidy
				if ( count( $forms ) > 0 ) {
					foreach ( $forms as $form ) {

						// DAL3 now processes these in the OBJ class (starting to centralise properly.)
						$res['objects'][] = $zbs->DAL->forms->listViewObj( $form, $columnsRequired );

					} // / foreach
				}
				break;

			/*
			=================== / FORM ===================================================
			============================================================================= */

			/*
			==============================================================================
			===================== SEGMENT =============================================== */

			case 'segment':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number        = 0;
				$ownerID            = -99;
				$possibleSearchTerm = '';
				$withAudienceCount  = false;
				$inArray            = '';

				// } Sorting
				$sortField = 'ID';
				$sortOrder = 'DESC';

				// } Catch filters :)

					// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

					// } latest log
				if ( in_array( 'audiencecount', $columnsRequired ) ) {

					$withAudienceCount = true;

				}

					// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

					// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

						// } Actually these need translating for now..
					switch ( $possSortField ) {

						case 'id':
							$sortField = 'ID';

							break;

						case 'name':
							$sortField = 'zbsseg_name';

							break;

						case 'added':
							$sortField = 'zbsseg_created';

							break;

						// todo
						/*
							case 'audiencecount':


							$sortField = 'post_title';

							break;*/

						default:
							$sortField = '';

							break;

					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'DESC';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = strtoupper( $listViewParams['sortorder'] );
						}
					}
				}

					// } Retrieve data
					$segments = $zbs->DAL->segments->getSegments( $ownerID, $per_page, $page_number, false, $possibleSearchTerm, $inArray, $sortField, $sortOrder );

					// } If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {
					// phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase, WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
					$res['objectcount'] = (int) $zbs->DAL->segments->getSegmentsCountIncParams( $ownerID, $per_page, $page_number, false, $possibleSearchTerm, $inArray, $sortField, $sortOrder );

				}

					// } No need to tidy from our straight-from-db stuff
					// actually I do, to simplify ui

					/*
				MOVED THIS INTO DAL
					#} Tidy
					if (count($segments) > 0) foreach ($segments as $segment) {
					$resArr = array();
					$resArr['id'] = $segment->zbssegid;
					$resArr['created'] = $segment->zbsseg_created;
					$resArr['lastupdated'] = $segment->zbsseg_lastupdated;
					$resArr['lastcompiled'] = $segment->zbsseg_lastcompiled;
					$resArr['name'] = $segment->zbsseg_name;
					$res['objects'][] = $resArr;

					} */

					$res['objects'] = $segments;

				break;

			/*
			=================== / SEGMENT ================================================
			============================================================================= */

			/*
			==============================================================================
			===================== QUOTE TEMPLATE ======================================== */

			case 'quotetemplate':
				// } Build query
				// now got by screenopt above $per_page = 20;
				$page_number          = 0;
				$possibleSearchTerm   = '';
				$withQuotes           = false;
				$withTransactions     = false;
				$possibleCoID         = '';
				$possibleTagIDs       = '';
				$possibleQuickFilters = '';
				$inArray              = '';
				$withTags             = false;
				$withAssigned         = false;
				$latestLog            = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// } Search
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['s'] ) && ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

				// } Catch paging :)

				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}
					// $res['paged'] = $page_number;

				// } Catch sorting

				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {

						$sortField = $possSortField;

						// ... and this
						if ( $sortField == 'added' ) {
							$sortField = 'created';
						}
						if ( $sortField == 'assigned' ) {
							$sortField = 'zbs_owner';
						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

				// } Retrieve data
				$quote_templates = zeroBS_getQuoteTemplates( false, $per_page, $page_number, $possibleSearchTerm );// phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

				// } If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					$res['objectcount'] = zeroBS_getQuoteTemplatesCountIncParams( false, $per_page, $page_number, $possibleSearchTerm );

				}

				// } Tidy
				if ( count( $quote_templates ) > 0 ) {
					foreach ( $quote_templates as $quote_template ) {

						// DAL3 now processes these in the OBJ class (starting to centralise properly.)
						$res['objects'][] = $zbs->DAL->quotetemplates->listViewObj( $quote_template, $columnsRequired ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase, WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

					} // / foreach
				}

				break;

			/*
			=================== / QUOTE TEMPLATE =========================================
			============================================================================= */

			/*
			==============================================================================
			===================== TASK ================================================= */

			case 'event':
				// build query
				$page_number          = 0;
				$possibleSearchTerm   = '';
				$possibleTagIDs       = '';
				$possibleQuickFilters = array();
				$inArray              = '';
				$withTags             = false;
				$withAssigned         = false;

				// } Sorting
				$sortField = 'id';
				$sortOrder = 'desc';

				// Search
				if ( ! empty( $listViewParams['filters']['s'] ) ) {
					$possibleSearchTerm = $listViewParams['filters']['s'];
				}

				// Tags
				if ( ! empty( $listViewParams['filters']['tags'] ) && is_array( $listViewParams['filters']['tags'] ) ) {

					$possibleTagIDs = array();
					foreach ( $listViewParams['filters']['tags'] as $tagObj ) {

						// DAL2:
						if ( isset( $tagObj['term_id'] ) ) {
							$possibleTagIDs[] = $tagObj['term_id'];
						}
						// V3+:
						if ( isset( $tagObj['id'] ) ) {
							$possibleTagIDs[] = $tagObj['id'];
						}
					}
				}

				// QuickFilters
				if ( isset( $listViewParams['filters'] ) && isset( $listViewParams['filters']['quickfilters'] ) && is_array( $listViewParams['filters']['quickfilters'] ) ) {

					foreach ( $listViewParams['filters']['quickfilters'] as $quickFilter ) {
						$possibleQuickFilters[] = $quickFilter;
					}
				}

				// Catch paging :)
				if ( isset( $listViewParams['paged'] ) && ! empty( $listViewParams['paged'] ) ) {

					$possiblePage = (int) $listViewParams['paged'];
					if ( $possiblePage > 0 ) {

						// NVM! // it'll come in +1 (because this is zero-indexed, where as js is +1)
						$page_number = $possiblePage;
					}
				}

				// Catch sorting
				if ( isset( $listViewParams['sort'] ) && ! empty( $listViewParams['sort'] ) ) {

					$possSortField = $listViewParams['sort'];

					// DAL3: allow all fields for now :) (little interpretation needed)
					if ( ! empty( $possSortField ) && $possSortField != false && $possSortField != 'false' ) {

						$sortField = $possSortField;

						switch ( $sortField ) {

							case 'added':
								$sortField = 'created';
								break;
							case 'assigned':
								$sortField = 'zbs_owner';
								break;
							case 'status':
								$sortField = 'zbse_complete';
								break;
							case 'start':
							case 'end':
							case 'title':
							case 'desc':
								$sortField = 'zbse_' . $sortField;
								break;

						}
					}

					if ( ! empty( $sortField ) ) {

						$sortOrder = 'desc';
						if ( isset( $listViewParams['sortorder'] ) && ! empty( $listViewParams['sortorder'] ) ) {
							$sortOrder = $listViewParams['sortorder'];
						}
					}
				}

				// if ($page_number < 0) $page_number = 0;

				// make ARGS
				$args = array(

					'withAssigned' => true,
					'withOwner'    => true,

					'isTagged'     => $possibleTagIDs,

					'sortByField'  => $sortField,
					'sortOrder'    => $sortOrder,

					'page'         => $page_number,
					'perPage'      => $per_page,

					'ignoreowner'  => zeroBSCRM_DAL2_ignoreOwnership( ZBS_TYPE_TASK ),

				);

				// owner
				// if ($ownedByID > 0) $args['ownedBy'] = $ownedByID;

				// search term
				if ( ! empty( $possibleSearchTerm ) ) {
					$args['searchPhrase'] = $possibleSearchTerm;
				}

				// filters
				foreach ( $possibleQuickFilters as $quick_filter ) {

					switch ( $quick_filter ) {

						case 'status_incomplete':
							$args['isIncomplete'] = true;

							break;

						case 'status_completed':
							$args['isComplete'] = true;

							break;

						case 'next30':
							$args['datedAfter']  = time() - ( 60 * 60 ); // add an hour's leeway
							$args['datedBefore'] = strtotime( '1 month' );

							break;

						case 'last30':
							$args['datedAfter']  = strtotime( '-1 months' );
							$args['datedBefore'] = strtotime( '+1 days' );

							break;

						case 'next7':
							$args['datedAfter']  = time() - ( 60 * 60 ); // add an hour's leeway
							$args['datedBefore'] = strtotime( '+7 days' );

							break;

						case 'last7':
							$args['datedAfter']  = strtotime( '-7 days' );
							$args['datedBefore'] = strtotime( '+1 days' );

							break;

					}
				}

				$tasks = $zbs->DAL->events->getEvents( $args );

				// } If using pagination, also return total count
				if ( isset( $listViewParams['pagination'] ) && $listViewParams['pagination'] ) {

					// get count
					$args['count']   = true;
					$args['page']    = -1;
					$args['perPage'] = -1;

					$res['objectcount'] = $zbs->DAL->events->getEvents( $args );

				}

				// } Tidy
				if ( count( $tasks ) > 0 ) {
					foreach ( $tasks as $task ) {

						// DAL3 now processes these in the OBJ class (starting to centralise properly.)
						$res['objects'][] = $zbs->DAL->events->listViewObj( $task, $columnsRequired );

					} // / foreach
				}

				break;

			/*
			=================== / TASK ==================================================
			============================================================================= */

			// } Default = non hard typed listtype !
			default:
				// allow bolt-ins from extensions (mailcamps uses this)
				// funcs which fire here have to return internally, they can't rely on $res return
				do_action( 'zerobs_ajax_list_view_' . $listViewParams['listtype'], $listViewParams );

				// err really

				break;

		}
	}

		// debug $res = array(isset($listViewParams),gettype($listViewParams) == 'array',isset($listViewParams['listtype']));

		header( 'Content-Type: application/json' );
		echo json_encode( $res );
		exit( 0 );
}

	// } Enact some bulk action :)
	add_action( 'wp_ajax_enactListViewBulkAction', 'zeroBSCRM_AJAX_enactListViewBulkAction' );
function zeroBSCRM_AJAX_enactListViewBulkAction() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	global $zbs;

	// Get object type (string, not ID)
	$objtype = empty( $_POST['objtype'] ) ? '' : sanitize_text_field( $_POST['objtype'] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.MissingUnslash

	// Check perms for given object
	$has_perms = zeroBSCRM_permsObjType( $zbs->DAL->objTypeID( $objtype ) ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
	if ( ! $has_perms ) {
		$reply = array(
			'status'  => __( 'Forbidden', 'zero-bs-crm' ),
			'message' => __( 'You do not have permission to access this resource.', 'zero-bs-crm' ),
		);
		wp_send_json_error( $reply, 403 );
	}

	// ret
	$passBack = array();

		$actionstr = '';
	if ( isset( $_POST['actionstr'] ) ) {
		$actionstr = sanitize_text_field( $_POST['actionstr'] );
	}
		$idsToChange = zeroBSCRM_dataIO_postedArrayOfInts( $_POST['ids'] );

		// Check ID's legit
		$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
		foreach ( $idsToChange as $id ) {

			$intID = (int) $id;
			if ( $intID > 0 ) {
				$legitIDs[] = $intID;
			}
		}
		}

		// Any ID's to process?
		if ( count( $legitIDs ) > 0 ) {

			// Switch by type
			switch ( $objtype ) {

				case 'customer':
						// Actions:
					switch ( $actionstr ) {

						// delete customers
						case 'delete':
							// delete sub stuff?
							$leaveOrphans = true;

							if ( isset( $_POST['leaveorphans'] ) ) {
								if ( $_POST['leaveorphans'] == '0' ) {
									$leaveOrphans = false;
								}
							}

							// cycle through + delete (should have sanity checked via SWAL)
							$deleted = 0;
							foreach ( $legitIDs as $id ) {

								// delete all orphans
								zeroBS_deleteCustomer( $id, $leaveOrphans );
								++$deleted;

							}

							$passBack['deleted'] = $deleted;

							// } Return
							header( 'Content-Type: application/json' );
							echo json_encode( $passBack );
							exit( 0 );

							break;

						// change status
						case 'changestatus':
							$new_status = isset( $_POST['newstatus'] ) ? sanitize_text_field( $_POST['newstatus'] ) : '';
							$accepted   = 0;

							$valid_statuses = zeroBSCRM_getCustomerStatuses( true );

							// legit status?
							if ( in_array( $new_status, $valid_statuses ) ) {

								// cycle through + mark
								foreach ( $legitIDs as $id ) {

									// Update contact status
									$zbs->DAL->contacts->setContactStatus( $id, $new_status );

									++$accepted;
								}
							} else {
								zeroBSCRM_API_error( 'Invalid status!' );
							}

							$passBack['accepted'] = $accepted;

							// } Return
							header( 'Content-Type: application/json' );
							echo json_encode( $passBack );
							exit( 0 );

							break;

						// add tag(s) to customers
						case 'addtag':
							zeroBSCRM_bulkAction_enact_addTags( $legitIDs, ZBS_TYPE_CONTACT ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

							break;

						// remove tag(S) from customers
						case 'removetag':
							zeroBSCRM_bulkAction_enact_removeTags( $legitIDs, ZBS_TYPE_CONTACT ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

							break;

						// merge customers
						case 'merge':
							// merge which into which
							$dominant = false;
							if ( isset( $_POST['dominant'] ) && ! empty( $_POST['dominant'] ) ) {
								$dominant = (int) sanitize_text_field( $_POST['dominant'] );
							}
							$slave = false; if ( ! empty( $dominant ) ) {

								// discern slave (should only ever be 2 id's)
								foreach ( $legitIDs as $id ) {
									if ( $id != $dominant ) {
										$slave = $id;
									}
								}
							}

							if ( ! empty( $dominant ) && ! empty( $slave ) ) {

								$passBack['merged'] = zeroBSCRM_mergeCustomers( $dominant, $slave );

							} else {

								$passBack = false;

							}

							// } Return
							header( 'Content-Type: application/json' );
							echo json_encode( $passBack );
							exit( 0 );

							break;

					}

						// } Return - will be an error if here, really!?!? should be passsing headers as such.
						header( 'Content-Type: application/json' );
						echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'company':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete company
							case 'delete':
								// delete sub stuff?
								$leaveOrphans = true;

								if ( isset( $_POST['leaveorphans'] ) ) {
									if ( $_POST['leaveorphans'] == '0' ) {
										$leaveOrphans = false;
									}
								}

								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete all orphans
									zeroBS_deleteCompany( $id, $leaveOrphans );
									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// add tag(s) to company(s)
							case 'addtag':
								zeroBSCRM_bulkAction_enact_addTags( $legitIDs, ZBS_TYPE_COMPANY ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

							// remove tag(S) from company(s)
							case 'removetag':
								zeroBSCRM_bulkAction_enact_removeTags( $legitIDs, ZBS_TYPE_COMPANY ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'quote':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete quote
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete all orphans
									$zbs->DAL->quotes->deleteQuote(
										array(
											'id'          => $id,
											'saveOrphans' => true,
										)
									);

									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// mark accepted
							case 'markaccepted':
								// cycle through + mark
								$accepted = 0;
								foreach ( $legitIDs as $id ) {

									// } Update quote as accepted (should verify this worked...)
									zeroBS_markQuoteAccepted( $id, zeroBS_getCurrentUserUsername() );

									++$accepted;

								}

								$passBack['accepted'] = $accepted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// mark unaccepted
							case 'markunaccepted':
								// cycle through + mark
								$unaccepted = 0;
								foreach ( $legitIDs as $id ) {

									// } Update quote as unaccepted (should verify this worked...)
									zeroBS_markQuoteUnAccepted( $id );

									++$unaccepted;

								}

								$passBack['unaccepted'] = $unaccepted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// add tag(s) to quote(s)
							case 'addtag':
								zeroBSCRM_bulkAction_enact_addTags( $legitIDs, ZBS_TYPE_QUOTE ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

							// remove tag(S) from quote(s)
							case 'removetag':
								zeroBSCRM_bulkAction_enact_removeTags( $legitIDs, ZBS_TYPE_QUOTE ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'invoice':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete quote
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete all orphans
									$zbs->DAL->invoices->deleteInvoice(
										array(
											'id'          => $id,
											'saveOrphans' => false,
										)
									);

									++$deleted;
								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// change status
							case 'changestatus':
								$accepted = 0;

								// legit status?
								$statusStr = sanitize_text_field( $_POST['newstatus'] );
								if ( in_array( $statusStr, zeroBSCRM_getInvoicesStatuses() ) ) {

									// cycle through + mark
									foreach ( $legitIDs as $id ) {

										// } Update invoice status (should verify this worked...)
										zeroBS_updateInvoiceStatus( $id, $statusStr );

										++$accepted;

									}
								}

								$passBack['accepted'] = $accepted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// add tag(s) to invoice(s)
							case 'addtag':
								zeroBSCRM_bulkAction_enact_addTags( $legitIDs, ZBS_TYPE_INVOICE ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

							// remove tag(S) from invoice(s)
							case 'removetag':
								zeroBSCRM_bulkAction_enact_removeTags( $legitIDs, ZBS_TYPE_INVOICE ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'transaction':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete transaction(s)
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete all orphans
									$zbs->DAL->transactions->deleteTransaction(
										array(
											'id'          => $id,
											'saveOrphans' => true,
										)
									);

									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

							// add tag(s) to transaction(s)
							case 'addtag':
								zeroBSCRM_bulkAction_enact_addTags( $legitIDs, ZBS_TYPE_TRANSACTION ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

							// remove tag(S) from transaction(s)
							case 'removetag':
								zeroBSCRM_bulkAction_enact_removeTags( $legitIDs, ZBS_TYPE_TRANSACTION ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'form':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete quote
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete all orphans
									$zbs->DAL->forms->deleteForm(
										array(
											'id'          => $id,
											'saveOrphans' => true,
										)
									);

									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'segment':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete segments
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete
									$zbs->DAL->segments->deleteSegment( array( 'id' => $id ) );
									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'quotetemplate':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete segments
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete
									$zbs->DAL->quotetemplates->deleteQuotetemplate( array( 'id' => $id ) );
									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				case 'event':
					// check id's legit
					$legitIDs = array(); if ( is_array( $idsToChange ) && count( $idsToChange ) > 0 ) {
						foreach ( $idsToChange as $id ) {

												$intID = (int) $id;
							if ( $intID > 0 ) {
								$legitIDs[] = $intID;
							}
						}
					}

					if ( count( $legitIDs ) > 0 ) {

						// actions:
						switch ( $actionstr ) {

							// delete quote
							case 'delete':
								// cycle through + delete (should have sanity checked via SWAL)
								$deleted = 0;
								foreach ( $legitIDs as $id ) {

									// delete all orphans
									$zbs->DAL->events->deleteEvent(
										array(
											'id'          => $id,
											'saveOrphans' => true,
										)
									);

									++$deleted;

								}

								$passBack['deleted'] = $deleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

								break;

								// add tag(s) to transaction(s)
							case 'addtag':
								zeroBSCRM_bulkAction_enact_addTags( $legitIDs, ZBS_TYPE_TASK ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

								// remove tag(S) from transaction(s)
							case 'removetag':
								zeroBSCRM_bulkAction_enact_removeTags( $legitIDs, ZBS_TYPE_TASK ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

								break;

								// mark completed
							case 'markcomplete':
								// cycle through + mark
								$completed = 0;
								foreach ( $legitIDs as $id ) {

									// update task as completed
									$zbs->DAL->events->setEventCompleteness( $id, 1 );

									++$completed;

								}

								$passBack['completed'] = $completed;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

									break;

								// mark completed
							case 'markincomplete':
								// cycle through + mark
								$incompleted = 0;
								foreach ( $legitIDs as $id ) {

									// update task as completed
									$zbs->DAL->events->setEventCompleteness( $id, -1 );

									++$incompleted;

								}

								$passBack['incompleted'] = $incompleted;

								// } Return
								header( 'Content-Type: application/json' );
								echo json_encode( $passBack );
								exit( 0 );

									break;

						}
					} else {

						// NO IDS!

					}

					// } Return - will be an error if here, really!?!? should be passsing headers as such.
					header( 'Content-Type: application/json' );
					echo json_encode( $passBack );
					exit( 0 );

					break;

				default:
					// err really :o
					header( 'Content-Type: application/json' );
					exit( '[]' );

					break;

			}
		} else {

			// NO IDS!

		}

		exit( 0 );
}

	/**
	 * Adds tags to any object (for bulk action AJAX requests called in zeroBSCRM_AJAX_enactListViewBulkAction())
	 *
	 * @param int[] $obj_ids     Array of object ids.
	 * @param int   $obj_type_id Object type ID.
	 *
	 * @return void Outputs JSON and exits.
	 */
function zeroBSCRM_bulkAction_enact_addTags( $obj_ids = array(), $obj_type_id = -1 ) {

		global $zbs;

		// return
		$passBack = array();

		// retrieve tag (array of id's)
		$tagArr = zeroBSCRM_dataIO_postedArrayOfInts( $_POST['tags'] );
		$tagIDs = array();
	if ( is_array( $tagArr ) && count( $tagArr ) > 0 ) {
		foreach ( $tagArr as $t ) {

			$tInt = (int) $t;
			if ( $tInt > 0 ) {
				$tagIDs[] = $tInt;
			}
		}
	}

	if ( count( $tagIDs ) > 0 ) {

		// tags to add

			// cycle through + add tag
			$tagged = 0;
		foreach ( $obj_ids as $id ) {

			// pass as array of term ID's :)

			$zbs->DAL->addUpdateObjectTags(
				array(
					'objid'   => $id,
					'objtype' => $obj_type_id,
					'tagIDs'  => $tagIDs,
					'mode'    => 'append',
				)
			);

			// no checks.?
			++$tagged;

		}

			$passBack['tagged'] = $tagged;

			// This function outputs JSON and exits.
			zeroBSCRM_sendJSONSuccess( $passBack );

	} else {

		// no tags

	}

		// err
		zeroBSCRM_sendJSONError( -1 );
		exit( 0 );
}

	/**
	 * Remove tags from any object (for bulk action AJAX requests called in zeroBSCRM_AJAX_enactListViewBulkAction())
	 *
	 * @param int[] $obj_ids     Array of object ids.
	 * @param int   $obj_type_id Object type ID.
	 *
	 * @return void Outputs JSON and exits.
	 */
function zeroBSCRM_bulkAction_enact_removeTags( $obj_ids = array(), $obj_type_id = -1 ) {

		global $zbs;

		// return
		$passBack = array();

		// retrieve tag (array of id's)
		$tagArr = zeroBSCRM_dataIO_postedArrayOfInts( $_POST['tags'] );
		$tagIDs = array();
	if ( is_array( $tagArr ) && count( $tagArr ) > 0 ) {
		foreach ( $tagArr as $t ) {

			$tInt = (int) $t;
			if ( $tInt > 0 ) {
				$tagIDs[] = $tInt;
			}
		}
	}

	if ( count( $tagIDs ) > 0 ) {

		// tags to add

			// cycle through + remove tags
			$untagged = 0;
		foreach ( $obj_ids as $id ) {

			// pass as array of term ID's :)
			// https://codex.wordpress.org/Function_Reference/wp_remove_object_terms
			$zbs->DAL->addUpdateObjectTags(
				array(
					'objid'   => $id,
					'objtype' => $obj_type_id,
					'tagIDs'  => $tagIDs,
					'mode'    => 'remove',
				)
			);

			// no checks.?
			++$untagged;

		}

			$passBack['untagged'] = $untagged;

			// This function outputs JSON and exits.
			zeroBSCRM_sendJSONSuccess( $passBack );

	} else {

		// no tags

	}

		// err
		zeroBSCRM_sendJSONError( -1 );
		exit( 0 );
}

/*
======================================================
	/ Admin AJAX: List View (API STYLE)
====================================================== */

/*
======================================================
	Admin AJAX: Segments
====================================================== */

// } Preview a segment
add_action( 'wp_ajax_zbs_segment_previewsegment', 'zeroBSCRM_AJAX_previewSegment' );
function zeroBSCRM_AJAX_previewSegment() {

	// } Check nonce
	check_ajax_referer( 'zbs-ajax-nonce', 'sec' );

	// either way
	header( 'Content-Type: application/json' );

	if ( current_user_can( 'admin_zerobs_customers' ) ) {

		global $zbs;

		// sanitize?
		$segmentID = -1;
		if ( isset( $_POST['sID'] ) ) {
			$segmentID = (int) sanitize_text_field( $_POST['sID'] );
		}
		$segmentTitle = __( 'Untitled Segment', 'zero-bs-crm' );
		if ( isset( $_POST['sTitle'] ) ) {
			$segmentTitle = sanitize_text_field( $_POST['sTitle'] );
		}
		$segmentMatchType = 'all';
		if ( isset( $_POST['sMatchType'] ) ) {
			$segmentMatchType = sanitize_text_field( $_POST['sMatchType'] );
		}
		$segmentConditions = array();
		if ( isset( $_POST['sConditions'] ) ) {
			$segmentConditions = zeroBSCRM_segments_filterConditions( $_POST['sConditions'], false );
		}

		// optional 2.90+ can just pass id and this'll fill the conditions from saved
		if ( $segmentID > 0 && count( $segmentConditions ) == 0 ) {

			$potentialSegment = $zbs->DAL->segments->getSegment( $segmentID, true );
			if ( is_array( $potentialSegment ) && isset( $potentialSegment['id'] ) ) {
				$segment           = $potentialSegment;
				$segmentConditions = $segment['conditions'];
				$segmentMatchType  = $segment['matchtype'];
				$segmentTitle      = $segment['name'];
			}
		}

		try {

			// attempt to build a top 5 customer list + total count for segment
			$ret = $zbs->DAL->segments->previewSegment( $segmentConditions, $segmentMatchType );

		} catch ( Segment_Condition_Exception $exception ) {

			// We're missing the condition class for one or more of this segment's conditions.
			$zbs->DAL->segments->segment_error_condition_missing( $segmentID, $exception );

			// return error str
			$error_string = $exception->get_error_code();
			$status       = 500;
			if ( $error_string === 'segment_condition_produces_no_args' ) {
				$status = 400;
			}

			// return fail
			zeroBSCRM_sendJSONError(
				array(
					'count' => 0,
					'error' => $error_string,
				),
				$status
			);
			exit( 0 );

		}

		if ( is_array( $ret ) && isset( $ret['count'] ) ) {

			// return id / fail
			echo json_encode( $ret );
			exit( 0 );

		}
	}

	// empty handed
	echo json_encode( array( 'count' => 0 ) );
	exit( 0 );
}
// } Save a segment down (update or add)
add_action( 'wp_ajax_zbs_segment_savesegment', 'zeroBSCRM_AJAX_saveSegment' );
function zeroBSCRM_AJAX_saveSegment() {

	// } Check nonce
	check_ajax_referer( 'zbs-ajax-nonce', 'sec' );

	// either way
	header( 'Content-Type: application/json' );

	if ( current_user_can( 'admin_zerobs_customers' ) ) {

		global $zbs;

		// sanitize?
		$segmentID = -1;
		if ( isset( $_POST['sID'] ) ) {
			$segmentID = (int) sanitize_text_field( $_POST['sID'] );
		}
		$segmentTitle = __( 'Untitled Segment', 'zero-bs-crm' );
		if ( isset( $_POST['sTitle'] ) ) {
			$segmentTitle = sanitize_text_field( zeroBSCRM_textProcess( $_POST['sTitle'] ) );
		}
		$segmentMatchType = 'all';
		if ( isset( $_POST['sMatchType'] ) ) {
			$segmentMatchType = sanitize_text_field( $_POST['sMatchType'] );
		}
		$segmentConditions = array();
		if ( isset( $_POST['sConditions'] ) ) {
			$segmentConditions = zeroBSCRM_segments_filterConditions( $_POST['sConditions'] );
		}

		// nice and simple, push to DAL (empty template ID will get created, else updated)
		$segmentID = $zbs->DAL->segments->addUpdateSegment( $segmentID, -1, $segmentTitle, $segmentConditions, $segmentMatchType, true );

		if ( ! empty( $segmentID ) ) {

			// return id / fail
			echo json_encode( array( 'id' => $segmentID ) );
			exit( 0 );

		}
	}

	// empty handed
	exit( 0 );
}

/*
======================================================
	/ Admin AJAX: Segments
====================================================== */

/*
======================================================
	Admin AJAX: Top Menu
====================================================== */
// } This is our toggle full screen mode for users to be able to control whether the CRM is fullscreen or not.
add_action( 'wp_ajax_zbs_admin_top_menu_save', 'zeroBSCRM_admin_top_menu_save' );
function zeroBSCRM_admin_top_menu_save() {
	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce-topmenu', 'sec' );
	if ( zeroBSCRM_permsIsZBSUserOrAdmin() ) {
		// } current user
		$cid  = get_current_user_id();
		$hide = (int) sanitize_text_field( $_POST['hide'] );
		update_user_meta( $cid, 'zbs-hide-wp-menus', $hide );
	}
	wp_die();
}

/*
======================================================
	/ Admin AJAX: Top Menu
====================================================== */

/*
======================================================
	Admin AJAX: Tag Management
====================================================== */

add_action( 'wp_ajax_zbs_add_tag', 'zeroBSCRM_AJAX_addTag' );
function zeroBSCRM_AJAX_addTag() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	// } Permission
	if ( zeroBSCRM_permsIsZBSUserOrAdmin() ) {

		// } Get
		$objType = -1;
		if ( isset( $_POST['objtype'] ) && ! empty( $_POST['objtype'] ) ) {
			$objType = sanitize_text_field( $_POST['objtype'] );
		}
		$objTag = '';
		if ( isset( $_POST['tag'] ) && ! empty( $_POST['tag'] ) ) {
			$objTag = sanitize_text_field( $_POST['tag'] );
		}

		if ( empty( $objType ) ) {
			zeroBSCRM_sendJSONError( array( 'notag' => 1 ) );
			exit( 0 );
		}

		global $zbs;

		// this converts 'contact' => 1 and weeds out any wrongly-typed obj types
		$objTypeID = $zbs->DAL->objTypeID( $objType );

		if ( $objTypeID !== -1 && $objTypeID > 0 ) {

			// addtag to (OBJ) (WILL BE DAL2)
			$tagID = $zbs->DAL->addUpdateTag(
				array(

					'id'   => -1,

					// fields (directly)
					'data' => array(

						'objtype' => $objTypeID,
						'name'    => $objTag,
						// 'slug'            => '',
						// 'owner'           => -1

					),
				)
			);

			if ( ! empty( $tagID ) ) {

				// retrieve just-made slug
				$slug = $zbs->DAL->getTag(
					$tagID,
					array(
						'objtype'  => $objTypeID,
						'onlySlug' => true,
					)
				);

				zeroBSCRM_sendJSONSuccess(
					array(
						'id'   => $tagID,
						'slug' => $slug,
					)
				);
			}
		} // if objtype match

	}

	zeroBSCRM_sendJSONError( array( 'dataerr' => 1 ) );
	exit( 0 );
}

add_action( 'wp_ajax_zbs_delete_tag', 'zeroBSCRM_AJAX_deleteTag' );
function zeroBSCRM_AJAX_deleteTag() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	// } Permission
	if ( zeroBSCRM_permsIsZBSUserOrAdmin() ) {

		// } Get
		// $objType = -1; if (isset($_POST['objtype']) && !empty($_POST['objtype'])) $objType = (int)sanitize_text_field( $_POST['objtype'] );
		$objTagID = -1;
		if ( isset( $_POST['tagid'] ) && ! empty( $_POST['tagid'] ) ) {
			$objTagID = (int) sanitize_text_field( $_POST['tagid'] );
		}

		if ( empty( $objTagID ) ) {
			zeroBSCRM_sendJSONError( array( 'notag' => 1 ) );
			exit( 0 );
		}

		global $zbs;

		if ( $objTagID !== -1 && $objTagID > 0 ) {

			// addtag to (OBJ) (WILL BE DAL2)
			$res = $zbs->DAL->deleteTag(
				array(

					'id'          => $objTagID,
					'deleteLinks' => true,

				)
			);

			zeroBSCRM_sendJSONSuccess( array( 'res' => $res ) );

		} // if objtype match

	}

	zeroBSCRM_sendJSONError( array( 'dataerr' => 1 ) );
	exit( 0 );
}

// } Preview a tagged group
add_action( 'wp_ajax_zbs_tags_previewtagged', 'zeroBSCRM_AJAX_previewTagged' );
function zeroBSCRM_AJAX_previewTagged() {

	// } Check nonce
	check_ajax_referer( 'zbs-ajax-nonce', 'sec' );

	// either way
	header( 'Content-Type: application/json' );

	if ( current_user_can( 'admin_zerobs_customers' ) ) {

		global $zbs;

		// sanitize?
		$tagID = -1;
		if ( isset( $_POST['tagID'] ) ) {
			$tagID = (int) sanitize_text_field( $_POST['tagID'] );
		}
		$tagMatchType = 'hastag';
		if ( isset( $_POST['tagMatchType'] ) ) {
			$tagMatchType = sanitize_text_field( $_POST['tagMatchType'] );
		}

		// build quick search
		$contactArgs = array(
			'withCustomFields' => false, // not req
			'page'             => 0,
			'perPage'          => 5,
			'ignoreowner'      => true,
		);

		if ( $tagMatchType == 'hastag' ) {
			$contactArgs['isTagged'] = $tagID;
		}
		if ( $tagMatchType == 'nohastag' ) {
			$contactArgs['isNotTagged'] = $tagID;
		}

		// this is to get just the total count
		$countContactGetArgs            = $contactArgs;
		$countContactGetArgs['perPage'] = 100000;
		$countContactGetArgs['count']   = true;

		// attempt to build a top 5 customer list + total count for this
		$ret = array(
			// DEBUG
			// 'args' => $contactArgs, // TEMP - remove this
			'count' => $zbs->DAL->contacts->getContacts( $countContactGetArgs ),
			'list'  => $zbs->DAL->contacts->getContacts( $contactArgs ),
		);

		if ( is_array( $ret ) && isset( $ret['count'] ) ) {

			// return id / fail
			echo json_encode( $ret );
			exit( 0 );

		}
	}

	// empty handed
	echo json_encode( array( 'count' => 0 ) );
	exit( 0 );
}

/*
======================================================
	/ Admin AJAX: Tag Management
====================================================== */

/*
======================================================
	Admin AJAX: Screen options DAL2
====================================================== */

	// } Feedback
	add_action( 'wp_ajax_save_zbs_screen_options', 'zeroBSCRM_AJAX_saveScreenOptions' );
function zeroBSCRM_AJAX_saveScreenOptions() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	// } Check is logged in legit user
	if ( ! zeroBS_canUpdateScreenOptions() ) {
		zeroBSCRM_sendJSONError( array( 'err' => 'rights' ) );
	}

	global $zbs;

	// } This is the filtering model for all screenoptions :)
	$screenOptionsFilters = array(

		// order of metaboxes for 'normal' area of page
		'mb_normal'    => array(
			'filter' => FILTER_UNSAFE_RAW,
			'flags'  => FILTER_FORCE_ARRAY,
		),
		// order of metaboxes for 'side' area of page
		// e.g. 'key','key2'
		'mb_side'      => array(
			'filter' => FILTER_UNSAFE_RAW,
			'flags'  => FILTER_FORCE_ARRAY,
		),
		// list of hidden metaboxes
		// e.g. 'key','key2'
		'mb_hidden'    => array(
			'filter' => FILTER_UNSAFE_RAW,
			'flags'  => FILTER_FORCE_ARRAY,
		),
		// list of minimised metaboxes
		// e.g. 'key','key2'
		'mb_mini'      => array(
			'filter' => FILTER_UNSAFE_RAW,
			'flags'  => FILTER_FORCE_ARRAY,
		),

		// for now, this is a catchall :)
		'pageoptions'  => array(
			'filter' => FILTER_UNSAFE_RAW,
			'flags'  => FILTER_FORCE_ARRAY,
		),

		// selected table columns (currently just co view)
		'tablecolumns' => array(
			'filter' => FILTER_UNSAFE_RAW,
			'flags'  => FILTER_FORCE_ARRAY,
		),

		// perpage (only used for list pages, just an int)
		'perpage'      => FILTER_VALIDATE_INT,

	);

	$screenOpts = array();
	$pageKey    = '';
	if ( isset( $_POST['screenopts'] ) ) {

		// get
		$screenOpts = $_POST['screenopts'];

		// sanitize - http://php.net/manual/en/function.filter-var-array.php
		$screenOpts = filter_var_array( $screenOpts, $screenOptionsFilters );

		// Formerly this used FILTER_SANITIZE_STRING, which is now deprecated as it was fairly broken. This is basically equivalent.
		// @todo Replace this with something more correct.
		foreach ( $screenOpts as $k => $v ) {
			if ( isset( $screenOptionsFilters[ $k ]['filter'] ) && $screenOptionsFilters[ $k ]['filter'] === FILTER_UNSAFE_RAW && $v !== null ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase
				foreach ( $v as $k2 => $v2 ) {
					$screenOpts[$k][$k2] = strtr(
						strip_tags( $v2 ),
						array(
							"\0" => '',
							'"' => '&#34;',
							"'" => '&#39;',
							"<" => '',
						)
					);
				}
			}
		}
	}
	if ( isset( $_POST['pagekey'] ) ) {
		$pageKey = sanitize_text_field( $_POST['pagekey'] );
	}

	if ( ! empty( $pageKey ) ) {

		// } Brutally update
		$zbs->DAL->updateSetting( 'screenopts_' . $pageKey, $screenOpts ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase,WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

		zeroBSCRM_sendJSONSuccess( array( 'fini' => 1 ) );
		exit( 0 );

	}

	zeroBSCRM_sendJSONError( array( 'err' => 'pagekey' ) );
	exit( 0 );
}

/*
======================================================
	/ Admin AJAX: Screen options DAL2
====================================================== */

/*
======================================================
	Admin AJAX: Inline Editor
====================================================== */

	// } Save any inline-edits
	add_action( 'wp_ajax_zbs_list_save_inline_edit', 'zeroBSCRM_AJAX_listViewInlineEdit_save' );
function zeroBSCRM_AJAX_listViewInlineEdit_save() {

	// } Nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	global $zbs;

	// } Retrieve deets
	$listtype = sanitize_text_field( $_POST['listtype'] );
	$id       = (int) sanitize_text_field( $_POST['id'] );
	$field    = sanitize_text_field( $_POST['field'] );
	$v        = sanitize_text_field( $_POST['v'] );

	switch ( $listtype ) {

		case 'customer':
			// } Perms
			if ( ! zeroBSCRM_permsCustomers() ) {
				zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
			}

			// } check deets
			if ( $id > 0 && ! empty( $field ) ) {

				$success = false;
				switch ( $field ) {

					case 'status':
						$success = $zbs->DAL->contacts->setContactStatus( $id, $v );
						break;
					case 'assigned':
						$success = $zbs->DAL->contacts->setContactOwner( $id, $v );
						break;

				}

				if ( $success ) {
					zeroBSCRM_sendJSONSuccess( array( 'success' => 1 ) );
				}
			}

			break;

	}

	zeroBSCRM_sendJSONError( array( 'no-action-or-rights' => 1 ) );
}

/*
======================================================
	/ Admin AJAX: Inline Editor
====================================================== */

/*
======================================================
	ZBS Invoicing
	====================================================== */

// } AJAX Send Inv
add_action( 'wp_ajax_zbs_invoice_send_invoice', 'zbs_invoice_send_invoice' );
function zbs_invoice_send_invoice() {

	check_ajax_referer( 'inv-ajax-nonce', 'security' );

	$zbs_invID = -1;
	$em        = '';
	$r         = array();
	if ( isset( $_POST['id'] ) && ! empty( $_POST['id'] ) ) {
		$zbs_invID = (int) sanitize_text_field( $_POST['id'] );  // accepts the post ID
	}
	if ( isset( $_POST['em'] ) && ! empty( $_POST['em'] ) ) {
		$em = sanitize_text_field( $_POST['em'] );
	}

	// v3.0 changed var and added a few more:
	$attachAssignedDocs = false;
	$attachAsPDF        = false;
	if ( isset( $_POST['email'] ) && ! empty( $_POST['email'] ) ) {
		$em = sanitize_text_field( $_POST['email'] );
	}
	if ( isset( $_POST['attachassoc'] ) && $_POST['attachassoc'] == 1 ) {
		$attachAssignedDocs = true;
	}
	if ( isset( $_POST['attachpdf'] ) && $_POST['attachpdf'] == 1 ) {
		$attachAsPDF = true;
	}

	// validate the email
	if ( ! zeroBSCRM_validateEmail( $em ) ) {

		zeroBSCRM_sendJSONError( array( 'message' => __( 'Not valid', 'zero-bs-crm' ) ) );
		exit( 0 );

	}

	// } Check id + perms + em
	if ( $zbs_invID <= 0 || empty( $em ) || ! zeroBSCRM_permsInvoices() ) {

		zeroBSCRM_sendJSONError( array( 'message' => __( 'Not valid', 'zero-bs-crm' ) ) );
		exit( 0 );

	}

	$sent = zeroBSCRM_AJAX_sendInvoiceEmail_v3( $em, $zbs_invID, $attachAssignedDocs, $attachAsPDF );

	if ( $sent ) {

		// send result
		zeroBSCRM_sendJSONSuccess( array( 'message' => 'sent' ) );

	} else {

		// send err
		zeroBSCRM_sendJSONError( array( 'message' => __( 'not sent', 'zero-bs-crm' ) ) );

	}

	// whatever:
	exit( 0 );
}

// v3.0+ send email for an invoice
function zeroBSCRM_AJAX_sendInvoiceEmail_v3( $email = '', $invoiceID = -1, $attachAssignedDocs = false, $attachAsPDF = false ) {

	global $zbs;

	$biz_name  = zeroBSCRM_getSetting( 'businessname' );
	$biz_extra = zeroBSCRM_getSetting( 'businessextra' );

	// retrieve inv
	$invoice = $zbs->DAL->invoices->getInvoice(
		$invoiceID,
		array(
			// with what?
			'withLineItems'    => true,
			'withCustomFields' => true,
			'withTransactions' => true,
			'withAssigned'     => true,
			'withTags'         => true,
			'withOwner'        => true,
			'withFiles'        => true,

		)
	);

	// retrieve assoc records
	$contactID = -1;
	if ( is_array( $invoice ) && isset( $invoice['contact'] ) && is_array( $invoice['contact'] ) && count( $invoice['contact'] ) > 0 ) {
		$contactID = $invoice['contact'][0]['id'];
	}
	$companyID = -1;
	if ( is_array( $invoice ) && isset( $invoice['company'] ) && is_array( $invoice['company'] ) && count( $invoice['company'] ) > 0 ) {
		$companyID = $invoice['company'][0]['id'];
	}
	// now $contactID $cID =  get_post_meta($zbs_invID, 'zbs_customer_invoice_customer',true);

	// } check if the email is active..
	$active = zeroBSCRM_get_email_status( ZBSEMAIL_EMAILINVOICE );
	if ( zeroBSCRM_validateEmail( $email ) && $invoiceID > 0 && $active ) {

		// send welcome email (tracking will now be dealt with by zeroBSCRM_mailDelivery_sendMessage)

		// ==========================================================================================
		// =================================== MAIL SENDING =========================================

		// Attachments?
		$attachments = array();
		if ( $attachAssignedDocs ) {
			if ( isset( $invoice['files'] ) && is_array( $invoice['files'] ) && count( $invoice['files'] ) > 0 ) {

				// cycle through files + add as attachments
				// we pass as 2part array so they don't have their funky md5 prefixes..
				foreach ( $invoice['files'] as $invFile ) {

					$filename = basename( $invFile['file'] );
					// if in privatised system, ignore first hash in name
					if ( isset( $invFile['priv'] ) ) {

						$filename = substr( $filename, strpos( $filename, '-' ) + 1 );
					}

					$attachments[] = array( $invFile['file'], 'x' . $filename );

				}
			}
		}

		// Attach as PDF?
		if ( $attachAsPDF ) {

			// make pdf.

			// generate the PDF
			$pdf_path = jpcrm_invoice_generate_pdf( $invoiceID ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			if ( $pdf_path !== false ) {

				// attach inv
				$attachments[] = array( $pdf_path );

			}

			// NOTE: for security / hygiene, we delete this PDF after email is sent

		}

		// generate html
		$emailHTML = zeroBSCRM_invoice_generateNotificationHTML( $invoiceID, true );

			// build send array
			$mailArray = array(
				'toEmail'     => $email,
				'toName'      => '',
				'subject'     => zeroBSCRM_mailTemplate_getSubject( ZBSEMAIL_EMAILINVOICE ),
				'headers'     => zeroBSCRM_mailTemplate_getHeaders( ZBSEMAIL_EMAILINVOICE ),
				'body'        => $emailHTML,
				'textbody'    => '',
				'attachments' => $attachments,
				'options'     => array(
					'html' => 1,
				),
			);
			// track if contactID
			if ( $contactID > 0 ) {

				// senderWPID = -14 = new inv email to contact
				$mailArray['tracking'] = array(
					// tracking :D (auto-inserted pixel + saved in history db)
					'emailTypeID'     => ZBSEMAIL_EMAILINVOICE,
					'targetObjID'     => $contactID,
					'senderWPID'      => -14,
					'associatedObjID' => $invoiceID,
				);

			}
			// track if companyID
			if ( $companyID > 0 ) {

				// senderWPID = -16 = new inv email to contact
				$mailArray['tracking'] = array(
					// tracking :D (auto-inserted pixel + saved in history db)
					'emailTypeID'     => ZBSEMAIL_EMAILINVOICE,
					'targetObjID'     => $companyID,
					'senderWPID'      => -16,
					'associatedObjID' => $invoiceID,
				);

			}

			// DEBUG echo 'Sending:<pre>'; print_r($mailArray); echo '</pre>Result:';

			// Sends email, including tracking, via setting stored route out, (or default if none)
			// and logs trcking :)

			// discern del method
			$mailDeliveryMethod = zeroBSCRM_mailTemplate_getMailDelMethod( ZBSEMAIL_EMAILINVOICE );
			if ( ! isset( $mailDeliveryMethod ) || empty( $mailDeliveryMethod ) ) {
				$mailDeliveryMethod = -1;
			}

			// send
			$sent = zeroBSCRM_mailDelivery_sendMessage( $mailDeliveryMethod, $mailArray );

			// delete any gen'd pdf's
			if ( $attachAsPDF && $pdf_path !== false ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

				// delete the PDF file once it's been read (i.e. emailed)
				wp_delete_file( $pdf_path );

			}

			// =================================== / MAIL SENDING =======================================
			// ==========================================================================================

			// once the invoice is sent it will mark it as unpaid (automatically)
			// (if is draft)
			if ( isset( $invoice['status'] ) && $invoice['status'] === 'Draft' ) {

				$zbs->DAL->invoices->setInvoiceStatus( $invoiceID, 'Unpaid' ); // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase, WordPress.NamingConventions.ValidVariableName.VariableNotSnakeCase

			}

			return true;

	} else {

		// err
		return false;

	}
}

// } AJAX Send Inv
add_action( 'wp_ajax_zbs_invoice_send_statement', 'zeroBSCRM_AJAX_sendStatement' );
function zeroBSCRM_AJAX_sendStatement() {

	// } Check nonce
	check_ajax_referer( 'zbscrmjs-glob-ajax-nonce', 'sec' );  // nonce to bounce out if not from right page

	$cID = -1;
	$em  = '';
	$r   = array();
	if ( isset( $_POST['cid'] ) && ! empty( $_POST['cid'] ) ) {
		$cID = (int) sanitize_text_field( $_POST['cid'] );  // accepts the post ID
	}
	if ( isset( $_POST['em'] ) && ! empty( $_POST['em'] ) ) {
		$em = sanitize_text_field( $_POST['em'] );
	}

	// validate the email
	if ( ! zeroBSCRM_validateEmail( $em ) ) {

		$r['error'] = __( 'Not a valid email', 'zero-bs-crm' );
		zeroBSCRM_sendJSONError( $r );
		exit( 0 );

	} else {
		$email = $em;
	}

	// } Check id + perms + em
	if ( $cID <= 0 || empty( $email ) || ! zeroBSCRM_permsInvoices() ) {

		$r['error'] = '';
		zeroBSCRM_sendJSONError( $r );
		exit( 0 );

	}

	// ==== BUILD STATEMENT PDF

		// generates pdf file
		$statementPDFfilepath = zeroBSCRM_invoicing_generateStatementPDF( $cID, false );

		// check worked
	if ( ! file_exists( $statementPDFfilepath ) ) {

		$r['error'] = '';
		zeroBSCRM_sendJSONError( $r );
		exit( 0 );

	}

	// ==== SEND VIA EMAIL ATTACHMENT
	// ==========================================================================================
	// =================================== MAIL SENDING =========================================

	// Attachment
	$attachments = array(
		array( $statementPDFfilepath, __( 'statement', 'zero-bs-crm' ) . '.pdf' ),
	);

	// generate html
	$emailHTML = zeroBSCRM_statement_generateNotificationHTML( $cID, true );

		// build send array
		$mailArray = array(
			'toEmail'     => $email,
			'toName'      => '',
			'subject'     => zeroBSCRM_mailTemplate_getSubject( ZBSEMAIL_STATEMENT ),
			'headers'     => zeroBSCRM_mailTemplate_getHeaders( ZBSEMAIL_STATEMENT ),
			'body'        => $emailHTML,
			'textbody'    => '',
			'attachments' => $attachments,
			'options'     => array(
				'html' => 1,
			),
			'tracking'    => array(
				// tracking :D (auto-inserted pixel + saved in history db)
				'emailTypeID'     => ZBSEMAIL_STATEMENT,
				'targetObjID'     => $cID,
				'senderWPID'      => -15, // wh added -15 you have a statement sent to customer,
				'associatedObjID' => -1,
			),
		);

		// DEBUG echo 'Sending:<pre>'; print_r($mailArray); echo '</pre>Result:';

		// Sends email, including tracking, via setting stored route out, (or default if none)
		// and logs trcking :)

		// discern del method
		$mailDeliveryMethod = zeroBSCRM_mailTemplate_getMailDelMethod( ZBSEMAIL_STATEMENT );
		if ( ! isset( $mailDeliveryMethod ) || empty( $mailDeliveryMethod ) ) {
			$mailDeliveryMethod = -1;
		}

		// send
		$sent = zeroBSCRM_mailDelivery_sendMessage( $mailDeliveryMethod, $mailArray );

		// =================================== / MAIL SENDING =======================================
		// ==========================================================================================

		// DELETE statement
		// delete the PDF file once it's been read (i.e. sent)
		unlink( $statementPDFfilepath );

		$r['success'] = __( 'Sent', 'zero-bs-crm' );
		zeroBSCRM_sendJSONSuccess( $r );
		exit( 0 );
}

/*
replaced with zeroBSCRM_retrieve
function zbs_get_content($URL){
		//need to wrap this in if function exists...
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $URL);
		$data = curl_exec($ch);
		curl_close($ch);
		return $data;
} */

add_action( 'wp_ajax_zbs_invoice_mark_paid', 'zbs_invoice_mark_paid' );
function zbs_invoice_mark_paid() {

	// } get if poss
	$zbs_invID = -1;
	if ( isset( $_POST['id'] ) && ! empty( $_POST['id'] ) ) {
		$zbs_invID = (int) sanitize_text_field( $_POST['id'] );  // accepts the post ID
	}

	// } Check id + perms + em
	if ( $zbs_invID < 1 || ! zeroBSCRM_permsInvoices() ) {

		die( 0 );

	} else {

		// } Continue

		// once the invoice is sent it will mark it as unpaid (automatically)
		$zbs_inv_meta           = get_post_meta( $zbs_invID, 'zbs_customer_invoice_meta', true );
		$zbs_inv_meta['status'] = 'Paid';
		update_post_meta( $zbs_invID, 'zbs_customer_invoice_meta', $zbs_inv_meta );

		// all OK ....
		$r['message'] = 'All done OK';
		echo json_encode( $r );

	}

	die( 0 ); // exiting ... yarp..
}

// } and send test so they can test before actually sending the invoice
add_action( 'wp_ajax_zbs_invoice_send_test_invoice', 'zbs_invoice_send_test_invoice' );
function zbs_invoice_send_test_invoice() {

	check_ajax_referer( 'inv-ajax-nonce', 'security' );
	$zbs_invID = -1;
	$em        = '';
	$r         = array();

	if ( isset( $_POST['id'] ) && ! empty( $_POST['id'] ) ) {
		$zbs_invID = (int) sanitize_text_field( $_POST['id'] );  // accepts the post ID
	}
	if ( isset( $_POST['em'] ) && ! empty( $_POST['em'] ) ) {
		$em = sanitize_text_field( $_POST['em'] );
	}

	// debug
	$r['em'] = $em;
	// debug $r['id'] = $zbs_invID;

	// validate the email
	if ( ! zeroBSCRM_validateEmail( $em ) ) {
		$r['message'] = 'Not a valid email';
		echo json_encode( $r );
		die( 0 );
	} else {
		$email = $em;
	}

	// } Check id + perms + em
	if ( $zbs_invID <= 0 || empty( $em ) || ! zeroBSCRM_permsInvoices() ) {
		die( 0 );
	}

	$body = zeroBSCRM_invoice_generateNotificationHTML( $zbs_invID, true );

	$biz_name  = zeroBSCRM_getSetting( 'businessname' );
	$biz_extra = zeroBSCRM_getSetting( 'businessextra' );

	$subject     = '[Test Email] You have received an invoice';
	$headers     = array( 'Content-Type: text/html; charset=UTF-8' );
	$attachments = array();

	/*
	WH did unbeknownst, seperately //invoice attachments (actually called invoices but these now can be things like toggl timesheet reports(?) or T&Cs....
	$zbsCustomerInvoices = get_post_meta($zbs_invID, 'zbs_customer_invoices', true);
	foreach($zbsCustomerInvoices as $invoice){
		$attachments[] = $invoice['file'];
	}
	*/
		// Attachments?
		$attachments        = array();
		$zbsSendAttachments = get_post_meta( $zbs_invID, 'zbs_inv_sendattachments', true );
	if ( $zbsSendAttachments == '1' ) {
		$invFiles = get_post_meta( $zbs_invID, 'zbs_customer_invoices', true );
		if ( is_array( $invFiles ) && count( $invFiles ) > 0 ) {

			// cycle through files + add as attachments
			// we pass as 2part array so they don't have their funky md5 prefixes..
			foreach ( $invFiles as $invFile ) {

				$filename = basename( $invFile['file'] );
				// if in privatised system, ignore first hash in name
				if ( isset( $invFile['priv'] ) ) {

					$filename = substr( $filename, strpos( $filename, '-' ) + 1 );
				}

				$attachments[] = array( $invFile['file'], $filename );

			}
		}
	}

	// ah.. still uses WP mail - but this should still be sending.
	// wp_mail( $email, $subject, $body, $headers, $attachments );

	/* new HTML send - to code up with actual invoice html (i.e. replace the body, properly) */

	// $html = zeroBSCRM_mailTemplate_emailPreview($emailtab);

	/*
	old way


	wp_mail( $test_email, $subject, $html, $headers );

	*/

	// discern del method
	$mailDeliveryMethod = zeroBSCRM_mailTemplate_getMailDelMethod( ZBSEMAIL_EMAILINVOICE );
	if ( ! isset( $mailDeliveryMethod ) || empty( $mailDeliveryMethod ) ) {
		$mailDeliveryMethod = -1;
	}

	// build send array
	$mailArray = array(
		'toEmail'     => $email,
		'toName'      => '',
		'subject'     => $subject,
		'headers'     => $headers,
		'body'        => $body,
		'textbody'    => '',
		'attachments' => $attachments,
		'options'     => array(
			'html' => 1,
		),
	);

	// Sends email
	$sent = zeroBSCRM_mailDelivery_sendMessage( $mailDeliveryMethod, $mailArray );

	// sends the invoice via wp_mail (for now)...
	$r['message'] = 'All done OK';
	echo json_encode( $r );
	die( 0 ); // exiting ... yarp..
}

/*
Not req.
function my_custom_email_content_type() {
	return 'text/html';
}
*/

// } We need to set the from email (mail campaigns may do this too?)
// } REMOVED - THESE FILTERS CHANGE IT FOR EVERYTHING. BEST DONE VIA THE HEADERS passed to wp_mail..
/*
add_filter( 'wp_mail_from', 'zbs_wp_mail_from' );
function zbs_wp_mail_from( $original_email_address ) {
	$f = zeroBSCRM_getSetting('invfromemail');
	if($f == ''){
	return $original_email_address;
	}else{
	return $f;
	}
}

add_filter( 'wp_mail_from_name', 'zbs_wp_mail_from_name' );
function zbs_wp_mail_from_name( $original_email_from ) {
		$n = zeroBSCRM_getSetting('invfromname');
		if($n == ''){
			return $original_email_from;
		}else{
			return $n;
	}
}
*/
	add_action( 'wp_ajax_zbs_get_invoice_data', 'zeroBSCRM_AJAX_getInvoice' );
function zeroBSCRM_AJAX_getInvoice() {

	// check nonce
	check_ajax_referer( 'zbscrmjs-ajax-nonce', 'sec' );

	// check perms
	if ( ! zeroBSCRM_permsIsZBSUser() ) {
			zeroBSCRM_sendJSONError();
			exit( 0 );
	}

		// build + return
		$invID = -1;
	if ( isset( $_POST['invid'] ) ) {
		$invID = (int) $_POST['invid'];
	}

	if ( $invID > 0 ) {

		// retrieve ID
		$invID = (int) sanitize_text_field( $_POST['invid'] );

		// retrieve obj to return
		$data = zeroBSCRM_invoicing_getInvoiceData( $invID );

		// pass back in json
		zeroBSCRM_sendJSONSuccess( $data );
		exit( 0 );

	} else {

		// pass -1 if it is a new invoice (vs edit invoice)
		// defaults (invoice_id) will be the next available ID?
		// WH how do we handle the "New" creation want it to return defaults
		// but if a new invoice, the $objID will be -1?
		// WP makes and 'auto-draft' and gets that postID
		// so if 2 people make an invoice at once, it won't use the same ID.
		// probably need to consider this and race conditions on save or smt?
		// WH Notes: Agreed, for now just rolling this in, to discuss, (perhaps v3.1?)

		// build default
		$data = array();

		$data['invoiceObj']   = zeroBSCRM_get_invoice_defaults( -1 );
		$data['tax_linesObj'] = zeroBSCRM_taxRates_getTaxTableArr();

		// pass back in json
		zeroBSCRM_sendJSONSuccess( $data );
		exit( 0 );

	}

		// exit json
		zeroBSCRM_sendJSONError( array( 'here' ) );
		exit( 0 );
}

/*
======================================================
	/ ZBS Invoicing
	====================================================== */

/*
======================================================
	Admin AJAX: Tasks
====================================================== */

add_action( 'wp_ajax_mark_task_complete', 'zeroBSCRM_ajax_mark_task_complete' );
function zeroBSCRM_ajax_mark_task_complete() {

	check_ajax_referer( 'zbscrmjs-glob-ajax-nonce', 'sec' );

	if ( ! zeroBSCRM_perms_tasks() ) {
		wp_send_json_error( array( 'permission_error' => 1 ), 403 );
	}

	global $zbs;

	if ( isset( $_POST['status'] ) && isset( $_POST['taskID'] ) ) {

		$status  = (int) $_POST['status'];
		$task_id = (int) $_POST['taskID'];

		if ( $zbs->DAL->events->setEventCompleteness( $task_id, $status ) ) { // phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase

			wp_send_json_success(
				array(
					'task_id' => $task_id,
					'status'  => $status,
				)
			);
		}
	}

	wp_send_json_error( array( 'params_error' => 1 ), 400 );
}

/*
======================================================
	/ Admin AJAX: Tasks
====================================================== */

	// sends a proper error response
function zeroBSCRM_sendJSONError( $errObj = '', $status_code = 500 ) {
	wp_send_json_error( $errObj, $status_code );
}

function zeroBSCRM_sendJSONSuccess( $successObj = '' ) {

	header( 'Content-Type: application/json' );
	echo json_encode( $successObj, true );
	exit( 0 );
}
