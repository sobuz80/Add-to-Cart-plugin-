<?php

namespace ConditionalAddToCart;

use ConditionalAddToCart\Core\Utility\Condition as ConditionUtility;
use ConditionalAddToCart\Core\Utility\Hook;
use ConditionalAddToCart\Core\Utility\Settings;

class Front {

	/**
	 *
	 * Front instance.
	 *
	 * @var \ConditionalAddToCart\Front $instance
	 */
	protected static $instance = null;

	/**
	 * Return front instance.
	 * @return \ConditionalAddToCart\Front
	 */
	public static function instance() {
		if ( static::$instance === null ) {
			static::$instance = new Front;
		}

		return static::$instance;
	}

	/**
	 * Front logic.
	 */
	function run() {
		$this->defineHooks();
	}

	function is_frontend_ajax(){
		if(!defined('DOING_AJAX') || ! DOING_AJAX){
			return false;
		}

		$referer = wp_get_referer();
		
		if( !$referer ){
				return false;
		}

		return strpos($referer, '/wp-admin/') === false;

	}
	function is_frontend(){

		// Allow frontend ajax requests.
		if($this->is_frontend_ajax()){
			return true;
		}


		// Disallow dashboard.
		if( is_admin() ){
			return false;
		}
		
		return true;
	}
	function defineHooks() {

		if( ! $this->is_frontend() ){
				return;
		}
		if (! (bool) Settings::get( 'enable' ) ) {
				return;
		}
		
		add_action( 'woocommerce_before_shop_loop_item', [ $this, 'applyConditions' ]);
		add_action( 'wp', [ $this, 'applyConditions' ]);
	}

	function applyConditions() {
		if ( ! ConditionUtility::match() ) {
			remove_filter( 'woocommerce_product_single_add_to_cart_text', [$this, 'changeAddToCartButtonText']);
			remove_filter( 'woocommerce_product_add_to_cart_text', [$this, 'changeAddToCartButtonText'] );
			Hook::restoreCallback(['woocommerce_template_loop_add_to_cart','woocommerce_template_single_add_to_cart']);
		}
	else{
	 $actionKey = Settings::get( 'actions.truthy.key' );
		switch ($actionKey) {
			case 'hide':
				Hook::replaceCallback(['woocommerce_template_loop_add_to_cart', 'woocommerce_template_single_add_to_cart']);
				break;
			case 'customize':
				// product single
				add_filter( 'woocommerce_product_single_add_to_cart_text', [$this, 'changeAddToCartButtonText']);
				// loop
				add_filter( 'woocommerce_product_add_to_cart_text', [$this, 'changeAddToCartButtonText'] );
				break;
			case 'replace':
				Hook::replaceCallback(['woocommerce_template_loop_add_to_cart', 'woocommerce_template_single_add_to_cart'], [$this, 'replaceAddToCartButton']);
				break;
	}
}
	}

	function changeAddToCartButtonText(){
		$actions = Settings::get( 'actions.truthy.value' );
		return __( $actions[ 'customize' ], 'conditional-add-to-cart' );
	}

	function replaceAddToCartButton(){
		$actions = Settings::get( 'actions.truthy.value' );
		echo do_shortcode( $actions[ 'replace' ] );
	}

}
