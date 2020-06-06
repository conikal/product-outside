<?php

/**
 * @package WordPress
 * @subpackage Product Outside
 */

require_once plugin_dir_path( __FILE__ ) . 'widgets/product_outside.php';


/**
 * Register Petition custom widgets
 *
 * @since Campoal 1.0.0
 */
if( !function_exists('conikal_register_widgets') ): 
    function conikal_register_widgets() {
        register_widget('Product_Outside');
    }
endif;
add_action( 'widgets_init', 'conikal_register_widgets' );

?>