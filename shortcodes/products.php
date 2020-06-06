<?php

/**
 * Product Outside shortcode
 */
if( !function_exists('conikal_pdo_products_shortcode') ): 
    function conikal_pdo_products_shortcode($attrs, $content = null) {
        extract(shortcode_atts(array(
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
            'featured' => '',
            'category' => 'all',
            'tag' => '',
            'on_sale' => '',
            'min_price' => '',
            'max_price' => '',
            'stock_status' => 'any',
            'new_tab' => false,
            'image_hover' => false,
            'load_more' => false,
            'columns' => '3',
            'columns_md' => '2',
            'columns_sm' => '2',
            'columns_xs' => '1',
            'columns_mb' => '1'
        ), $attrs));

        $args = array(
            'page' => $page,
            'per_page' => $per_page,
            'search' => $search,
            'order' => $order,
            'orderby' => $orderby,
            'slug' => $slug,
            'sku' => $sku,
            'tag' => $tag,
            'min_price' => $min_price,
            'max_price' => $max_price,
        );

        if ($exclude) {
            $exclude = str_replace(' ', '', $exclude);
            $args = explode(',', $exclude);
        }

        if ($include) {
            $include = str_replace(' ', '', $include);
            $args = explode(',', $include);
        }

        if ($category != 'all') {
            $args['category'] = $category;
        }

        if ($after) {
            $args['after'] = $after;
        }

        if ($before) {
            $args['before'] = $before;
        }

        if ($offset) {
            $args['offset'] = $offset;
        }

        if ($status != 'any') {
            $args['status'] = $status;
        }

        if ($type != 'any') {
            $args['type'] = $type;
        }

        if ($featured) {
            $args['featured'] = $featured;
        }

        if ($on_sale) {
            $args['on_sale'] = $on_sale;
        }

        if ($stock_status != 'any') {
            $args['stock_status'] = $stock_status;
        }

        if ($method == 'server') {
            $woocommerce    = conikal_woocommerce_api();
            if ($woocommerce) {
               $products       = $woocommerce->get('products', $args);
                $system_status  = $woocommerce->get('system_status');
                $price_args     = conikal_pdo_price_settings($system_status); 
            }
        } else {
            wp_nonce_field('product_outside_ajax_nonce', 'securityProductOuside', true);
        }

        $columns_args = array(
            'col-xl' => $columns,
            'col-md' => $columns_md,
            'col-sm' => $columns_sm,
            'col-xs' => $columns_xs,
            'col' => $columns_mb,
        );

        $classes = '';
        foreach ($columns_args as $class => $column) {
            $classes .= $class . '-' . (intval($column) == 5 ? '12-5' : 12/intval($column)) . ' ';
        }

        if (is_rtl()) {
            $tooltip_position = 'right';
        } else {
            $tooltip_position = 'left';
        }
        ?>

    <?php if ($display_title) : ?>
        <h2><?php echo esc_html($title) ?></h2>
    <?php endif; ?>
    <div class="pdo">
        <div id="product-outside-<?php echo esc_attr(sanitize_title($title)) ?>" data-id="<?php echo esc_attr(sanitize_title($title)) ?>" data-items-container="true" class="gf-blog-inner clearfix layout-grid gf-gutter-30 <?php echo esc_attr($method == 'client' ? 'product-outside' : '') ?>" data-args='<?php echo json_encode($args) ?>' data-classes="<?php echo esc_attr($classes) ?>" data-newt="<?php echo esc_attr($new_tab ? 1 : 0) ?>" data-hover="<?php echo esc_attr($image_hover ? 1 : 0) ?>">
        <?php  if ($method == 'server') :
            if ($woocommerce) :
                foreach ($products as $id => $product) { ?>
            <article class="clearfix product-item-wrap product-content-product <?php echo esc_attr($classes) ?>product type-product post-2130 status-publish first instock product_cat-91 product_tag-93 product_tag-92 has-post-thumbnail shipping-taxable purchasable product-type-simple product-small">
                <div class="product-item-inner clearfix">
                    <div class="product-thumb">
                        <div class="product-images-hover change-image">
                            <div class="product-images-hover change-image">
                                <?php foreach ($product->images as $id => $image) { ?>
                                <div class="product-thumb-<?php echo esc_attr($id == 0 ? 'primary' : 'secondary') ?>">
                                    <div class="entry-thumbnail">
                                        <a class="entry-thumbnail-overlay" href="<?php echo esc_url($product->permalink) ?>" title="<?php echo esc_html($product->name) ?>"<?php echo esc_attr($new_tab ? ' target="_blank"' : '') ?>>
                                            <img src="<?php echo esc_url($image->src) ?>" class="img-responsive wp-post-image" alt="<?php echo esc_html($product->name) ?>">
                                        </a>
                                    </div>
                                </div>
                                <?php
                                    if ($id == 1 ||($id == 0 && $image_hover == false)) {
                                        break;
                                    }
                                } ?>
                            </div>
                        </div>

                        <div class="product-actions gf-tooltip-wrap" data-tooltip-options="{&quot;placement&quot;:&quot;<?php echo esc_attr($tooltip_position) ?>&quot;}">
                            <div class="product-action-item add_to_cart_tooltip" data-toggle="tooltip" data-original-title="Add to cart">
                                <a href="<?php echo esc_url($product->permalink) ?>?add-to-cart=<?php echo esc_attr($product->id) ?>" class="product_type_simple add_to_cart_button" rel="nofollow"<?php echo esc_attr($new_tab ? ' target="_blank"' : '') ?>>
                                <?php esc_html_e('Add to card', 'product-outside') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="product-info">
                        <h4 class="product-name product_title">
                            <a class="gsf-link" href="<?php echo esc_url($product->permalink) ?>"<?php echo esc_attr($new_tab ? ' target="_blank"' : '') ?>><?php echo esc_html($product->name) ?></a>
                        </h4>

                        <span class="price"><span class="woocommerce-Price-amount amount"><?php echo conikal_pdo_price($product->price, $price_args) ?></span>
                        </span>
                        <div class="product-description">
                            <?php echo $product->short_description ?>
                        </div>
                        <div class="product-list-actions d-flex align-items-center flex-wrap">
                            <div class="product-action-item">
                                <a href="<?php echo esc_url($product->permalink) ?>?add-to-cart=<?php echo esc_attr($product->id) ?>" class="product_type_simple add_to_cart_button ajax_add_to_cart btn" rel="nofollow"<?php echo esc_attr($new_tab ? ' target="_blank"' : '') ?>>
                                    <?php esc_html_e('Add to card', 'product-outside') ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </article>
        <?php } 
            else :?>
            <div class="col-sm-6 col-md-6">
                <div class="alert-message alert-message-danger">
                    <h4><?php esc_html_e('Error Connection', 'product-outside') ?></h4>
                    <p><?php esc_html_e('No connect to your site. You have not configured the connection, to go Settings > Product Outside.' ,'product-outside') ?></p>
                </div>
            </div>
        <?php // end shortcode content
            endif;
        endif; ?>
        </div>
        <?php if ($load_more) : ?> 
        <div class="pdo load-more">
            <a href="javascript:void(0)" class="pdo button pdo-load-more<?php echo esc_attr($method == 'client' ? ' display none' : '') ?>" id="button-load-more-<?php echo esc_attr(sanitize_title($title)) ?>" data-page="0"><span><?php esc_html_e('Load more', 'product-outside') ?></span></a>
        </div>
        <?php endif; ?>
    </div>
    <?php // end function
    }
endif;

function conikal_product_outside_shortcodes($category = true) {
    // get categories for selection dropdown
    if ($category) {
        $category_seclection = conikal_category_selection();
    } else {
        $category_seclection = array();
    }

    $shortcode_params = array(
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Title', 'product-outside'),
            "param_name" => 'title',
            "value" => 'Product Outside',
            "description" => esc_html__('Title of Section', 'product-outside')
        ),
        array(
            "type" => 'checkbox',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Display Title', 'product-outside'),
            "param_name" => 'display_title',
            "description" => esc_html__('Show title above products or not.', 'product-outside')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Render Method', 'product-outside'),
            "param_name" => 'method',
            "value" => array(
                esc_html__('Client Side Render', 'product-outside') => 'client',
                 esc_html__('Server Side Render', 'product-outside') => 'server',
                ),
            "std" => 'desc',
            "description" => esc_html__('Ways to rendering product via ajax loading or php.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Page', 'product-outside'),
            "param_name" => 'page',
            "value" => 1,
            "description" => esc_html__('Current page of the collection.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Per page', 'product-outside'),
            "param_name" => 'per_page',
            "value" => 6,
            "description" => esc_html__('The "per_page" shortcode determines how many products to show on the page', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Search', 'product-outside'),
            "param_name" => 'search',
            "value" => '',
            "description" => esc_html__('Limit results to those matching a string.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('After', 'product-outside'),
            "param_name" => 'after',
            "value" => '',
            "description" => esc_html__('Limit response to resources published after a given ISO8601 compliant date.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Before', 'product-outside'),
            "param_name" => 'before',
            "value" => '',
            "description" => esc_html__('Limit response to resources published before a given ISO8601 compliant date.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Exclude (separated by commas)', 'product-outside'),
            "param_name" => 'exclude',
            "value" => '',
            "description" => esc_html__('Ensure result set excludes specific IDs.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Include (separated by commas)', 'product-outside'),
            "param_name" => 'include',
            "value" => '',
            "description" => esc_html__('Limit result set to specific ids.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Offset', 'product-outside'),
            "param_name" => 'offset',
            "value" => '',
            "description" => esc_html__('Offset the result set by a specific number of items.', 'product-outside')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Order', 'product-outside'),
            "param_name" => 'order',
            "value" => array(
                esc_html__('Ascending', 'product-outside') => 'asc',
                 esc_html__('Descending', 'product-outside') => 'desc',
                ),
            "std" => 'desc',
            "description" => esc_html__('Order sort attribute ascending or descending.', 'product-outside')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Order by', 'product-outside'),
            "param_name" => 'orderby',
            "value" => array(
                esc_html__('Date', 'product-outside') => 'date',
                esc_html__('ID', 'product-outside') => 'id',
                esc_html__('Include', 'product-outside') => 'include',
                esc_html__('Title', 'product-outside') => 'title',
                esc_html__('Slug', 'product-outside') => 'slug',
            ),
            "std" => 'date',
            "description" => esc_html__('Sort collection by object attribute.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Slug', 'product-outside'),
            "param_name" => 'slug',
            "value" => '',
            "description" => esc_html__('Limit result set to products with a specific slug.', 'product-outside')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Status', 'product-outside'),
            "param_name" => 'status',
            "value" => array(
                esc_html__('Any', 'product-outside') => 'any',
                esc_html__('Publish', 'product-outside') => 'publish',
                esc_html__('Draft', 'product-outside') => 'draft',
                esc_html__('Pending', 'product-outside') => 'pending',
                esc_html__('Private', 'product-outside') => 'private',
            ),
            "std" => 'publish',
            "description" => esc_html__('Limit result set to products assigned a specific status.', 'product-outside')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Type', 'product-outside'),
            "param_name" => 'type',
            "value" => array(
                esc_html__('Any', 'product-outside') => 'any',
                esc_html__('Simple', 'product-outside') => 'simple',
                esc_html__('External', 'product-outside') => 'external',
                esc_html__('Variable', 'product-outside') => 'variable',
                ),
            "std" => 'any',
            "description" => esc_html__('Limit result set to products assigned a specific type.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('SKU', 'product-outside'),
            "param_name" => 'sku',
            "value" => '',
            "description" => esc_html__('Limit result set to products with a specific SKU.', 'product-outside')
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Category', 'product-outside'),
            "param_name" => 'category',
            "value" => $category_seclection,
            "std" => 'any',
            "description" => esc_html__('Limit result set to products assigned a specific category ID.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Tag ID (separated by commas)', 'product-outside'),
            "param_name" => 'tag',
            "value" => '',
            "description" => esc_html__('Limit result set to products assigned a specific tag ID.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Minimum Price', 'product-outside'),
            "param_name" => 'min_price',
            "value" => '',
            "description" => esc_html__('Limit result set to products based on a minimum price.', 'product-outside')
        ),
        array(
            "type" => 'textfield',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Maximum Price', 'product-outside'),
            "param_name" => 'max_price',
            "value" => '',
            "description" => esc_html__('Limit result set to products based on a maximum price.', 'product-outside')
        ),
        array(
            "type" => 'checkbox',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('On Sale', 'product-outside'),
            "param_name" => 'on_sale',
            "description" => esc_html__('Limit result set to products on sale.', 'product-outside')
        ),
        array(
            "type" => 'checkbox',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Featured', 'product-outside'),
            "param_name" => 'featured',
            "description" => esc_html__('Limit result set to featured products.', 'product-outside')
        ),
        array(
            "type" => 'checkbox',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Open in New Tab', 'product-outside'),
            "param_name" => 'new_tab',
            "description" => esc_html__('Open in new tab when click on product link.', 'product-outside')
        ),
        array(
            "type" => 'checkbox',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Image hover', 'product-outside'),
            "param_name" => 'image_hover',
            "description" => esc_html__('Flip to secondary image when hovering on product image.', 'product-outside')
        ),
        array(
            "type" => 'checkbox',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Load more button', 'product-outside'),
            "param_name" => 'load_more',
            "description" => esc_html__('Display load more button below products list', 'product-outside'),
        ),
        array(
            "type" => 'dropdown',
            "holder" => 'div',
            "class" => '',
            "heading" => esc_html__('Stock status', 'product-outside'),
            "param_name" => 'stock_status',
            "value" => array(
                esc_html__('Any', 'product-outside') => 'any',
                esc_html__('Instock', 'product-outside') => 'instock',
                esc_html__('Outofstock', 'product-outside') => 'outofstock',
                esc_html__('Onbackorder', 'product-outside') => 'onbackorder',
                ),
            "std" => 'any',
            "description" => esc_html__('Limit result set to products with specified stock status.', 'product-outside')
        ),
    );

    return $shortcode_params;
}

// interact with visual composer
add_action( 'vc_before_init', 'conikal_pdo_vc_products_shortcode' );
function conikal_pdo_vc_products_shortcode() {
    $shortcode_params = conikal_product_outside_shortcodes();

    $shortcode_params = array_merge($shortcode_params, conikal_column_responsive(array(
        'element'=>'layout_style',
        'value'=>array('grid')
    )));

    vc_map( array(
        "name" => esc_html__('Product Outside', 'product-outside'),
        "base" => 'product_outside',
        "description" => esc_html__('Display products from another store', 'product-outside'),
        "class" => '',
        "category" => esc_html__('WooCommerce', 'product-outside'),
        'admin_enqueue_js' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.js',
        'admin_enqueue_css' => plugin_dir_url( __FILE__ ) . 'vc_extend/bartag.css',
        "icon" => plugin_dir_url( __FILE__ ) . 'images/product-outside-icon.svg',
        "params" => $shortcode_params,
    ));
}

?>