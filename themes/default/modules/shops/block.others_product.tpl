<!-- BEGIN: main -->
<div id="productslide" class="carousel slide">
    <h2 class="tittle-product">{BLOCK_TITLE}</h2>
    <ol class="carousel-indicators">
        <!-- BEGIN: loopnum -->
		<li data-target="#productslide" data-slide-to="{NUM}" class="{ACTIVE}"></li>
		<!-- END: loopnum -->
    </ol>
    <div class="carousel-inner">
		<!-- BEGIN: loop -->
        <div class="{ACTIVE} item">
            <div class="row">
                <!-- BEGIN: loopitem -->
				<div class="span4">
                    <div class="box-product">
                        <!-- <span class="hotsale"></span> -->
                        <!-- <span class="sale-bar">20%+ Bộ chăn ga gần 3 triệu</span> -->
                        <div class="product-block bar">
                            <a href="{LINK}" target="_self" class="mosaic-overlay">
                                <div class="details">
                                    <h4>{TITLE}</h4>
									<!-- BEGIN: price -->
									<!-- BEGIN: discounts -->
									<p class="sale">{PRICE.sale_format} {PRICE.unit}</p>
									<p class="discounts_money">{PRICE.price_format} {PRICE.unit}</p>
									<!-- END: discounts -->
									
									<!-- BEGIN: no_discounts -->
									<p class="{class_money} price">{PRICE.price_format} {PRICE.unit}</p>
									<!-- END: no_discounts -->
									<!-- END: price -->
									 
                                    
                                </div>
                            </a>
                            <div class="mosaic-backdrop"><img src="{IMG_SRC}" alt="{TITLE}" /></div>
                        </div>
                    </div>
                </div>
				<!-- END: loopitem -->
			   <div class="clearfix"></div>
            </div>
        </div>
		<!-- END: loop -->
	</div>
</div>
<!-- END: main -->