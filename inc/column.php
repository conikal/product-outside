<?php

/**
 * Get Post Columns
 *
 * @param bool $inherit
 * @return array|mixed|void
 */
function conikal_post_columns($inherit = false)
{
    $config = apply_filters('conikal_options_post_columns', array(
        '1' => '1',
        '2' => '2',
        '3' => '3',
        '4' => '4',
        '5' => '5',
        '6' => '6'
    ));

    if ($inherit) {
        $config = array(
                '' => esc_html__('Inherit', 'product-outside')
            ) + $config;
    }

    return $config;
}

function conikal_column_responsive($dependency = array())
{
    $responsive = array(
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Large Devices', 'product-outside'),
            'description' => esc_html__('Browser Width >= 1200px', 'product-outside'),
            'param_name' => 'columns',
            'value' => conikal_post_columns(),
            'std' => 3,
            'group' => esc_html__('Responsive', 'product-outside'),
            'dependency' => $dependency
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Medium Devices', 'product-outside'),
            'param_name' => 'columns_md',
            'description' => esc_html__('Browser Width < 1200px', 'product-outside'),
            'value' => conikal_post_columns(),
            'std' => 2,
            'group' => esc_html__('Responsive', 'product-outside'),
            'dependency' => $dependency
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Small Devices', 'product-outside'),
            'param_name' => 'columns_sm',
            'description' => esc_html__('Browser Width < 992px', 'product-outside'),
            'value' => conikal_post_columns(),
            'std' => 2,
            'group' => esc_html__('Responsive', 'product-outside'),
            'dependency' => $dependency
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Extra Small Devices', 'product-outside'),
            'param_name' => 'columns_xs',
            'description' => esc_html__('Browser Width < 768px', 'product-outside'),
            'value' => conikal_post_columns(),
            'std' => 1,
            'group' => esc_html__('Responsive', 'product-outside'),
            'dependency' => $dependency
        ),
        array(
            'type' => 'dropdown',
            'heading' => esc_html__('Extra Extra Small Devices', 'product-outside'),
            'param_name' => 'columns_mb',
            'description' => esc_html__('Browser Width < 576px', 'product-outside'),
            'value' => conikal_post_columns(),
            'std' => 1,
            'group' => esc_html__('Responsive', 'product-outside'),
            'dependency' => $dependency
        )
    );
    return $responsive;
}

?>