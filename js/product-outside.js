(function($) {
    "use strict";

if ($('.product-outside').length) {
	$('.product-outside').each(function(index) {
		var id = $(this).attr('data-id');
		getProductOutside(id);
	});
	
}

$('.pdo-load-more').on('click', function() {
	$(this).toggleClass("button-loading");
	var id = $(this).parent().prev().attr('data-id');
	getProductOutside(id);
});

function getProductOutside(id) {
	var ajaxURL = product_outside_vars.admin_url + 'admin-ajax.php';
	var security = $('#securityProductOuside').val();
	var page = $('#button-load-more-' + id).attr('data-page');
		page = parseInt(page) + 1;
	var args = $('#product-outside-' + id).attr('data-args');
		args = jQuery.parseJSON(args);
	if (page) {
		args.page = page;
	}
	var classes = $('#product-outside-' + id).attr('data-classes');
	var newt = $('#product-outside-' + id).attr('data-newt');
	var hover = $('#product-outside-' + id).attr('data-hover');
	var target_link = '';
	if (newt == 1) {
		target_link = ' target="_blank"';
	}

	$.ajax({
        type: 'POST',
        dataType: 'json',
        url: ajaxURL,
        data: {
            'action': 'conikal_get_products',
            'security': security,
            'args': args,
        },
        success: function(resp) {
        	if (resp.status) {
	            var html = '';
	            $.each(resp.products, function(id, product) {
	            html += `<article class="clearfix product-item-wrap product-content-product ` + classes + `product type-product post-2130 status-publish first instock product_cat-91 product_tag-93 product_tag-92 has-post-thumbnail shipping-taxable purchasable product-type-simple product-small">
				        <div class="product-item-inner clearfix">
				            <div class="product-thumb">
				                <div class="product-images-hover change-image">
				                    <div class="product-images-hover change-image">`;
				                        $.each(product.images, function(id, image) {
				                        if (id == 0) {
				                        	var primary_image = 'primary';
				                        } else {
				                        	var primary_image = 'secondary';
				                        }
				                        html += `<div class="product-thumb-` + primary_image + `">
				                            <div class="entry-thumbnail">
				                                <a class="entry-thumbnail-overlay" href="` + product.permalink + `" title="` + product.name + `"` + target_link + `>
				                                    <img src="` + image.src + `" class="img-responsive wp-post-image" alt="` + product.name + `">
				                                </a>
				                            </div>
				                        </div>`;
				                            if (id == 1 || (id == 0 && hover == 0)) {
				                               return false;
				                            }
				                        });
				                    html += `</div>
				                </div>

				                <div class="product-actions gf-tooltip-wrap" data-tooltip-options="{&quot;placement&quot;:&quot;` + product_outside_vars.tooltip_position + `&quot;}">
				                    <div class="product-action-item add_to_cart_tooltip" data-toggle="tooltip" data-original-title="` + product_outside_vars.add_to_cart + `">
				                        <a href="` + product.permalink + `?add-to-cart=` + product.id + `" class="product_type_simple add_to_cart_button" rel="nofollow"` + target_link + `>` + product_outside_vars.add_to_cart + `</a>
				                    </div>
				                </div>
				            </div>
				            <div class="product-info">
				                <h4 class="product-name product_title">
				                    <a class="gsf-link" href="` + product.permalink + `"` + target_link + `>` + product.name + `</a>
				                </h4>

				                <span class="price"><span class="woocommerce-Price-amount amount">` + product.price + `</span>
				                </span>
				                <div class="product-description">` + product.short_description + `</div>
				                <div class="product-list-actions d-flex align-items-center flex-wrap">
				                    <div class="product-action-item">
				                        <a href="` + product.permalink + `?add-to-cart=` + product.id + `" class="product_type_simple add_to_cart_button ajax_add_to_cart btn" rel="nofollow"` + target_link + `>
				                            ` + product_outside_vars.add_to_cart + `
				                        </a>
				                    </div>
				                </div>
				            </div>
				        </div>
				    </article>`;
	            });

	          	$('#product-outside-' + id).append(html);

	          	if (parseInt(resp.products.length) < args.per_page) {
	          		$('#button-load-more-' + id).addClass('display none').removeClass("button-loading");;
	          	} else {
	          		$('#button-load-more-' + id).removeClass('display none');
	          	}
	          	$('#button-load-more-' + id).attr('data-page', page).removeClass("button-loading");
	         } else {
	         	$('#button-load-more-' + id).addClass('display none').removeClass("button-loading");;
	         }
        },
        error: function(errorThrown) {
            $('#button-load-more-' + id).addClass('display none').removeClass("button-loading");;
        }
    });
}

})(jQuery);