<?php

defined('SYSPATH') or die('No direct script access.');


class Controller_Webpowerfor extends Controller_Webpage
{
    
   
   
    
    //google product 定时导出
    public function action_mihqtgylls()
    { 
        ignore_user_abort(true);
        set_time_limit(0);
        //为什么定义美国与欧美
        // 
        $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'US' or country='EN' and status =1  ")->execute('slave')->as_array();
        if($arr){
            $feed='.'.$arr[0]['feed'];
            $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".txt");     

        }

        foreach ($fileurls as $k => $fileurl)
        {
            if (!file_exists($fileurl))//如果文件不存在，则实现导出
            {
                $this->_daochutxtforsize($k);
            }
            else
            {
                $result = @unlink($fileurl); //如果存在文件，则删除文件，并实现导出txt与feed
                $this->_daochutxtforsize($k);
                #$this->_daochufeed();
            }
        }
        die;

        $fileurl5 = "/home/data/www/htdocs/clothes/Export/shopalike.csv";
        if (!file_exists($fileurl5))
        {
            self::twdatafeed();
        }
        else
        {
            $lasttime5 = filemtime($fileurl5);
            if ($lasttime5 && (time() - $lasttime5 >= 86400))
            {
                self::twdatafeed();
            }
        }

        //by chencaihong
        //$fileurl2="/var/www/htdocs/choies/cjfeed.csv";
        $fileurl2 = "/home/data/www/htdocs/clothes/Export/cjfeed.csv";
        if (!file_exists($fileurl2))
        {
            self::cjdatafeed();
        }
        else
        {
            $lasttime2 = filemtime($fileurl2);
            if ($lasttime2 && (time() - $lasttime2 >= 86400))
            {
                self::cjdatafeed();
            }
        }

        //by wangshuiyan
        $fileurl3 = "/home/data/www/htdocs/clothes/Export/datafeed.csv";
        if (!file_exists($fileurl3))
        {
            self::datafeed();
        }
        else
        {
            $lasttime3 = filemtime($fileurl3);
            if ($lasttime3 && (time() - $lasttime3 >= 86400))
            {
                self::datafeed();
            }
        }
       
        //by zhangchunmei   2015.6.25
        
        $fileurl4 = "/home/data/www/htdocs/clothes/Export/Xmldatafeed.csv";
        if (!file_exists($fileurl4))
        {
            self::Xmldatafeed();
        }
        else
        {
            $lasttime4 = filemtime($fileurl4);
            if ($lasttime4 && (time() - $lasttime4 >= 86400))
            {
                self::Xmldatafeed();
            }
        }
        
        echo "<br />suceess";
        exit;
    }

    public function action_guoaddforcitro()
    {
        $fileurl5 = "/home/data/www/htdocs/clothes/googleproduct/choies_criteo_feed.csv";
        if (!file_exists($fileurl5))
        {
            $k = 'US';
            self::daochucsv($k);
        }
        else
        {
            $lasttime5 = filemtime($fileurl5);
            if ($lasttime5 && (time() - $lasttime5 >= 86400))
            {
                $k = 'US';
                self::daochucsv($k);
            }
        }        
    }
    


    public function action_mihqtgyllsuk()
    {
        ignore_user_abort(true);
        set_time_limit(0);
         $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'UK' and status=1 ")->execute('slave')->as_array();
        if($arr){;
            $feed='.'.$arr[0]['feed'];
             $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".uk.txt");     
         
        }
      /*  else{
               $fileurls = array("UK" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.uk.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        }*/
     
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtforsize($k);
            }
            else
            {
                $result = @unlink($fileurl); 
                $this->_daochutxtforsize($k);
            }
        }

        echo "<br />suceess";
        exit;
    }       
    
    
    public  function  action_getp(){
        
   phpinfo();       
        exit('e');
    }
    
    public function action_mihqtgyllsau()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'AU' and status=1 ")->execute('slave')->as_array();
        if($arr){
            $feed='.'.$arr[0]['feed'];
            $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".au.txt");     
         
        }
        foreach ($fileurls as $k => $fileurl)
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtforsize($k);
            }
            else
            {
                $result = @unlink($fileurl); 
                $this->_daochutxtforsize($k);
            }
        }

        echo "<br />suceess";
        exit;
    }   
    
    public function action_mihqtgyllsde()
    {
        ignore_user_abort(true);
        set_time_limit(0);
          $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'DE' and status=1 ")->execute('slave')->as_array();
        if($arr){
            $feed='.'.$arr[0]['feed'];
            $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".de.txt");     
         
        }
        
        foreach ($fileurls as $k => $fileurl)
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtforsize($k);
            }
            else
            {
                $result = @unlink($fileurl); 
                $this->_daochutxtforsize($k);
            }
        }

        die;
        //by chencaihong
        $fileurl3 = "/home/data/www/htdocs/clothes/Export/cjfeed-de.csv";
        if (!file_exists($fileurl3))
        {
            self::cjdatafeed('de');
        }
        else
        {
            $lasttime3 = filemtime($fileurl3);
            if ($lasttime3 && (time() - $lasttime3 >= 86400))
            {
                self::cjdatafeed('de');
            }
        }
        echo "<br />suceess";
        exit;
    }

    public function action_mihqtgyllses()
    {
        ignore_user_abort(true);
        set_time_limit(0);
           $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'ES'  and status=1")->execute('slave')->as_array();
        if($arr){
            $feed='.'.$arr[0]['feed'];
            $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".es.txt");     
         
        }
        foreach ($fileurls as $k => $fileurl)
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtforsize($k);
            }
            else
            {   
                $result = @unlink($fileurl); 
                $this->_daochutxtforsize($k);
                
            }
        }
        die;
        //by chencaihong
        $fileurl2 = "/home/data/www/htdocs/clothes/Export/cjfeed-es.csv";
        if (!file_exists($fileurl2))
        {
            self::cjdatafeed('es');
        }
        else
        {
            $lasttime2 = filemtime($fileurl2);
            if ($lasttime2 && (time() - $lasttime2 >= 86400))
            {
                self::cjdatafeed('es');
            }
        }
        echo "<br />suceess";
        exit;
    }

    public function action_mihqtgyllsfr()
    {
        ignore_user_abort(true);
        set_time_limit(0);
            $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'FR' and status=1 ")->execute('slave')->as_array();
        if($arr){
            $feed='.'.$arr[0]['feed'];
            $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".fr.txt");     
         
        }
        foreach ($fileurls as $k => $fileurl)
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtforsize($k);
            }
            else
            {
                $result = @unlink($fileurl); 
                $this->_daochutxtforsize($k);
            }
        }
        die;
        //by chencaihong
        $fileurl2 = "/home/data/www/htdocs/clothes/Export/cjfeed-fr.csv";
        if (!file_exists($fileurl2))
        {
            self::cjdatafeed('fr');
        }
        else
        {
            $lasttime2 = filemtime($fileurl2);
            if ($lasttime2 && (time() - $lasttime2 >= 86400))
            {
                self::cjdatafeed('fr');
            }
        }
        echo "<br />suceess";
        exit;
    }

    public function action_mihqtgyllsru()
    {
        ignore_user_abort(true);
        set_time_limit(0);
      
        $fileurls = array("RU" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.ru.txt");

        
        foreach ($fileurls as $k => $fileurl)
        {
            if (!file_exists($fileurl))
            {  
                
                $this->_daochutxt($k);
            }
            else
            {
                $result = @unlink($fileurl); 
                $this->_daochutxt($k);
            }
        }

        //by chencaihong
        $fileurl2 = "/home/data/www/htdocs/clothes/Export/cjfeed-ru.csv";
        if (!file_exists($fileurl2))
        {
            self::cjdatafeed('ru');
        }
        else
        {
            $lasttime2 = filemtime($fileurl2);
            if ($lasttime2 && (time() - $lasttime2 >= 86400))
            {
                self::cjdatafeed('ru');
            }
        }
        echo "<br />suceess";
        exit;
    }

    
  /*   by zhangchunmei   
   *  CA */ 
   public function action_mihqtgyllsTxtca()
    {
        ignore_user_abort(true);
        set_time_limit(0);
          $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country = 'CA'  and status=1")->execute('slave')->as_array();
        if($arr){
            $feed='.'.$arr[0]['feed'];
            $country=$arr[0]['country'];
            $fileurls = array($country => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed".$feed.".ca.txt");     
         
        }
        
       
        
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {       
            if (!file_exists($fileurl))
            {                
                $this->_daochutxtReplenish($k);
            }
            else
            {
                $result = @unlink($fileurl);             
                $this->_daochutxtReplenish($k);             
            }
        }

        //guo add
/*        $fileurl5 = "/home/data/www/htdocs/clothes/googleproduct/choies_criteo_feed.ca.csv";
        if (!file_exists($fileurl5))
        {
            $k = 'CA';
            self::daochucsv1($k);
        }
        else
        {
            $lasttime5 = filemtime($fileurl5);
            if ($lasttime5 && (time() - $lasttime5 >= 86400))
            {
                $k = 'CA';
                self::daochucsv1($k);
            }
        }*/

/*        $k = "FR";
        $this->_daochutxttwocach($k);*/
        echo "<br />suceess";
        exit;
    }

    // ch fr
   public function action_mihqtgyllsTxtchfr()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurls = array("FR" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.ch.fr.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {            
            if (!file_exists($fileurl))
            {                  
                // ch fr 
                $this->_daochutxttwoch($k);
            }
            else
            {     
                // ch fr            
                $result = @unlink($fileurl);               
                $this->_daochutxttwoch($k);              
            }
        }


        echo "<br />suceess";
        exit;
    }
  
    
    /*   by zhangchunmei
     *  CH 瑞士
        */
    
    public function action_mihqtgyllsTxtch()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurls = array("CH" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.ch.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtReplenish($k);
            }
            else
            {
                $result = @unlink($fileurl);
                $this->_daochutxtReplenish($k);
            }
        }
/*        $k = "DE";       //ch de 
        $this->_daochutxttwocach($k);
        $a = "FR";  
        $this->_daochutxttwoch($a);
        echo "<br />suceess";*/
        exit;
    }
    
    /*   by zhangchunmei
     *  mx  */
    public function action_mihqtgyllsTxtmx()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurls = array("MX" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.mx.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtReplenish($k);
            }
            else
            {
                $result = @unlink($fileurl);
                $this->_daochutxtReplenish($k);
            }
        }
        echo "<br />suceess";
        exit;
    }
    
    /*   by zhangchunmei
     *  at  */
    public function action_mihqtgyllsTxtat()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurls = array("AT" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.at.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtReplenish($k);
            }
            else
            {
                $result = @unlink($fileurl);
                $this->_daochutxtReplenish($k);
            }
        }
        echo "<br />suceess";
        exit;
    }
   
    /*   by zhangchunmei
     *  be  */
    public function action_mihqtgyllsTxtbe()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurls = array("BE" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.be.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxtReplenish($k);
            }
            else
            {
                $result = @unlink($fileurl);
                $this->_daochutxtReplenish($k);
            }
        }
        echo "<br />suceess";
        exit;
    }

    public function action_mihqtgyllsausize()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurls = array("AU" => "/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_feed.ausize.txt"); //定义 一个文件路径，初始默认为UK（这个路径在哪？）
        foreach ($fileurls as $k => $fileurl) //循环文件，如果没内容，则调用本类中的_daochutxt($k)方法
        {
            if (!file_exists($fileurl))
            {
                $this->_daochutxt2($k);
            }
            else
            {
                $result = @unlink($fileurl);
                $this->_daochutxt2($k);
            }
        }
        echo "<br />suceess";
        exit;   
    }
    
    
    public function action_createxml()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurls = array("US" => "/home/data/www/htdocs/clothes/sitemap.xml");
        $fileurl1 = "/home/data/www/htdocs/clothes/sitemap_category.xml";
        $fileurl2 = "/home/data/www/htdocs/clothes/sitemap_product.xml";

        foreach ($fileurls as $k => $fileurl) 
        {
            if (!file_exists($fileurl))
            {
/*                self::xmldata1($k,$fileurl);*/
                self::xmldata2($k,$fileurl1);
                self::xmldata3($k,$fileurl2);
            }
            else
            {
/*                $result = @unlink($fileurl); 
                $result1 = @unlink($fileurl1); 
                $result = @unlink($fileurl2); */
            //    self::xmldata1($k,$fileurl);
                self::xmldata2($k,$fileurl1);
                self::xmldata3($k,$fileurl2);
            }
        }

    }

    public function action_createxmltwo()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurls = array("US" => "/home/data/www/htdocs/clothes/sitemap.xml");
        $fileurl1 = "/home/data/www/htdocs/clothes/sitemap_category.xml";
        $fileurl2 = "/home/data/www/htdocs/clothes/sitemap_product.xml";

        foreach ($fileurls as $k => $fileurl) 
        {
            if (!file_exists($fileurl))
            {
                self::xmldata1($k,$fileurl);
                self::xmldata2($k,$fileurl1);
                self::xmldata3($k,$fileurl2);
            }
            else
            {
                self::xmldata1($k,$fileurl);
                self::xmldata2($k,$fileurl1);
                self::xmldata3($k,$fileurl2);
            }
        }  
    }

    public function action_createxmlfr()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurls = array("FR" => "/home/data/www/htdocs/clothes/sitemap_category_fr.xml");
        $fileurl2 = "/home/data/www/htdocs/clothes/sitemap_product_fr.xml";

        foreach ($fileurls as $k => $fileurl) 
        {
            if (!file_exists($fileurl))
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
            else
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
        }

    }

    public function action_createxmlde()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurls = array("DE" => "/home/data/www/htdocs/clothes/sitemap_category_de.xml");
        $fileurl2 = "/home/data/www/htdocs/clothes/sitemap_product_de.xml";

        foreach ($fileurls as $k => $fileurl) 
        {
            if (!file_exists($fileurl))
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
            else
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
        }
    }

    public function action_createxmles()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurls = array("ES" => "/home/data/www/htdocs/clothes/sitemap_category_es.xml");
        $fileurl2 = "/home/data/www/htdocs/clothes/sitemap_product_es.xml";

        foreach ($fileurls as $k => $fileurl) 
        {
            if (!file_exists($fileurl))
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
            else
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
        }
    }

    public function action_createxmlru()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurls = array("RU" => "/home/data/www/htdocs/clothes/sitemap_category_ru.xml");
        $fileurl2 = "/home/data/www/htdocs/clothes/sitemap_product_ru.xml";

        foreach ($fileurls as $k => $fileurl) 
        {
            if (!file_exists($fileurl))
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
            else
            {
                self::xmldata2($k,$fileurl);
                self::xmldata3($k,$fileurl2);
            }
        }
    }

    public static function xmldata1($k,$fileurl)
    {
        ini_set('memory_limit', '512M');
        $filetime = date("Y-m-d", time());  
        if ($k != "US")
        {
            $data_array1 = array(
                array(
                    'loc' => 'http://www.choies.com/sitemap_category_'.strtolower($k).'.xml.gz',
                    'lastmod' => $filetime
                ),
            ); 

            $data_array2 = array(
                array(
                    'loc' => 'http://www.choies.com/sitemap_product_'.strtolower($k).'.xml.gz',
                    'lastmod' => $filetime
                ),
            ); 
        }
        else
        {
            $data_array1 = array(
                array(
                    'loc' => 'http://www.choies.com/sitemap_category.xml.gz',
                    'lastmod' => $filetime
                ),
                array(
                    'loc' => 'http://www.choies.com/sitemap_category_de.xml.gz',
                    'lastmod' => $filetime
                ),
                array(
                    'loc' => 'http://www.choies.com/sitemap_category_es.xml.gz',
                    'lastmod' => $filetime
                ),
                array(
                    'loc' => 'http://www.choies.com/sitemap_category_fr.xml.gz',
                    'lastmod' => $filetime
                ),
            ); 

            $data_array2 = array(
                array(
                    'loc' => 'http://www.choies.com/sitemap_product.xml.gz',
                    'lastmod' => $filetime
                ),
                array(
                    'loc' => 'http://www.choies.com/sitemap_product_de.xml.gz',
                    'lastmod' => $filetime
                ),
                array(
                    'loc' => 'http://www.choies.com/sitemap_product_es.xml.gz',
                    'lastmod' => $filetime
                ),
                array(
                    'loc' => 'http://www.choies.com/sitemap_product_fr.xml.gz',
                    'lastmod' => $filetime
                ),
            ); 
        }   


        $data_array = array_merge($data_array1, $data_array2);

        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        //  输出方式，也可以设置为某个xml文件地址，直接输出成文件
        $xml->setIndentString('  ');
        $xml->setIndent(true);

        $xml->startDocument('1.0', 'utf-8');
        //  开始创建文件
        //  根结点
        $xml->startElement('sitemapindex');

        //写入属性
        $xml->writeAttribute('xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9");
        foreach ($data_array as $data)
        {
            $xml->startElement('sitemap');

            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
            $xml->endElement(); //  item
        }

        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';
        die;
    }
    public function action_xml_review()
    {
        self::xml_review();
    }
    public static function xml_review()
    {
        $title=Site::instance()->get('meta_title');
        $pinfos = DB::query(DATABASE::SELECT, 'SELECT r.product_id pid, p.sku sku,r.firstname f_name,r.time time,r.content content,rs.rating rate
                                    from reviews r
                                    left join products p on r.product_id=p.id 
                                    left join review_statistics rs on r.product_id=rs.product_id
                                    order by r.product_id')->execute('slave')->as_array();


        $xml = new XMLWriter();
        $xml->openUri("/home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_review.xml");///home/data/www/htdocs/clothes/googleproduct/choies_googleshopping_review.xml
        //  输出方式，也可以设置为某个xml文件地址，直接输出成文件
        $xml->setIndentString('  ');
        $xml->setIndent(true);

        $xml->startDocument('1.0', 'UTF-8'); 
        $xml->startElement('feed'); 
        $xml->writeAttribute('xmlns:vc',"http://www.w3.org/2007/XMLSchema-versioning");
        $xml->writeAttribute('xmlns:xsi',"http://www.w3.org/2001/XMLSchema-instance"); 
        $xml->writeAttribute('xsi:noNamespaceSchemaLocation',"http://www.google.com/shopping/reviews/schema/product/2.1/product_reviews.xsd"); 
            $xml->startElement('aggregator'); 
                $xml->startElement('name'); 
                    $xml->text('CHOIES');
                $xml->endElement(); 
            $xml->endElement(); 
            $xml->startElement('publisher');
                $xml->startElement('name');
                    $xml->text('CHOIES');
                $xml->endElement();  
            $xml->endElement(); 
            $xml->startElement('reviews'); 
                foreach ($pinfos as $k => $v) {
                            $pid=$v['pid'];
                            $sku=$v['sku'];
                            $name=$v['f_name'];
                            $time=$v['time'];
                            $review_content=$v['content'];
                            $rate=$v['rate'];
                            $times=date("Y-m-d H:i:s");
                            $times=explode(' ', $times);
                            $time1=$times[0];
                            $time2=$times[1];
                            $plink = Product::instance($pid)->permalink();

                            $xml->startElement('review');
                                $xml->startElement('review_id');
                                    $xml->text($sku);
                                $xml->endElement();
                                $xml->startElement('reviewer');
                                    $xml->startElement('name');
                                        $xml->text($name);
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->startElement('review_timestamp');
                                    $xml->text($time1.'T'.$time2.'Z');
                                $xml->endElement();
                                $xml->startElement('content');
                                    $xml->text($review_content);
                                $xml->endElement();
                                $xml->startElement('review_url');
                                    $xml->writeAttribute('type',"singleton");
                                    $xml->text($plink);
                                $xml->endElement();
                                $xml->startElement('ratings');
                                    $xml->startElement('overall');
                                        $xml->writeAttribute('min',"1");
                                        $xml->writeAttribute('max',"5");
                                        $xml->text($rate);
                                    $xml->endElement();
                                $xml->endElement();
                                $xml->startElement('products');
                                    $xml->startElement('product');
                                        $xml->startElement('product_url');
                                            $xml->text($plink);
                                        $xml->endElement();
                                    $xml->endElement();
                                $xml->endElement(); 
                            $xml->endElement(); 



                }
            $xml->endElement(); 
        



        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';
        die;
    }

    public static function xmldata2($k,$fileurl)
    {
        ini_set('memory_limit', '512M');
        $filetime = date("Y-m-d", time());    

        if ($k != "US")
        {
            $data_array1 = array(
                array(
                    'loc' => 'http://www.choies.com/'.strtolower($k),
                    'lastmod' => $filetime,
                    'changefreq' => 'weekly',
                    'priority' => '1',
                ),
            );
        }
        else
        {
            $data_array1 = array(
                array(
                    'loc' => 'http://www.choies.com',
                    'lastmod' => $filetime,
                    'changefreq' => 'weekly',
                    'priority' => '1',
                ),
            );
        }   


        $catalogs = DB::query(DATABASE::SELECT, 'select `id`,`link` from catalogs where visibility=1 and on_menu=1 order by id asc')->execute('slave');

        $data_array2 = array();
        $i = 0;
        foreach ($catalogs as $catalog)
        {
            if ($k != "US")
            {
                $data_array2[$i]['loc'] = 'http://www.choies.com/'.strtolower($k).'/'. $catalog['link'].'-c-'.$catalog['id'];
            }
            else
            {
                $data_array2[$i]['loc'] = 'http://www.choies.com/' . $catalog['link'].'-c-'.$catalog['id'];
            }
            
            $data_array2[$i]['lastmod'] = $filetime;
            $data_array2[$i]['changefreq'] = 'weekly';
            $data_array2[$i]['priority'] = '0.8';
            $i++;
        }

        $data_array = array_merge($data_array1, $data_array2);

        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        //  输出方式，也可以设置为某个xml文件地址，直接输出成文件
        $xml->setIndentString('  ');
        $xml->setIndent(true);

        $xml->startDocument('1.0', 'utf-8');
        //  开始创建文件
        //  根结点
        $xml->startElement('urlset');

        //写入属性
        $xml->writeAttribute('xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9");
        foreach ($data_array as $data)
        {
            $xml->startElement('url');

            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
            $xml->endElement(); //  item
        }
        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';

    }

    public static function xmldata3($k,$fileurl)
    {
        ini_set('memory_limit', '512M');
        $filetime = date("Y-m-d", time());   

        if ($k != "US")
        {
            $data_array1 = array(
                array(
                    'loc' => 'http://www.choies.com/'.strtolower($k),
                    'lastmod' => $filetime,
                    'changefreq' => 'weekly',
                    'priority' => '1',
                ),
            );
        }
        else
        {
            $data_array1 = array(
                array(
                    'loc' => 'http://www.choies.com',
                    'lastmod' => $filetime,
                    'changefreq' => 'weekly',
                    'priority' => '1',
                ),
            );
        }     


        $products = DB::query(DATABASE::SELECT, 'select `id` from products where visibility=1 and status=1 order by created DESC')->execute('slave');

        $data_array3 = array();
        $j = 0;
        if ($k != "US"){
            $k = strtolower($k);
        }else{
            $k = '';
        }
        foreach ($products as $product)
        {
            $product_link = Product::instance($product['id'],$k)->permalink();
            $data_array3[$j]['loc'] = $product_link;
            $data_array3[$j]['lastmod'] = $filetime;
            $data_array3[$j]['changefreq'] = 'weekly';
            $data_array3[$j]['priority'] = '0.5';
            $j++;
        }

        $data_array = array_merge($data_array1, $data_array3);

        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        //  输出方式，也可以设置为某个xml文件地址，直接输出成文件
        $xml->setIndentString('  ');
        $xml->setIndent(true);

        $xml->startDocument('1.0', 'utf-8');
        //  开始创建文件
        //  根结点
        $xml->startElement('urlset');

        //写入属性
        $xml->writeAttribute('xmlns', "http://www.sitemaps.org/schemas/sitemap/0.9");
        foreach ($data_array as $data)
        {
            $xml->startElement('url');

            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
            $xml->endElement(); //  item
        }
        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';
        die;
    }

    public static function xmldata($fileurl)
    {
        ini_set('memory_limit', '512M');
        $filetime = date("Y-m-d", time());
        $data_array1 = array(
            array(
                'loc' => 'http://www.choies.com',
                'lastmod' => 'weekly',
                'changefreq' => $filetime,
                'priority' => '1',
            ),
        );
        $catalogs = DB::query(DATABASE::SELECT, 'select `link` from catalogs where visibility=1 and on_menu=1 order by id asc')->execute('slave');
        $products = DB::query(DATABASE::SELECT, 'select `id` from products where visibility=1 and status=1 order by created DESC')->execute('slave');

        $data_array2 = array();
        $i = 0;
        foreach ($catalogs as $catalog)
        {
            $data_array2[$i]['loc'] = 'http://www.choies.com/' . $catalog['link'];
            $data_array2[$i]['lastmod'] = 'weekly';
            $data_array2[$i]['changefreq'] = $filetime;
            $data_array2[$i]['priority'] = '0.8';
            $i++;
        }
        $data_array3 = array();
        $j = 0;
        foreach ($products as $product)
        {
            $product_link = Product::instance($product['id'])->permalink();
            $data_array3[$j]['loc'] = $product_link;
            $data_array3[$j]['lastmod'] = 'weekly';
            $data_array3[$j]['changefreq'] = $filetime;
            $data_array3[$j]['priority'] = '0.8';
            $j++;
        }
        $data_array4 = array_merge($data_array1, $data_array2);
        $data_array = array_merge($data_array4, $data_array3);

        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        //  输出方式，也可以设置为某个xml文件地址，直接输出成文件
        $xml->setIndentString('  ');
        $xml->setIndent(true);

        $xml->startDocument('1.0', 'utf-8');
        //  开始创建文件
        //  根结点
        $xml->startElement('urlset');

        foreach ($data_array as $data)
        {
            $xml->startElement('url');

            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
            $xml->endElement(); //  item
        }
        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success";
        exit;
    }
    
    
  
    public function action_webgainsfeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurl = "/home/data/www/htdocs/clothes/Export/webgainsfeed.csv";
        if (!file_exists($fileurl))
        {
            self::createwg($fileurl);
        }
        else
        {
            $lasttime = filemtime($fileurl);
            if ($lasttime && (time() - $lasttime >= 604800))
            {
                self::createwg($fileurl);
            }
        }
    }

    public static function createwg($fileurl)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $filename = $fileurl;
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("Product ID", "Product Name", "Description", "Price", "Deep Link", "Image Url", "Category", "Delivery Cost", "Delivery period", "Manufacturer", "Brand", "In Stock");
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        $products = DB::query(DATABASE::SELECT, "select `id`,`name`,`sku`,`description` from products where `visibility`=1 and `status`=1 order by created DESC")->execute('slave');
        $currency = Site::instance()->currencies("GBP");
        foreach ($products as $product)
        {
            $data = array();
            $product_instance = Product::instance($product['id']);
            $product_link = $product_instance->permalink();
            $product_price = $product_instance->price();
            $product_sku = $product['sku'];
            $product_name = $product['name'];
            $product_description = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
            $imglink = Image::link($product_instance->cover_image(), 10);
            $current_catalog = $product_instance->default_catalog();
            $crumbs = Catalog::instance($current_catalog)->crumbs();
            $catalogs = array();
            foreach ($crumbs as $crumb):
                if ($crumb['id']):
                    $catalogs[] = $crumb['name'];
                endif;
            endforeach;
            $catalog_name = implode(" > ", $catalogs);
            if ($product_description != "")
            {
                $data[] = $product_sku ? $product_sku : "";
                $data[] = $product_name ? $product_name : "";
                $data[] = $product_description;
                $data[] = $product_price ? number_format($product_price * $currency['rate'], 2) : "";
                $data[] = $product_link ? $product_link . "?currency=gbp" : "";
                $data[] = $imglink ? $imglink : " ";
                $data[] = $catalog_name ? $catalog_name : "Apparel";
                $data[] = 0;
                $data[] = 30;
                $data[] = "CHOIES";
                $data[] = "CHOIES";
                $data[] = "Y";
                fputcsv($outstream, $data);
            }
        }
        fclose($outstream_itemlist);
        echo "success";
        exit;
    }

    public function action_edmfeed12()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurl = "/home/data/www/htdocs/clothes/Export/edm12.csv";
        if (!file_exists($fileurl))
        {
            $this->_hkedmfeed12();
        }
        else
        {
            $lasttime = filemtime($fileurl);
            if ($lasttime && (time() - $lasttime >= 86400))
            {
                $this->_hkedmfeed12();
            }
        }
    }

    public function action_edmfeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurl = "/home/data/www/htdocs/clothes/Export/edm.csv";
        if (!file_exists($fileurl))
        {
            $this->_hkedmfeed();
        }
        else
        {
            $result = @unlink($fileurl);
            $this->_hkedmfeed();
/*            $lasttime = filemtime($fileurl);
            if ($lasttime && (time() - $lasttime >= 86400))
            {
                $this->_hkedmfeed();
            }*/
        }
    }

    public function action_pfeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurl = "/home/data/www/htdocs/clothes/Export/PolyvoreFeed.txt";
        
        if (!file_exists($fileurl))
        {
            $this->_polyvorefeed();
        }
        else
        {
            $lasttime = filemtime($fileurl);
            if ($lasttime && (time() - $lasttime >= 86400))
            {
                $this->_polyvorefeed();
            }
        }
    }

    public function action_customers()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $filename = "member_" . date("Ymd", strtotime("yesterday", strtotime(date("Y-m-d"), time()))) . ".csv";
        $fileurl = "/home/data/www/htdocs/clothes/Export/customers/" . $filename;
        if (!file_exists($fileurl))
        {
            self::customerexport();
        }
        else
        {
            $lasttime = filemtime($fileurl);
            if ($lasttime && (time() - $lasttime >= 86400))
            {
                self::customerexport();
            }
        }
    }

    public function action_nextag()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        $fileurl = "/home/data/www/htdocs/clothes/nextag/feed.csv";
        if (!file_exists($fileurl))
        {
            $this->_nextagfeed();
        }
        else
        {
            $lasttime = filemtime($fileurl);
            if ($lasttime && (time() - $lasttime >= 86400))
            {
                $this->_nextagfeed();
            }
        }
    }

    public function _hkedmfeed12()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filename = "/home/data/www/htdocs/clothes/Export/edm12.csv";
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("item", "title", "link", "image", "price", "available", "category", "c_price_gbp", "c_price_eur", "c_price_cad", "c_price_aud", "c_price_brl", "c_link_es", "c_link_de", "c_link_fr", "c_title_es", "c_title_de", "c_title_fr");
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        /*$products = DB::query(DATABASE::SELECT, "select P.`id`,P.`link`,P.`sku`,P.`status`,P.`name` as pname,P.`description`,D.`name` as dname,E.`name` as ename,F.`name` as fname from products P LEFT JOIN `products_de` D ON P.id=D.id LEFT JOIN `products_es` E ON P.id=E.id LEFT JOIN `products_fr` F ON P.id=F.id where P.visibility=1 and P.status = 1 order by P.created DESC")->execute('slave');*/
        $products = DB::query(DATABASE::SELECT, "select P.`id`,P.`link`,P.`sku`,P.`status`,P.`name` as pname,P.`description`,D.`name` as dname,E.`name` as ename,F.`name` as fname from products P LEFT JOIN `products_de` D ON P.id=D.id LEFT JOIN `products_es` E ON P.id=E.id LEFT JOIN `products_fr` F ON P.id=F.id where P.visibility=1  order by P.created DESC limit 0,10")->execute('slave');
        foreach ($products as $product)
        {
            if(strpos($product['description'], 'free gift') !== False)
            {
                continue;
            }
            $data = array();
            $product_instance = Product::instance($product['id']);
            $product_link = "http://www.choies.com/product/" . $product['link'];
            $product_price = $product_instance->price();
            $product_sku = $product['sku'];
            $product_name = $product['pname'];
            $product_name_es = $product['ename'];
            $product_name_de = $product['dname'];
            $product_name_fr = $product['fname'];
            $product_link_de = "http://www.choies.com/de/product/" . $product['link'];
            $product_link_es = "http://www.choies.com/es/product/" . $product['link'];
            $product_link_fr = "http://www.choies.com/fr/product/" . $product['link'];
            $imglink = Image::link($product_instance->cover_image(), 7);
            $current_catalog = $product_instance->all_catalog();
            $catalog_name = "";
            if(is_array($current_catalog))
            {
                $arr = array();
            foreach($current_catalog as $k=>$v){
                  $crumbs = Catalog::instance($v)->crumbs();  
                  $catalogs = array();

                    foreach ($crumbs as $crumb){
                        if ($crumb['id']){
                            $catalogs[] = $crumb['name'];
                        }          
                    }

            $catalog_name = implode(" > ", $catalogs); 

            $arr[] =$catalog_name;

                }
            $catalog_name = implode(" | ",$arr);

            }
            else
            {
             $crumbs = Catalog::instance($current_catalog)->crumbs();

            $catalogs = array();

            foreach ($crumbs as $crumb):
                if ($crumb['id']):
                    $catalogs[] = $crumb['name'];
                endif;
            endforeach;
            $catalog_name = implode(" > ", $catalogs);    
        
            }

            $data[] = $product_sku ? $product_sku : "";
            $data[] = $product_name ? $product_name : "";
            $data[] = $product_link ? $product_link : "";
            $data[] = $imglink ? $imglink : " ";
            $data[] = $product_price ? number_format($product_price, 2) : "";
            if ($product['status'] == 1)
            {
                $data[] = "true";
            }
            else
            {
                $data[] = "false";
            }
            $data[] = $catalog_name ? $catalog_name : "Apparel";
            $data[] = $product_price ? number_format($product_price * 0.63, 2) : ""; //GBP
            $data[] = $product_price ? number_format($product_price * 0.78, 2) : ""; //EUR
            $data[] = $product_price ? number_format($product_price * 1.12, 2) : ""; //CAD
            $data[] = $product_price ? number_format($product_price * 1.11, 2) : ""; //AUD
            $data[] = $product_price ? number_format($product_price * 2.27, 2) : ""; //BRL
            $data[] = $product_link_es ? $product_link_es : "";
            $data[] = $product_link_de ? $product_link_de : "";
            $data[] = $product_link_fr ? $product_link_fr : "";
            $data[] = $product_name_es ? $product_name_es : "";
            $data[] = $product_name_de ? $product_name_de : "";
            $data[] = $product_name_fr ? $product_name_fr : "";
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "success";
        exit;
    }

    public function _hkedmfeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filename = "/home/data/www/htdocs/clothes/Export/edm.csv";
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("item", "title", "link", "image", "price", "available", "category", "c_price_gbp", "c_price_eur", "c_price_cad", "c_price_aud", "c_price_brl", "c_link_es", "c_link_de", "c_link_fr", "c_title_es", "c_title_de", "c_title_fr");
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        /*$products = DB::query(DATABASE::SELECT, "select P.`id`,P.`link`,P.`sku`,P.`status`,P.`name` as pname,P.`description`,D.`name` as dname,E.`name` as ename,F.`name` as fname from products P LEFT JOIN `products_de` D ON P.id=D.id LEFT JOIN `products_es` E ON P.id=E.id LEFT JOIN `products_fr` F ON P.id=F.id where P.visibility=1 and P.status = 1 order by P.created DESC")->execute('slave');*/
        $products = DB::query(DATABASE::SELECT, "select P.`id`,P.`link`,P.`sku`,P.`status`,P.`name` as pname,P.`description`,D.`name` as dname,E.`name` as ename,F.`name` as fname from products P LEFT JOIN `products_de` D ON P.id=D.id LEFT JOIN `products_es` E ON P.id=E.id LEFT JOIN `products_fr` F ON P.id=F.id where P.visibility=1  order by P.created DESC")->execute('slave');
        foreach ($products as $product)
        {
            if(strpos($product['description'], 'free gift') !== False)
            {
                continue;
            }
            $data = array();
            $product_instance = Product::instance($product['id']);
            $product_link = "http://www.choies.com/product/" . $product['link'];
            $product_price = $product_instance->price();
            $product_sku = $product['sku'];
            $product_name = $product['pname'];
            $product_name_es = $product['ename'];
            $product_name_de = $product['dname'];
            $product_name_fr = $product['fname'];
            $product_link_de = "http://www.choies.com/de/product/" . $product['link'];
            $product_link_es = "http://www.choies.com/es/product/" . $product['link'];
            $product_link_fr = "http://www.choies.com/fr/product/" . $product['link'];
            $imglink = Image::link($product_instance->cover_image(), 7);
            $current_catalog = $product_instance->all_catalog();
            $catalog_name = "";
            if(is_array($current_catalog))
            {
                $arr = array();
                foreach($current_catalog as $k=>$v){
                  $crumbs = Catalog::instance($v)->crumbs();  
                        $catalogs = array();

                        foreach ($crumbs as $crumb){
                            if ($crumb['id']){
                                $catalogs[] = $crumb['name'];
                            }          
                        }

            $catalog_name = implode(" > ", $catalogs); 

            $arr[] =$catalog_name;

                }
            $catalog_name = implode(" | ",$arr);

            }
            else
            {
             $crumbs = Catalog::instance($current_catalog)->crumbs();
            $catalogs = array();

            if(!empty($crumbs))
            {
                foreach ($crumbs as $crumb):
                    if ($crumb['id']):
                        $catalogs[] = $crumb['name'];
                    endif;
                endforeach;                
            }

            $catalog_name = implode(" > ", $catalogs);    
        
            }

            $data[] = $product_sku ? $product_sku : "";
            $data[] = $product_name ? $product_name : "";
            $data[] = $product_link ? $product_link : "";
            $data[] = $imglink ? $imglink : " ";
            $data[] = $product_price ? number_format($product_price, 2) : "";
            if ($product['status'] == 1)
            {
                $data[] = "true";
            }
            else
            {
                $data[] = "false";
            }
            $data[] = $catalog_name ? $catalog_name : "Apparel";
            $data[] = $product_price ? number_format($product_price * 0.63, 2) : ""; //GBP
            $data[] = $product_price ? number_format($product_price * 0.78, 2) : ""; //EUR
            $data[] = $product_price ? number_format($product_price * 1.12, 2) : ""; //CAD
            $data[] = $product_price ? number_format($product_price * 1.11, 2) : ""; //AUD
            $data[] = $product_price ? number_format($product_price * 2.27, 2) : ""; //BRL
            $data[] = $product_link_es ? $product_link_es : "";
            $data[] = $product_link_de ? $product_link_de : "";
            $data[] = $product_link_fr ? $product_link_fr : "";
            $data[] = $product_name_es ? $product_name_es : "";
            $data[] = $product_name_de ? $product_name_de : "";
            $data[] = $product_name_fr ? $product_name_fr : "";
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "success";
        exit;
    }

    public function _polyvorefeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

      /*   echo "1111L";
        exit(exit);
         */
        $head_gooproductinfo = array('Polyvore', 'title', 'brand', 'url', 'cpc_tracking_url', 'imgurl', 'price', 'sale_price', 'currency', 'description', 'color', 'sizes', 'tags', 'subject', 'category');

       
        $file_name = "/home/data/www/htdocs/clothes/Export/PolyvoreFeed.txt";
        $open = fopen($file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        //只取这些set下的产品
        $set_ids = '"7","8","9","10","11","12","13","14","15","16","20","280","396","375","472","473","395","500","475","498","499","497"';
        $products = DB::query(DATABASE::SELECT, 'select `id`,`sku`,`name`,`description`,`set_id` from products where `site_id`=1 and visibility=1 and status=1 order by created DESC')->execute('slave');
        $colors = '"4","5","6","7","8","9","10","11","12","13","14","15","16","17"';
        $exclude_skus = array("CC014914", "CC031525", "CCJJ0827", "CCPY1484", "CD080275", "CDJJ0812", "CDPY0418", "CDYP0794", "CDYP0795", "CDZY2418", "CDZY2427", "CDZY4788", "CGZW0001", "CLWC4167", "COAT1113A184A", "COAT1113A188A", "COAT1121A411D", "COAT1121A412D", "CPWC2535", "CPWC2970", "CPWC2981", "CR014888", "CR031745", "CR031746", "CR051025", "CR051029", "CR051135", "CR051136", "CR051139", "CR051140", "CRJJ0639", "CRJJ0682", "CRJJ0723", "CRJJ0763", "CRJJ0789", "CRJJ0796", "CRJJ0822", "CRJJ0823", "CRJJ0824", "CRJJ0828", "CRJJ0829", "CRJJ0833", "CRPC0040", "CRPC0041", "CRPC0043", "CRPC0044", "CRPY0863", "CRPY1181", "CRWC0006", "CRWC0010", "CRWC4624", "CRWC4625", "CRWC4626", "CRWC4627", "CRWC4628", "CRWC4692", "CRWC4693", "CRWC4694", "CRYP0618", "CRYP0619", "CRYP0620", "CRYP0623", "CRYP0624", "CRYP0625", "CRYP0628", "CRYP0629", "CRYP0631", "CRYP0632", "CRYP0649", "CRYP0650", "CRYP0796", "CRYP0880", "CRYP0884", "CRYP0991", "CRYP0998", "CRYY0011", "CRYY0176", "CRYY0178", "CRYY0179", "CRYY0181", "CRYY0211", "CRYY0214", "CRYY0220", "CRYY0222", "CRYY0225", "CRYY0227", "CRZY2690", "CRZY3437", "CRZY3439", "CRZY4487", "CRZY4488", "CRZY4489", "CRZY4490", "CRZY4493", "CRZY4496", "CRZY4674", "CRZY4675", "CRZY4676", "CRZY4679", "CRZY4765", "CRZY4767", "CRZY4770", "CRZY4771", "CRZY4773", "CSDL0425", "CSGZ0005", "CSSM0010", "CSWC0593", "CSXF0710", "CSXR0060", "CSXR0062", "CSXZ0164", "CSZY1062", "CSZY1215", "CSZY3203", "CT051180", "CTPY0174", "CTPY0175", "CTSM0412", "CTSM0413", "CTSM0417", "CTWC2666", "CTXF2037", "CTXF2388", "CTXF2431", "CTXF2439", "CTXF2508", "CTYP0027", "CTYP0170", "CTYP0898", "CTYY0428", "CTYY0429", "CTYY0617", "CTYY0888", "CTZY2068", "CTZY2230", "CTZY3099", "CTZY3126", "CTZY4015", "CTZY4016", "CTZY4017", "CVZY0992", "CVZY4031", "CVZY4707", "CWXR0309", "CWZY2363", "CWZY3424", "CWZY3426", "DRES1022A113E", "DRES1107A279C", "HOOD100814E008", "HOOD100814E011", "HOOD100814E013", "HOOD1011A054D", "HOOD1020A103K", "HOOD1020A104K", "HOOD1020A105K", "HOOD1029A209E", "HOOD1031A228E", "HOOD1031A229E", "HOOD1103A260E", "HOOD1103A261E", "HOOD1103A265E", "HOOD1104A219D", "HOOD1104A220D", "HOOD1105A316E", "HOOD1105A317E", "HOOD1118A488E", "HOOD1118A489E", "HOOD1121A410D", "HOOD1124A530E", "HOOD1125A371B", "HOOD1125A372B", "HOOD1203A403B", "HOOD1203A408B", "HOOD1203A409B", "HOOD1203A411B", "HOOD1203A632E", "HOOD1203A689G", "HOOD1206A777K", "SKIR1015A067A", "SWEA100714A026", "SWEA100714A027", "TSHI1031A001P", "TSHI1111A002P", "TSHI1129A674K", "TSHI1129A675K", "TWOP1013A039G", "TWOP1024A160E", "TWOP1208A677E", "SWEA1216A500D", "DRES1210A783K", "TSHI1210A782K", "TSHI1210A781K", "HOOD1203A404B");
        foreach ($products as $product)
        {
            if (!in_array($product['sku'], $exclude_skus))
            {
                $data = array();
                $product_instance = Product::instance($product['id']);
                $imageURL = Image::link($product_instance->cover_image(), 10); //
                
                $link = $product_instance->permalink();
                $set_name = Set::instance($product['set_id'])->get('name');
                $p_price = $product_instance->get('price');
                $price = $product_instance->price();
                $crumbs = Catalog::instance($product_instance->default_catalog())->crumbs();
                $tag = array();

                if(!empty($crumbs))
                {
                    foreach ($crumbs as $crumb):
                        if ($crumb['id'])
                        {
                            $tag[] = $crumb['name'];
                        }
                    endforeach;
                }
                if (!empty($tag))
                {
                    $tags = implode(",", $tag);
                }
                else
                {
                    $tags = "";
                }
                if (!empty($tag) && $tag[0] != "Men's Collection")
                {

                    $size = "";
                    $attributes = $product_instance->get("attributes");
                    if (!empty($attributes['Size']))
                    {
                        $size = implode(",", $attributes['Size']);
                    }
                    //$attribute_color=DB::query(DATABASE::SELECT,'select A.`label` from `product_attribute_values` PV left join `attributes` A on PV.`attribute_id`=A.`id` where PV.`product_id`='.$product['id'].' and  PV.`attribute_id` in ('.$colors.')')->execute('slave')->get('label');
                    //filter attributes
                    $filter_sorts = array();
                    $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                    if (!empty($filter_attributes))
                    {
                        $filter_sqls = array();
                        foreach ($filter_attributes as $key => $filter)
                        {
                            if ($filter)
                                $filter_sqls[] = '"' . $filter . '"';
                            else
                                unset($filter_attributes[$key]);
                        }
                        $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                        $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                        if (!empty($sorts))
                        {
                            foreach ($sorts as $sort)
                            {
                                if (array_key_exists($sort['sort'], $filter_attributes))
                                    continue;
                                $attr = '';
                                $attributes = explode(',', strtolower($sort['attributes']));
                                foreach ($filter_attributes as $key => $attribute)
                                {
                                    $attribute = strtolower($attribute);
                                    if (in_array($attribute, $attributes))
                                    {
                                        $attr = $attribute;
                                        unset($filter_attributes[$key]);
                                        break;
                                    }
                                }
                                if ($attr)
                                    $filter_sorts[strtoupper($sort['sort'])] = $attr;
                            }
                        }
                    }
                    if (!empty($filter_sorts))
                    {
                        foreach ($filter_sorts as $name => $sort)
                        {
                            if ($name == "color" || $name == "Color" || $name == "COLOR")
                            {
                                $attribute_color = $sort;
                                break;
                            }
                        }
                    }
                    //filter attributes
                    $data[] = "Choies";
                    $data[] = "Choies " . $product['name'];
                    $data[] = "Choies";
                    $data[] = $link;
                    $data[] = $link . "?utm_source=polyvore&utm_medium=cpc&trackid=skinnyjeansABC123&keyword=" . $set_name;
                    $data[] = $imageURL;
                    $data[] = number_format($p_price, 2);
                    if ($p_price > $price)
                    {
                        $data[] = number_format($price, 2);
                        ;
                    }
                    else
                    {
                        $data[] = "";
                    }
                    $data[] = "USD";
                    $data[] = "Choies " . $product['name'];
                    $data[] = $attribute_color ? $attribute_color : "as photo";
                    $data[] = $size;
                    $data[] = $tags;
                    $data[] = "Women";
                    $data[] = "clothing";
                    $str = implode("\t", $data);
                    fwrite($open, $str . PHP_EOL);
                }
            }
        }
        $re = fclose($open);
        echo "success";
        exit;
    }

    public function _nextagfeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $filename = "/home/data/www/htdocs/clothes/nextag/feed.csv";
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array('Manufacturer', 'Manufacturer Part #', 'Product Name', 'Product Description', 'Click-Out URL', 'Price', 'Category: Other Format', 'Category: Nextag Numeric ID', 'Image URL', 'Ground Shipping', 'Stock Status', 'Product Condition', 'Marketing Message', 'Weight', 'Cost-per-Click', 'UPC', 'Distributor ID', 'MUZE ID', 'ISBN');
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        $products = DB::query(DATABASE::SELECT, "select `id`,`set_id`,`sku`,`name`,`description` from products where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $data = array();
            $product_instance = Product::instance($product['id']);
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $link = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $price = $product_instance->price();

            $data[] = "Choies";
            $data[] = $product['sku'];
            $data[] = $product['name'];
            $data[] = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
            $data[] = $link;
            $data[] = number_format($price, 2);
            $data[] = $set_name;
            $data[] = "";
            $data[] = $imageURL;
            $data[] = "0";
            $data[] = "Yes";
            $data[] = "New";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "success";
        exit;
    }

 //by zhangchunmei 2015.6.25
    public static function Xmldatafeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $set_names = array(
            "DE" => array(
                "Shoes" => "Bekleidung & Accessoires > Schuhe",
                "Bralets" => "Bekleidung & Accessoires > Bekleidung > Unterwäsche & Socken > Büstenhalter",
                "Menswear" => "Apparel & Accessories > Clothing > Outerwear",
                "Neck" => "Bekleidung & Accessoires > Schmuck > Halsketten",
                "Sandals" => "Apparel & Accessories > Shoes",
                "Eye Masks" => "Health & Beauty > Personal Care > Sleeping Aids > Sleep Masks",
                "Hair Extensions" => "Apparel & Accessories > Costumes & Accessories > Wigs",
                "Hair Accessories" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Haaraccessoires",
                "Waistcoats" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets > Overcoats",
                "Jumpers & Pullovers" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Mens Jumpers & Cardigans" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Mens Hoodies & Sweatshirts" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Mens Coats & Jackets" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Nails" => "Hardware > Hardware Accessories > Nails",
                "Overalls" => "Bekleidung & Accessoires > Bekleidung > Einteiler > Overalls",
                "Platforms" => "Apparel & Accessories > Shoes",
                "Rompers & Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Flats" => "Apparel & Accessories > Shoes",
                "Sneakers & Athletic Shoes" => "Apparel & Accessories > Shoes",
                "Heels" => "Apparel & Accessories > Shoes",
                "Wedges" => "Apparel & Accessories > Shoes",
                "Bags" => "Bekleidung & Accessoires > Handtaschen & Geldbörsenaccessoires",
                "Purses" => "Bekleidung & Accessoires > Handtaschen, Geldbörsen & Etuis > Geldbeutel & Geldklammern",
                "Socks & Tights" => "Bekleidung & Accessoires > Bekleidung > Unterwäsche & Socken > Socken",
                "Boots" => "Apparel & Accessories > Shoes",
                "Mens T-Shirts & Tanks" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Blazers" => "Bekleidung & Accessoires > Bekleidung > Anzüge",
                "Coats & Jackets" => "Bekleidung & Accessoires > Bekleidung > Überbekleidung > Mäntel & Jacken",
                "Dresses" => "Bekleidung & Accessoires > Bekleidung > Kleider",
                "Shorts" => "Bekleidung & Accessoires > Bekleidung > Shorts",
                "Cardigans" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Skirts" => "Bekleidung & Accessoires > Bekleidung > Röcke",
                "Pants" => "Bekleidung & Accessoires > Bekleidung > Hosen",
                "Blouses & Shirts" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "T-Shirts" => " Bekleidung & Accessoires > Bekleidung > Shirts & Tops ",
                "Knit Vests" => " Bekleidung & Accessoires > Bekleidung > Shirts & Tops ",
                "Bracelets & Bangles" => "Bekleidung & Accessoires > Schmuck > Armbänder",
                "Rings" => "Bekleidung & Accessoires > Schmuck > Ringe",
                "Belts" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Gürtel",
                "Jeans" => "Bekleidung & Accessoires > Bekleidung > Hosen",
                "Hats & Caps" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Hüte",
                "Sunglasses" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Sonnenbrillen",
                "Earrings" => "Bekleidung & Accessoires > Schmuck > Ohrringe",
                "Brooch" => "Bekleidung & Accessoires > Schmuck > Broschen und Anstecknadeln",
                "Scarves & Snoods" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Schals & Halstücher",
                "Wigs" => "Bekleidung & Accessoires > Bekleidungsaccessoires",
                "Gloves" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Handschuhe & Fausthandschuhe > Handschuhe",
                "Jumpsuits&Playsuits" => "Bekleidung & Accessoires > Bekleidung > Einteiler > Overalls",
                "Jumpsuits/Playsuits" => "Bekleidung & Accessoires > Bekleidung > Einteiler > Overalls",
                "Jumpsuits" => "Bekleidung & Accessoires > Bekleidung > Einteiler > Overalls",
                "Hoodies & Sweatshirts" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Watch" => "Bekleidung & Accessoires > Schmuck > Armbanduhren",
                "Occasion Dresses" => "Bekleidung & Accessoires > Bekleidung > Kleider > Tägliche Kleider",
                "Swimwear" => "Bekleidung & Accessoires > Bekleidung > Bademode",
                "Jumpsuits & Playsuits" => "Bekleidung & Accessoires > Bekleidung > Einteiler > Overalls",
                "ELF SACK" => "Bekleidung & Accessoires > Bekleidung > Röcke",
                "AIMER" => "Bekleidung & Accessoires > Bekleidung > Bademode",
                "Corset" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Two-piece suits" => "Bekleidung & Accessoires > Bekleidung > Anzüge",
                "Celebona" => "Bekleidung & Accessoires > Bekleidung > Röcke",
                "Sivanna" => "Gesundheit & Schönheit > Körperpflege > Kosmetika > Make-up",
                "Swimwear/Beachwear" => "Bekleidung & Accessoires > Bekleidung > Bademode",
                "LEMONPAIER" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Schals & Halstücher",
                "Sleepwear" => "Bekleidung & Accessoires > Bekleidung > Nachtwäsche & Loungewear",
                "Leggings" => "Bekleidung & Accessoires > Bekleidung > Hosen",
                "Scarves" => "Bekleidung & Accessoires > Bekleidungsaccessoires > Schals & Halstücher",
                "Kimonos" => "Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos",
                "Camis & Tanks" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Crop Tops & Bralets" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Skirts" => "Bekleidung & Accessoires > Bekleidung > Röcke",
                "Dress-tops" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Anklets" => "Bekleidung & Accessoires > Schmuck > Fußkettchen",
                "Body Harness" => "Bekleidung & Accessoires > Schmuck > Körperschmuck",
                "Mens Shirts" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Mens Pants & Jeans" => "Bekleidung & Accessoires > Bekleidung > Hosen",
                "Skorts" => "Bekleidung & Accessoires > Bekleidung > Skorts",
                "Mens Shorts" => "Bekleidung & Accessoires > Bekleidung > Shorts",
                "Free Bracelets" => "Bekleidung & Accessoires > Schmuck > Armbänder",
                "Bodysuits" => "Bekleidung & Accessoires > Bekleidung > Shirts & Tops",
                "Three-piece suits" =>"Bekleidung & Accessoires > Bekleidung > Anzüge",
                "HOME DECOR" => "Heim & Garten > Dekoration",
            ),
        );
    
        $filename = "/home/data/www/htdocs/clothes/Export/Xmldatafeed.csv";
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("Name", "SKU", "URL to product", "URL to image", "Description", "Price", "Currency", "Brand", "Gender", "category1", "category2", "category3", "stockInformation");
        fputcsv($outstream_itemlist, $head_itemlist);
    
        $time = time(); //获取当前时间
        $b = 86400*15; //计算15天的时间数
        $time = $time-$b; //用当前时间减去15天的时间数
        $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute()->as_array();
        foreach($attr as $v){
            $vv[]= $v['product_id'];
        }
        
        $outstream = fopen($filename, 'a');
        $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description` from products_de where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $data = array();
            $product_type = "";
            $product_instance = Product::instance($product['id']);
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $link = $product_instance->permalink();
            $set_name = Set::instance($product_instance->get('set_id'))->get('name');
            $price = $product_instance->price();
            $default_catalog = $product_instance->default_catalog();
            $product_type = isset($set_names[$set_name]) ? $set_names[$set_name] : '';
            
            /* $product_type = $set_names[$set_name];
            if ($default_catalog)
            {
                $catalog = Catalog::instance($default_catalog)->get('name');
            }
            else
            {
                $catalog = "";
            } */
            $data[] = $product['name'];
            $data[] = $product['sku'];
            $data[] = $link;
            $data[] = $imageURL;
            $data[] = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
            //$data[] = number_format($price, 2);
   
            if ($product_instance->get('price') > $price)
            {
                $data[] = number_format($product_instance->get('price'), 2);
            }
            else
            {
                $data[] = number_format($price, 2);
            }
            
            if (strpos ( $product ['name'], 'Kimono' ) != false)
            {
                $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
            }
            else
            {
                $product_type = isset($set_names ["DE"] [$set_name]) ? $set_names ["DE"] [$set_name] : '';
            }
            
            
            $proextra_fee = isset($product['extra_fee']) ? $product['extra_fee'] : '0';
            $data[] =  ":::" . number_format($proextra_fee, 2) . " EURO";
            $data[] = "Choies";
            $data[] = "Damen";
            
            $product_type = $product_type ? $product_type : "";
            $category= explode('>', $product_type);
            if(empty($category[0])){
            $data[]="choies"; 
            }else{
           //category1
            $data[]=isset($category[0]) ? $category[0] : '';                
            }

            //category2
            $data[]=isset($category[1]) ? $category[1] : ''; 
            //category3
            $data[]=isset($category[2]) ? $category[2] : ''; 
            
            //stockInformation
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower("de") . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower("de"));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = isset($product['brief']) ? $product['brief'] : '';
                $brief = strip_tags($brief);
                //END小语种取details
                $descrip = isset($product['description']) ? $product['description'] : '';        
                $descrip  = str_replace(PHP_EOL, '',strip_tags($descrip));
                 
                $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
               
         
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "success";
    }
    
    
    
    //by wangshuiyan
    public static function datafeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $set_names = array(
            "EN" => array("Shoes" => "Apparel & Accessories > Shoes",
                "Bralets" => "Apparel & Accessories > Clothing > Underwear & Socks > Bras",
                "Neck" => "Apparel & Accessories > Jewelry > Necklaces",
                "Hair Accessories" => "Apparel & Accessories > Clothing Accessories > Hair Accessories",
                "Bags" => "Apparel & Accessories > Handbags",
                "Mens T-Shirts & Tanks" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Hair Extensions" => "Apparel & Accessories > Costumes & Accessories > Wigs",
                "Purses" => "Apparel & Accessories > Handbags",
                "Camis & Tanks" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Crop Tops & Bralets" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Socks & Tights" => "Apparel & Accessories > Clothing > Underwear & Socks > Socks",
                "Blazers" => "Apparel & Accessories > Clothing > Suits",
                "Overalls" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweaters & Cardigans",
                "Eye Masks" => "Health & Beauty > Personal Care > Sleeping Aids > Sleep Masks",
                "Coats & Jackets" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets",
                "Mens Jumpers & Cardigans" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweaters & Cardigans",
                "Jumpers & Pullovers" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweaters & Cardigans",
                "Mens Hoodies & Sweatshirts" => "Apparel & Accessories > Clothing > Shirts & Tops > Sweatshirts",
                "Mens Coats & Jackets" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets",
                "Platforms" => "Apparel & Accessories > Shoes",
                "Dresses" => "Apparel & Accessories > Clothing > Dresses",
                "Shorts" => "Apparel & Accessories > Clothing > Shorts",
                "Cardigans" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Skirts" => "Apparel & Accessories > Clothing > Skirts",
                "Pants" => "Apparel & Accessories > Clothing > Pants",
                "Blouses & Shirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "T-Shirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Knit Vests" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Bracelets & Bangles" => "Apparel & Accessories > Jewelry > Bracelets",
                "Rings" => "Apparel & Accessories > Jewelry > Rings",
                "Belts" => "Apparel & Accessories > Clothing Accessories > Belts",
                "Jeans" => "Apparel & Accessories > Clothing > Pants",
                "Hats & Caps" => "Apparel & Accessories > Clothing Accessories > Hats",
                "Sunglasses" => "Apparel & Accessories > Clothing Accessories > Sunglasses",
                "Earrings" => "Apparel & Accessories > Jewelry > Earrings",
                "Waistcoats" => "Apparel & Accessories > Clothing > Outerwear > Coats & Jackets > Overcoats",
                "Brooch" => "Apparel & Accessories > Jewelry > Brooches & Lapel Pins",
                "Scarves & Snoods" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Rompers & Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Wigs" => "Apparel & Accessories > Costumes & Accessories > Wigs",
                "Gloves" => "Apparel & Accessories > Clothing Accessories > Gloves & Mittens > Gloves",
                "Jumpsuits&Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Boots" => "Apparel & Accessories > Shoes",
                "Sandals" => "Apparel & Accessories > Shoes",
                "Flats" => "Apparel & Accessories > Shoes",
                "Sneakers & Athletic Shoes" => "Apparel & Accessories > Shoes",
                "Heels" => "Apparel & Accessories > Shoes",
                "Wedges" => "Apparel & Accessories > Shoes",
                "Jumpsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits",
                "Hoodies & Sweatshirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Watch" => "Apparel & Accessories > Jewelry > Watches",
               "Occasion Dresses" => "Apparel & Accessories > Clothing > Dresses > Day Dresses",
                "Swimwear" => "Apparel & Accessories > Clothing > Swimwear",
                "Jumpsuits & Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "Jumpsuits/Playsuits" => "Apparel & Accessories > Clothing > One-pieces > Jumpsuits & Rompers",
                "ELF SACK" => "Apparel & Accessories > Clothing > Skirts",
                "Nails" => "Hardware > Hardware Accessories > Nails",
                "AIMER" => "Apparel & Accessories > Clothing > Swimwear",
                "Corset" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Two-piece suits" => "Apparel & Accessories > Clothing > Suits",
                "Celebona" => "Apparel & Accessories > Clothing > Skirts",
                "Kimonos" => "Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos",
                "Sivanna" => "Health & Beauty > Personal Care > Cosmetics > Makeup",
                "LEMONPAIER" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Sleepwear" => "Apparel & Accessories > Clothing > Sleepwear & Loungewear",
                "Leggings" => "Apparel & Accessories > Clothing > Pants",
                "Menswear" => "Apparel & Accessories > Clothing > Outerwear",
                "Scarves" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Skirts" => "Apparel & Accessories > Clothing > Skirts",
                "Dress-tops" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Anklets" => "Apparel & Accessories > Jewelry > Anklets",
                "Body Harness" => "Apparel & Accessories > Jewelry > Body Jewelry",
                "Mens Shirts" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Mens Pants & Jeans" => "Apparel & Accessories > Clothing > Pants",
                "Skorts" => "Apparel & Accessories > Clothing > Skorts",
                "Mens Shorts" => "Apparel & Accessories > Clothing > Shorts",
                "Free Bracelets" => "Apparel & Accessories > Jewelry > Bracelets",
                "Bodysuits" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Three-piece suits" => "Apparel & Accessories > Clothing > Suits",
                "HOME DECOR" => "Home & Garden > Decor",
                ),
        );

        $filename = "/home/data/www/htdocs/clothes/Export/datafeed.csv";
        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("SKU", "Name", "URL to product", "Price", "Retail Price", "product_type", "URL to image", "URL to image", "Commission", "Category", "SubCategory", "Description", "SearchTerms", "Status", "Your MerchantID", "Custom 1", "Custom 2", "Custom 3", "Custom 4", "Custom 5", "Manufacturer", "PartNumber", "MerchantCategory", "MerchantSubcategory", "Short Description", "ISBN", "UPC", "CrossSell", "MerchantGroup", "MerchantSubgroup", "CompatibleWith", "CompareTo", "QuantityDiscount", "Bestseller", "AddToCartURL", "ReviewsRSSURL", "Option1", "Option2", "Option3", "Option4", "Option5", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse", "ReservedForFutureUse");
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description` from products where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $data = array();
            $product_type = "";
            $product_instance = Product::instance($product['id']);
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $link = $product_instance->permalink();
            $set_name = Set::instance($product_instance->get('set_id'))->get('name');
            $price = $product_instance->price();
            $default_catalog = $product_instance->default_catalog();
            $product_type = isset($set_names[$set_name]) ? $set_names[$set_name] : '';
            if ($default_catalog)
            {
                $catalog = Catalog::instance($default_catalog)->get('name');
            }
            else
            {
                $catalog = "";
            }
            $data[] = $product['sku'];
            $data[] = $product['name'];
            $data[] = $link;
            $data[] = number_format($price, 2);
            if ($product_instance->get('price') > $price)
            {
                $data[] = number_format($product_instance->get('price'), 2);
            }
            else
            {
                $data[] = number_format($price, 2);
            }
            $data[] = $product_type ? $product_type : "";
            $data[] = $imageURL;
            $data[] = $imageURL;
            $data[] = number_format(($price * 0.1), 2);
            $data[] = "8";
            $data[] = "59";
            $data[] = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
            $data[] = "LatestFashion, street fashion, woman fashion, shoes, clothing, clothes, apparels, jewelry, fashion accessory, new arrival, high heels, deal, discount, clearance, promotion, shopping, free shipping, bags, handbags, sunglasses, leggingsng";
            $data[] = "instock";
            $data[] = "41271";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "Choies";
            $data[] = "";
            $data[] = "Fashion";
            $data[] = "Clothing";
            $data[] = $catalog; //catalog
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "contact us";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            $data[] = "";
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "success";
    }

    //by chencaihong
    public static function cjdatafeed($lang = null)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $set_names = Kohana::config('googlefeed.set_name');
        if ($lang)
        {
            $filename = "/home/data/www/htdocs/clothes/Export/cjfeed-" . $lang . ".csv";
        }
        else
        {
            $filename = "/home/data/www/htdocs/clothes/Export/cjfeed.csv";
        }

        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("Name", "KEYWORDS", "Description", "SKU", "BUYURL", "AVAILABLE", "IMAGEURL", "PRICE", "CURRENCY", "PROMOTIONALTEXT", "ADVERTISERCATEGORY", "MANUFACTURER", "INSTOCK");
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        if ($lang && $lang != 'uk' && $lang !='au')
        {
            $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description` from products_" . $lang . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        }
        else
        {
            $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description` from products where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        }
        foreach ($products as $product)
        {
            $data = array();
            $product_type = "";
            if ($lang)
            {
                $product_instance = Product::instance($product['id'], $lang);
            }
            else
            {
                $product_instance = Product::instance($product['id']);
            }
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $link = $product_instance->permalink();
            $set_name = Set::instance($product_instance->get('set_id'))->get('name');
            $price = $product_instance->price();
            $default_catalog = $product_instance->default_catalog();
            $catalog = "";

            if ($lang)
            {
                if ($default_catalog)
                {
                    $catalog = DB::query(DATABASE::SELECT, "select `name` from catalogs_" . $lang . " where `id`=" . $default_catalog)->execute('slave')->get('name');
                }
                $product_type = $set_names[strtoupper($lang)][$set_name];
            }
            else
            {
                if ($default_catalog)
                {
                    $catalog = DB::query(DATABASE::SELECT, "select `name` from catalogs where `id`=" . $default_catalog)->execute('slave')->get('name');
                }
                $product_type = $set_names['US'][$set_name];
            }

            $data[] = $product['name'];
            if ($lang == "es")
            {
                $data[] = "Moda, Ropa, Ropa de Mujer";
            }
            elseif ($lang == "de")
            {
                $data[] = "Mode，Kleidung，Damen Bekleidung";
            }
            elseif ($lang == "fr")
            {
                $data[] = "mode,vêtements,vêtements femme";
            }
            elseif ($lang == "ru")
            {
                $data[] = "Мода,одежды,Женские одежды";
            }
            else
            {
                $data[] = "fashion, clothing, women clothes";
            }
            $data[] = $product['description'] ? trim(strip_tags(str_replace(PHP_EOL, '', $product['description']))) : $catalog;
            $data[] = $product['sku'];
            if ($lang == "ru")
            {
                $currency = Site::instance()->currencies("RUB");
                $data[] = $link . "?currency=rub";
                $data[] = "Да";
                $data[] = $imageURL;
                $data[] = number_format($price * $currency['rate'], 2);
                $data[] = "RUB";
                $data[] = "Для продвижения";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "Да";
            }
            elseif ($lang == "es")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $link . "?currency=eur";
                $data[] = "Si";
                $data[] = $imageURL;
                $data[] = number_format($price * $currency['rate'], 2);
                $data[] = "EUR";
                $data[] = "Por promoción";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "Si";
            }
            elseif ($lang == "de")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $link . "?currency=eur";
                $data[] = "JA";
                $data[] = $imageURL;
                $data[] = number_format($price * $currency['rate'], 2);
                $data[] = "EUR";
                $data[] = "Für Promotion";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "JA";
            }
            elseif ($lang == "fr")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $link . "?currency=eur";
                $data[] = "OUI";
                $data[] = $imageURL;
                $data[] = number_format($price, 2);
                $data[] = "EUR";
                $data[] = "Pour la promotion";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "OUI";
            }
            elseif ($lang == "au")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $link . "?currency=eur";
                $data[] = "OUI";
                $data[] = $imageURL;
                $data[] = number_format($price, 2);
                $data[] = "AU";
                $data[] = "Pour la promotion";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "OUI";
            }
            elseif ($lang == "uk")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $link . "?currency=eur";
                $data[] = "OUI";
                $data[] = $imageURL;
                $data[] = number_format($price, 2);
                $data[] = "£";
                $data[] = "Pour la promotion";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "OUI";
            }
            else
            {
                $data[] = $link;
                $data[] = "YES";
                $data[] = $imageURL;
                $data[] = number_format($price, 2);
                $data[] = "USD";
                $data[] = "For promotion";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "YES";
            }

            fputcsv($outstream, $data);//将行格式化为 CSV 并写入一个打开的文件,CSV的格式如：George,John,Thomas,USA
        }
        fclose($outstream_itemlist);
        echo "cjfeed success";
    }

    //by guo
    public static function twdatafeed($lang = null)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $set_names = Kohana::config('googlefeed.set_name');
        if ($lang)
        {
            $filename = "/home/data/www/htdocs/clothes/Export/cjfeed-" . $lang . ".csv";
        }
        else
        {
            $filename = "/home/data/www/htdocs/clothes/Export/shopalike.csv";
        }

        $outstream_itemlist = fopen($filename, 'w');
        $head_itemlist = array("SKU","Name", "Top category", "Sub category", "Gender", "Color", "Sizes", "Pattern", "Brand", "Material", "Description", "Current price", "Old price", "Currency","In stock","Shipping time","Shipping costs","Image URL","Deeplink URL");
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filename, 'a');
        if ($lang && $lang != 'uk' && $lang !='au')
        {
            $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description` from products_" . $lang . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        }
        else
        {
            $products = DB::query(DATABASE::SELECT, "select `id`,`sku`,`name`,`description`,`filter_attributes`,`price` from products where visibility=1 and status=1 order by created DESC")->execute('slave');
        }
        foreach ($products as $product)
        {
            $data = array();
            $product_type = "";
            if ($lang)
            {
                $product_instance = Product::instance($product['id'], $lang);
            }
            else
            {
                $product_instance = Product::instance($product['id']);
            }
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $link = $product_instance->permalink();
            $set_name = Set::instance($product_instance->get('set_id'))->get('name');
            $price = $product_instance->price();
            $default_catalog = $product_instance->default_catalog();
            $all_catalog = $product_instance->all_catalog($on_menu=1);
            $sub_catalog = '';
            $sub_catalog = isset($all_catalog[1]) ? $all_catalog[1] : $all_catalog[0]; 
            $catalog = "";

            if ($lang)
            {
                if ($default_catalog)
                {
                    $catalog = DB::query(DATABASE::SELECT, "select `name` from catalogs_" . $lang . " where `id`=" . $default_catalog)->execute('slave')->get('name');
                }
                $product_type = $set_names[strtoupper($lang)][$set_name];
            }
            else
            {
                if ($default_catalog)
                {
                    $catalog = Catalog::instance($default_catalog)->get('name');
                    $sub_catalog = Catalog::instance($sub_catalog)->get('name');
                }
            }

            $data[] = $product['sku'];
            $data[] = $product['name'];
            $data[] = isset($catalog) ? $catalog : '';
            $data[] = isset($sub_catalog) ? $sub_catalog : '';
            $data[] = 'Female';
            $crr = explode(';',$product['filter_attributes']);
            $data[] = $crr[0];

            $size = "see site";
            $attributes = $product_instance->get("attributes");
            if (!empty($attributes['Size']))
            {
                $size = implode(",", $attributes['Size']);
            }   

            $data[] = $size; 

            $data[] = '';
            $data[] = 'CHOIES';
            $data[] = '';
            $data[] = $product['description'] ? trim(strip_tags(str_replace(PHP_EOL, '', $product['description']))) : $catalog;
            $currency = Site::instance()->currencies("TWD");
            if ($lang == "uk")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $link . "?currency=eur";
                $data[] = "OUI";
                $data[] = $imageURL;
                $data[] = number_format($price, 2);
                $data[] = "£";
                $data[] = "Pour la promotion";
                $data[] = $product_type ? $product_type : "";
                $data[] = "Choies";
                $data[] = "OUI";
            }
            else
            {
                $data[] = number_format($price * $currency['rate'], 2);
                $data[] = number_format($product['price'] * $currency['rate'], 2);
                $data[] = 'TWD';
                $data[] = "YES";
                $data[] = "3~15 days";
                $data[] = "Free";
                $data[] = $imageURL;
                $data[] = $link;
            }
            fputcsv($outstream, $data);//将行格式化为 CSV 并写入一个打开的文件,CSV的格式如：George,John,Thomas,USA
        }
        fclose($outstream_itemlist);
        echo "twfeed success";
    }

    public static function customerexport()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $start = strtotime(date("Y-m-d", strtotime("yesterday", strtotime(date("Y-m-d"), time()))));
        $end = $start + 86400;
        $filename = "member_" . date("Ymd", strtotime("yesterday", strtotime(date("Y-m-d"), time()))) . ".csv";
        $filepath = "/home/data/www/htdocs/clothes/Export/customers/" . $filename;
        $outstream_itemlist = fopen($filepath, 'w');
        $head_itemlist = array('email', 'firstname', 'lastname','first register date');
        fputcsv($outstream_itemlist, $head_itemlist);

        $outstream = fopen($filepath, 'a');
        $customers = DB::query(DATABASE::SELECT, "select * from customers where `site_id`=1 and ( `created`>=" . $start . " and `created`<" . $end . ") order by id asc")->execute('slave');
        foreach ($customers as $customer)
        {
            $data = array();
            $data[] = $customer['email'];
            $data[] = $customer['firstname'];
            $data[] = $customer['lastname'];
            $data[] = date('Y-m-d', $customer['created']);
            fputcsv($outstream, $data);
        }
        fclose($outstream_itemlist);
        echo "export success";
        /** webdav upload* */
        $credentials = array('choies_new', '205251771e');
        $remoteUrl = 'http://suite7.emarsys.net/storage/choies/';
        $filesize = filesize($filepath);
        $fh = fopen($filepath, 'rb');
        $ch = curl_init($remoteUrl);
        curl_setopt($ch, CURLOPT_USERPWD, implode(':', $credentials));
        curl_setopt($ch, CURLOPT_URL, $remoteUrl . $filename);
        curl_setopt($ch, CURLOPT_PUT, true);
        curl_setopt($ch, CURLOPT_INFILE, $fh);
        curl_setopt($ch, CURLOPT_INFILESIZE, $filesize);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER, true); // --data-binary
        curl_exec($ch);
        fclose($fh);
        echo $filename . " upload success";
        exit;
    }
    
    public function _daochutxtReplenish($k)
    {
         
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country= '$k' and status=1 and type=0")->execute('slave')->as_array();
        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $set_names = Kohana::config('googlefeed.set_name');
        if($k=="CA"){
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }elseif($k=="CH"){
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }elseif($k=="MX"){
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }elseif($k=="AT"){
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }elseif($k=="BE"){
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
          
        if(isset($arr[0]['feed']))
        {
            $feed=$arr[0]['feed'].'.';
        }
        else
        {
            $feed='';
        }
       
        $file_name = "choies_googleshopping_feed.". $feed . strtolower($k) . ".txt";
       // $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';
        $open = fopen($local_directory . $file_name, "w");
      
        
        $head = implode("\t", $head_gooproductinfo);
       
      
        fwrite($open, $head . PHP_EOL);
       

        if ($k == "CA" ||$k == "CH"){
            $suffix = "";
        }
        elseif($k=="MX"){
            $suffix = "_" . strtolower("ES");
        } 
        elseif($k=="AT"){
            $suffix = "_" . strtolower("DE");
        }else{
            $suffix = "_" . strtolower("fr");
        }
       
        
        
        $time = time(); //获取当前时间
        $b = 86400*15; //计算15天的时间数
        $time = $time-$b; //用当前时间减去15天的时间数
        $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
        foreach($attr as $v){
            $vv[]= $v['product_id'];
        }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC ")->execute('slave');
        $product_type = "";
        
        $brr = Kohana::config('googlefeed.notsku');
        foreach ($products as $product)
        {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
           
            if ($k == "CA" || $k == "CH")
            {
                $product_instance = Product::instance($product['id']);
                
            }
            elseif($k =="MX")
            {
                $product_instance = Product::instance($product['id'], strtolower("es"));
            
            } elseif($k =="AT")
            {
                $product_instance = Product::instance($product['id'], strtolower("de"));
            
            } elseif($k =="BE")
            {
                $product_instance = Product::instance($product['id'], strtolower("fr"));
            
            }
           
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = $product_instance->default_catalog();
            $cataname = Catalog::instance($product_catalog)->get("name");
            
            if ($set_name) {
                if ($k == "CA" || $k == "CH") 
                {
                    if (strpos ( $product ['name'], 'Kimono' ) != false) 
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    } 
                    else
                     {
                        if(isset($set_names["CA"][$set_name]))
                        {
                            $product_type = $set_names["CA"][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }
                    }
                } 
                else 
                {
                    if (strpos ( $product ['name'], 'Kimono' ) != false) 
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    } 
                    else
                     {
                        if(isset($set_names[$k][$set_name]))
                        {
                            $product_type = $set_names[$k][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }
                    }
                }
            }
            //id
            $data[] = $product['sku'].'-'.$arr[0]['uid'];
            
            if(empty($product['pla_name'])){
                if($k == "BE"){
                    $proname = stripslashes($product['name']);
                    $data[] = "choies ".$proname; 
                }else{
                        if($k == 'US' || $k == 'UK' || $k == 'CA' || $k == 'CH' || $k == 'AU'){
                                  $data[] = $product['name']; 
                        }else{
                                $data[] = "Choies ".$product['name'];        
                        }
                }
          
            }else{
             $data[] = $product['pla_name'];  
            }
            
          //description
          if ($k == "CA" || $k == "CH")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
                
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));//将字符串，以；分割成数据
                
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    
                    
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                   
                    if (!empty($sorts))
                    {
                        
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            
                           
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            
                         
                            if ($attr)
                            {
                                
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                
                                if($k=="MX"){
                                    $a="es";
                                }elseif($k=="AT"){
                                    $a="de";
                                }elseif($k=="BE"){
                                    $a="fr";
                                }
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($a) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                               
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
               
               
                    //BEGIN小语种取details
                    $sortArr_en = Kohana::config('sorts.en');
                    $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                    if (!empty($filter_sorts))
                    {
                        foreach ($filter_sorts as $name => $sort)
                        {
                            $en_name = strtolower($name);
                            if (in_array($en_name, $sortArr_en))
                            {
                                $small_key = array_keys($sortArr_en, $en_name);
                                $small_name = $sortArr_small[$small_key[0]];
                            }
                            else
                                $small_name = $name;
                            $detail[] = ucfirst($small_filter[strtolower($sort)]);
                            
                        }
                    }
                    $details = implode(" ", $detail);
                    $details = str_replace("&nbsp;", "", $details);
                    $details = $details ? strip_tags($details) : "default";
                    
                    //by zhangchunmei
                    $details = str_replace("<p>", "", $details);
                    $details = str_replace("</p>", "", $details);
                    
                    $details = str_replace("<span *>", "", $details);
                    $details = str_replace("</span>", "", $details);
                    
                    $brief = strip_tags($product['brief']);
                    $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                    if($k == 'BE'){
                      $descrip  = strip_tags($product['description']);
                      $descrip = stripslashes($descrip);
                    }else{
                     $descrip  = strip_tags($product['description']); 
                    }
                    //by zhangchunmei 2015.6.30
                    $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                    $descrip = str_replace("; ",";",$descrip);
                    $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
                    //by zhangchunmei
                   // $dp2=str_replace("<p>", "", $dp1);
                    //$data[]=str_replace("</p>", "", $dp2);
                    
             }
             
           
            //custom_label_0
            if(strpos($product['name'],'Kimono') != false){
                $data[] = 'Kimono';
            }else{
                $data[] = $set_name;
            }
          
       
            //custom_label_1
            $crr = explode(';',$product['filter_attributes']);
            $data[] = $crr[0];
          
            //custom_label_2
            /*if($cataname){
                $data[] = $cataname;
            }else{
              $data[] = $set_name;  
            }     */  
            $data[]=$arr[0]["custom_label"];//自定义    
             //custom_label_3
            if(in_array($product['id'],$vv)){
                $data[] = 'top seller';
            }else{
                $data[] = 'not top seller';
          
            }
            
            
            //custom_label_4
            if($k == 'AT' || $k == "BE"){
                $currency = Site::instance()->currencies("EUR");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }elseif($k == 'CA'){
                $currency = Site::instance()->currencies("CAD");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }elseif($k == 'CH'){
                $currency = Site::instance()->currencies("CHF");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }elseif($k == 'MX'){
                $currency = Site::instance()->currencies("MXN");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            
            
            //google_product_category
            $data[] = $product_type;
            //product_type
            $data[] = $product_type;
            
            if ($k == "CA")
            {
                $currency = Site::instance()->currencies("CAD");
                $data[] = $plink . "?currency=cad";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CAD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CAD";
            } 
            elseif ($k == "CH")  //6.18写到这里
            {
                $currency = Site::instance()->currencies("CHF");
                $data[] = $plink . "?currency=chf";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CHF";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CHF";
            }
            elseif ($k == "MX")   
            {
                $currency = Site::instance()->currencies("MXN");
                $data[] = $plink . "?currency=mxn";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " MXN";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " MXN";
                
               /*  print_r( $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " MXN");
                die; */
                
            }
            elseif ($k == "AT")   
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "BE")   
            {
                 $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            
            $size = "see site";
            $attributes = $product_instance->get("attributes");
            if (!empty($attributes['Size']))
            {
                $size = implode(",", $attributes['Size']);
            }     
            if ($k == "CA" || $k =="CH" )
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }
        
            elseif ($k == "MX")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = $size;
            }
            elseif ($k == "BE")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = $size;
            }
            else
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }
            
            $data[] = "Choies";
        
         //title、description默认内容写在前面或后面的判断
                $explode= explode('=',$arr[0]['position']);
                $explode1=explode('-',$explode[0]); 
                $explode2=explode('-',$explode[1]); 
                $title=explode('++++',$arr[0]['title']);
                $description=explode('++++',$arr[0]['description']);
                if($explode1[0]){$data[1]=$title[0].' '.$data[1];}
                if($explode1[1]){$data[1].=' '.$title[1];}
                if($explode2[0]){$data[2]=$description[0].' '.$data[2];}
                if($explode2[1]){$data[2].=' '.$description[1];}
         //custom_label_0 1 2 3 4
                $color=$data[4];//color
                $catalog=$data[3];//分类
                $sell=$data[6];//爆款
                $price=$data[7];//价格
                $custom_label=$data[5];//自定义
             /*   if($arr[0]['custom_label_0']=='1'){
                    $data[4]=$color;//$data[4]对应custom_label_0
                }else if($arr[0]['custom_label_0']=='2'){
                    $data[4]=$catalog;
                }else if($arr[0]['custom_label_0']=='3'){
                    $data[4]=$price;
                }else if($arr[0]['custom_label_0']=='4'){
                    $data[4]=$sell;
                }else if($arr[0]['custom_label_0']=='5'){
                    $data[4]=$custom_label;
                }*/
                //custom_label_0 1 2 3 4 数据调换位置
                for($i=0;$i<5;$i++){
                    if($arr[0]["custom_label_{$i}"]=='1'){
                        $data[$i+3]=$color;
                    }else if($arr[0]["custom_label_{$i}"]=='2'){
                        $data[$i+3]=$catalog;
                    }else if($arr[0]["custom_label_{$i}"]=='3'){
                        $data[$i+3]=$price;
                    }else if($arr[0]["custom_label_{$i}"]=='4'){
                        $data[$i+3]=$sell;
                    }else if($arr[0]["custom_label_{$i}"]=='5'){
                        $data[$i+3]=$custom_label;
                    }

                }
            //link
            if(strpos ($data[10],'?'))
            {
                $data[10]=$data[10].'&lang='.$arr[0]['lang'];
            }else{
                 $data[10]=$data[10].'?lang='.$arr[0]['lang'];
            }

            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
            }  //end sku guolv
            }  // end set
        }
        $re = fclose($open);
        echo "pla success";
        
    }

        //for criteo code
    public static function daochucsv1($k)
    {
         
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        
        $set_names = Kohana::config('googlefeed.set_name');
        if($k=="CA"){
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price','retailprice','brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }elseif($k=="CH"){
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }elseif($k=="MX"){
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }elseif($k=="AT"){
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }elseif($k=="BE"){
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        
        $filename = "/home/data/www/htdocs/clothes/googleproduct/choies_criteo_feed." . strtolower($k) . ".csv";
       // $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';
        $outstream_itemlist = fopen($filename, 'w');
        fputcsv($outstream_itemlist, $head_gooproductinfo);
       
        $outstream = fopen($filename, 'a');
        if ($k == "CA" ||$k == "CH"){
            $suffix = "";
        }
        elseif($k=="MX"){
            $suffix = "_" . strtolower("ES");
        } 
        elseif($k=="AT"){
            $suffix = "_" . strtolower("DE");
        }else{
            $suffix = "_" . strtolower("fr");
        }
       
        
        
        $time = time(); //获取当前时间
        $b = 86400*15; //计算15天的时间数
        $time = $time-$b; //用当前时间减去15天的时间数
        $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
        foreach($attr as $v){
            $vv[]= $v['product_id'];
        }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        
        $brr = Kohana::config('googlefeed.notsku');
        $shoesarr = array('Boots','Sandals','Platforms','Flats','Sneakers & Athletic Shoes','Heels');
        foreach ($products as $product)
        {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
           
            if ($k == "CA" || $k == "CH")
            {
                $product_instance = Product::instance($product['id']);
                
            }
            elseif($k =="MX")
            {
                $product_instance = Product::instance($product['id'], strtolower("es"));
            
            } elseif($k =="AT")
            {
                $product_instance = Product::instance($product['id'], strtolower("de"));
            
            } elseif($k =="BE")
            {
                $product_instance = Product::instance($product['id'], strtolower("fr"));
            
            }
           
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = Product::instance($product['id'])->default_catalog();
            $cataname = Catalog::instance($product_catalog)->get("name");
            $isteshu = 0;
            if(in_array($cataname,$shoesarr)){
                $isteshu = 1;
            }
            if ($set_name) {
                if ($k == "CA" || $k == "CH") 
                {
                    if (strpos ( $product ['name'], 'Kimono' ) != false) 
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    } 
                    else
                     {
                        $product_type = $set_names ["CA"] [$set_name];
                    }
                } 
                else 
                {
                    if (strpos ( $product ['name'], 'Kimono' ) != false) 
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    } 
                    else
                     {
                        $product_type = $set_names [$k] [$set_name];
                    }
                }
            }else{   //shoes分类的单独处理
                $product_type = $set_names[$k][$cataname];
            }
            
            $data[] = $product['id'];
            
            if(empty($product['pla_name'])){
                if($k == "BE"){
                    $proname = stripslashes($product['name']);
                    $data[] = $proname; 
                }else{
                  $data[] = $product['name'];   
                }
          
            }else{
             $data[] = $product['pla_name'];  
            }
            
          //description
          if ($k == "CA" || $k == "CH")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = 'Choies design Up to 80% OFF'.' '.$product['name']. ' ' .$des ;
                
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));//将字符串，以；分割成数据
                
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    
                    
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                   
                    if (!empty($sorts))
                    {
                        
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            
                           
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            
                         
                            if ($attr)
                            {
                                
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                
                                if($k=="MX"){
                                    $a="es";
                                }elseif($k=="AT"){
                                    $a="de";
                                }elseif($k=="BE"){
                                    $a="fr";
                                }
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($a) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                               
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
               
               
                    //BEGIN小语种取details
                    $sortArr_en = Kohana::config('sorts.en');
                    $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                    if (!empty($filter_sorts))
                    {
                        foreach ($filter_sorts as $name => $sort)
                        {
                            $en_name = strtolower($name);
                            if (in_array($en_name, $sortArr_en))
                            {
                                $small_key = array_keys($sortArr_en, $en_name);
                                $small_name = $sortArr_small[$small_key[0]];
                            }
                            else
                                $small_name = $name;
                            $detail[] = ucfirst($small_filter[strtolower($sort)]);
                            
                        }
                    }
                    $details = implode(" ", $detail);
                    $details = str_replace("&nbsp;", "", $details);
                    $details = $details ? strip_tags($details) : "default";
                    
                    //by zhangchunmei
                    $details = str_replace("<p>", "", $details);
                    $details = str_replace("</p>", "", $details);
                    
                    $details = str_replace("<span *>", "", $details);
                    $details = str_replace("</span>", "", $details);
                    
                    $brief = strip_tags($product['brief']);
                    $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                    if($k == 'BE'){
                      $descrip  = strip_tags($product['description']);
                      $descrip = stripslashes($descrip);
                    }else{
                     $descrip  = strip_tags($product['description']); 
                    }
                    //by zhangchunmei 2015.6.30
                    $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                    $descrip = str_replace("; ",";",$descrip);
                    $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
                    //by zhangchunmei
                   // $dp2=str_replace("<p>", "", $dp1);
                    //$data[]=str_replace("</p>", "", $dp2);
                    
             }
             
           
            //custom_label_0
            if(strpos($product['name'],'Kimono') != false){
                $data[] = 'Kimono';
            }else{
                $data[] = $set_name;
            }
          
       
            //custom_label_1
            $crr = explode(';',$product['filter_attributes']);
            $data[] = $crr[0];
          
            //custom_label_2
            $data[] = 'see site';
            //custom_label_3
            if(in_array($product['id'],$vv)){
                $data[] = 'top seller';
            }else{
                $data[] = 'not top seller';
          
            }
            
            
            //custom_label_4
            if($k == 'AT' || $k == "BE"){
                $currency = Site::instance()->currencies("EUR");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  self::get_priceround1($b);
            }elseif($k == 'CA'){
                $currency = Site::instance()->currencies("CAD");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  self::get_priceround1($b);
            }elseif($k == 'CH'){
                $currency = Site::instance()->currencies("CHF");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  self::get_priceround1($b);
            }elseif($k == 'MX'){
                $currency = Site::instance()->currencies("MXN");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  self::get_priceround1($b);
            }
            
            
            //google_product_category
            if($isteshu){
            $data[] = $product_type.' > '.$cataname;
            $data[] = $product_type.' > '.$cataname;
            }else{
             //shoes分类的单独处理    
            $data[] = $product_type;
            $data[] = $product_type;
            }
        
            if ($k == "CA")
            {
                $currency = Site::instance()->currencies("CAD");
                $data[] = $plink . "?currency=cad";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CAD";
                $data[] = number_format($product_instance->get('price') * $currency['rate'], 2) . " CAD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CAD";
            } 
            elseif ($k == "CH")  //6.18写到这里
            {
                $currency = Site::instance()->currencies("CHF");
                $data[] = $plink . "?currency=chf";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CHF";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CHF";
            }
            elseif ($k == "MX")   
            {
                $currency = Site::instance()->currencies("MXN");
                $data[] = $plink . "?currency=mxn";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " MXN";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " MXN";
                
               /*  print_r( $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " MXN");
                die; */
                
            }
            elseif ($k == "AT")   
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "BE")   
            {
                 $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            
            if ($k == "CA" || $k =="CH" )
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = "see site";
            }
        
            elseif ($k == "MX")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = "ver sitio";
            }
            elseif ($k == "BE")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = "voir site";
            }
            else
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = "see site";
            }
            
            $data[] = "Choies";
         
            fputcsv($outstream, $data);
            }  //end sku guolv
            } //end set 
        }
        fclose($outstream_itemlist);
        echo "criteo success";
        
    }

    public function get_priceround($b){
        $brr = array('0-9.9','10-19.9','20-29.9','30-39.9','40-59.9','60-99.9','100');
        if($b <= 9.9){
            return $brr[0];
        }elseif(9.9 < $b and $b <=19.9){
            return $brr[1];
        }elseif(20 < $b and $b <=29.9){
            return  $brr[2];
        }elseif($b >30 and $b <=39.9){
            return  $brr[3];
        }elseif(40 < $b and $b <=59.9){
            return $brr[4];
        }elseif(60 < $b and $b <=99.9){
            return  $brr[5];
        }elseif($b >=100){
            return $brr[6];
        }
    }

    public static  function get_priceround1($b){
        $brr = array('0-9.9','10-19.9','20-29.9','30-39.9','40-59.9','60-99.9','100');
        if($b <= 9.9){
            return $brr[0];
        }elseif(9.9 < $b and $b <=19.9){
            return $brr[1];
        }elseif(20 < $b and $b <=29.9){
            return  $brr[2];
        }elseif($b >30 and $b <=39.9){
            return  $brr[3];
        }elseif(40 < $b and $b <=59.9){
            return $brr[4];
        }elseif(60 < $b and $b <=99.9){
            return  $brr[5];
        }elseif($b >=100){
            return $brr[6];
        }
    }

    public function action_gettxt()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        //为什么定义美国与欧美
        $fileurls = "/home/data/www/htdocs/clothes/googleproduct/choiesfeed1.txt";

            if (!file_exists($fileurls))
            {
                $this->_daochufeed123();
            }
            else
            {
                $result = @unlink($fileurls); 
                $this->_daochufeed123();

            }
           
    }

    public function _daochufeed123()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';
        $file_name = "choiesfeed1.txt";

$head_gooproductinfo = array('Priduct Name', 'Catogory', 'retail price','Price','Buy URL', 'Image URL','Description','SKU','Uinque ID');

        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);
        $products = DB::query(DATABASE::SELECT, "select * from products  where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        foreach ($products as $product)
        {
            $data = array();
            $product_instance = Product::instance($product['id']);
            $data[] = $product['name'];  
            $set_name = Set::instance($product['set_id'])->get('name');
            $data[] = $set_name;
            $data[] = number_format($product_instance->price(), 2) . "USD";
            $data[] = number_format($product_instance->get('price'), 2) . "USD";
            $plink = $product_instance->permalink();
            $data[] = $plink;
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $data[] = $imageURL;
            $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
            if($des){
                $data[] = $des;
            }else{
                $data[] = $product['name'];
            }
            $data[] = $product['sku'];
            $data[] = $product['id'];
            $data[] = "Choies";
            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
        }
        $re = fclose($open);
        echo "pla success";
    }
    
  
    
    public function _daochutxt($k)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
        $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country= '$k' and status=1 and type=0")->execute('slave')->as_array();
        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';
 
        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание","custom_label_0", "custom_label_1", "custom_label_2", "custom_label_3", "custom_label_4", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type','promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }

        if ($k != "US")
        {
            if(isset($arr[0]['feed']))
            {
                $feed=$arr[0]['feed'].'.';
            }
            else
            {
                $feed='';
            }
            $file_name = "choies_googleshopping_feed." .$feed. strtolower($k) . ".txt";
        }
        else
        {
            if(isset($arr[0]['feed']))
            {
                $feed=$arr[0]['feed'];
            }
            else
            {
                $feed='';
            }
            $file_name = "choies_googleshopping_feed".$feed.".txt";
        }
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
    
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave')->as_array();
        $product_type = "";
        $brr = Kohana::config('googlefeed.notsku');
        $crr = array('US','UK','CA');
        $blackfridy = array('US','UK','AU');
        $blackarr = Site::instance()->isblack();
        foreach ($products as $product)
        {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = Product::instance($product['id'])->default_catalog();
            $cataname = Catalog::instance($product_catalog)->get("name");
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        if(isset($set_names["US"][$set_name]))
                        {
                            $product_type = $set_names["US"][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }   
                    }        
                }
                else
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        if(isset($set_names[$k][$set_name]))
                        {
                            $product_type = $set_names[$k][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }
                    }         
                }
            }
            //id
            $data[] = $product['sku'].'-'.$arr[0]['uid'];
            if(empty($product['pla_name']))
            {
                if($k == "FR")
                {
                    $proname = stripslashes($product['name']);
                    $data[] = "choies ".$proname; 
                }
                else
                {
                    if($k == 'US' || $k == 'UK' || $k == 'CA' || $k == 'CH' || $k == 'AU')
                    {
                        $data[] = $product['name']; 
                    }
                    else
                    {
                        $proname = str_replace('"','',$product['name']);
                        $data[] = "Choies ".$proname;        
                    }
                }
            }
            else
            {
                $data[] = $product['pla_name'];  
            }

            
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                $brief = trim(strip_tags(str_replace(PHP_EOL, '', $brief)));
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                 $descrip = stripslashes($descrip);
                }
                $proname1 = str_replace('"','',$product['name']);
                $descrip = str_replace('&nbsp;','',$descrip);
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                
                $descrip = str_replace("; ",";",$descrip); 

                $data[] = $proname1 . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }
            //custom_label_0
/*            if ($k != "RU")
            {*/
                if(strpos($product['name'],'Kimono') != false)
                {
                    $data[] = 'Kimono';
                }
                else
                {
                    $data[] = $set_name;
                }
                
/*                if ($k == "US" || $k == "EN" || $k =="AU" || $k=="UK")
                {
                    $data[] = "EN";
                }
                else
                {
                    $data[] = $k;
                }*/
                //custom_label_1
                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0];
                if(!empty($crr[0]))
                {
                    $colors = $crr[0];
                    if($colors == 'multi')
                    {
                      $colors = 'as photo';  
                    }
                }
                else
                {
                    $colors = 'as photo';
                }
        //    }

                    //custom_label_2
            //    if($k != 'RU'){
              /*  if($cataname)
                {
                    $data[] = $cataname;
                }
                else
                {
                    $data[] = $set_name;  
                }*/
                $data[]=$arr[0]["custom_label"];//自定义
                    //custom_label_3
               if(in_array($product['id'],$vv))
                {  
                    $data[] = 'top seller';
                }
                else
                {
                    $data[] = 'not top seller';
                }  

        //    }

                //label4
            if($k == 'DE' || $k == "ES" || $k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            elseif($k == 'AU')
            {
                $currency = Site::instance()->currencies("AUD");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            elseif($k == 'UK')
            {
                $currency = Site::instance()->currencies("GBP");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            else
            {
                $b = number_format($product_instance->price(), 2);
                $data[] =  $this->get_priceround($b);
            }

            $data[] = $product_type;
            $data[] = $product_type;
            //promotion_id
            //$data[] = '';

            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur&lang=de";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur&lang=fr";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "RU")
            {

                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                //$data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            else
            {
                $data[] = $plink;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " USD";
            }


            $size = "see site";
            $attributes = $product_instance->get("attributes");
            if (!empty($attributes['Size']))
            {
                $size = implode(",", $attributes['Size']);
            }            
            if ($k == "EN" || $k =="AU" || $k=="UK" || $k == "US")
            {
                $data[] = "Adult";
                $data[] = $colors;
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = isset($colors) ? $colors : 'as photo';
                $data[] = $size;
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = isset($colors) ? $colors : 'as photo';
                $data[] = $size;
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = isset($colors) ? $colors : 'as photo';
                $data[] = $size;
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = 'as photo';
                $data[] = $size;
            }
            else
            {
                $data[] = "Adult";
                $data[] = $colors;
                $data[] = $size;
            }

            $data[] = "Choies";
   //title、description默认内容写在前面或后面的判断
                $explode= explode('=',$arr[0]['position']);
                $explode1=explode('-',$explode[0]); 
                $explode2=explode('-',$explode[1]); 
                $title=explode('++++',$arr[0]['title']);
                $description=explode('++++',$arr[0]['description']);
                if($explode1[0]){$data[1]=$title[0].' '.$data[1];}
                if($explode1[1]){$data[1].=' '.$title[1];}
                if($explode2[0]){$data[2]=$description[0].' '.$data[2];}
                if($explode2[1]){$data[2].=' '.$description[1];}
         //custom_label_0 1 2 3 4
                $color=$data[4];//color
                $catalog=$data[3];//分类
                $sell=$data[6];//爆款
                $price=$data[7];//价格
                $custom_label=$data[5];//自定义
             /*   if($arr[0]['custom_label_0']=='1'){
                    $data[4]=$color;//$data[4]对应custom_label_0
                }else if($arr[0]['custom_label_0']=='2'){
                    $data[4]=$catalog;
                }else if($arr[0]['custom_label_0']=='3'){
                    $data[4]=$price;
                }else if($arr[0]['custom_label_0']=='4'){
                    $data[4]=$sell;
                }else if($arr[0]['custom_label_0']=='5'){
                    $data[4]=$custom_label;
                }*/
                //custom_label_0 1 2 3 4 数据调换位置
                for($i=0;$i<5;$i++){
                    if($arr[0]["custom_label_{$i}"]=='1'){
                        $data[$i+3]=$color;
                    }else if($arr[0]["custom_label_{$i}"]=='2'){
                        $data[$i+3]=$catalog;
                    }else if($arr[0]["custom_label_{$i}"]=='3'){
                        $data[$i+3]=$price;
                    }else if($arr[0]["custom_label_{$i}"]=='4'){
                        $data[$i+3]=$sell;
                    }else if($arr[0]["custom_label_{$i}"]=='5'){
                        $data[$i+3]=$custom_label;
                    }

                }
       
            //promotion
           // $data[10]=$arr[0]['promotion'];

            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
            }  //end sku guolv
            }  //end set 618
        }
        $re = fclose($open);
        echo "pla success";
    }

    public function _daochutxtforsize($k)
    {
        $arr = DB::query(Database::SELECT, "SELECT * FROM pla where country= '$k' and status=1 and type=0")->execute('slave')->as_array();

        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');
 
        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID','item_group_id', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp','promotion_id', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id','item_group_id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría','promotion_id', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant",'item_group_id', "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie",'promotion_id', "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание","custom_label_0", "custom_label_1", "custom_label_2", "custom_label_3", "custom_label_4", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "CA")
        {    
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id','item_group_id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'promotion_id', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'age_group', 'color', 'size', 'mpn');
        }

        if ($k != "US")
        {
            if(isset($arr[0]['feed']))
            {
                $feed=$arr[0]['feed'].'.';
            }
            else
            {
                $feed='';
            }
            $file_name = "choies_googleshopping_feed." .$feed.strtolower($k) . ".txt";
        }
        else
        {
            if(isset($arr[0]['feed']))
            {
                $feed=$arr[0]['feed'];
            }
            else
            {
                $feed='';
            }
            $file_name = "choies_googleshopping_feed.".$feed.".txt";
        }
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK" && $k!="CA")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK" || $k =="CA")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
    
        $products = DB::query(DATABASE::SELECT, "select * from products " . $suffix . " where `site_id`=1 and visibility=1 and status=1  order by created DESC")->execute('slave')->as_array();
        $product_type = "";
        $brr = Kohana::config('googlefeed.notsku');
        $crr = array('US','UK','CA');
        $blackfridy = array('US','UK','AU');
        $blackarr = Site::instance()->isblack();
        foreach ($products as $product)
        {
            $sizearr = unserialize($product['attributes']);
            if(empty($sizearr))
            {
                continue;
            }
            foreach($sizearr['Size'] as $ksize=>$sizechima)
            {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK" && $k!="CA")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = Product::instance($product['id'])->default_catalog();
            $cataname = Catalog::instance($product_catalog)->get("name");
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK" || $k =="CA")
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        if(isset($set_names["US"][$set_name]))
                        {
                            $product_type = $set_names["US"][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }   
                    }        
                }
                else
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        if(isset($set_names[$k][$set_name]))
                        {
                            $product_type = $set_names[$k][$set_name];
                        }
                        else
                        {
                            $product_type = $set_name;
                        }
                    }         
                }
            }
            //id
            $size=strstr($sizechima,'/',true);
            if($size)
            {
                $sizechima=$size;
            }


            $data[] = $product['sku'].'-'.$sizechima.'-'.$arr[0]['uid'];
            //$data[]="SKU-Size-".$arr[0]['uid'];
            //item_group_id
            $data[] = $product['sku'];
            //title
             
            if(empty($product['pla_name']))
            {
                if($k == "FR")
                {
                    $product['name'] = Product::instance($product['id'],'fr')->transname();
                    $proname = stripslashes($product['name']);
                    $data[] = "choies ".$proname; 
                }
                else
                {
                    if($k == 'US' || $k == 'UK' || $k == 'CA' || $k == 'CH' || $k == 'AU')
                    {
                        $data[] = $product['name']; 
                    }
                    else
                    {
                        if($k == 'DE')
                        {
                            $product['name'] = Product::instance($product['id'],'de')->transname();
                        }
                        $proname = str_replace('"','',$product['name']);
                        $data[] = "Choies ".$proname;        
                    }
                }
            }
            else
            {
                $data[] = $product['pla_name'];  
            }
           
            //description
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK" || $k =="CA")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                $brief = trim(strip_tags(str_replace(PHP_EOL, '', $brief)));
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                 $descrip = stripslashes($descrip);
                }
                $proname1 = str_replace('"','',$product['name']);
                $descrip = str_replace('&nbsp;','',$descrip);
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                
                $descrip = str_replace("; ",";",$descrip); 

                $data[] = $proname1 . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }
/*            if ($k != "RU")
            {*/
                //custom_label_0 分类1
                if(strpos($product['name'],'Kimono') != false)
                {
                    $data[] = 'Kimono';
                }
                else
                {
                    $data[] = $set_name;
                }
                
/*                if ($k == "US" || $k == "EN" || $k =="AU" || $k=="UK")
                {
                    $data[] = "EN";
                }
                else
                {
                    $data[] = $k;
                }*/
                //custom_label_1 颜色
                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0];
                if(!empty($crr[0]))
                {
                    $colors = $crr[0];
                    if($colors == 'multi')
                    {
                      $colors = 'as photo';  
                    }
                }
                else
                {
                    $colors = 'as photo';
                }
        //    }

                    //custom_label_2 
            //    if($k != 'RU'){
            /*    if($cataname)
                {
                    $data[] = $cataname;
                }
                else
                {
                    $data[] = $set_name;  
                }*/
                $data[]=$arr[0]["custom_label"];//自定义
                    //custom_label_3 爆款
                if(!empty($vv))
                {
                   if(in_array($product['id'],$vv))
                    {  
                        $data[] = 'top seller';
                    }
                    else
                    {
                        $data[] = 'not top seller';
                    }                      
                }
                else
                {
                        $data[] = 'not top seller';              
                }


        //    }

                //label4  价格范围
            if($k == 'DE' || $k == "ES" || $k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            elseif($k == 'AU')
            {
                $currency = Site::instance()->currencies("AUD");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            elseif($k == 'UK')
            {
                $currency = Site::instance()->currencies("GBP");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            elseif($k == 'CA')
            {
                $currency = Site::instance()->currencies("CAD");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }
            else
            {
                $b = number_format($product_instance->price(), 2);
                $data[] =  $this->get_priceround($b);
            }
            //google_product_category
            $data[] = $product_type;
            //product_type
            $data[] = $product_type;
            //promotion_id
            //$data[] = '';
            $data[]=$arr[0]['promotion'];
            //link,image_link,condition,availability,price,brand,gender,tax

            //link
            $linkget = '';
            if(isset($arr[0]['lang']) && !empty($arr[0]['lang']))
            {
                $linkget = '?lang='.$arr[0]['lang'];
            }

            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "RU")
            {
                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                //$data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                //$data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            elseif ($k == "CA")
            {
                $currency = Site::instance()->currencies("CAD");
                $data[] = $plink . "?currency=cad";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CAD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                //$data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CAD";
            }
            else
            {
                $data[] = $plink.$linkget;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
            }


            $size = "see site";
            $attributes = $product_instance->get("attributes");
            if (!empty($attributes['Size']))
            {
                $size = implode(",", $attributes['Size']);
            }            
            if ($k == "EN")
            {
                $data[] = "Adult";
                $data[] = $colors;
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = isset($colors) ? $colors : 'as photo';
                $data[] = $sizechima;
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = isset($colors) ? $colors : 'as photo';
                $data[] = $sizechima;
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = isset($colors) ? $colors : 'as photo';
                $data[] = $sizechima;
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = 'as photo';
                $data[] = $size;
            }
            else
            {
                $data[] = "Adult";
                $data[] = $colors;
                $data[] = $sizechima;
            }
            $data[] = "Choies";
              //title、description默认内容写在前面或后面的判断
                $explode= explode('=',$arr[0]['position']);
                $explode1=explode('-',$explode[0]); 
                $explode2=explode('-',$explode[1]); 
                $title=explode('++++',$arr[0]['title']);
                $description=explode('++++',$arr[0]['description']);
    
                if($explode1[0]){$data[2]=$title[0].' '.$data[2];}
                if($explode1[1]){$data[2].=' '.$title[1];}
                if($explode2[0]){$data[3]=$description[0].' '.$data[3];}
                if($explode2[1]){$data[3].=' '.$description[1];}
            //custom_label_0 1 2 3 4
                $color=$data[5];//color
                $catalog=$data[4];//分类
                $sell=$data[7];//爆款
                $price=$data[8];//价格
                $custom_label=$data[6];//自定义
             /*   if($arr[0]['custom_label_0']=='1'){
                    $data[4]=$color;//$data[4]对应custom_label_0
                }else if($arr[0]['custom_label_0']=='2'){
                    $data[4]=$catalog;
                }else if($arr[0]['custom_label_0']=='3'){
                    $data[4]=$price;
                }else if($arr[0]['custom_label_0']=='4'){
                    $data[4]=$sell;
                }else if($arr[0]['custom_label_0']=='5'){
                    $data[4]=$custom_label;
                }*/
                //custom_label_0 1 2 3 4 数据调换位置
                for($i=0;$i<5;$i++){
                    if($arr[0]["custom_label_{$i}"]=='1'){
                        $data[$i+4]=$color;
                    }else if($arr[0]["custom_label_{$i}"]=='2'){
                        $data[$i+4]=$catalog;
                    }else if($arr[0]["custom_label_{$i}"]=='3'){
                        $data[$i+4]=$price;
                    }else if($arr[0]["custom_label_{$i}"]=='4'){
                        $data[$i+4]=$sell;
                    }else if($arr[0]["custom_label_{$i}"]=='5'){
                        $data[$i+4]=$custom_label;
                    }

                }

            $str = implode("\t", $data);

            fwrite($open, $str . PHP_EOL);
            }  //end sku guolv
            }  //end set 618
            }  //end foreach
        }
        $re = fclose($open);
        echo "pla success";
    }

    public function _daochutxt2($k)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }

        if ($k != "US")
        {
            $file_name = "choies_googleshopping_feed.ausize.txt";
        }
        else
        {
            $file_name = "choies_googleshopping_feed.txt";
        }
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        $brr = Kohana::config('googlefeed.notsku');
        $crr = array('US','UK','CA');
        $grr = array(2,5,17,18,19,22,23,25,270,540,541,542,543,544,545,546,555,566,618,703);
        $sizearr = array(
        array('S'),
        array('M'),
        array('L'),
        );


        foreach ($products as $product)
        {     
               
            foreach($sizearr as $ksize=>$sizechima)
            {
                $data = array();
            if(!in_array($product['sku'],$brr))
            {
                if(!in_array($product['set_id'],$grr))
                {
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = Product::instance($product['id'])->default_catalog();
            $cataname = Catalog::instance($product_catalog)->get("name");
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                        $product_type = $set_names["US"][$set_name];
                    }       
                    
                }
                else
                {       
                    if(strpos($product['name'],'Kimono') != false)
                    {
                        $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                    }
                    else
                    {
                    $product_type = $set_names[$k][$set_name];
                    }   
                    
                }
            }

                $data[] = $product['sku'].'-Size'.$sizechima[0];
                if(empty($product['pla_name']))
                {
                    if($k == "FR")
                    {
                        $proname = stripslashes($product['name']);
                        $data[] = "choies ".$proname; 
                    }
                    else
                    {
                        if($k == 'US' || $k == 'UK' || $k == 'CA' || $k == 'CH' || $k == 'AU')
                        {
                            if($sizechima[0] == 'S')
                            {
                                $data[] = "CHOiES Fashion ".$product['name']. " For Girls Size ".$sizechima[0];  
                            }
                            elseif($sizechima[0] == 'M')
                            {
                                $data[] = "CHOiES Cheap ".$product['name']. " For Women Size ".$sizechima[0]; 
                            }
                            else
                            {
                                $data[] = "CHOiES Stylish ".$product['name']. " For Women Size ".$sizechima[0]; 
                            }
                                      
                        }
                        else
                        {
                            $data[] = "choies ".$product['name'];        
                        }
      
                    }
                }
                else
                {
                    $data[] = $product['pla_name'];  
                }


            
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                }
                    
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                $descrip = str_replace("; ",";",$descrip);
                $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }
            if ($k != "RU")
            {
                if(strpos($product['name'],'Kimono') != false){
                    $data[] = 'Kimono';
                }else{
                    $data[] = $set_name;
                }
                
                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0];
            }

                    //custom_label_2
                if($k != 'RU'){
                    if($cataname){
                        $data[] = $cataname;
                    }else{
                      $data[] = $set_name;  
                    }
                    //custom_label_3
                $data[] = "Size ".$sizechima[0];
                    
            }

                //label4
            if($k == 'DE' || $k == "ES" || $k == "FR"){
                $currency = Site::instance()->currencies("EUR");
                $b = number_format($product_instance->price() * $currency['rate'], 2);
                  $data[] =  $this->get_priceround($b);
            }elseif($k == 'AU'){
                $currency = Site::instance()->currencies("AUD");
                 $b = number_format($product_instance->price() * $currency['rate'], 2);
                 $data[] =  $this->get_priceround($b);
            }elseif($k == 'UK'){
                $currency = Site::instance()->currencies("GBP");
            $b = number_format($product_instance->price() * $currency['rate'], 2);
                $data[] =  $this->get_priceround($b);
            }else{
                $b = number_format($product_instance->price(), 2);
                $data[] =  $this->get_priceround($b);
            }

            $data[] = $product_type;
            $data[] = $product_type;
            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "RU")
            {

                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                $data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            else
            {
                $data[] = $plink;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " USD";
            }
            if ($k == "EN" || $k =="AU" || $k=="UK")
            {
                $size = "";
                $attributes = $product_instance->get("attributes");
                if (!empty($attributes['Size']))
                {
                    $size = implode(",", $attributes['Size']);
                }
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = "wie Bilder";
                $data[] = "Website sehen";
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = "ver sitio";
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = "voir site";
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = "as photo";
                $data[] = "see site";
            }
            else
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = "see site";
            }

            $data[] = "Choies"."\n";     
                   }  //end set_id guolv
            }  //end sku guolv


            $str = implode("\t", $data);
            $str = str_replace("\n\t","\n",$str);
            fwrite($open, $str . PHP_EOL);  
             }  //end size foreach 
        }
        $re = fclose($open);
        echo "pla success";
    }

    public function _daochutxt1($k)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }

        if ($k != "US")
        {
            $file_name = "choies_googleshopping_feed." . strtolower($k) . ".txt";
        }
        else
        {
            $file_name = "choies_googleshopping_feed.txt";
        }
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        $brr = Kohana::config('googlefeed.notsku');
        $crr = array('US','UK','CA');
        foreach ($products as $product)
        {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names["US"][$set_name];
                }       
                    
                }
                else
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names[$k][$set_name];
                }   
                    
                }
            }

             $data[] = $product['sku'].',';
            if(empty($product['pla_name'])){
                if($k == "FR"){
                    $proname = stripslashes($product['name']);
                    $data[] = "choies ".$proname.','; 
                }else{
                  $data[] = "choies ".$product['name'].',';   
                }
            }else{
             $data[] = $product['pla_name'].',';  
            }
            
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des .',';
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                }
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));
                $descrip = str_replace("; ",";",$descrip);
                $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief.',';
            }
            if ($k != "RU")
            {
                if(strpos($product['name'],'Kimono') != false){
                    $data[] = 'Kimono,';
                }else{
                    $data[] = $set_name.',';
                }
                
/*                if ($k == "US" || $k == "EN" || $k =="AU" || $k=="UK")
                {
                    $data[] = "EN";
                }
                else
                {
                    $data[] = $k;
                }*/
                //custom_label_1
                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0].',';
            }

                    //custom_label_2
                if($k != 'RU'){
                    $data[] = 'see site,';
                    //custom_label_3
               if(in_array($product['id'],$vv)){  
                    $data[] = 'top seller,';
                 }else{
                    $data[] = 'not top seller,';
                }  

            }

                //label4
    if($k == 'DE' || $k == "ES" || $k == "FR"){
        $currency = Site::instance()->currencies("EUR");
        $b = number_format($product_instance->price() * $currency['rate'], 2);
          $data[] =  $this->get_priceround($b);
    }elseif($k == 'AU'){
        $currency = Site::instance()->currencies("AUD");
         $b = number_format($product_instance->price() * $currency['rate'], 2);
         $data[] =  $this->get_priceround($b);
    }elseif($k == 'UK'){
        $currency = Site::instance()->currencies("GBP");
    $b = number_format($product_instance->price() * $currency['rate'], 2);
        $data[] =  $this->get_priceround($b).',';
    }else{
        $b = number_format($product_instance->price(), 2);
        $data[] =  $this->get_priceround($b);
    }

            $data[] = $product_type.',';
            $data[] = $product_type.',';
            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "RU")
            {

                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp,";
                $data[] = $imageURL.',';
                $data[] = "new,";
                $data[] = $product['status'] == 1 ? "in stock," : "out of stock,";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP,";
                $data[] = "Choies,";
                $data[] = "female,";
                $data[] = "GB::0:,";
                $data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP,";
            }
            else
            {
                $data[] = $plink.',';
                $data[] = $imageURL.',';
                $data[] = "new,";
                $data[] = $product['status'] == 1 ? "in stock," : "out of stock,";
                $data[] = number_format($product_instance->price(), 2) . " USD,";
                $data[] = "Choies,";
                $data[] = "female,";
                $data[] = $k . "::0:,";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " USD,";
            }
            if ($k == "EN" || $k =="AU" || $k=="UK")
            {
                $size = "";
                $attributes = $product_instance->get("attributes");
                if (!empty($attributes['Size']))
                {
                    $size = implode(",", $attributes['Size']);
                }
                $data[] = "Adult,";
                $data[] = "as photo,";
                $data[] = $size.',';
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = "wie Bilder";
                $data[] = "Website sehen";
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = "ver sitio";
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = "voir site";
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = "as photo";
                $data[] = "see site";
            }
            else
            {
                $data[] = "Adult,";
                $data[] = "as photo,";
                $data[] = "see site,";
            }

            $data[] = "Choies,";
            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
            }  //end sku guolv
            }  // end set 
        }
        $re = fclose($open);
        echo "pla success";
    }

    public static function daochucsv($k)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price','retailprice', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price','retailprice','brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }


        if ($k != "US")
        {
            $filename = "/home/data/www/htdocs/clothes/googleproduct/choies_criteo_feed." . strtolower($k) . ".csv";
        }
        else
        {
            $filename = "/home/data/www/htdocs/clothes/googleproduct/choies_criteo_feed.csv";
        }

        $outstream_itemlist = fopen($filename, 'w');
        fputcsv($outstream_itemlist, $head_gooproductinfo);

        $outstream = fopen($filename, 'a');
        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        $brr = Kohana::config('googlefeed.notsku');
        $crr = array('US','UK','CA');
        
        foreach ($products as $product)
        {
            if($product['set_id'] != 618)
            {
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            
            $shoesarr = array('Boots','Sandals','Platforms','Flats','Sneakers & Athletic Shoes','Heels');
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $product_catalog = Product::instance($product['id'])->default_catalog();
            $cataname = Catalog::instance($product_catalog)->get("name");
            $isteshu = 0;
            if(in_array($cataname,$shoesarr)){
                $isteshu = 1;
            }
            if ($set_name){

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names["US"][$set_name];
                }       
                    
                }
                else
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names[$k][$set_name];
                }   
                    
                }
            }



             $data[] = $product['id'];
            if(empty($product['pla_name'])){
                if($k == "FR"){
                    $proname = stripslashes($product['name']);
                    $data[] = $proname; 
                }else{
                  $data[] = $product['name'];   
                }
            }else{
             $data[] = $product['pla_name'];  
            }
            
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = 'Choies design Up to 80% OFF'.' '.$product['name']. ' ' .$des;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                }
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));  
                $descrip = str_replace("; ",";",$descrip);
                $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }
            if ($k != "RU")
            {
                if(strpos($product['name'],'Kimono') != false){
                    $data[] = 'Kimono';
                }else{
                    $data[] = $set_name;
                }
                
                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0];
            }

                    //custom_label_2
                if($k != 'RU'){
                    $data[] = 'see site';
                    //custom_label_3
               if(in_array($product['id'],$vv)){  
                    $data[] = 'top seller';
                 }else{
                    $data[] = 'not top seller';
                }  

            }

                //label4
    if($k == 'DE' || $k == "ES" || $k == "FR"){
        $currency = Site::instance()->currencies("EUR");
        $b = number_format($product_instance->price() * $currency['rate'], 2);
          $data[] =  self::get_priceround1($b);
    }elseif($k == 'AU'){
        $currency = Site::instance()->currencies("AUD");
         $b = number_format($product_instance->price() * $currency['rate'], 2);
         $data[] =  self::get_priceround1($b);
    }elseif($k == 'UK'){
        $currency = Site::instance()->currencies("GBP");
    $b = number_format($product_instance->price() * $currency['rate'], 2);
        $data[] =  self::get_priceround1($b);
    }else{
        $b = number_format($product_instance->price(), 2);
        $data[] =  self::get_priceround1($b);
    }

            if($isteshu){
            $data[] = $product_type.' > '.$cataname;
            $data[] = $product_type.' > '.$cataname;;
            }else{
             //shoes分类的单独处理    
            $data[] = $product_type;
            $data[] = $product_type;
            }

            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "RU")
            {

                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = number_format($product_instance->get('price') * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                $data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            else
            {
                $data[] = $plink;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = number_format($product_instance->get('price'), 2). " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " USD";
            }
            if ($k == "EN" || $k =="AU" || $k=="UK")
            {
                $size = "";
                $attributes = $product_instance->get("attributes");
                if (!empty($attributes['Size']))
                {
                    $size = implode(",", $attributes['Size']);
                }
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = "wie Bilder";
                $data[] = "Website sehen";
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = "ver sitio";
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = "voir site";
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = "as photo";
                $data[] = "see site";
            }
            else
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = "see site";
            }

            $data[] = "Choies";
            
            fputcsv($outstream, $data);
            }  //end sku guolv
            }  // end set
            
        }
        fclose($outstream_itemlist);
        echo "criteo success";
    }


    //guo for feed  next  oneone

    public function _daochutxttwocach($k)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }

        if ($k != "US" && $k == "FR")
        {
            $file_name = "choies_googleshopping_feed.ca." . strtolower($k) . ".txt";
        }
        elseif($k == "DE")
        {
            $file_name = "choies_googleshopping_feed.ch." . strtolower($k) . ".txt";            
        }
        else
        {
            $file_name = "choies_googleshopping_feed.txt";
        }
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        foreach ($products as $product)
        {
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names["US"][$set_name];
                }       
                    
                }
                else
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names[$k][$set_name];
                }   
                    
                }
            }

             $data[] = $product['sku'];
            if(empty($product['pla_name'])){
                if($k == "FR"){
                    $proname = stripslashes($product['name']);
                    $data[] = "choies ".$proname; 
                }else{
                  $data[] = "choies ".$product['name'];   
                }
            }else{
             $data[] = $product['pla_name'];  
            }


            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                }
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip))); 
                $descrip = str_replace("; ",";",$descrip);
                $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }
            if ($k != "RU")
            {
                if(strpos($product['name'],'Kimono') != false){
                    $data[] = 'Kimono';
                }else{
                    $data[] = $set_name;
                }
                

                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0];
            }

                    //custom_label_2
                if($k != 'RU'){
                    $data[] = 'see site';
                    //custom_label_3
               if(in_array($product['id'],$vv)){  
                    $data[] = 'top seller';
                 }else{
                    $data[] = 'not top seller';
                }  

            }

                //label4
    if($k == 'DE' || $k == "ES" || $k == "FR"){
        $currency = Site::instance()->currencies("EUR");
        $b = number_format($product_instance->price() * $currency['rate'], 2);
          $data[] =  $this->get_priceround($b);
    }elseif($k == 'AU'){
        $currency = Site::instance()->currencies("AUD");
         $b = number_format($product_instance->price() * $currency['rate'], 2);
         $data[] =  $this->get_priceround($b);
    }elseif($k == 'UK'){
        $currency = Site::instance()->currencies("GBP");
    $b = number_format($product_instance->price() * $currency['rate'], 2);
        $data[] =  $this->get_priceround($b);
    }else{
        $b = number_format($product_instance->price(), 2);
        $data[] =  $this->get_priceround($b);
    }

            $data[] = $product_type;
            $data[] = $product_type;
            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("CHF");
                $data[] = $plink . "?currency=chf";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CHF";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = 'CH' . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CHF";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("CAD");
                $data[] = $plink . "?currency=cad";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CAD";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = 'CA' . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CAD";
            }
            elseif ($k == "RU")
            {

                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                $data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            else
            {
                $data[] = $plink;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " USD";
            }
            if ($k == "EN" || $k =="AU" || $k=="UK")
            {
                $size = "";
                $attributes = $product_instance->get("attributes");
                if (!empty($attributes['Size']))
                {
                    $size = implode(",", $attributes['Size']);
                }
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = "wie Bilder";
                $data[] = "Website sehen";
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = "ver sitio";
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = "voir site";
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = "as photo";
                $data[] = "see site";
            }
            else
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = "see site";
            }

            $data[] = "Choies";
            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
        }
        $re = fclose($open);
        echo "pla success";
    }


    //guo add for de ruishi   two two
    //guo for feed  next  

    public function _daochutxttwoch($k)
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $set_names = Kohana::config('googlefeed.set_name');
        //Itemlist
        if ($k == "DE")
        {
            $head_gooproductinfo = array('ID', 'Titel', 'Beschreibung ', 'Benutzerdefiniertes Label 0', 'Benutzerdefiniertes Label 1','Benutzerdefiniertes Label 2','Benutzerdefiniertes Label 3','Benutzerdefiniertes Label 4', 'Google Produktkategorie', 'Produkttyp', 'Link', 'Bildlink', 'Zustand', 'Verfügbarkeit', 'Preis', 'Marke', 'Geschlecht', 'Versand', 'Altersgruppe', 'Farbe', 'Größe', 'MPN');
        }
        elseif ($k == "ES")
        {
            $head_gooproductinfo = array('id', 'título', 'descripción', 'etiqueta personalizada 0', 'etiqueta personalizada 1','etiqueta personalizada 2','etiqueta personalizada 3','etiqueta personalizada 4', 'categoría en google product', 'categoría', 'enlace', 'enlace imagen', 'estado', 'disponibilidad', 'precio', 'marca', 'sexo', 'envío', 'edad', 'color', 'talla', 'mpn');
        }
        elseif ($k == "FR")
        {
            $head_gooproductinfo = array("identifiant", "titre", "description", "Étiquette personnalisée 0", "Étiquette personnalisée 1","Étiquette personnalisée 2","Étiquette personnalisée 3","Étiquette personnalisée 4", "catégorie de produits Google", "catégorie", "lien", "lien image", "état", "disponibilité", "prix", "marque", "sexe", "livraison", "tranche d'âge", "couleur", "taille", "référence fabricant");
        }
        elseif ($k == "RU")
        {
            $head_gooproductinfo = array("id", "название", "описание", "категория продукта google", "тип товара", "ссылка", "ссылка на изображение", "состояние", "наличие", "Цена", "марка", "пол", "доставка", "возрастная группа", "цвет", "размер", "код производителя");
        }
        elseif ($k == "AU")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        elseif ($k == "UK")
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }
        else
        {
            $head_gooproductinfo = array('id', 'title', 'description', 'custom_label_0', 'custom_label_1', 'custom_label_2', 'custom_label_3', 'custom_label_4', 'google_product_category', 'product_type', 'link', 'image_link', 'condition', 'availability', 'price', 'brand', 'gender', 'tax', 'shipping', 'age_group', 'color', 'size', 'mpn');
        }

        if ($k != "US" && $k == "FR")
        {
            $file_name = "choies_googleshopping_feed.ch." . strtolower($k) . ".txt";
        }
        elseif($k == "DE")
        {
            $file_name = "choies_googleshopping_feed.ch." . strtolower($k) . ".txt";            
        }
        else
        {
            $file_name = "choies_googleshopping_feed.txt";
        }
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
        {
            $suffix = "_" . strtolower($k);
        }
        elseif($k == "AU" || $k =="UK")
        {
            $suffix = "";
        }
        else
        {
            $suffix = "";
        }
        
        /**用于取订单表order_items中订单创建时间离现在在时间了少于15天的数据，
         * 并根据产品编号订单，对每个产品的订单数据进行统计**/
         $time = time(); //获取当前时间
          $b = 86400*15; //计算15天的时间数
          $time = $time-$b; //用当前时间减去15天的时间数
           $attr = DB::query(Database::SELECT, 'SELECT count( product_id ) AS co,product_id FROM order_items where created > '. $time . ' group by product_id order by co desc limit 0,30 ')->execute('slave')->as_array();
         foreach($attr as $v){
              $vv[]= $v['product_id'];
          }
        /****/
         
        $products = DB::query(DATABASE::SELECT, "select * from products" . $suffix . " where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        $brr = Kohana::config('googlefeed.notsku');
        foreach ($products as $product)
        {
            if($product['set_id'] !=618){
            if(!in_array($product['sku'],$brr)){
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }

            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names["US"][$set_name];
                }       
                    
                }
                else
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = $set_names[$k][$set_name];
                }   
                    
                }
            }

             $data[] = $product['sku'];
            if(empty($product['pla_name'])){
                if($k == "FR"){
                    $proname = stripslashes($product['name']);
                    $data[] = "Choies ".$proname; 
                }else{
                  $data[] = "Choies ".$product['name'];   
                }
            }else{
             $data[] = $product['pla_name'];  
            }

/*            if($product['id'] == '46215'){
                echo '<pre>';
                print_r($data);
                die;
            }*/
            
            if ($k == "US" || $k == "EN" || $k =="AU" || $k =="UK")
            {
                $des = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
                $data[] = $product['name']. ' ' .$des ;
            }
            else
            {
                $detail = array();
                $filter_sorts = array();
                $small_filter = array();
                $filter_attributes = explode(';', $product_instance->get('filter_attributes'));
                if (!empty($filter_attributes))
                {
                    $filter_sqls = array();
                    foreach ($filter_attributes as $key => $filter)
                    {
                        if ($filter)
                            $filter_sqls[] = '"' . $filter . '"';
                        else
                            unset($filter_attributes[$key]);
                    }
                    $filter_sql = "'" . implode(',', $filter_sqls) . "'";
                    $sorts = DB::query(DATABASE::SELECT, 'SELECT DISTINCT sort, attributes FROM catalog_sorts WHERE MATCH (attributes) AGAINST (' . $filter_sql . ' IN BOOLEAN MODE) ORDER BY sort')->execute()->as_array();
                    if (!empty($sorts))
                    {
                        foreach ($sorts as $sort)
                        {
                            if (array_key_exists($sort['sort'], $filter_attributes))
                                continue;
                            $attr = '';
                            $attributes = explode(',', strtolower($sort['attributes']));
                            foreach ($filter_attributes as $key => $attribute)
                            {
                                $attribute = strtolower($attribute);
                                if (in_array($attribute, $attributes))
                                {
                                    $attr = $attribute;
                                    unset($filter_attributes[$key]);
                                    break;
                                }
                            }
                            if ($attr)
                            {
                                $filter_sorts[strtoupper($sort['sort'])] = $attr;
                                $sattr = DB::query(Database::SELECT, 'SELECT s.' . strtolower($k) . ' AS small FROM attributes_small s LEFT JOIN attributes a ON s.attribute_id = a.id WHERE a.name = "' . $attr . '"')->execute()->get('small');
                                $small_filter[$attr] = $sattr;
                            }
                        }
                    }
                }
                //BEGIN小语种取details
                $sortArr_en = Kohana::config('sorts.en');
                $sortArr_small = Kohana::config('sorts.' . strtolower($k));
                if (!empty($filter_sorts))
                {
                    foreach ($filter_sorts as $name => $sort)
                    {
                        $en_name = strtolower($name);
                        if (in_array($en_name, $sortArr_en))
                        {
                            $small_key = array_keys($sortArr_en, $en_name);
                            $small_name = $sortArr_small[$small_key[0]];
                        }
                        else
                            $small_name = $name;
                        $detail[] = ucfirst($small_filter[strtolower($sort)]);
                    }
                }
                $details = implode(" ", $detail);
                $details = str_replace("&nbsp;", "", $details);
                $details = $details ? strip_tags($details) : "default";
                $brief = strip_tags($product['brief']);
                $brief = str_replace('&nbsp;','',$brief);
                    //END小语种取details
                if($k == 'FR'){
                  $descrip  = strip_tags($product['description']);
                  $descrip = stripslashes($descrip);
                }else{
                 $descrip  = strip_tags($product['description']); 
                }
                $descrip = trim(strip_tags(str_replace(PHP_EOL, '', $descrip)));  
                $descrip = str_replace("; ",";",$descrip);
                $data[] = $product['name'] . ' ' . $descrip . ' ' . $details . ' ' . $brief;
            }
            if ($k != "RU")
            {
                if(strpos($product['name'],'Kimono') != false){
                    $data[] = 'Kimono';
                }else{
                    $data[] = $set_name;
                }
                
/*                if ($k == "US" || $k == "EN" || $k =="AU" || $k=="UK")
                {
                    $data[] = "EN";
                }
                else
                {
                    $data[] = $k;
                }*/
                //custom_label_1
                $crr = explode(';',$product['filter_attributes']);
                $data[] = $crr[0];
            }

                    //custom_label_2
                if($k != 'RU'){
                    $data[] = 'see site';
                    //custom_label_3
               if(in_array($product['id'],$vv)){  
                    $data[] = 'top seller';
                 }else{
                    $data[] = 'not top seller';
                }  

            }

                //label4
    if($k == 'DE' || $k == "ES" || $k == "FR"){
        $currency = Site::instance()->currencies("EUR");
        $b = number_format($product_instance->price() * $currency['rate'], 2);
          $data[] =  $this->get_priceround($b);
    }elseif($k == 'AU'){
        $currency = Site::instance()->currencies("AUD");
         $b = number_format($product_instance->price() * $currency['rate'], 2);
         $data[] =  $this->get_priceround($b);
    }elseif($k == 'UK'){
        $currency = Site::instance()->currencies("GBP");
    $b = number_format($product_instance->price() * $currency['rate'], 2);
        $data[] =  $this->get_priceround($b);
    }else{
        $b = number_format($product_instance->price(), 2);
        $data[] =  $this->get_priceround($b);
    }

            $data[] = $product_type;
            $data[] = $product_type;
            if ($k == "DE")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "neu";
                $data[] = $product['status'] == 1 ? "auf Lager" : "ausverkauft";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "Damen";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "ES")
            {
                $currency = Site::instance()->currencies("EUR");
                $data[] = $plink . "?currency=eur";
                $data[] = $imageURL;
                $data[] = "nuevo";
                $data[] = $product['status'] == 1 ? "en stock" : "fuera de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " EUR";
                $data[] = "Choies";
                $data[] = "mujer";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " EUR";
            }
            elseif ($k == "FR")
            {
                $currency = Site::instance()->currencies("CHF");
                $data[] = $plink . "?currency=chf";
                $data[] = $imageURL;
                $data[] = "neuf";
                $data[] = $product['status'] == 1 ? "en stock" : "en rupture de stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " CHF";
                $data[] = "Choies";
                $data[] = "femme";
                //$data[]=$k."::0:";
                $data[] = 'CH' . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " CHF";
            }
            elseif ($k == "RU")
            {

                $currency = Site::instance()->currencies("RUB");
                $data[] = $plink . "?currency=rub";
                $data[] = $imageURL;
                $data[] = "новый";
                $data[] = $product['status'] == 1 ? "в наличии" : "нет в наличии";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " RUB";
                $data[] = "Choies";
                $data[] = "женский";
                //$data[]=$k."::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'] * $currency['rate'], 2) . " RUB";
            }
            elseif ($k == "AU")
            {           
                $currency = Site::instance()->currencies("AUD");
                $data[] = $plink . "?currency=aud";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " AUD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " AUD";
            }
            elseif ($k == "UK")
            {
                $currency = Site::instance()->currencies("GBP");
                $data[] = $plink . "?currency=gbp";
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price() * $currency['rate'], 2) . " GBP";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = "GB::0:";
                $data[] = "GB:::" . number_format($product['extra_fee'], 2) . " GBP";
            }
            else
            {
                $data[] = $plink;
                $data[] = $imageURL;
                $data[] = "new";
                $data[] = $product['status'] == 1 ? "in stock" : "out of stock";
                $data[] = number_format($product_instance->price(), 2) . " USD";
                $data[] = "Choies";
                $data[] = "female";
                $data[] = $k . "::0:";
                $data[] = $k . ":::" . number_format($product['extra_fee'], 2) . " USD";
            }

            $size = "see site";
            $attributes = $product_instance->get("attributes");
            if (!empty($attributes['Size']))
            {
                $size = implode(",", $attributes['Size']);
            }
            if ($k == "EN" || $k =="AU" || $k=="UK")
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }
            elseif ($k == "DE")
            {
                $data[] = "Erwachsene";
                $data[] = "wie Bilder";
                $data[] = $size;
            }
            elseif ($k == "ES")
            {
                $data[] = "adultos";
                $data[] = "como se muestra";
                $data[] = $size;
            }
            elseif ($k == "FR")
            {
                $data[] = "Adulte";
                $data[] = "comme des photos";
                $data[] = $size;
            }
            elseif ($k == "RU")
            {
                $data[] = "взрослые";
                $data[] = "as photo";
                $data[] = $size;
            }
            else
            {
                $data[] = "Adult";
                $data[] = "as photo";
                $data[] = $size;
            }

            $data[] = "Choies";
            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
            }  //end sku guolv
            }
        }
        $re = fclose($open);
        echo "pla success";
    }


   

    public function _daochufeed()
    {
        ignore_user_abort(true);
        set_time_limit(0);
        ini_set('memory_limit', '512M');

        $local_directory = '/home/data/www/htdocs/clothes/googleproduct/';

        $cata_log = array(
           "Shoes" => 10110000,
                "Neck" => 10130900,
                "Hair Accessories" => 10130900,
                "Bags" => 10010600,
                "Mens T-Shirts & Tanks" => 10060900,
                "Hair Extensions" => 10130900,
                "Purses" => 10010600,
                "Camis & Tanks" => 8726,
                "Crop Tops & Bralets" => 8726,
                "Socks & Tights" => 10130400,
                "Blazers" => 100000601,
                "Overalls" => 8726,
                "Eye Masks" => 10130900,
                "Coats & Jackets" => 100000601,
                "Mens Jumpers & Cardigans" => 10060800,
                "Jumpers & Pullovers" => 100001164,
                "Mens Hoodies & Sweatshirts" => 10060900,
                "Mens Coats & Jackets" => 10060300,
                "Mens Pants & Jeans" =>10060400,
                "Mens Shirts" =>10060500,
                "Mens Shorts" =>10060600,
                "Platforms" => 10110000,
                "Dresses" => 10091100,
                "Shorts" => 10091100,
                "Cardigans" => 100001164,
                "Skirts" => 10090700,
                "Pants" => 10090500,
                "Blouses & Shirts" => 8726,
                "T-Shirts" => 10091000,
                "Sandals" => 10110000,
                "Knit Vests" => 8726,
                "Bracelets & Bangles" => 10130900,
                "Rings" => 10130900,
                "Belts" => 10130800,
                "Jeans" => 100000942,
                "Hats & Caps" => 10130300,
                "Sunglasses " => 10070000,
                "Earrings " => 10130900,
                "Waistcoats" => 8726,
                "Brooch " => 10130900,
                "Scarves & Snoods" => 10130500,
                "Rompers & Playsuits" => 10090500,
                "Wigs" => 10130900,
                "Gloves" => 10130900,
                "Jumpsuits&Playsuits" => 10090500,
                "Boots" => 10110000,
                "Flats" => 10110000,
                "Sneakers & Athletic Shoes" => 10110000,
                "Heels" => 10110000,
                "Wedges" => 10110000,
                "Jumpsuits" => 10090500,
                "Hoodies & Sweatshirts" => 8726,
                "Watch" => 10130900,
               "Occasion Dresses" => 10090100,
                "Swimwear" => 100001199,
                "Jumpsuits & Playsuits" => 10090500,
                "ELF SACK" => "Apparel & Accessories > Clothing > Skirts",
                "Nails" => 10130900,
                "AIMER" => "Apparel & Accessories > Clothing > Swimwear",
                "Corset" => "Apparel & Accessories > Clothing > Shirts & Tops",
                "Two-piece suits" => 100001176,
                "Celebona" => "Apparel & Accessories > Clothing > Skirts",
                "Kimono" => 8726,
                "Sivanna" => "Health & Beauty > Personal Care > Cosmetics > Makeup",
          //      "Swimwear/Beachwear" => "Apparel & Accessories > Clothing > Swimwear",
                "LEMONPAIER" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Sleepwear" => 10101100,
                "Leggings" => 10080000,
                "Kimonos" => "Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos",
                "Menswear" => "Apparel & Accessories > Clothing > Outerwear",
                "Scarves" => "Apparel & Accessories > Clothing Accessories > Scarves & Shawls",
                "Skirts" => "Apparel & Accessories > Clothing > Skirts",'Coats/Jackets'=>111111111111);
        //Itemlist
            $head_gooproductinfo = array('Unique ID', 'Title', 'Description', 'Category', 'Product URL', 'Image URL', 'Condition', 'Availability', 'Current Price', 'Item Group ID', 'Brand', 'GTIN', 'MPN', 'Gender', 'Age Group','Original Price','ASIN','Ship Cost','Ship Cost','Ship Weight','Bid','Ship Cost','Promo Text',);
        
            $file_name = "265078_0.txt";
        
        $open = fopen($local_directory . $file_name, "w");
        $head = implode("\t", $head_gooproductinfo);
        fwrite($open, $head . PHP_EOL);

        $k = "EN";
        $products = DB::query(DATABASE::SELECT, "select * from products where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        $product_type = "";
        foreach ($products as $product)
        {
            if($product['set_id'] != 618)
            {
            $data = array();
            $str = "";
            if ($k != "US" && $k != "EN" && $k !="AU" && $k!="UK")
            {
                    
                $product_instance = Product::instance($product['id'], strtolower($k));
            }
            else
            {
                $product_instance = Product::instance($product['id']);

            }
            $imageURL = Image::link($product_instance->cover_image(), 10);
            $plink = $product_instance->permalink();
            $set_name = Set::instance($product['set_id'])->get('name');
            $sprice = $product_instance->price();
            if ($set_name)
            {

                if ($k == "EN" || $k =="AU" || $k =="UK")
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = isset($cata_log[$set_name]) ? $cata_log[$set_name] : '';
                }else{
                    $product_type = isset($cata_log[$set_name]) ? $cata_log[$set_name] : '';
                }       
                    
                }
                else
                {       
            if(strpos($product['name'],'Kimono') != false){
                    $product_type = 'Apparel & Accessories > Clothing > Traditional & Ceremonial Clothing > Kimonos';
                }else{
                    $product_type = isset($cata_log[$set_name]) ? $cata_log[$set_name] : '';
                }   
                    
                }
            }

            $data[] = $product['sku'];
            $data[] = $product['name'];
            $data[] = trim(strip_tags(str_replace(PHP_EOL, '', $product['description'])));
          /*  if(empty($set_name)){
               $data[]  = 'dresses';
            }else{
               $data[]  = $set_name;
            }   */

            if(empty($set_name)){
                $data[] = 'not found';
            }else{
                 $data[] = $product_type;
            }

            $data[] = $plink;
            $data[] = $imageURL;
            //Condition
            $data[] = 'NEW';

            $data[] = 'In Stock';
            $currency = Site::instance()->currencies("EUR");
           // $data[] = number_format($product_instance->price() * $currency['rate'], 2);
           $data[] = number_format($product_instance->price(), 2);

           //Item Group ID
           $data[] = '';

           $data[] = 'CHOIES';
           $data[] = '';
           $data[] = '';


           //Gender
            if(empty($set_name)){
               $data[]  = 'women';
            }else{
                 $b = 'Mens';
                 $a = explode(' ',$set_name);
             if(in_array($b,$a)){
                  $data[]  = 'men';
                }else{
                     $data[]  = 'women';
                }
            }

            $data[] = 'Adult';

                $attributes = $product_instance->get("attributes");
                                if (!empty($attributes['Size']))
                {
                    $size = implode(",", $attributes['Size']);
                }
                $data[] = $size;

                //原价
                if(!empty($sprice)){
                   $data[] = number_format($sprice,2); 
               }else{
                   $data[] = number_format($product_instance->price(), 2); 
               }
              
                $data[] = '';
                $data[] = '';
                $data[] = '';
                $data[] = '0.4';
                $data[] = '';

          
            $str = implode("\t", $data);
            fwrite($open, $str . PHP_EOL);
            } //end set guolv
        }
        $re = fclose($open);
        echo "daochufeed success";
    }

    public function action_feed()
    {
        $set_ids = array(17, 11, 8, 396, 1, 23, 21, 280, 20, 475, 395, 3, 13, 18, 14, 2, 10, 12, 6, 22, 472, 15, 375, 16, 298);
        $set_feeds = array(
17 =>   array('name' => 'Bracelets & Bangles', 'feed' => ' 2700322 : More Categories / Clothing & Accessories / Jewelry / Bracelets ', 'click' => 0.3, 'click' => 0.3),
11 =>   array('name' => 'Cardigans',    'feed' => '2700371 : More Categories / Clothing & Accessories / Sweaters & Sweatshirts / Women\'s Sweaters & Sweatshirts ', 'click' => 0.3),
8 =>    array('name' => 'Coats & Jackets',    'feed' => '2700440 : More Categories / Clothing & Accessories / Outerwear / Women\'s Outerwear ', 'click' => 0.3),
396 =>  array('name' => 'Corset',   'feed' => '2700515 : More Categories / Clothing & Accessories / Tops / Women\'s Tops ', 'click' => 0.3),
1 =>    array('name' => 'Dresses',    'feed' => '2700517 : More Categories / Clothing & Accessories / Dresses & Skirts / Women\'s Dresses & Skirts ', 'click' => 0.3),
23 =>   array('name' => 'Earrings', 'feed' => '2700319 : More Categories / Clothing & Accessories / Jewelry / Earrings ', 'click' => 0.3),
21 =>   array('name' => 'Hats & Caps',    'feed' => ' 2732604 : More Categories / Clothing & Accessories / Clothing Accessories / Hats / Others ', 'click' => 0.3),
280 =>  array('name' => 'Hoodies & Sweatshirts',  'feed' => '2700371 : More Categories / Clothing & Accessories / Sweaters & Sweatshirts / Women\'s Sweaters & Sweatshirts ', 'click' => 0.3),
20 =>   array('name' => 'Jeans',    'feed' => '2700394 : More Categories / Clothing & Accessories / Pants / Women\'s Pants ', 'click' => 0.3),
475 =>  array('name' => 'Jumpsuits/Playsuits',  'feed' => '2732689 : More Categories / Clothing & Accessories / One-pieces / Jumpsuits & Rompers ', 'click' => 0.3),
395 =>  array('name' => 'Leggings', 'feed' => '2700394 : More Categories / Clothing & Accessories / Pants / Women\'s Pants ', 'click' => 0.3),
3 =>    array('name' => 'Neck', 'feed' => '2700320 : More Categories / Clothing & Accessories / Jewelry / Neck ', 'click' => 0.3),
13 =>   array('name' => 'Pants',    'feed' => '2700394 : More Categories / Clothing & Accessories / Pants / Women\'s Pants ', 'click' => 0.3),
18 =>   array('name' => 'Rings',    'feed' => '2700318 : More Categories / Clothing & Accessories / Jewelry / Rings ', 'click' => 0.3),
14 =>   array('name' => 'Blouses & Shirts', 'feed' => '2700515 : More Categories / Clothing & Accessories / Tops / Women\'s Tops ', 'click' => 0.3),
2 =>    array('name' => 'shoes',    'feed' => '2700220 : More Categories / Clothing & Accessories / Shoes / Women\'s Shoes ', 'click' => 0.38),
10 =>   array('name' => 'shorts',   'feed' => '2700377 : More Categories / Clothing & Accessories / Shorts / Women\'s Shorts ', 'click' => 0.25),
12 =>   array('name' => 'Skirts',    'feed' => '2700517 : More Categories / Clothing & Accessories / Dresses & Skirts / Women\'s Dresses & Skirts ', 'click' => 0.25),
6 =>    array('name' => 'Socks & Tights', 'feed' => '2700513 : More Categories / Clothing & Accessories / Socks & Hosiery / Women\'s Socks & Hosiery ', 'click' => 0.25),
22 =>   array('name' => 'sunglasses',   'feed' => '2700328 : More Categories / Clothing & Accessories / Sunglasses ', 'click' => 0.25),
472 =>  array('name' => 'swimwear/Beachwear',   'feed' => '2700398 : More Categories / Clothing & Accessories / Swimwear / Women\'s Swimwear ', 'click' => 0.25),
15 =>   array('name' => 'T-Shirts',  'feed' => '2700515 : More Categories / Clothing & Accessories / Tops / Women\'s Tops ', 'click' => 0.25),
375 =>  array('name' => 'Two-piece suits',   'feed' => '2700515 : More Categories / Clothing & Accessories / Tops / Women\'s Tops ', 'click' => 0.25),
16 =>   array('name' => 'Knit Vests',   'feed' => '2700515 : More Categories / Clothing & Accessories / Tops / Women\'s Tops ', 'click' => 0.25),
298 =>  array('name' => 'Watch',    'feed' => '2732758 : More Categories / Clothing & Accessories / Jewelry / Watches / Others ', 'click' => 0.25),
        );
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="feed.csv"');
        echo "\xEF\xBB\xBF" . "Manufacturer,Manufacturer Part #,Product Name,Product Description,Click-Out URL,Price,Category: Other Format,Category: Nextag Numeric ID,Image URL,Ground Shipping,Stock Status,Product Condition,Marketing Message,Weight,Cost-per-Click,UPC,Distributor ID,MUZE ID,ISBN\n";

        $products = DB::select(DB::expr('id, sku, name, set_id, link, price, configs, status, stock, weight'))
            ->from('products')
            ->where('set_id', 'IN', $set_ids)
            ->where('visibility', '=', 1)
            ->execute();
        foreach($products as $p)
        {
            echo 'Choies,';
            echo '"' . $p['sku'] . '",';
            echo '"' . $p['name'] . '",';
            echo '"' . $p['name'] . '",';
            $url = 'http://www.choies.com/product/' . $p['link'] . '_p' . $p['id'];
            echo '"' . $url . '",';
            echo '"' . $p['price'] . '",';
            echo '"' . $set_feeds[$p['set_id']]['name'] . '",';
            echo '"' . $set_feeds[$p['set_id']]['feed'] . '",';
            
            if($p['configs'])
            {
                $configs = unserialize($p['configs']);
                $image_id = isset($configs['default_image']) ? $configs['default_image'] : 0;
                $image = 'http://img3.choies.com/pimg/240/' . $image_id . '.jpg';
            }
            else
                $image = '';
            echo '"' . $image . '",';
            echo 0 . ',';
            $stock = $p['status'] && $p['stock'] ? 'Yes' : 'No';
            echo '"' . $stock . '",';
            echo 'New,';
            echo ',';
            echo '"' . $p['weight'] . '",';
            echo '"' . $set_feeds[$p['set_id']]['click'] . '",';
            echo PHP_EOL;
        }
        exit;
    }

}