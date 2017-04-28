<?php

defined('SYSPATH') or die('No direct script access.');
class Controller_Admin_Site_Pla extends Controller_Admin_Site
{
	public function action_index(){
		$languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }
       
	        $list=DB::query(Database::SELECT, "SELECT * FROM pla where type=0")->execute('slave')->as_array();
	   		$feeds = DB::select()->from('pla')->where('type','=',1)->execute()->as_array();
	        $content = View::factory('admin/site/pla')
	            ->set('languages', $languages)
	            ->set('lang', $lang)
	            ->set('lists',$list)
				->set('feeds',$feeds)
	            ->render();
	        
			$this->request->response = View::factory('admin/template')->set('content', $content)->render();
        
	}
	//新增、编辑数据操作
	public function action_add(){
		$type = Arr::get($_POST,'type');
		if(!$type){
			//自定义feed的新增、编辑操作
			$pla=Arr::get($_POST,'pla');
			$data['feed']=trim(Arr::get($_POST,'feed'));
			$data['uid']=trim(Arr::get($_POST,'uid'));
			if(Arr::get($_POST,'id')){$id=Arr::get($_POST,'id');};
			$data['custom_label_0']=Arr::get($_POST,'custom_label_0');
			$data['custom_label_1']=Arr::get($_POST,'custom_label_1');
			$data['custom_label_2']=Arr::get($_POST,'custom_label_2');
			$data['custom_label_3']=Arr::get($_POST,'custom_label_3');
			$data['custom_label_4']=Arr::get($_POST,'custom_label_4');
			$data['promotion']=trim(Arr::get($_POST,'promotion'));
			$data['country']=Arr::get($_POST,'country');
			$data['title']=trim(Arr::get($_POST,'title1')).'++++'.trim(Arr::get($_POST,'title2'));
			$data['description']=trim(Arr::get($_POST,'description1')).'++++'.trim(Arr::get($_POST,'description2'));
			$data['custom_label']=trim(Arr::get($_POST,'zdy'));
			$data['status']=0;
			$data['lang']=trim(Arr::get($_POST,'lang'));
			$data['type']=Arr::get($_POST,'type',0);

			//custom_label_4
			if(trim(Arr::get($_POST,'title1'))){
				$data['position']='1-';
			}else{
				$data['position']='0-';
			}
			if(trim(Arr::get($_POST,'title2'))){
				$data['position'].='1=';
			}else{
				$data['position'].='0=';
			}

			if(trim(Arr::get($_POST,'description1'))){
				$data['position'].='1-';
			}else{
				$data['position'].='0-';
			}
			if(trim(Arr::get($_POST,'description2'))){
				$data['position'].='1';
			}else{
				$data['position'].='0';
			}

			if($pla=='add'){
				$sql='';
				$feed=$data['feed'];

				$sql="select * from pla where feed='$feed' and country='{$data['country']}'";

				$res=DB::query(Database::SELECT,$sql);
				$row=$res->execute()->as_array();

				if(!$row){
						$query=DB::insert('pla',array('feed','uid','custom_label_0','custom_label_1','custom_label_2','custom_label_3','custom_label_4','promotion','country','title','description','custom_label','status','lang','type','position'))->values($data);
						$query->execute();
						Request::instance()->redirect('admin/site/pla/index');

				}else{
					$query=DB::update('pla')->set($data)->where('id','=',$row[0]['id']);
					$query->execute();
					Request::instance()->redirect('admin/site/pla/index');
				}
			}elseif($pla=='edit'){

				$query=DB::update('pla')->set($data)->where('id','=',$id);
				$query->execute();
				Request::instance()->redirect('admin/site/pla/index');
			}
		}
		else
		{//自动获取类feedd的编辑
			$country = Arr::get($_POST,'country');
			$res = DB::select()->from('pla')->where('country','=',$country)->where('type','=',1)->execute()->as_array();
			if($res)
			{
				DB::update('pla')->set($_POST)->where('type','=',1)->where('country','=',$country)->execute();
				Request::instance()->redirect('admin/site/pla/index');
			}
			else
			{
				DB::insert('pla',array('type','country','promotion'))->values($_POST)->execute();
				Request::instance()->redirect('admin/site/pla/index');
			}
		}
	}
	//新增、编辑页面展示
	public function action_edit(){
		$languages = Kohana::config('sites.'.$this->site_id.'.language');
        $lang = Arr::get($_GET, 'lang');
        if(!in_array($lang, $languages))
        {
            $lang = '';
        }

		$id=Arr::get($_GET,'id');
		$feed = Arr::get($_GET,'feed',0);
		$list = '';
		$feed_list = '';

		if($feed)
		{//自动获取类feed
			$feed_list = DB::select()->from('pla')->where('type','=',1)->where('id','=',$id)->execute()->as_array();

		}
		else
		{//自定义类feed
			if($id){
				$list=DB::query(Database::SELECT, "SELECT * FROM pla where id={$id}")->execute('slave')->as_array();

				$explode0= explode('=',$list[0]['position']);
				$explode1= explode('-',$explode0[0]);
				$explode2= explode('-',$explode0[1]);
				$title=explode('++++',$list[0]['title']);
				$description=explode('++++',$list[0]['description']);
				$list[0]['checkbox1']=$explode1;
				$list[0]['checkbox2']=$explode2;
				$list[0]['title']=$title;
				$list[0]['description']=$description;
			}else{
				$list[0]=array();
			}
		}
		$content = View::factory('admin/site/pla_edit')
			->set('languages', $languages)
			->set('lang', $lang)
			->set('lists',$list)
			->set('feed',$feed)
			->set('feed_list',$feed_list)
			->render();
		$this->request->response = View::factory('admin/template')->set('content', $content)->render();



	}


	public function action_get(){
		$id=Arr::get($_GET,'id');
		$country=Arr::get($_GET,'c');
		$type = Arr::get($_GET,'type');
		if(isset($type))
		{
			if($country=='US')
			{
				$country = '';
			}else{
                $country = strtolower($country);
            }
			Request::instance()->redirect("http://www.choies.com/webpower/mihqtgylls{$country}");
		}
	    $list=DB::query(Database::SELECT, "SELECT * FROM pla where id=$id")->execute('slave')->as_array();
	    //将脚本不使用的数据，status=0
	    $data['status']=0;
	    $query=DB::update('pla')->set($data)->where('country','=',"$country");
		$query->execute();
		//脚本要使用的数据，status设置成1
		$data['status']=1;
		$query=DB::update('pla')->set($data)->where('id','=',"$id");
		$query->execute();
	 	$country=$list[0]['country'];
	    if($country=='US'){
	    	$country='';
	    }
	   
	    $country=strtolower($country);
	    if($country=="ca"){
	    	$country='Txtca';
	    }

	    Request::instance()->redirect("http://www.choies.com/webpowerfor/mihqtgylls{$country}");
	}


//自动抓取的feed，添加promotion_id自定义内容
	public function action_pla_feed()
	{
		$promotion = $_POST['promotion'];
		if(!empty($promotion['US']))
		{
			$country =  'US';
		}
		if(!empty($us))
		{
			$country =  'FR';
		}
		if(!empty($us))
		{
			$country =  'UK';
		}
		if(!empty($us))
		{
			$country =  'DE';
		}
		if(!empty($us))
		{
			$country =  'ES';
		}
		if(!empty($us))
		{
			$country =  'AU';
		}
		if(!empty($us))
		{
			$country =  'CA';
		}
		$arr['promotion'] = $promotion[$country];var_dump($arr);
		$res = DB::select()->from('pla')->where('type','=',1)->where('country','=',$country)->execute()->as_array();
		if($res)
		{
			$id = $res[0]['id'];var_dump($id);
			DB::query(Database::UPDATE, "UPDATE pla set promotion = {$arr['promotion']} where id={$id}")->execute();
			Request::instance()->redirect('admin/site/pla/index');
		}
		else
		{
			$arr['country'] = $country;
			var_dump($arr);
			DB::query(Database::INSERT,"INSERT INTO pla (country,promotion,type,status) VALUES ('{$arr['country']}',{$arr['promotion']},1,1)")->execute();
			Request::instance()->redirect('admin/site/pla/index');
		}


	}
}
