<link type="text/css" rel="stylesheet" href="<?php echo LANGPATH; ?>/css/quickview.css" media="all" />
<script>
    var page = <?php echo isset($_GET['page']) ? 1 : 0; ?>;
    $(function(){
        if(page)
        {
            window.location.href = '#pagefocus';
        }
    })
</script>
	<div class="page">
		<div class="site-content">
			<div class="main-container clearfix">
				<div class="container">
					<div class="crumbs">
			            <div class="fll">
			                <a href="<?php echo LANGPATH; ?>/" class="home">Homepage</a>&gt; SCHAU DER KÄUFER
			            </div>
                    </div>
        <?php echo message::get(); ?>
                    <div class="lookbook-details row mb20">
                    	<div class="col-xs-12 col-sm-4">
                        <?php 
                            if(count($c_images)>1 || !empty($c_images) || $c_images !="Undefined"){
                           
                        ?>
                    		<a href=""><img src="<?php echo STATICURL . '/limg/' . $c_images['image']; ?>"  alt=""></a>
                    	</div>
                    	<div class="col-xs-12 col-sm-8 container">
                    		<div class="row">
                        <?php
                        $product = Product::instance($c_images['product_id'], LANGUAGE);
                        $link = $product->permalink();
                        ?>
                    			<div class="col-xs-6 col-sm-5">
		                        	<a href="<?php echo $link; ?>"><img src="<?php echo Image::link($product->cover_image(), 1); ?>"  alt="" /></a></a>
		                        </div>
		                     	<div class="col-xs-6 col-sm-7">
		                        	<div class="con">
			                            <h4><a href="<?php echo $link; ?>"><?php echo $product->get('name'); ?></a></h4>
			                            <h2 class="mt20"><?php echo Site::instance()->price($product->price(), 'code_view'); ?></h2>
			                            <p><a href="<?php echo $link; ?>" id="<?php echo $c_images['product_id']; ?>" attr-lang="<?php echo LANGUAGE; ?>" class="btn btn-default btn-lg mt20 quick_view JS_popwinbtn1">JETZT KAUFEN</a></p>
                            <?php
                            if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                            {
                                ?>
                                <p><a class="btn btn-default btn-lg mt20 JS_popwinbtn4">SEHEN SIE HIER</a></p>
                                <?php
                            }
                            ?>
			                            <div class="lookbook-share">
			                                <span>Teilen Mit:</span>
			                                <span class="sns fix">
			                                    <a rel="nofollow" href="http://www.facebook.com/sharer.php?u=<?php echo urlencode($link); ?>" target="_blank" class="sns1"></a>
			                                    <a rel="nofollow" href="http://twitter.com/share?url=<?php echo urlencode($link); ?>" target="_blank" class="sns2"></a>
			                                    <a rel="nofollow" href="http://pinterest.com/pin/create/button/?url=<?php echo urlencode($link); ?>&media=<?php echo Image::link($product->cover_image(), 1); ?>&description=<?php $product->get('name'); ?>" target="_blank" class="sns5"></a>
			                                </span>
			                            </div>
			                        </div>
		                        </div>		
                    		</div>
                    	</div>
                    </div>
                <?php
                if ($c_images['type'] != 1 && $c_images['link_sku'] && strlen($c_images['link_sku']) > 0)
                {
                    ?>
                    <div class="bottom">
                        <h2>Zu diesem Artikel Passen</h2>
                        <div class="JS_carousel2 product_carousel">
                            <ul class="fix hide-box-0">
                                <?php
                                $skus = explode(',', $c_images['link_sku']);
                                if (is_array($skus)):
                                    $n = 1;
                                    foreach ($skus as $sku):
                                        $pro_id = Product::get_productId_by_sku(trim($sku));
                                        if (!$pro_id)
                                        {
                                            continue;
                                        }
                                        if ($n > 8)
                                        {
                                            break;
                                        }
                                        $n++;
                                        ?>
                                        <li>
                                            <?php
                                            $link_pro = Product::instance($pro_id, LANGUAGE);
                                            if ($link_pro->get('visibility') != 1)
                                            {
                                                continue;
                                            }
                                            $orig_price = round($link_pro->get('price'), 2);
                                            $price = round($link_pro->price(), 2);
                                            ?>
                                            <a href="<?php echo $link_pro->permalink(); ?>" target="_blank"><img src="<?php echo Image::link($link_pro->cover_image(), 1); ?>" title="<?php echo $link_pro->get('name'); ?>" alt="<?php echo $link_pro->get('name'); ?>" /></a>
                                            <p class="price center">
                                                <b>
                                                <?php if ($orig_price > $price)
                                                {
                                                    ?>
                                                    <?php echo Site::instance()->price($price, 'code_view'); ?>
                                                    <del><?php echo Site::instance()->price($orig_price, 'code_view'); ?></del>
                                                    <?php
                                                }
                                                else
                                                {
                                                    echo Site::instance()->price($link_pro->get('price'), 'code_view');
                                                }
                                                ?>
                                                </b>
                                            </p>
                                        </li>
                                    <?php
                                    endforeach;
                                endif;
                                ?>
                            </ul>
                            <span class="prev1 JS_prev2"></span>
                            <span class="next1 JS_next2"></span>
                        </div>
                    </div>
                    <?php
                } 
                 }
                ?>					
					
                    <div class="lookbook-details row">
                    	<div class="col-xs-12 col-sm-5">
                    		<div class="reviews-sign mb20">
				                <h3>REVIEWS</h3>
				                <ul class="con">
                    <?php
                    if (count($reviews) > 0)
                    {
                        foreach ($reviews as $review)
                        {
                            $firstname = Customer::instance($review['user_id'])->get('firstname');
                            $date = date('d/m/Y', $review['created']);
                            ?>
				                    <li>
				                        <div class="clearfix">
				                        	<strong class="rating_show fll"><span class="rating_value<?php echo $review['star']; ?>">rating</span></strong>
				                        	<span class="time flr"><?php echo $firstname . ' on ' . $date; ?></span>
				                        </div>
				                        <p><?php echo $review['content']; ?></p>
				                    </li>
                            <?php
                        }
                    }
                    ?>
				                </ul>
				                <div class="clearfix">
								<?php echo $pagination; ?>
								</div>
				            </div>
                    	</div>
                    	<div class="col-xs-12 col-sm-5 col-md-offset-2">
                    		<div class="reviews-sign mb20">
	                    		<h3>WRITE A REVIEW</h3>
                    <?php
                    if ($customer_id = Customer::logged_in())
                    {
                        ?>
								<form class="signin-form sign-form form form2 user_form" method="post" action="<?php echo LANGPATH; ?>/site/lookbook_review" id="reviewForm">
									 <input type="hidden" name="type" value="1" />
                            <?php
                            if (count($reviews) == 0)
                            {
                                ?>
                                <b>Be the first to write a review</b>
							<?php
							}
							?>
							                     <ul class="mtb10">
                                <li class="fix">
                                    <label class="fll"><span>*</span>Grade:</label>
                                    <div class="right_box fll">
                                        <span class="rating_wrap fix">
                                            <input class="star" type="radio" name="star" value="1" />
                                            <input class="star" type="radio" name="star" value="2" />
                                            <input class="star" type="radio" name="star" value="3" />
                                            <input class="star" type="radio" name="star" value="4" />
                                            <input class="star" type="radio" name="star" value="5" checked="checked" />
                                        </span>
                                    </div>
                                </li>
                                <li class="fix">
                                    <label><span>*</span>Comment:</label>
                                    <div class="right_box"><textarea name="content"></textarea></div>
                                </li>
                                <li class="fix">
                                    <label for="submit">&nbsp;</label>
                                    <input type="hidden" name="lookbook_id" value="<?php echo $c_images['id']; ?>" />
                                    <input type="hidden" name="customer_id" value="<?php echo $customer_id; ?>" />
                                    <div class="right_box"><input type="submit" value="submit" class="view_btn btn26" /></div>
                                </li>
                            </ul>
                        </form>
                 <script>
                            $("#reviewForm").validate({
                                rules: {
                                    star: {
                                        required: true
                                    },
                                    content: {
                                        required: true,
                                        minlength: 5
                                    }
                                },
                                messages: {
                                    email:{
                                        required:"Please choose a grade."
                                    },
                                    password: {
                                        required: "Please input comment.",
                                        minlength: "Your comment must be at least 5 characters long."
                                    }
                                }
                            });
                        </script>
								<?php
									}
									else
									{
									?>
                 <form action="<?php echo LANGPATH; ?>/customer/login" method="post" class="form form1 user_form" id="loginForm">
                            <input type="hidden" value="<?php echo 'http://' . Site::instance()->get('domain') . '/lookbook/' . $c_images['id'] . '-1#pagefocus'; ?>" name="referer">
									<ul>
										<li>
											<div>
												<label>Email address:</label>
											</div>
											<input class="text" type="email" name="email" value="">
										</li>
										<li>
											<div>
												<label>Password:</label>
											</div>
											<input class="text" type="password" maxlength="16" name="password" value="">
										</li>
										<li>
											<input class="btn btn-primary btn-lg mr10" type="submit" name="submit" value="Sign In">
											<a class="text-underline" href="forgot-password.html">Forgot password?</a>
										</li>
										<li>
											<a class="facebook-btn" href="https://www.facebook.com/dialog/oauth?client_id=274338969357670&redirect_uri=http%3A%2F%2Fwww.choies.com%2F&state=1520f2d6acc5f5f2f6f7ea4e936dde9c&scope=email"></a>
										</li>
									</ul>
								</form>
                        <script>
                            $("#loginForm").validate({
                                rules: {
                                    email: {
                                        required: true,
                                        email: true
                                    },
                                    password: {
                                        required: true,
                                        minlength: 5,
                                        maxlength:20
                                    }
                                },
                                messages: {
                                    email:{
                                        required:"Please provide an email.",
                                        email:"Please enter a valid email address."
                                    },
                                    password: {
                                        required: "Please provide a password.",
                                        minlength: "Your password must be at least 5 characters long.",
                                        maxlength: "The password exceeds maximum length of 20 characters."
                                    }
                                }
                            });
                        </script>
    <?php
}
?>								
								
								
							</div>
                    	</div>
                    </div>
				</div>
			</div>
		</div>
<script type="text/javascript">
    $(function(){
        $('.grade').children().click(function(){
            var star = $(this).attr('alt');
            $('#star').val(star);
        })
    })
</script>

<?php echo View::factory(LANGPATH . '/quickview'); ?>
<div class="mybag hide" id="mybag" style="position: fixed;top: 10px;right: 140px; z-index:100px;z-index: 1000; background: #FFFFFF; border-color: #F6F6F7; border-style: solid;border-width: 8px 4px 4px;">
    <div class="add_tit" style="margin-top:0px;">Success! Item Added To BAG</div>
    <div class="order order_addtobag">
        <ul id="bag_items">
            <li>
            </li>
        </ul>
    </div>
    <div class="mybagButton"><a href="<?php echo LANGPATH; ?>/cart/view" id="checkout1" class="allbtn btn-chk1">&nbsp;</a></div>
</div>
<script type="text/javascript">
    $(function(){
        $(".btn_size input").live("click",function(){
            var qty = $(this).attr('title');
            if(qty)
                $("#only_left").html('Only '+qty+' Left!');
        });

    })
</script>

		<div id="gotop" class="hide ">
			<a href="#" class="xs-mobile-top"></a>
		</div>
	</div>
