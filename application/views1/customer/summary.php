<!-- main begin -->
<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">home</a> > my account
			</div>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php
$url = URL::current(0);
$lists = array(
    'My Orders' => array(
        array(
            'name' => 'Order History',
            'link' => '/customer/orders'
        ),
        array(
            'name' => 'Unpaid Orders',
            'link' => '/customer/unpaid_orders'
        ),
        array(
            'name' => 'Items to review',
            'link' => '#'
        ),
        array(
            'name' => 'Wishlist',
            'link' => '/customer/wishlist'
        ),
        array(
            'name' => 'Track Order',
            'link' => '/tracks/track_order'
        ),
    ),
    'My Profile' => array(
        array(
            'name' => 'Account Setting',
            'link' => '/customer/profile'
        ),
        array(
            'name' => 'Change Password',
            'link' => '/customer/password'
        ),
        array(
            'name' => 'Address Book',
            'link' => '/customer/address'
        ),
        array(
            'name' => 'Create Address',
            'link' => '/address/add'
        )
    ),
    'MY POINTS&COUPONS' => array(
        array(
            'name' => 'Points History',
            'link' => '/customer/points_history'
        ),
        array(
            'name' => 'Social Sharing Bonus',
            'link' => '#'
        ),
        array(
            'name' => 'My Coupons',
            'link' => '/customer/coupons'
        ),
    ),
);

$customer_id = Customer::logged_in();
$email = Customer::instance($customer_id)->get('email');
$vip_level = Customer::instance($customer_id)->get('vip_level');
if(intval($vip_level)>0){
$lists['MY PREVILEGES'][]=array(
                    'name' => 'VIP Entrance',
                    'link' => '/activity/vip_exclusive'
                );
        
    
}
$celebrity = DB::select('id')->from('celebrits')->where('email', '=', $email)->execute()->get('id');

if ($celebrity)
{
    $lists['My Profile'][] = array(
        'name' => 'My Blog Show',
        'link' => '/customer/blog_show'
    );
}
?>
<aside id="aside" class="col-sm-3 col-xs-10 col-xs-offset-2 col-sm-offset-0">
    <a href="<?php echo LANGPATH; ?>/customer/summary" class="user-home hidden-xs">My Account</a>
    <?php
    foreach ($lists as $title => $link):
        ?>
        <div class="category-box aside-box">
            <h3 class="bg"><?php echo $title; ?></h3>
            <ul class="scroll-list">
                <?php
                foreach ($link as $l):
                    if (!$l['link'] OR $l['link'] == '#')
                        continue;
                    ?>
                    <li><a  href="<?php echo $l['link']; ?>"<?php if ($url == $l['link']) echo ' class="on"'; ?>><?php echo $l['name']; ?></a></li>
                    <?php
                endforeach;
                ?>
            </ul>
        </div>
        <?php
    endforeach;
    ?>
    <a href="<?php echo LANGPATH; ?>/customer/logout" class="user-home">Sign Out</a>
</aside>

					<article class="user user-account col-sm-9 hidden-xs">
						<dl>
							<dt>Hi, <?php echo $customer->get('firstname') ? $customer->get('firstname') : 'Choieser'; ?> . Welcome to Choies.</dt>
							<dd>VIP Member or Not:<strong class="mr10"> <?php if($is_vip){ echo "Yes";}else{ echo "No";}?></strong>
							<?php
								if($vip_end){
							?>
							<span>Expires on: <strong><?php echo $vip_end?></strong></span></dd>
							<?php
								}
							?>
						</dl>				

						<!-- vip -->
						<div class="vip JS_clickcon hide">
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr>
									<th width="15%" class="first">
										<div class="r">Privileges</div>
										<div>VIP Level</div>
									</th>
									<th width="20%">Accumulated Transaction Amount</th>
									<th width="16%">Extra Discounts for Items</th>
									<th width="16%">Points Use Permissions</th>
									<th width="15%">Order Points Reward</th>
									<th width="18%">Other Privileges</th>
								</tr>
								<tr>
									<td><span class="icon-nonvip" title="Non-VIP"></span><strong>Non-VIP</strong>
									</td>
									<td>$0</td>
									<td>/</td>
									<td rowspan="6">
										<div>You may apply Points equaling up to only 10% of your order value.</div>
									</td>
									<td rowspan="6">$1 = 1 points</td>
									<td>15% off Coupon Code</td>
								</tr>
								<tr>
									<td><span class="icon-vip" title="Diamond VIP"></span><strong>VIP</strong>
									</td>
									<td>$1 - $199</td>
									<td>/</td>
									<td rowspan="5">
										<div>Get double shopping points during major holidays.
											<br /> Special birthday gift.
											<br /> And More...</div>
									</td>
								</tr>
								<tr>
									<td><span class="icon-bronze" title="Bronze VIP"></span><strong>Bronze VIP</strong>
									</td>
									<td>$199 - $399</td>
									<td>5% OFF</td>
								</tr>
								<tr>
									<td><span class="icon-silver" title="Silver VIP"></span><strong>Silver VIP</strong>
									</td>
									<td>$399 - $599</td>
									<td>8% OFF</td>
								</tr>
								<tr>
									<td><span class="icon-gold" title="Gold VIP"></span><strong>Gold VIP</strong>
									</td>
									<td>$599 - $1999</td>
									<td>10% OFF</td>
								</tr>
								<tr>
									<td><span class="icon-diamond" title="Diamond VIP"></span><strong>Diamond VIP</strong>
									</td>
									<td>&ge; $1999</td>
									<td>15% OFF</td>
								</tr>
							</table>
						</div>
						<!--order-list-->
            <?php if(!empty($orders)){ ?>
						<div class="order-list fix">
						<h4 style="font-size:18px;margin-bottom:10px;font-weight:normal;">Below are your recent orders: </h4>
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr bgcolor="#e4e4e4">
									<th width="20%"><strong>Order Date</strong>
									</th>
									<th width="20%"><strong>Order No.</strong>
									</th>
									<th width="15%"><strong>Order Total</strong>
									</th>
									<th width="15%"><strong>Shipping</strong>
									</th>
									<th width="15%"><strong>Order Status</strong>
									</th>
									<th width="15%"><strong>Action</strong>
									</th>
								</tr>
                  <?php foreach($orders as $order){ 
                    $currency = Site::instance()->currencies($order['currency']);
                    ?>

								<tr>
                    <td><?php echo date('n/j/Y H:i:s', $order['created']); ?></td>
                    <td><a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>"><?php echo $order['ordernum']; ?></a></td>
                    <td><?php echo $currency['code'] . round($order['amount'], 2); ?></td>
                    <td><?php echo $currency['code'] . round($order['amount_shipping'], 2); ?></td>
                    <td>
                    <?php
                        if($order['refund_status'])
                        {
                            $status = str_replace('_', ' ', $order['refund_status']);
                        }else{
                            if($order['shipping_status']=="new_s" OR $order['payment_status']=="cancel")
                            {
                                $status = kohana::config('order_status.payment.' . $order['payment_status'] . '.name');
                                if ($status == 'New' OR $status == 'new'){ $status = 'Unpaid'; }
                            }else{
                                $status=$order['shipping_status'];
                                if ($status == 'partial_shipped'){ $status = 'Partial Shipped'; }
                            }
                        }
                        echo ucfirst($status);
                        ?>
                    </td>
                    <td>
                    <?php
                    if($order['shipping_status'] == 'shipped' OR $order['shipping_status'] == 'partial_shipped'){
                        ?>
                        <a href="/tracks/customer_track?id=<?php echo $order['ordernum']; ?>" class="order-list-btn">Track</a>
                    <?php }else{
                    if ($order['payment_status'] == 'success' OR $order['payment_status'] == 'verify_pass')
                    {?>
                    <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">View Details</a>
                    <?php }elseif (!$order['refund_status'] AND $order['amount'] > 0 AND ($order['payment_status']=="new" or $order['payment_status']=="failed")){ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>" class="btn btn-primary btn-xs">To pay</a>
                    <?php }else{ ?>
                        <a href="<?php echo LANGPATH; ?>/order/view/<?php echo $order['ordernum']; ?>">View Details</a>
                    <?php } ?>
                        
                    <?php }?>
                    </td>
								</tr>

                  <?php } ?>
							</table>

						</div>
		          <?php } ?>				
	
					<?php 
						if(!empty($view_history)){
						$i=0; 
						$count=count($view_history);
						$num=ceil($count/7);
					?>	
						<div class="box-dibu1">
                            <div class="w-tit">
								<h2>Recently Viewed</h2>
							</div>
							<div id="personal-recs">
                <?php foreach($view_history as $id){
                if($i==0){ ?>
								<div class="hide-box1-0">
									<ul>
                <?php }elseif($i%7==0){ ?>
                <div class="hide-box1-<?php echo ceil($i/7); ?> hide">
									<ul>
                <?php } ?>

                <li><a href="<?php echo Product::instance($id)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
				 <?php
                $i++;
                if($i%7==0){
                    echo "</ul></div>";
                }
                }  ?>
					
				</div>
					</div>
							<div id="JS-current1" class="box-current">
								<ul>
									<li class="on"></li>
            <?php for($j=0;$j<$num-1;$j++){ ?>
            <li></li>
            <?php } ?>
								</ul>
							</div>
		<?php		}else{ ?>
		
							<div class="recently-viewed">
                            <div class="w-tit">
								<h2>Best Seller</h2>
							</div>
							<div id="personal-recs">
                <?php 
                $i=0;
                $top_seller = Catalog::instance(32)->products();
                foreach($top_seller as $id){
                    if($i>9)break;
                     $stock = Product::instance($id)->get('stock');
                     if ($stock == 0)
                                continue;
                            elseif ($stock == -1)
                            {
                                $stocks = DB::select(DB::expr('SUM(stocks) AS sum'))
                                                ->from('product_stocks')
                                                ->where('product_id', '=', $id)
                                                ->where('attributes', '<>', '')
                                                ->execute()->get('sum');
                                if (!$stocks)
                                    continue;
                            }
                if($i==0){ ?>
								<div class="hide-box1-0">
									<ul>
                <?php }elseif($i%7==0){ ?>
                <div class="hide-box1-<?php echo ceil($i/7); ?> hide">
                <ul>
                <?php } ?>

                <li><a href="<?php echo Product::instance($id)->permalink(); ?>">
                    <img src="<?php echo Image::link(Product::instance($id)->cover_image(), 7); ?>" width="150"  /></a>
                  <p class="price">
                      <b><?php echo Site::instance()->price(Product::instance($id)->price(), 'code_view'); ?></b>
                   </p>
                </li>
				 <?php
                $i++;
                if($i%7==0){
                    echo "</ul></div>";
                }
                }  ?>
					
				</div>
					</div>
					</div>
							<div id="JS-current1" class="box-current">
								<ul>
									<li class="on"></li>
									<?php 
									$num=ceil($i/7);
									for($j=0;$j<$num-1;$j++){ ?>
									<li></li>
									<?php } ?>
								</ul>
							</div>
		
	        <?php } ?>  			
					</article>
		    </div>
		</div>
	</div>
</section>
<script type="text/javascript">
var f=0;
var t1;
var tc1;
$(function(){
$(".box-current1 li").hover(function(){
$(this).addClass("on").siblings().removeClass("on");
var c=$(".box-current1 li").index(this);
$(".hide-box1-0,.hide-box1-1,.hide-box1-2,.hide-box1-3").hide();
$(".hide-box1-"+c).fadeIn(150);
f=c;
})
})
</script>
<script src="/assets/js/buttons.js"></script>
<script src="/assets/js/product-rotation.js"></script>



