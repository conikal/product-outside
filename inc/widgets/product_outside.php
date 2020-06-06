<?php
/**
 * @package WordPress
 * @subpackage Product Outside
 */


/**
 * Product Outside
 *
 * @since Product Outside 1.0.7
 */
class Product_Outside extends WP_Widget {
    function __construct() {
        $widget_ops = array('classname' => 'product_outside_sidebar', 'description' => esc_html__('Display product from another WooCommerce store', 'product-outside'));
        $control_ops = array('id_base' => 'product_outside_widget');
        parent::__construct('product_outside_widget', 'Product Outside', $widget_ops, $control_ops);
    }

    function form($instance) {
        $defaults = array(
            'title' => 'Product Outside',
            'display_title' => false,
            'method' => 'client',
            'page' => '1',
            'per_page' => '6',
            'search' => '',
            'after' => '',
            'before' => '',
            'exclude' => '',
            'include' => '',
            'offset' => '',
            'order' => 'desc',
            'orderby' => 'date',
            'slug' => '',
            'status' => 'any',
            'type' => 'any',
            'sku' => '',
            'category' => 'all',
            'tag' => '',
            'min_price' => '',
            'max_price' => '',
            'on_sale' => '',
            'featured' => '',
            'new_tab' => false,
            'image_hover' => false,
            'load_more' => false,
            'stock_status' => 'any',
            'columns' => '3',
            'columns_md' => '2',
            'columns_sm' => '2',
            'columns_xs' => '1',
            'columns_mb' => '1'
        );
        $instance = wp_parse_args((array) $instance, $defaults);

        // get shotcodes params
        $shortcode_params = conikal_product_outside_shortcodes(); ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('title')) ?>"><?php esc_html_e('Title', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')) ?>" name="<?php echo esc_attr($this->get_field_name('title')) ?>" value="<?php echo esc_attr($instance['title']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('display_title')) ?>"><?php esc_html_e('Display title', 'product-outside') ?>:</label>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('display_title')) ?>" name="<?php echo esc_attr($this->get_field_name('display_title')) ?>" value="1" <?php echo esc_attr($instance['display_title'] ? 'checked' : '') ?> />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('method')) ?>'"><?php esc_html_e('Method', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('method')) ?>" name="<?php echo esc_attr($this->get_field_name('method')) ?>">
        <?php foreach ($shortcode_params[2]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['method'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('page')) ?>"><?php esc_html_e('Page', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('page')) ?>" name="<?php echo esc_attr($this->get_field_name('page')) ?>" value="<?php echo esc_attr($instance['page']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('per_page')) ?>"><?php esc_html_e('Page', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('per_page')) ?>" name="<?php echo esc_attr($this->get_field_name('per_page')) ?>" value="<?php echo esc_attr($instance['per_page']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('search')) ?>"><?php esc_html_e('Search', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('search')) ?>" name="<?php echo esc_attr($this->get_field_name('search')) ?>" value="<?php echo esc_attr($instance['search']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('after')) ?>"><?php esc_html_e('After', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('after')) ?>" name="<?php echo esc_attr($this->get_field_name('after')) ?>" value="<?php echo esc_attr($instance['after']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('before')) ?>"><?php esc_html_e('Before', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('before')) ?>" name="<?php echo esc_attr($this->get_field_name('before')) ?>" value="<?php echo esc_attr($instance['before']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('exclude')) ?>"><?php esc_html_e('Exclude', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('exclude')) ?>" name="<?php echo esc_attr($this->get_field_name('exclude')) ?>" value="<?php echo esc_attr($instance['exclude']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('include')) ?>"><?php esc_html_e('Include', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('include')) ?>" name="<?php echo esc_attr($this->get_field_name('include')) ?>" value="<?php echo esc_attr($instance['include']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('offset')) ?>"><?php esc_html_e('Offset', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('offset')) ?>" name="<?php echo esc_attr($this->get_field_name('offset')) ?>" value="<?php echo esc_attr($instance['offset']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('order')) ?>'"><?php esc_html_e('Order', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('order')) ?>" name="<?php echo esc_attr($this->get_field_name('order')) ?>">
        <?php foreach ($shortcode_params[11]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['order'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('orderby')) ?>'"><?php esc_html_e('Orderby', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('orderby')) ?>" name="<?php echo esc_attr($this->get_field_name('orderby')) ?>">
        <?php foreach ($shortcode_params[12]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['orderby'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('slug')) ?>"><?php esc_html_e('Slug', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('slug')) ?>" name="<?php echo esc_attr($this->get_field_name('slug')) ?>" value="<?php echo esc_attr($instance['slug']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('status')) ?>'"><?php esc_html_e('Status', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('status')) ?>" name="<?php echo esc_attr($this->get_field_name('status')) ?>">
        <?php foreach ($shortcode_params[14]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['status'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('type')) ?>'"><?php esc_html_e('Type', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('type')) ?>" name="<?php echo esc_attr($this->get_field_name('type')) ?>">
        <?php foreach ($shortcode_params[15]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['type'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('sku')) ?>"><?php esc_html_e('SKU', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('sku')) ?>" name="<?php echo esc_attr($this->get_field_name('sku')) ?>" value="<?php echo esc_attr($instance['sku']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('category')) ?>'"><?php esc_html_e('Category', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('category')) ?>" name="<?php echo esc_attr($this->get_field_name('category')) ?>">
        <?php foreach ($shortcode_params[17]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['category'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('tag')) ?>"><?php esc_html_e('Tag', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('tag')) ?>" name="<?php echo esc_attr($this->get_field_name('tag')) ?>" value="<?php echo esc_attr($instance['tag']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('min_price')) ?>"><?php esc_html_e('Min price', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('min_price')) ?>" name="<?php echo esc_attr($this->get_field_name('min_price')) ?>" value="<?php echo esc_attr($instance['min_price']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('max_price')) ?>"><?php esc_html_e('Max price', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('max_price')) ?>" name="<?php echo esc_attr($this->get_field_name('max_price')) ?>" value="<?php echo esc_attr($instance['max_price']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('on_sale')) ?>"><?php esc_html_e('On Sale', 'product-outside') ?>:</label>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('on_sale')) ?>" name="<?php echo esc_attr($this->get_field_name('on_sale')) ?>" value="1" <?php echo esc_attr($instance['on_sale'] ? 'checked' : '') ?> />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('new_tab')) ?>"><?php esc_html_e('Display title', 'product-outside') ?>:</label>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('new_tab')) ?>" name="<?php echo esc_attr($this->get_field_name('new_tab')) ?>" value="1" <?php echo esc_attr($instance['new_tab'] ? 'checked' : '') ?> />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('image_hover')) ?>"><?php esc_html_e('Image hover', 'product-outside') ?>:</label>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('image_hover')) ?>" name="<?php echo esc_attr($this->get_field_name('image_hover')) ?>" value="1" <?php echo esc_attr($instance['image_hover'] ? 'checked' : '') ?> />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('load_more')) ?>"><?php esc_html_e('Load more', 'product-outside') ?>:</label>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('load_more')) ?>" name="<?php echo esc_attr($this->get_field_name('load_more')) ?>" value="1" <?php echo esc_attr($instance['load_more'] ? 'checked' : '') ?> />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('featured')) ?>"><?php esc_html_e('Featured', 'product-outside') ?>:</label>
            <input type="checkbox" id="<?php echo esc_attr($this->get_field_id('featured')) ?>" name="<?php echo esc_attr($this->get_field_name('featured')) ?>" value="1" <?php echo esc_attr($instance['featured'] ? 'checked' : '') ?> />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('stock_status')) ?>'"><?php esc_html_e('Stock Status', 'product-outside') ?>:</label>
            <select type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('stock_status')) ?>" name="<?php echo esc_attr($this->get_field_name('stock_status')) ?>">
        <?php foreach ($shortcode_params[26]['value'] as $name => $value) { ?>
                <option value="<?php echo esc_attr($value) ?>"<?php echo esc_attr($instance['stock_status'] === $value ? ' selected="selected"' : '') ?>><?php echo esc_html($name) ?></option>
        <?php } ?>            
            </select>
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns')) ?>"><?php esc_html_e('Large Devices', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('columns')) ?>" name="<?php echo esc_attr($this->get_field_name('columns')) ?>" value="<?php echo esc_attr($instance['columns']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_md')) ?>"><?php esc_html_e('Medium Devices', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('columns_md')) ?>" name="<?php echo esc_attr($this->get_field_name('columns_md')) ?>" value="<?php echo esc_attr($instance['columns_md']) ?>" />
        </p><p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_sm')) ?>"><?php esc_html_e('Small Devices', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('columns_sm')) ?>" name="<?php echo esc_attr($this->get_field_name('columns_sm')) ?>" value="<?php echo esc_attr($instance['columns_sm']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_xs')) ?>"><?php esc_html_e('Extra Small Devices', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('columns_xs')) ?>" name="<?php echo esc_attr($this->get_field_name('columns_xs')) ?>" value="<?php echo esc_attr($instance['columns_xs']) ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_id('columns_mb')) ?>"><?php esc_html_e('Extra Extra Small Devices', 'product-outside') ?>:</label>
            <input type="text" class="widefat" id="<?php echo esc_attr($this->get_field_id('columns_mb')) ?>" name="<?php echo esc_attr($this->get_field_name('columns_mb')) ?>" value="<?php echo esc_attr($instance['columns_mb']) ?>" />
        </p>
    <?php }


    function update($new_instance, $old_instance) {
        // get shotcodes params
        $shortcode_params   = conikal_product_outside_shortcodes(false);
        $column_responsive  = conikal_column_responsive();
        $params = array_merge($shortcode_params, $column_responsive);
        
        $instance = $old_instance;

        foreach ($params as $param) {
            $param_name = $param['param_name'];
            if (array_key_exists($param_name, $new_instance)) {
                $instance[$param_name] = sanitize_text_field($new_instance[$param_name]);
            }
        }

        // print_r($instance);

        return $instance;
    }

    function widget($args, $instance) {
        extract($args);

        echo wp_kses_post($before_widget);

        // print_r($instance);
        // print_r($args);
        echo conikal_pdo_products_shortcode($instance);

        echo $args['after_widget'];
        echo wp_kses_post($after_widget);
    }

}

?>