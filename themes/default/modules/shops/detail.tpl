<!-- BEGIN: main -->

<div class="container">
<div class="row">
<div class="border span12 shadow product-page-details">
    <div class="row">
        <div class="span4" style="position:relative; margin-bottom: 50px">
            <script type="text/javascript">
                $(document).ready(function() {
                    var totWidth = 0;
                    var positions = new Array();
                    $('#slides .slide').each(function(i) {
                        positions[i] = totWidth;
                        totWidth += $(this).width();
                        if (!$(this).width()) {
                            alert("Please, fill in width & height for all your images!");
                            return false;
                        }
                    });
                    $('#slides').width(totWidth);
                    $('#menu ul li a').click(function(e) {
                        var pos = $(this).parent().prevAll('.menuItem').length;
                        $('#slides').stop().animate({
                            marginLeft: -positions[pos] + 'px'
                        }, 0);
                        e.preventDefault();
                    });
                });
            </script>
            <div id="gallery">
                <div id="slides" style="width: 300px; margin-left: 0px;">
                    <div class="slide">
						<a href="{SRC_PRO_LAGE}" title="{TITLE}" <!-- BEGIN: shadowbox -->rel="shadowbox"<!-- END: shadowbox -->> <img src="{SRC_PRO}" alt="" width="140px" class="img-thumbnail"> </a>
					</div>
                </div>
                <div id="menu">
                    <ul>
                        <li class="menuItem">
                            <a href=""><img src="{SRC_PRO_LAGE}" alt="{TITLE}"></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <div class="span4">
            <div class="product-page-details-sp" style="position: relative">
                <ul class="product_info">
					<li>
						<h2>{TITLE}</h2>
					</li>
					<li class="text-muted">
						{DATE_UP} - {NUM_VIEW} {LANG.detail_num_view}
					</li>

					<!-- BEGIN: product_code -->
					<li>
						{LANG.product_code}: <strong>{PRODUCT_CODE}</strong>
					</li>
					<!-- END: product_code -->

					<!-- BEGIN: price -->
					<li>
						<p>
							{LANG.detail_pro_price}:
							<!-- BEGIN: discounts -->
							<span class="money">{PRICE.sale_format} {PRICE.unit}</span>
							<span class="discounts_money">{PRICE.price_format} {PRICE.unit}</span>
							<!-- END: discounts -->
							<span class="money">{product_discounts} {money_unit}</span>

							<!-- BEGIN: no_discounts -->
							<span class="money">{PRICE.price_format} {PRICE.unit}</span>
							<!-- END: no_discounts -->
						</p>
					</li>
					<!-- END: price -->

					<!-- BEGIN: contact -->
					<li>
						{LANG.detail_pro_price}: <span class="money">{LANG.price_contact}</span>
					</li>
					<!-- END: contact -->

					<!-- BEGIN: hometext -->
					<li>
						<p class="text-justify">
							{hometext}
						</p>
					</li>
					<!-- END: hometext -->

					<!-- BEGIN: custom -->
					<!-- BEGIN: loop -->
					<li>
						<p>
							<strong>{custom.lang}:</strong> {custom.title}
						</p>
					</li>
					<!-- END: loop -->
					<!-- END: custom -->

					<!-- BEGIN: custom_lang -->
					<!-- BEGIN: loop -->
					<li>
						<p>
							<strong>{custom_lang.lang}:</strong> {custom_lang.title}
						</p>
					</li>
					<!-- END: loop -->
					<!-- END: custom_lang -->

					<!-- BEGIN: promotional -->
					<li>
						<strong>{LANG.detail_promotional}:</strong> {promotional}
					</li>
					<!-- END: promotional -->

					<!-- BEGIN: warranty -->
					<li>
						<strong>{LANG.detail_warranty}:</strong> {warranty}
					</li>
					<!-- END: warranty -->
				</ul>
				<!-- BEGIN: order -->
				<div class="pull-right" style="margin-top: 6px">
					<span class="pull-left text-muted">{LANG.quantity}: <strong>{QUANTITY}</strong> {PRO_UNIT}</span>
					<input type="number" name="num" value="1" id="pnum" class="pull-left form-control" style="width: 70px">
					<a class="buy pull-right add_cart" href="javascript:void(0)" id="{ID}" title="{TITLE}" onclick="cartorder_detail(this)">
					<button class="btn btn-warning btn-xs" style="margin: 5px 0 0 5px">
						{LANG.add_product}
					</button></a>
				</div>
				<!-- END: order -->

				<!-- BEGIN: product_empty -->
				<div class="pull-right" style="margin-top: 6px">
					<button class="btn btn-danger disabled">
						{LANG.product_empty}
					</button>
				</div>
				<!-- END: product_empty -->
                 
             </div>
        </div>
		<div class="span4">
			[HOTRO]
		</div>
        <div class="clearfix"></div>
    </div>
    <ul class="ctabs">
        <li class="active"><a href="#gioithieu" data-toggle="tab">Giới thiệu</a></li>
        <li><a href="#anhsanpham" data-toggle="tab">Ảnh sản phẩm</a></li>
		<li><a href="#facebook" data-toggle="tab">Bình luận</a></li>
 
    </ul>
    <div class="clearfix"></div>
    <div class="tab-content">
        <div class="tab-pane active" id="gioithieu">
            <div class="product-page-details-media">
                <h4 class="media-heading">{TITLE}</h4>
                <div class="media-body">
                    {DETAIL}
                </div>
                 
            </div>
        </div>
        <div class="tab-pane" id="anhsanpham">
            <!-- BEGIN: othersimg -->
			<section id="section-2">
				<!-- BEGIN: loop -->
				<div class="col-xs-6 col-md-3">
					<a href="{IMG_SRC_OTHER}" class="thumbnail" rel="shadowbox[miss]"><img src="{IMG_SRC_OTHER}" style="max-height: 100px" /></a>
				</div>
				<!-- END: loop -->
				<div class="clear">
					&nbsp;
				</div>
			</section>
			<!-- END: othersimg -->
        </div>
        <div class="tab-pane" id="facebook">
			<div id="fb-root"></div>
			<script type="text/javascript">(function(d, s, id) {
			  var js, fjs = d.getElementsByTagName(s)[0];
			  if (d.getElementById(id)) return;
			  js = d.createElement(s); js.id = id;
			  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.3&appId=112724838914387";
			  fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));</script>
             <div class="fb-comments" data-href="{SELFURL}" data-numposts="5" data-width="650"></div>
        </div>
          
    </div>
</div>
</div>
</div>
<div class="msgshow" id="msgshow"></div>
<!-- END: main -->
