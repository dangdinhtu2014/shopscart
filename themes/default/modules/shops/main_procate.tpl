<!-- BEGIN: main -->
<!-- BEGIN: catalogs -->
<ul class="product-tap">
    <li class="active">
        <a href="{LINK_CATALOG}" title="{TITLE_CATALOG}">{TITLE_CATALOG} ({NUM_PRO} {LANG.title_products})</a>
    </li>
 
</ul>
<div class="tab-content tab_list_group">
    <div class="tab-pane active" id="producttab1">
        <div class="row">
			<!-- BEGIN: items -->
            <div class="span4">
                <div class="box-product2">
                    <div class="img-product">
                        <a href="{LINK}" title="{TITLE}"><img src="{IMG_SRC_LARGE}" alt="{TITLE}"/></a>
                        <!-- <span class="saletab">Giảm giá lớn + Quà hấp dẫn</span> -->
                    </div>
                    <div class="box-product2-content">
                        <h3><a href="{LINK}" title="{TITLE}">{TITLE0}</a></h3>
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
            <!-- END: items -->
			<div class="clearfix"></div>
        </div>
        <a class="viewall" href="{LINK_CATALOG}">Xem tất cả</a>
    </div>
</div> 
<!-- END: catalogs -->
<!-- END: main -->