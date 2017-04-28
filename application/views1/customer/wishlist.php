<section id="main">
	<!-- crumbs -->
	<div class="container">
		<div class="crumbs">
			<div>
				<a href="<?php echo LANGPATH; ?>/">home</a>
				<a href="<?php echo LANGPATH; ?>/customer/summary" class="visible-xs-inline hidden-sm hidden-md hidden-lg"> > my account</a> > wish list
			</div>
            <?php echo Message::get(); ?>
		</div>
	</div>
	<!-- main-middle begin -->
	<div class="container">
		<div class="row">
<?php echo View::factory('customer/left'); ?>
<?php echo View::factory('customer/left_1'); ?>
			<article class="user col-sm-9 hidden-xs">
				<div class="tit">
					<h2>Wishlist</h2>
				</div>
				<p>You may add products to your wishlist for later view or purchase!</p>
				<table class="user-table wish-list-table">
					<tr>
						<th width="45%">Product Info</th>
						<th width="20%">Availability</th>
						<th width="20%">Price</th>
						<th width="15%">Action</th>
					</tr>
        <?php
        foreach ($wishlists as $wishlist):
            if (!Product::instance($wishlist['product_id'])->get('visibility'))
                continue;
            $link = Product::instance($wishlist['product_id'])->permalink();
            ?>
					<tr>
						<td>
							<div class="product-info">
								<div class="left">
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo Image::link(Product::instance($wishlist['product_id'])->cover_image(), 3); ?>" />
                            </a>
								</div>
								<div class="right">
                            <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'])->get('name'); ?></a>
									<p>Item :<?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								</div>
							</div>
						</td>
                <td>
                    <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'In Stock' : 'Out Stock';
                    ?>
                </td>
                <td><?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></td>
						<td>
		      <?php if ($status): ?>				
						<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">View Details</a>
			    <?php endif; ?>
							<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
						</td>
					</tr>
            <?php
        endforeach;
        ?>
				</table>
    <?php echo $pagination; ?>  
			<!--	<div class="tol-page">
					<div class="records">2 Records Found</div>
					<ul class="pagination flr">
					    <li class="disabled"><a href="#">« PRE</a></li>
					    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
					    <li><a href="#">2</a></li>
					    <li><a href="#">3</a></li>
					    <li><a href="#">4</a></li>
					    <li><a href="#">5</a></li>
					    <li><a href="#">NEXT »</a></li>
					</ul>
				</div>	-->
			</article>
			<article class="wish-list-mobile col-xs-12 hidden-sm hidden-md hidden-lg">
        <?php
        foreach ($wishlists as $wishlist){
            if (!Product::instance($wishlist['product_id'])->get('visibility'))
                continue;
            $link = Product::instance($wishlist['product_id'])->permalink();
            ?>
				<table class="user-table">
					<tbody>

						<tr>
							<td width="20%" align="left">
                            <a href="<?php echo $link; ?>">
                                <img src="<?php echo Image::link(Product::instance($wishlist['product_id'])->cover_image(), 3); ?>" />
                            </a>
							</td>
							<td width="65%">
                            <a href="<?php echo $link; ?>" class="name"><?php echo Product::instance($wishlist['product_id'])->get('name'); ?></a>
								<p>Item: #<?php echo Product::instance($wishlist['product_id'])->get('sku'); ?></p>
								<P>Price:<?php echo Site::instance()->price(Product::instance($wishlist['product_id'])->price(), 'code_view'); ?></P>
								<P>                            <?php
                    $status = Product::instance($wishlist['product_id'])->get('status');
                    echo $status ? 'In Stock' : 'Out Stock';
                    ?></P>	    <?php if ($status): ?>
								<a href="<?php echo $link; ?>" class="btn btn-primary btn-xs">ADD TO BAG</a>
								 <?php endif; ?>
							</td>
							<td width="15%">
								<a href="<?php echo LANGPATH; ?>/wishlist/delete/<?php echo $wishlist['id']; ?>" class="del-btn"></a>
							</td>
						</tr>
					</tbody>
				</table> 
		<?php } ?>
				<!--<div class="tol-page">
					<div class="records">2 Records Found</div>
					<ul class="pagination flr">
					    <li class="disabled"><a href="#">« PRE</a></li>
					    <li class="active"><a href="#">1 <span class="sr-only">(current)</span></a></li>
					    <li><a href="#">2</a></li>
					    <li><a href="#">3</a></li>
					    <li><a href="#">4</a></li>
					    <li><a href="#">5</a></li>
					    <li><a href="#">NEXT »</a></li>
					</ul>
				</div>   -->         <?php echo $pagination; ?>  
			</article>
		</div>
	</div>
</section>
