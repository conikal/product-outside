<?php
/**
 * Plugin Name: Product Outside
 * Plugin URI: https://www.conikal.com/product-outside
 * Description: Display products from another site via Woocommerce REST API
 * Version: 1.0.8
 * Author: Conikal
 * Author URI: https://www.conikal.com/
 * Text Domain: product-outside

 * Domain Path: /languages/
 *
 * @package Product Outside
 */

if ( ! defined( 'PDO_PLUGIN_FILE' ) ) {
	define( 'PDO_PLUGIN_FILE', __FILE__ );
}

// Check PUC Update Checker is exist or not and include core file
if ( !class_exists( 'Puc_v4_Factory' ) && file_exists( PDO_PLUGIN_FILE . '/libs/update-checker/plugin-update-checker.php' ) ) {
    require_once PDO_PLUGIN_FILE . '/libs/update-checker/plugin-update-checker.php';
}

/**
 * Check latest version of plugin on Github and notice update plugin for customers
 *
 * @since Product Outside 1.0.0
 */
if ( class_exists( 'Puc_v4_Factory' ) ) :
    $github_token = 'c509e757852e1bf1dbbf8f133fed01c7228467ab';

    $CampoalTapoUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
        'https://github.com/conikal/product-outside/',
        __FILE__,
        'product-outside'
    );

    //Optional: If you're using a private repository, specify the access token like this:
    $CampoalTapoUpdateChecker->setAuthentication($github_token);

    //Optional: Set the branch that contains the stable release.
    $CampoalTapoUpdateChecker->setBranch('master');

    // use release assets
    $CampoalTapoUpdateChecker->getVcsApi()->enableReleaseAssets();
endif;

// Load text domain
add_action( 'plugins_loaded', 'conikal_pdo_load_plugin_textdomain' );
function conikal_pdo_load_plugin_textdomain() {
    load_plugin_textdomain( 'product-outside', false, dirname( PDO_PLUGIN_FILE ) . '/languages' );
}

require_once dirname( PDO_PLUGIN_FILE ) . '/inc/settings.php';
require_once dirname( PDO_PLUGIN_FILE ) . '/inc/column.php'; 
require_once dirname( PDO_PLUGIN_FILE ) . '/vendor/autoload.php';
require_once dirname( PDO_PLUGIN_FILE ) . '/shortcodes/products.php';
require_once dirname( PDO_PLUGIN_FILE ) . '/inc/register_widgets.php';
use Automattic\WooCommerce\Client;

if (!function_exists('conikal_woocommerce_api')) :
    function conikal_woocommerce_api() {
        $site_url = get_option( 'conikal_pdo_url_option' );
    	$consumer_key = get_option( 'conikal_pdo_ck_option' );
    	$consumer_secret = get_option( 'conikal_pdo_cs_option' );
    	$version = get_option( 'conikal_pdo_ver_option', 'v3' );

        if ($site_url && $consumer_key && $consumer_secret) {
            $woocommerce = new Client(
                $site_url, 
                $consumer_key,
                $consumer_secret,
                [
                    'version' => 'wc/v3',
                ]
            );

            return $woocommerce;
        } else {
            return false;
        }
    }
endif;


/**
 * Proper way to enqueue scripts and styles
 *
 * @since Product Outside 1.0.0
 */
function conikal_product_outside_styles() {
    wp_enqueue_style( 'product-outside-style', plugins_url( '/css/style.css', PDO_PLUGIN_FILE ) );
    wp_enqueue_script('product-outside', plugins_url( '/js/product-outside.js', PDO_PLUGIN_FILE), array('jquery'), '1.0.0', true);

    if (is_rtl()) {
        $tooltip_position = 'right';
    } else {
        $tooltip_position = 'left';
    }

    $product_outside_vars = array(
        'admin_url' => esc_url(get_admin_url()),
        'add_to_cart' => esc_html__('Add to Cart', 'product-outside'),
        'tooltip_position' => $tooltip_position,
    );
    wp_localize_script('product-outside', 'product_outside_vars', $product_outside_vars);

}
add_action( 'wp_enqueue_scripts', 'conikal_product_outside_styles' );


/**
 * Register Shortcodes
 *
 * @since Product Outside 1.0.0
 */
if( !function_exists('conikal_pdo_register_shortcodes') ): 
    function conikal_pdo_register_shortcodes() {
        add_shortcode('product_outside', 'conikal_pdo_products_shortcode');
    }
endif;
add_action('init', 'conikal_pdo_register_shortcodes');


/**
 * Get products
 *
 * @since Product Outside 1.0.0
 */
if (!function_exists('conikal_get_products')) :
    function conikal_get_products() {
        check_ajax_referer('product_outside_ajax_nonce', 'security');

        $args = isset($_POST['args']) ? $_POST['args'] : '';

        $woocommerce    = conikal_woocommerce_api();
        $products       = $woocommerce->get('products', $args);
        $system_status  = $woocommerce->get('system_status');
        $price_args     = conikal_pdo_price_settings($system_status);

        foreach ($products as $id => $product) {
            $product->price = conikal_pdo_price($product->price, $price_args);
        }

        if ($products) {
            echo json_encode(
                array(
                    'status' => true,
                    'message' => esc_html__('Products loaded successfully!', 'product-outside'),
                    'products' => $products,
                )
            );
        } else {
            echo json_encode(
                array(
                    'status' => false,
                    'message' => esc_html__('Not founded products.', 'product-outside'),
                )
            );
        }
        exit();
        die();
    }
    add_action( 'wp_ajax_nopriv_conikal_get_products', 'conikal_get_products' );
    add_action( 'wp_ajax_conikal_get_products', 'conikal_get_products' );
endif;


/**
 * Price settings arugments
 *
 * @since Product Outside 1.0.0
 */
if (!function_exists('conikal_pdo_price_settings')) :
    function conikal_pdo_price_settings($system_status) {
        $price_args = array(
            'ex_tax_label'       => false,
            'currency_symbol'    => $system_status->settings->currency_symbol,
            'currency'           => $system_status->settings->currency,
            'decimal_separator'  => $system_status->settings->decimal_separator,
            'thousand_separator' => $system_status->settings->thousand_separator,
            'decimals'           => $system_status->settings->number_of_decimals,
            'price_format'       => conikal_pdo_price_format($system_status->settings->currency_position),
        );

        return $price_args;
    }
endif;


/**
 * Format product price
 *
 * @since Product Outside 1.0.0
 */
if (!function_exists('conikal_pdo_price')) :
    function conikal_pdo_price( $price, $args = array() ) {
        $unformatted_price = $price;
        $negative          = $price < 0;
        $price             = apply_filters( 'raw_woocommerce_price', floatval( $negative ? $price * -1 : $price ) );
        $price             = apply_filters( 'formatted_woocommerce_price', number_format( $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] ), $price, $args['decimals'], $args['decimal_separator'], $args['thousand_separator'] );

        if ( apply_filters( 'woocommerce_price_trim_zeros', false ) && $args['decimals'] > 0 ) {
            $price = wc_trim_zeros( $price );
        }

        $formatted_price = ( $negative ? '-' : '' ) . sprintf( $args['price_format'], '<span class="woocommerce-Price-currencySymbol">' . $args['currency_symbol'] . '</span>', $price );
        $return          = '<span class="woocommerce-Price-amount amount">' . $formatted_price . '</span>';

        if ( $args['ex_tax_label'] ) {
            $return .= ' <small class="woocommerce-Price-taxLabel tax_label">' . WC()->countries->ex_tax_or_vat() . '</small>';
        }

        /**
         * Filters the string of price markup.
         *
         * @param string $return            Price HTML markup.
         * @param string $price             Formatted price.
         * @param array  $args              Pass on the args.
         * @param float  $unformatted_price Price as float to allow plugins custom formatting. Since 3.2.0.
         */
        return apply_filters( 'wc_price', $return, $price, $args, $unformatted_price );
    }
endif;


/**
 * Position currency symbol price
 *
 * @return string
 */
if (!function_exists('conikal_pdo_price_format')) :
    function conikal_pdo_price_format($currency_pos) {
        $format       = '%1$s%2$s';

        switch ( $currency_pos ) {
            case 'left':
                $format = '%1$s%2$s';
                break;
            case 'right':
                $format = '%2$s%1$s';
                break;
            case 'left_space':
                $format = '%1$s&nbsp;%2$s';
                break;
            case 'right_space':
                $format = '%2$s&nbsp;%1$s';
                break;
        }

        return apply_filters( 'woocommerce_price_format', $format, $currency_pos );
    }
endif;


/**
 * Position currency symbol price
 *
 * @return string
 */
if (!function_exists('conikal_category_selection')) :
    function conikal_category_selection() {
        if (is_admin()) {
            $woocommerce    = conikal_woocommerce_api();
            if ($woocommerce) {
                $categories     = $woocommerce->get('products/categories', array(
                    'page' => 1,
                    'per_page' => 100,
                ));

                $category_seclection['All Category'] = 'all';
                foreach ($categories as $key => $category) {
                    $category_seclection[$category->name] = $category->id;
                }
            }
        } else {
            $category_seclection['All Category'] = 'all';
        }

        return $category_seclection;
    }
endif;
