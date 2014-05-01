<link href="{$path}css/slide.css" rel="stylesheet">
<link rel="stylesheet" href="{$path}libs/owl-carousel/owl.carousel.css">
<link rel="stylesheet" href="{$path}libs/owl-carousel/owl.theme.css">


<h1>Productos</h1>
<div id="owl-demo" class="owl-carousel">
{foreach from=$products item=product name=homeFeaturedProducts}
    <div id="product_list_grid" class="bordercolor box visible item" style="display: block;">
		<li class="ajax_block_product bordercolor ">
			<h3><a class="product_link" title="{$product.name|escape:html:'UTF-8'}" href="{$product.link}">{$product.name|escape:html:'UTF-8'}</a>
			</h3>
				<a href="{$product.link}" title="{$product.name|escape:html:'UTF-8'}" class="product_image">
					<img src="{$link->getImageLink($product.link_rewrite, $product.id_image, 'home')}" height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product.name|escape:html:'UTF-8'}" />
				</a>
				<p>
				{if (!$PS_CATALOG_MODE AND ((isset($product.show_price) && $product.show_price) || (isset($product.available_for_order) && $product.available_for_order)))}
					{if isset($product.show_price) && $product.show_price && !isset($restricted_country_mode)}<span class="price">{if !$priceDisplay}{convertPrice price=$product.price}{else}{convertPrice price=$product.price_tax_exc}{/if}</span>{/if}
				{/if}
				</p>
				<p class="product_desc"><a class="product_descr" href="{$product.link|escape:'htmlall':'UTF-8'}" title="{$product.description_short|truncate:30:'...'|strip_tags:'UTF-8'|escape:'htmlall':'UTF-8'}">{$product.description_short|truncate:50:'...'|strip_tags:'UTF-8'}</a></p>
				
				<div>
				{if ($product.id_product_attribute == 0 || (isset($add_prod_display) && ($add_prod_display == 1))) && $product.available_for_order && !isset($restricted_country_mode) && $product.minimal_quantity <= 1 && $product.customizable != 2 && !$PS_CATALOG_MODE}
					{if ($product.allow_oosp || $product.quantity > 0)}
						<a class="exclusive ajax_add_to_cart_button" rel="ajax_id_product_{$product.id_product|intval}" href="{$link->getPageLink('cart.php')}?add&amp;id_product={$product.id_product|intval}{if isset($static_token)}&amp;token={$static_token}{/if}" title="{l s='Add to cart'}">{l s='Add to cart'}</a>
					{else}
						<span class="exclusive">{l s='Add to cart'}</span>
					{/if}
				{/if}
				<a class="button" href="{$product.link|escape:'htmlall':'UTF-8'}" title="{l s='View'}">{l s='View'}</a>
				</div>
				
		</li>
	</div>
{/foreach}	
</div>
<script src="{$path}js/jquery-1.9.1.min.js"></script>
<script src="{$path}libs/owl-carousel/owl.carousel.min.js"></script>
<script type="text/javascript" src="{$path}js/slide.js"></script>

