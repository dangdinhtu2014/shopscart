<!-- BEGIN: main -->

<!-- BEGIN: grid_rows -->
<div class="span3">
    <div class="box-product3">
        <div class="img-product">
            <a href="{LINK}"><img src="{IMG_SRC_LARGE}" alt="{TITLE}" ></a>
            <!-- <span class="saletab"> 20% </span> -->
        </div>
        <div class="box-product3-content">
            <h3 class="highlight_find"> <a href="{LINK}">{TITLE0}</a> </h3>
            <!-- BEGIN: price -->
				<p class="price">
                    <!-- BEGIN: discounts -->
                    <span class="price">{PRICE.sale_format} {PRICE.unit}</span>
                    <span class="sale">{PRICE.price_format} {PRICE.unit}</span>
                    <!-- END: discounts -->
                    
					<!-- BEGIN: no_discounts -->
					<span class="price">{PRICE.price_format} {PRICE.unit}</span>
					<!-- END: no_discounts -->
				</p>
			<!-- END: price -->
        </div>
        <a class="buy" href="{LINK}">mua hàng</a>
    </div>
</div>
<!-- END: grid_rows -->
<div class="clear"></div>
<!-- END: main -->