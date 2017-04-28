<?php
defined ( 'SYSPATH' ) or die ( 'No direct script access.' );
class Controller_Webpower extends Controller_Webpage
 {
	public function action_mihqtgylls() 
	{
		
		ingore_user_abort ( true );
		set_time_limit ( 0 );
		
		// 为什么定义美国与欧美
		$fileurls = array (
				"All" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.txt" 
		);
		
		if (! file_exists ( $fileurl )) 		// 如果文件不存在，则实现导出
		{
			$this->_daochutxt ();
		} else {
			$result = @unlink ( $fileurl ); // 如果存在文件，则删除文件，并实现导出txt与feed
			$this->_daochutxt ();
		}
		echo "<br />suceess";
		exit ();
	}
	
	
	public function _daochutxt() 
	{
		ignore_user_abort ( true );
		set_time_limit ( 0 );
		ini_set ( 'memory_limit', '512M' );
		
		$local_directory = '/home/data/www/htdocs/clothes/googleproduct/';
		
		$head_gooproductinfo = array (
				'SKU',
				'Name',
				'URL to product',
				'Retail Price',
				'URL to image',
				'Commission',
				'Category',
				'SubCategory',
				'Description',
				'SearchTerms',
				'Status',
				'image_link',
				'Your MerchantID',
				'Custom 1',
				'Custom 2',
				'Custom 3',
				'Custom 4',
				'Custom 5',
				'Manufacturer',
				'PartNumber',
				'MerchantCategory',
				'MerchantSubcategory',
				'Short Description',
				'ISBN',
				'UPC',
				'CrossSell',
				'MerchantGroup',
				'MerchantSubgroup',
				'CompatibleWith',
				'CompareTo',
				'QuantityDiscount',
				'Bestseller',
				'AddToCartURL',
				'ReviewsRSSURL',
				'Option1',
				'Option2',
				'Option3',
				'Option4',
				'Option5',
				'ReservedForFutureUse',
				'	
					ReservedForFutureUse',
				'ReservedForFutureUse',
				'ReservedForFutureUse',
				'ReservedForFutureUse',
				'ReservedForFutureUse',
				'	ReservedForFutureUse',
				'ReservedForFutureUse',
				'ReservedForFutureUse',
				'	ReservedForFutureUse' 
		);
		$file_name = "choies_googleshopping_feed.txt";
		
		$open = fopen ( $local_directory . $file_name, "w" );
		$head = implode ( "\t", $head_gooproductinfo );
		fwrite ( $open, $head . "\n" );
		
		$time = time ();
		$b = 86400 * 15;
		$time = $time - $b;
		
		// 去数据库里找所以产品内容
		$conn = @mysql_connect ( "localhost", "root", " " ) or die ( "连接失败" );
		$sql = "select * from products order by created DESC";
		$attr = mysql_query ( $sql, $conn );
		$row = mysql_fetch_array ( $attr );
		echo $row [Name];
		echo $row [Age];
		echo $row [Classname];
		
		/*
		 * foreach($attr as $v){ $vv[]= $v['id']; }
		 */
		
		foreach ( $attr as $product )
		 {
			$data = array ();
			$str = "";
			
			$product_instance = Product::instance ( $product ['id'] );
			
			$imageURL = Image::link ( $product_instance->cover_image (), 9 );
			
			$set_name = Set::instance ( $product ['set_id'] )->get ( 'name' );
			
			$data [] = $product ['sku'];
			if (empty ( $product ['pla_name'] )) {
				$data [] = "choies " . $product ['name'];
			} else {
				$data [] = $product ['pla_name'];
			}
			
			$data [] = "Choies";
			$str = implode ( "\t", $data );
			fwrite ( $open, $str . PHP_EOL );
		}
		$re = fclose ( $open );
		echo "pla success";
	}
}