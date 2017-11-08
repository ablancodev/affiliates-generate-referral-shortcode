<?php
/*
 Plugin Name: Affiliates Generate Referral Shortcode
 Plugin URI: http://www.eggemplo.com
 Description: Generates a referral if an user visits a page where the shortcode is, and if an affiliate cookie exists.
 Author: eggemplo
 Version: 1.0
 Author URI: http://www.eggemplo.com
 */
add_shortcode('affiliates-generate-referral', 'affiliates_generate_referral');

function affiliates_generate_referral( $attr = array() ) {
	global $affiliates_db;

	$post_id  = get_the_ID();

	$amount   = isset( $attr['amount'] ) ? $attr['amount'] : 0;
	$currency = isset( $attr['currency'] ) ? $attr['currency'] : 'USD';
	$description = isset( $attr['description'] ) ? esc_html( $attr['description'] ) : sprintf( 'Post #%s', $post_id );

	$data = array(
			'order_id' => array(
					'title' => 'Post #',
					'domain' => 'affiliates',
					'value' => esc_sql( $post_id )
			),
			'order_total' => array(
					'title' => 'Total',
					'domain' =>  'affiliates',
					'value' => esc_sql( $amount )
			),
			'order_currency' => array(
					'title' => 'Currency',
					'domain' =>  'affiliates',
					'value' => esc_sql( $currency )
			),
			'date_time' => array(
					'title'  => 'Created on',
					'domain' => 'affiliates',
					'value'  => esc_html( date("Y-m-d H:i:s") )
			)
	);
	
	$r = new Affiliates_Referral_WordPress();
	$r->evaluate( $post_id, $description, $data, null, $amount, $currency, null, 'visit' );
}
