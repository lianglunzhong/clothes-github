<?php
defined('SYSPATH') or die('No direct script access.');

class Wishlist
{

	private static $instances;
	private $data;
	private $site_id;

	public static function & instance($id = 0)
	{
		if( ! isset(self::$instances[$id]))
		{
			$class = __CLASS__;
			self::$instances[$id] = new $class($id);
		}
		return self::$instances[$id];
	}

	public function __construct($id)
	{
		$this->site_id = Site::instance()->get('id');
		$this->_load($id);
	}

	public function _load($id)
	{
		if($id)
		{
			$cache = cache::instance();
			$key = $this->site_id."/wishlist/".$id;
			$data = array( );
			if( ! ($data = $cache->get($key)))
			{
				$wishlist = ORM::factory('wishlist', $id);
				if($wishlist->loaded())
				{
					$data = $wishlist->as_array();
					$cache->set($key, $data);
				}
			}
			if(count($data))
			{
				$this->data = $data;
			}
		}
	}

	public function get($key = NULL)
	{
		if(empty($key))
		{
			return $this->data;
		}
		else
		{
			return isset($this->data[$key]) ? $this->data[$key] : '';
		}
	}

    public static function set($data)
    {
        if(!$data) return FALSE;
        $wishlist_exist = DB::query(Database::SELECT, 'SELECT `wishlists`.id FROM `wishlists` WHERE `customer_id` = '.$data['customer_id'].' AND `product_id` = '.$data['product_id'])->execute()->get('id');
        if(!$wishlist_exist)
        {
            $wishlist = ORM::factory('wishlist');
            $wishlist->site_id = $data['site_id'];
            $wishlist->customer_id = $data['customer_id'];
            $wishlist->product_id = $data['product_id'];
            $wishlist->created = $data['created'];
            $wishlist->save();
            if($wishlist->saved())
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return TRUE;
        }
    }

	public function delete()
	{
		$wishlist = ORM::factory('wishlist')
				->where('id', '=', $this->data['id'])
				->find();
		if($wishlist->loaded())
		{
			$wishlist->delete();
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}
