<?php

defined('SYSPATH') or die('No direct script access.');

class Controller_Api extends Controller_Webpage
{
    public function action_image()
    {
        $data = array();
        $sku = Arr::get($_REQUEST, 'sku', '');
        $product_id = Product::get_productId_by_sku($sku);
        if($product_id)
        {
            $images = Product::instance($product_id)->images();
            foreach($images as $image)
            {
                $data[] = 'http://img.choies.com/uploads/1/pimages/' . $image['id'] . '.' . $image['suffix'];
            }
        }
        echo json_encode($data);
        exit;
    }

    public function action_item()
    {
        $id = Arr::get($_REQUEST, 'id', '');
        if ($id)
        {
            $product_id = trim($id);
        }
        else
        {
            $sku = Arr::get($_REQUEST, 'sku', '');
            $sku = htmlspecialchars_decode(trim($sku));
            $link = mysql_connect($_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'], $_SERVER['COFREE_DB_USER_S'], $_SERVER['COFREE_DB_PASS_S']) OR die(mysql_error());
            $sku = mysql_real_escape_string($sku);
            $product_id = Product::get_productId_by_sku($sku);
        }
        $product = array();
        if ($product_id)
        {
            $products = DB::query(DATABASE::SELECT, 'SELECT id, name, sku, price, visibility, status, stock, configs, attributes, factory, offline_factory, taobao_url, total_cost, offline_sku, set_id FROM products WHERE id = ' . $product_id)->execute('slave')->current();
            $image_url = '';
            $pimages = DB::select('id', 'suffix')->from('images')->where('site_id', '=', 1)->where('obj_id', '=', $product_id)->execute('slave')->as_array();
            $images = unserialize($products['configs']);
            if (isset($images['default_image']))
            {
                foreach($pimages as $pimage)
                {
                    if($pimage['id'] == $images['default_image'])
                        $image_url = STATICURL.'/pimg/o/' . $images['default_image'] . '.jpg';
                }
                
            }
            if (!$image_url)
                $image_url = STATICURL.'/pimg/o/' . $pimages[0]['id'] . '.'.$pimages[0]['suffix'];

            $images = array();
            foreach($pimages as $img)
            {
                $images[] = STATICURL.'/pimg/o/' . $img['id'] . '.' . $img['suffix'];
            }
            $pstocks = array();
            $on_stock = $products['visibility'] && $products['status'];
            if ($on_stock && $products['stocks'] = -1)
            {
                $stocks = DB::select('attributes', 'stocks')->from('product_stocks')->where('product_id', '=', $product_id)->where('stocks', '>', 0)->execute('slave')->as_array();
                if (!empty($stocks))
                {
                    foreach ($stocks as $stock)
                    {
                        $pstocks[$stock['attributes']] = $stock['stocks'];
                    }
                }
            }

            $factory = trim($products['factory']) ? trim($products['factory']) : $products['offline_factory'];

            $attributes = unserialize($products['attributes']);
            $sizes = array();
            if (isset($attributes['Size']))
            {
                $sizes = $attributes['Size'];
            }
            elseif (isset($attributes['size']))
            {
                $sizes = $attributes['size'];
            }
            foreach ($sizes as $size)
            {
                $sizename = $size;
                if (strpos($size, 'EUR') !== False)
                {
                    $sizename = substr($size, strpos($size, 'EUR') + 3, 2);
                }
                $stock = DB::query(Database::SELECT, 'SELECT SUM(quantity) as stock FROM order_instocks WHERE sku = "' . $products['sku'] . '" AND status = 0 AND attributes = "Size:' . $sizename . ';"')->execute('slave')->get('stock');
                $set = Set::instance($products['set_id'])->get('name');
                $product[] = array(
                    'id' => $products['id'],
                    'sku' => $products['sku'],
                    'price' => $products['price'],
                    'total_cost' => $products['total_cost'],
                    'size' => $sizename,
                    'name' => $products['name'],
                    'set' => $set,
                    'on_stock' => $on_stock ? 1 : 0,
                    'stock' => (int) $stock,
                    'image_url' => $image_url,
                    'factory' => $factory,
                    'taobao_url' => $products['taobao_url'],
                    'offline_sku' => $products['offline_sku'],
                    'link' => Product::instance($products['id'])->permalink(),
                    'price_now' => Site::instance()->price(Product::instance($products['id'])->price()),
                    'images' => $images,
                );
            }
        }

        echo json_encode($product);
        exit;
    }

    public function action_itemlist()
    {
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
        $date_visible = strtotime('2015-09-01');
        $page = (int) $page;
        if (!$page)
            $page = 1;
        $products = DB::query(Database::SELECT, 'SELECT id, name, sku, price, visibility, status, stock, configs, attributes, factory, offline_factory, taobao_url, total_cost, offline_sku, set_id, weight, cn_name, admin, created
        FROM products ORDER BY id DESC  LIMIT ' . ($page - 1) * $limit . ', ' . $limit)->execute('slave');
        $product = array();
        foreach($products as $p)
        {
            if($p['visibility'] == 0 AND $p['created'] < $date_visible)
                continue;
            $image_url = '';
            $images = unserialize($p['configs']);
            if (isset($images['default_image']))
            {
                $image_url = STATICURL.'/pimg/o/' . $images['default_image'] . '.jpg';
            }
            else
            {
                $pimages = DB::select('id', 'suffix')->from('images')->where('site_id', '=', 1)->where('obj_id', '=', $p['id'])->execute('slave')->current();
                if (!empty($pimages))
                    $image_url =  STATICURL.'/pimg/o/' . $pimages['id'] . '.'.$pimages['suffix'];

            }

            $pstocks = array();
            $on_stock = $p['visibility'] && $p['status'];
            if ($on_stock && $p['stocks'] = -1)
            {
                $stocks = DB::select('attributes', 'stocks')->from('product_stocks')->where('product_id', '=', $p['id'])->where('stocks', '>', 0)->execute('slave')->as_array();
                if (!empty($stocks))
                {
                    foreach ($stocks as $stock)
                    {
                        $pstocks[$stock['attributes']] = $stock['stocks'];
                    }
                }
            }
            $set = Set::instance($p['set_id'])->get('name');
            $factory = trim($p['factory']) ? trim($p['factory']) : $p['offline_factory'];
            $link = Product::instance($p['id'])->permalink();

            $admin_email = User::instance($p['admin'])->get('email');
            if(!$p['attributes'])
            {
                $product[] = array(
                    'id' => $p['id'],
                    'sku' => $p['sku'],
                    'price' => $p['price'],
                    'total_cost' => $p['total_cost'],
                    'size' => '',
                    'color' => '',
                    'name' => $p['name'],
                    'set' => $set,
                    'on_stock' => $on_stock ? 1 : 0,
                    'stock' => -1,
                    'image_url' => $image_url,
                    'factory' => $factory,
                    'taobao_url' => $p['taobao_url'],
                    'offline_sku' => $p['offline_sku'],
                    'link' => $link,
                    'weight' => $p['weight'],
                    'cn_name' => $p['cn_name'],
                    'weight' => $p['weight'],
                    'admin_email' => $admin_email,

                );
            }
            else
            {
                $attributes = unserialize($p['attributes']);
                $sizes = array();
                if (isset($attributes['Size']))
                {
                    $sizes = $attributes['Size'];
                }
                elseif (isset($attributes['size']))
                {
                    $sizes = $attributes['size'];
                }
                foreach ($sizes as $size)
                {
                    $sizename = $size;
                    if (strpos($size, 'EUR') !== False)
                    {
                        $sizename = substr($size, strpos($size, 'EUR') + 3, 2);
                    }
                    $stock = DB::query(Database::SELECT, 'SELECT SUM(quantity) as stock FROM order_instocks WHERE sku = "' . $p['sku'] . '" AND status = 0 AND attributes = "Size:' . $size . ';"')->execute('slave')->get('stock');
                    $product[] = array(
                        'id' => $p['id'],
                        'sku' => $p['sku'],
                        'price' => $p['price'],
                        'total_cost' => $p['total_cost'],
                        'size' => $sizename,
                        'color' => '',
                        'name' => $p['name'],
                        'set' => $set,
                        'on_stock' => $on_stock ? 1 : 0,
                        'stock' => (int) $stock,
                        'image_url' => $image_url,
                        'factory' => $factory,
                        'taobao_url' => $p['taobao_url'],
                        'offline_sku' => $p['offline_sku'],
                        'link' => $link,
                        'cn_name' => $p['cn_name'],
                        'weight' => $p['weight'],
                        'admin_email' => $admin_email,
                    );
                }
            }
        }
        
        echo json_encode($product);
        exit;
    }

    public function action_all_items()
    {
        // only new.choies.com can access
        $ip = Request::$client_ip;
        if($ip == '106.185.32.163')
        {
            $products = DB::select('id')
                ->from('products')
                ->where('visibility', '=', 1)
                ->where('status', '=', 1)
                ->execute('slave')->as_array();
            echo json_encode($products);
        }
        exit;
    }

    public function action_order()
    {
        $ordernum = isset($_REQUEST['ordernum']) ? $_REQUEST['ordernum'] : '';
        $ordernum = htmlspecialchars_decode(trim($ordernum));
        $link = mysql_connect($_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'], $_SERVER['COFREE_DB_USER_S'], $_SERVER['COFREE_DB_PASS_S']) OR die(mysql_error());
        $ordernum = mysql_real_escape_string($ordernum);
        if ($ordernum)
        {
            $o = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.transaction_id,o.rate,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders o WHERE o.is_active = 1 AND o.ordernum = ' . $ordernum)
                ->execute('slave')->current();
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM order_items WHERE order_id = ' . $o['id'])->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->FROM('order_remarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => $i['price'],
                    'product_id' => $i['product_id'],
                    'created' => date('Y-m-d H:i:s', $i['created']),
                    'status' => $i['status']
                );
            }
            $data = array(
                'id' => $o['id'],
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'trans_id' => $o['transaction_id'],
                'rate' => $o['rate'],
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
            );
        }
        echo json_encode($data);
        exit;
    }

    public function action_orderlist()
    {
        $data = array();
        $page = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;
        $limit = isset($_REQUEST['limit']) ? $_REQUEST['limit'] : 20;
        $page = (int) $page;
        if (!$page)
            $page = 1;
        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders o WHERE o.is_active = 1 AND o.payment_status = "verify_pass" GROUP BY o.id ORDER BY o.id limit  ' . ($page - 1) * $limit . ', ' . $limit)
                ->execute('slave');
        foreach ($orders as $o)
        {
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM order_items WHERE order_id = ' . $o['id'])->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->FROM('order_remarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => $i['price'],
                    'product_id' => $i['product_id'],
                    'created' => date('Y-m-d H:i:s', $i['created']),
                    'status' => $i['status']
                );
            }
            $data[] = array(
                'id' => $o['id'],
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
            );
        }
        echo json_encode($data);
        exit;
    }

    public function action_order_date_list()
    {
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . ' midnight');
        $to = strtotime($date . ' + 1 day midnight') - 1;
        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.rate,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.payment_method,o.payment_date,o.order_from,o.order_insurance,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.transaction_id 
                FROM orders o WHERE o.is_active = 1 AND o.erp_header_id < 1 AND o.payment_status = "verify_pass" AND o.verify_date BETWEEN "' . $from . '" AND "' . $to . '" GROUP BY o.id ORDER BY o.id')
                ->execute('slave');
        $countries = Site::instance()->countries();
        foreach ($orders as $o)
        {
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes, is_gift FROM order_items WHERE order_id = ' . $o['id'] .' and status != "cancel"')->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->FROM('order_remarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => round($i['price'], 2),
                    'is_gift' => $i['is_gift'],
                );
            }
            $admin_id = DB::select('admin')->from('celebrits')->where('email', '=', $o['email'])->execute('slave')->get('admin');
            if ($admin_id)
                $cele_admin = User::instance($admin_id)->get('name');
            else
                $cele_admin = '';
            if(strlen($o['billing_country']) > 2)
            {
                foreach($countries as $country)
                {
                    if(strtoupper($o['billing_country']) == strtoupper($country['name']))
                    {
                        $o['billing_country'] = $country['isocode'];
                        break;
                    }
                }
            }
            if(strlen($o['billing_country']) > 2)
            {
                $o['billing_country'] = '';
            }
            $data[] = array(
                'id' => $o['id'],
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'rate' => (float) $o['rate'],
                'amount' => $o['amount'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'order_insurance' => $o['order_insurance'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'payment' => $o['payment_method'],
                'payment_date' => date('Y-m-d H:i:s', $o['payment_date']),
                'order_from' => $o['order_from'],
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
                'cele_admin'=>$cele_admin,
                'trans_id'=> $o['transaction_id'],
            );
        }
        echo json_encode($data);
        exit;
    }

    //jiajia for java 2015/08/10
    public function action_orderlistjava()
    {
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . ' midnight');
        $to = $from + 86400;

        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.rate,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders o WHERE o.is_active = 1 AND o.payment_status = "verify_pass" AND o.created BETWEEN "' . $from . '" AND "' . $to . '" GROUP BY o.id ORDER BY o.id')
                ->execute('slave');
        foreach ($orders as $o)
        {
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM order_items WHERE order_id = ' . $o['id'])->execute('slave');
            $tracks = array();
            $tracking = DB::query(Database::SELECT, 'SELECT tracking_code, tracking_link FROM order_shipments WHERE order_id = ' . $o['id'])->execute('slave');
            $remark = array();
            $remarks = DB::select('remark')->FROM('order_remarks')->WHERE('order_id', '=', $o['id'])->execute('slave');

            foreach ($tracking as $t)
            {
                $tracks[] = array(
                    'tracking_code' => $t['tracking_code'],
                    'tracking_link' => $t['tracking_link']
                );
            }          
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $items[] = array(
                    'sku' => $i['sku'],
                    'attributes' => $i['attributes'],
                    'quantity' => $i['quantity'],
                    'price' => $i['price'],
                    'product_id' => $i['product_id'],
                    'created' => date('Y-m-d H:i:s', $i['created']),
                    'status' => $i['status']
                );
            }
                $amount_usd = $o['amount'] / $o['rate'];
            $data[] = array(
                'id' => null,
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1 ',
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_usd' => $amount_usd,
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'trackinginfo' => $tracks,
                'orderitems' => $items,
            );
        }
        echo json_encode($data);
        exit;
    }

    #当天用户消费清单 for java Ma 09.01   11.22 exit!
/*    public function action_usercount(){
        set_time_limit(0);
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . 'midnight');
        $to = $from + 86400;
        #查询当天所有订单
        $order = DB::query(Database::SELECT, 'select id,amount,created as order_time,email as usermail,payment_date from orders where created >= "'.$from.'" and created <= "'.$to.'" and payment_status = "verify_pass"')->execute()->as_array();
        if(!$order){
            $arr = array('message'=>'No order for the day!');
            echo json_encode($arr);exit;
        }
        $oidStr = '';
        foreach ($order as $orderItem) {
            $orderArr[$orderItem['id']] = $orderItem;
            $oidStr .= '"' . $orderItem['id'] . '",';
        }
        $oidStr = substr($oidStr, 0, -1);
        unset($order);

        #查询购买产品数
        $order_items = DB::query(Database::SELECT, 'select order_id,count(order_id) as ordercount,count(quantity) as quantity from order_items where order_id in ('.$oidStr.') group by order_id')->execute()->as_array();
        $countArr = array();
        foreach ($order_items as $count) {
            $countArr[$count['order_id']] = array_merge($count, $orderArr[$count['order_id']]);
        }

        #更改数组主键为email
        $countNarr = array();
        $mailStr = '';
        foreach ($countArr as $umail) {
            if(!isset($countNarr[$umail['usermail']])){
                $countNarr[$umail['usermail']]['amount'] = 0;
            }
            $amountSum = $countNarr[$umail['usermail']]['amount']+$umail['amount'];
            $countNarr[$umail['usermail']] = $umail;
            $mailStr .= '"' . $umail['usermail'] . '",';
        }
        $mailStr = substr($mailStr, 0, -1);
        unset($countArr);
        unset($order_items);
         
        #匹配用户
        $userArr = array();
        $user = DB::query(Database::SELECT, 'select email,created,last_login_time,country from customers where email in ('.$mailStr.')')->execute()->as_array();
        foreach ($user as $userItem) {
            $userArr[] = array_merge($userItem, $countNarr[$userItem['email']]);
        }
        
        #转换时间日期格式
        $outArr = array();
        foreach ($userArr as $key => $value) {
            $value['created'] = date('Y-m-d H:i:s', $value['created']);
            $value['last_login_time'] = date('Y-m-d H:i:s', $value['last_login_time']);
            $value['order_time'] = date('Y-m-d H:i:s', $value['order_time']);
            $value['payment_date'] = date('Y-m-d H:i:s', $value['payment_date']);
            $outArr[] = $value;
        }
        echo json_encode($outArr);
        exit;
    }*/

   //jiajia for java 2015/08/10
    public function action_orderlistjava11()
    {
        $data = array();
        $date = isset($_REQUEST['date']) ? trim($_REQUEST['date']) : '';
        $from = strtotime($date . ' midnight');
        $to = $from + 86400;

        $orders = DB::query(Database::SELECT, 'SELECT o.id,o.payment_status,o.verify_date,o.ordernum,o.email,o.customer_id,o.currency,o.amount,o.amount_products,o.amount_shipping,o.amount_coupon,o.amount_payment,o.ip,o.rate,o.points,o.amount_point,o.coupon_code,
                o.shipping_firstname,o.shipping_lastname,o.shipping_address,o.shipping_city,o.shipping_state,o.shipping_country,o.shipping_zip,o.shipping_phone,o.billing_firstname,o.billing_lastname,o.billing_address,o.billing_city,o.billing_zip,o.billing_phone,o.billing_state,o.billing_country,o.shipping_status,o.created,o.updated,o.payment_method,o.order_insurance,o.shipping_weight,o.order_from
                FROM orders o WHERE o.is_active = 1  AND o.created BETWEEN "' . $from . '" AND "' . $to . '" GROUP BY o.id ORDER BY o.id')
                ->execute('slave');
        foreach ($orders as $o)
        {
            $cus = Customer::instance($o['customer_id']);
            $cus_created = $cus ->get('created');
            $items = array();
            $itemArr = DB::query(Database::SELECT, 'SELECT sku, quantity, price, attributes,product_id,created,status FROM order_items WHERE order_id = ' . $o['id'])->execute('slave');
            $iscele = DB::query(Database::SELECT, 'SELECT orders.customer_id FROM `orders`,celebrits  WHERE orders.customer_id = celebrits.customer_id and orders.id = '.$o['id'])->execute('slave');
            $hongren = 0;
            if($iscele[0]['customer_id']){
                $hongren = 1;
            }
            $remark = array();
            $remarks = DB::select('remark')->FROM('order_remarks')->WHERE('order_id', '=', $o['id'])->execute('slave');
            foreach($remarks as $r)
            {
                $remark[] = $r['remark'];
            }
            foreach ($itemArr as $i)
            {
                $pro = Product::instance($i['product_id']);
                $procreated = $pro ->get('created');
                $source = $pro ->get('source');
                $total_cost = $pro ->get('total_cost');
                $ppprice = $pro ->get('price');
                $weight = $pro ->get('weight');
                $set = $pro ->get('set_id');
                $setname = Set::instance($set) ->get('name');
                $catemanger = Set::instance($set)->get('catemanger');
                $amount_usd = $o['amount'] / $o['rate'];
                $skucount = DB::query(Database::SELECT, 'select count(id) as skucount from products where set_id  = "'.$set.'"')->execute('slave')->current();
            $data[] = array(
                'id' => null,
                'payment_status' => $o['payment_status'],
                'date_purchased' => date('Y-m-d H:i:s', $o['verify_date']),
                'is_active' => '1',
                'cus_created' => date('Y-m-d H:i:s', $cus_created), 
                'hongren' => $hongren,
                'ordernum' => $o['ordernum'],
                'email' => $o['email'],
                'points' => $o['points'],
                'customer_id' => $o['customer_id'],
                'currency' => $o['currency'],
                'amount' => $o['amount'],
                'amount_point' => $o['amount_point'],
                'amount_usd' => $amount_usd,
                'coupon_code' => $o['coupon_code'],
                'rate' =>$o['rate'],
                'amount_products' => $o['amount_products'],
                'amount_shipping' => $o['amount_shipping'],
                'amount_coupon' => $o['amount_coupon'],
                'amount_payment' => $o['amount_payment'],
                'ip_address' => long2ip($o['ip']),
                'remark' => implode('|', $remark),
                'shipping_firstname' => $o['shipping_firstname'],
                'shipping_lastname' => $o['shipping_lastname'],
                'shipping_address' => $o['shipping_address'],
                'shipping_city' => $o['shipping_city'],
                'shipping_state' => $o['shipping_state'],
                'shipping_country' => $o['shipping_country'],
                'shipping_zip' => $o['shipping_zip'],
                'shipping_phone' => $o['shipping_phone'],
                'shipping_status' => $o['shipping_status'],
                'created' => date('Y-m-d H:i:s', $o['created']),
                'updated' => date('Y-m-d H:i:s', $o['updated']),
                'shipping_weight' => $o['shipping_weight'],
                'order_from' => $o['order_from'],
                'payment_method' => $o['payment_method'],
                'order_insurance' => $o['order_insurance'],
                'billing_firstname' => $o['billing_firstname'],
                'billing_lastname' => $o['billing_lastname'],
                'billing_address' => $o['billing_address'],
                'billing_city' => $o['billing_city'],
                'billing_state' => $o['billing_state'],
                'billing_country' => $o['billing_country'],
                'billing_zip' => $o['billing_zip'],
                'billing_phone' => $o['billing_phone'],
                'orderitems' => $items,
                'sku' => $i['sku'],
                'attributes' => $i['attributes'],
                'quantity' => $i['quantity'],
                'price' => $i['price'],
                'product_id' => $i['product_id'],
                'created' => date('Y-m-d H:i:s', $i['created']),
                'status' => $i['status'],
                'procreated' => date('Y-m-d H:i:s', $procreated),
                'source' => $source,
                'setname' => $setname,
                'total_cost' => $total_cost,
                'weight' => $weight,
                'ppprice' => $ppprice,
                'catemanger' => $catemanger,
                'skucount'=>$skucount['skucount']
                );

            }

        }
        echo json_encode($data);
        exit;
    }

    #获取图片表所有数据
    public function action_getImages(){
    	$curl_data = $_REQUEST;
    	if($curl_data['id'] != 'not'){
    		$id = intval($curl_data['id']);
    		$images = DB::query(Database::SELECT, 'select id,type,suffix,site_id,obj_id,image_name,status from images where id > ' . $id . ' order by id asc limit 10000')->execute('slave')->as_array();
    	}else{
    		$images = DB::query(Database::SELECT, 'select id,type,suffix,site_id,obj_id,image_name,status from images order by id asc limit 10000')->execute('slave')->as_array();
    	}
    	echo json_encode($images);
    	exit(); 
    }

#获取图片表所有数据
    public function action_getImages_by_skus(){
        
        if(empty($_POST['skus'])){
            echo false;
            exit();
        }
        $curl_data = $_POST['skus'];
        $skuArr = explode(',', $curl_data);
        $sql='select i.id iid,i.type itype,i.suffix isuffix,i.site_id isid ,i.image_name iin,i.status ist from products p inner join images i on p.id = i.obj_id where p.sku=';
        $sql1='select configs from products where sku=';
        $data_res=array();
        $data_res1=array();
        $data_res2=array();
        foreach ($skuArr as $sku) {
            if(!empty($sku)){
                $data_imgs=DB::query(Database::SELECT, $sql.'"'.$sku.'"')->execute('slave')->as_array();
                if(!empty($data_imgs)) $data_res[$sku]=$data_imgs;
                $data_configs=DB::query(Database::SELECT, $sql1.'"'.$sku.'" limit 1')->execute('slave')->current();
                if(!empty($data_configs))
                {
                    $data_res1[$sku]=$data_configs['configs']; 
                    $data_res2[$sku]=unserialize($data_configs['configs']);       
                } 
            }
        }
        
        if(empty($data_res)||empty($data_res1)){
            echo false;
            exit();
        }
        $d_r=array(
            'imgs'=>$data_res,
            'configs'=>$data_res1,
            'imgarr'=>$data_res2,
            );

        echo json_encode($d_r);
        exit();

    }
    
    //guo add 
    public function action_getproduct(){
        $arr = $_REQUEST; 
        $i = 0;
        foreach($arr as $v){
        	$brr[$i] = $v;
			$i++;
        }
        $pro = array();
        foreach($brr as $v){
        	$products = DB::select()->from('products')->where('sku', '=', $v)->execute('slave')->as_array();
            $pro[] = $products;
        }
        echo json_encode($pro);
        exit();
    }


    //ws鑾峰彇璁㈠崟鍚庢洿鏀筫rp_header_id = 2
    public function action_from_ws_update_order_erp()
    {
        $success = 0;
        if($_REQUEST)
        {
            $order_id = Arr::get($_REQUEST, 'order_id', 0);
            if($order_id)
            {
                //9.14 guo update
                $data['erp_header_id'] = 2;
                $data['shipping_status'] = 'processing';
                DB::update('orders')->set($data)->where('id', '=', $order_id)->execute();
                $success = 1;
            }
        }
        echo json_encode($success);
        exit;
    }

    public function action_cityads(){
        exit;
        //$click_id = Arr::get($_REQUEST, 'click_id', '');
        $status = Arr::get($_REQUEST, 'status', '');
        $token = Arr::get($_REQUEST, 'pkey', '');
        if($token!="m4eK5gu9TLUZOS3sGi75"){
            exit;
        }
        switch ($status)
        {
        case "new":
          $payment_status="'new'";
          $refund_status="";
          $status="new";
          break;
        case "done":
          $payment_status="'verify_pass','success'";
          $refund_status="";
          $status="done";
          break;
        case "cancel":
          $payment_status="'cancel'";
          $refund_status="'refund'";
          $status="cancel";
          break;
        default:
          $payment_status="'new','verify_pass','success','cancel'";
          $refund_status="'refund','partial_refund'";
          $status="all";
        }
        if($payment_status){
            $xml_date='<items>';
            if($refund_status){
                $refund=" OR O.`refund_status` in (".$refund_status.")";
            }else{
                $refund="";
            }
            $orders = DB::query(DATABASE::SELECT, "select O.*,C.`click_id` FROM cityads C left join `orders` O on C.`order_id`=O.`id` WHERE O.`payment_status` in (".$payment_status.")".$refund)->execute('slave');
            if($orders->count()>0){
                foreach ($orders as $order) {
                    if($order['refund_status']){
                        $order_statu="cancel";
                    }elseif($order['payment_status']=="new"){
                        $order_statu="new";
                    }elseif(in_array($order['payment_status'], array('verify_pass','success'))){
                        $order_statu="done";
                    }else{
                        $order_statu="";
                    }
                    $xml_date .='
                                <item> 
                                <order_id>'.$order["ordernum"].'</order_id> 
                                <click_id>'.$order["click_id"].'</click_id>
                                <status>'.$order_statu.'</status>
                                <date>'.$order["created"].'</date> 
                                <order_total>'.number_format(round($order["amount"], 2),2).'</order_total> 
                                <coupon>'.$order["coupon"].'</coupon> 
                                <discount>'.number_format(round($order["amount_coupon"], 2),2).'</discount> 
                                <currency>'.$order["currency"].'</currency> 
                                <payment_method>cash</payment_method> 
                                <customer_type>new</customer_type>
                                <basket> ';
                    $products=Order::instance($order["id"])->products();
                    foreach ($products as $product) {
                        $catalog=Set::instance(Product::instance($product['product_id'])->get("set_id"))->get('name');
                        $xml_date.='
                                <product> 
                                <pid>'.$product['sku'].'</pid> 
                                <pc>'.$catalog.'</pc> 
                                <pn>'.$product['name'].'</pn> 
                                <up>'.number_format(round($product['price'], 2),2).'</up> 
                                <qty>'.$product['quantity'].'</qty> 
                                </product>';
                    }
                    $xml_date.=' 
                                </basket> 
                                </item>';
                                
                }
            $xml_date.='</items>';
            header("Content-type: text/xml");  
            echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; 
            echo $xml_date;
            exit;
            }else{
                exit;
            }
        }else{
            exit;
        }
    }

    public function action_validate()
    {
        $type = Arr::get($_REQUEST, 'type', '');
        $return = False;
        if($type)
        {
            switch($type)
            {
                case 'country':
                    $country = trim(Arr::get($_REQUEST, 'country', ''));
                    if($country)
                        $return = True;
                    else
                        $return = False;
                    break;
                case 'state':
                    $country = trim(Arr::get($_REQUEST, 'state', ''));
                    if($country)
                        $return = True;
                    else
                        $return = False;
                default:
                    break;
            }
        }
        echo json_encode($return);
        exit;
    }

    public function action_product()
    {
        $id = Arr::get($_REQUEST, 'id', '');
        if ($id)
        {
            $product_id = trim($id);
        }
        else
        {
            $sku = Arr::get($_REQUEST, 'sku', '');
            $sku = htmlspecialchars_decode(trim($sku));
            $link = mysql_connect($_SERVER['COFREE_DB_HOST_S'] . ':' . $_SERVER['COFREE_DB_PORT_S'], $_SERVER['COFREE_DB_USER_S'], $_SERVER['COFREE_DB_PASS_S']) OR die(mysql_error());
            $sku = mysql_real_escape_string($sku);
            $product_id = Product::get_productId_by_sku($sku);
        }
        $product = array();
        if ($product_id)
        {
            $product = DB::query(DATABASE::SELECT, 'SELECT id, name, sku, price, visibility, status, brief, attributes, weight, set_id, total_cost FROM products WHERE id = ' . $product_id)->execute('slave')->current();
            $cover_image = Product::instance($product_id)->cover_image();
            $product['set_name'] = Set::instance($product['set_id'])->get('name');
            $product['cover_image'] = $cover_image['id'];
            $product['image_suffix'] = $cover_image['suffix'];
        }
        echo json_encode($product);
        exit;
    }

    public function action_make_orders()
    {
        if($_POST)
        {
            $quantity = Arr::get($_POST, 'quantity', 0);
            if($quantity)
            {
                $order_instocks = array(
                    'ordernum' => Arr::get($_POST, 'ordernum', 0),
                    'sku' => Arr::get($_POST, 'sku', 0),
                    'quantity' => 1,
                    'attributes' => Arr::get($_POST, 'attributes', 0),
                    'created' => Arr::get($_POST, 'created', 0),
                    'site_id' => Arr::get($_POST, 'site_id', 0),
                    'cost' => Arr::get($_POST, 'cost', 0),
                );
                for($i = 1;$i <= $quantity;$i ++)
                {
                    $insert = DB::insert('order_instocks', array_keys($order_instocks))->values($order_instocks)->execute();
                }
                if($insert)
                    echo 'success';
                else
                    echo 'error';
            }
            else
            {
                echo 'error';
            }
        }
        exit;
    }

    public function action_set()
    {
        $id = Arr::get($_REQUEST, 'id', '');
        $data = array();
        if ($id)
        {
            $set_id = trim($id);
            if ($set_id)
            {
                $data = DB::query(DATABASE::SELECT, 'SELECT name, brief, label FROM sets WHERE id = ' . $set_id)->execute('slave')->current();
            }
            
        }
        echo json_encode($data);
        exit;
    }

    public function action_from_ws_update_shipment()
    {
        if($_POST)
        {
            $success = 0;
            $updated = Arr::get($_POST, 'updated', 0);
            if($updated == 1)
            {
                $v = Validate::factory($_POST)
                    ->rule('ordernum', 'not_empty')
                    ->rule('status', 'not_empty')
                    ->rule('skus', 'not_empty')
                    ->rule('qtys', 'not_empty')
                    ->rule('totals', 'not_empty')
                    ->rule('tracking_no', 'not_empty')
                    ->rule('shipping_method', 'not_empty')
                    ->rule('shipping_time', 'not_empty')
                    ->filter('tracking_link', 'trim')
                    ->rule('package_id', 'not_empty');
                if ($v->check())
                {
                    $order = ORM::factory('order')->where('ordernum', '=', $v['ordernum'])->find();
                    if($order)
                    {
                        $orderd = Order::instance($order->id);
                        if($v['status'] == 'shipped')
                            $data['shipping_status'] = 'shipped';
                        else
                            $data['shipping_status'] = 'partial_shipped';
                        $data['shipping_date'] = time();
                        $shipping_status = $order->shipping_status;
                        if($shipping_status != 'shipped' and $data['shipping_status'] == 'shipped'){
                            // add points
                            // $amount = $order->amount;
                            // if ($amount > 0)
                            // {
                            //     Event::run('Order.payment', array(
                            //         'amount' => (int) $amount,
                            //         'order' => $orderd,
                            //     ));
                            // }
                        }
                        $order->values($data);
                        $ret = $order->save();
                        if ($ret)
                        {
                           
                            $shipment = array(
                                'carrier' => $v['shipping_method'],
                                'tracking_code' => $v['tracking_no'],
                                'tracking_link' => $v['tracking_link'],
                                'ship_date' => strtotime($v['shipping_time']),
                                'ship_price' => $v['totals'],
                                'package_id' => $v['package_id'],
                            );
                            $items = array();
                            $skusArr = explode(',', $v['skus']);
                            $qtysArr = explode(',', $v['qtys']);
                            foreach($skusArr as $key => $sku)
                            {
                                if(isset($qtysArr[$key]))
                                {
                                    $skuA = explode('-', $sku);
                                    $item_id = Product::get_productId_by_sku(trim($skuA[0]));
                                    if($item_id)
                                    {
                                        $items[] = array(
                                            'item_id' => $item_id,
                                            'quantity' => $qtysArr[$key],
                                        );
                                    }
                                }

                            }
                            if($orderd->add_shipment($shipment, $items))
                            {
                                $orderd->set(array(
                                    'shipping_date' => strtotime($v['shipping_time']),
                                    'tracking_code' => $v['tracking_no'],
                                    'tracking_link' => $v['tracking_link'],
                                ));
                                $success = 1;

                                if ($data['shipping_status'] == 'shipped')
                                {
                                    $email_params = array(
                                        'tracking_num' => $v['tracking_no'],
                                        'tracking_url' => $v['tracking_link'],
                                        'order_num' => $v['ordernum'],
                                        'currency' => $orderd->get('currency'),
                                        'amount' => $orderd->get('amount'),
                                        'email' => $orderd->get('email'),
                                        'firstname' => $orderd->get('shipping_firstname'),
                                        'tracking_words' => '',
                                    );
                                    Mail::SendTemplateMail('SHIPPING', $email_params['email'], $email_params);
                                }
                                else
                                {
                                    $email_params = array(
                                        'tracking_num' => $v['tracking_no'],
                                        'tracking_url' => $v['tracking_link'],
                                        'order_num' => $v['ordernum'],
                                        'currency' => $orderd->get('currency'),
                                        'amount' => $orderd->get('amount'),
                                        'email' => $orderd->get('email'),
                                        'firstname' => $orderd->get('shipping_firstname'),
                                        'tracking_words' => '',
                                    );

                                    Mail::SendTemplateMail('PARTIALSHIPPING', $email_params['email'], $email_params);
                                }
                            }
                        }
                    }
                }
            }
            elseif($updated == 2)
            {
                $v = Validate::factory($_POST)
                    ->rule('ordernum', 'not_empty')
                    ->rule('tracking_no', 'not_empty')
                    ->rule('shipping_method', 'not_empty')
                    ->filter('tracking_link', 'trim')
                    ->rule('package_id', 'not_empty');
                if ($v->check())
                {
                    $order = ORM::factory('order')->where('ordernum', '=', $v['ordernum'])->find();
                    if($order)
                    {
                        $shipment = DB::update('order_shipments')
                            ->set(array('tracking_code' => $v['tracking_no'], 'tracking_link' => $v['tracking_link']))
                            ->where('order_id', '=', $order->id)
                            ->where('package_id', '=', $v['package_id'])
                            ->execute();
                        if($shipment)
                        {
                            $success = 1;
                        }
                    }
                }
            }
            echo json_encode($success);
            exit;
        }
    }

    public function action_from_ws_update_shipment_status()
    {
        if($_POST)
        {
            $success = 0;
            $v = Validate::factory($_POST)
                ->rule('ordernum', 'not_empty')
                ->filter('delivery_age', 'trim')
                ->filter('delivery_time', 'trim')
                ->rule('status', 'not_empty');
            if ($v->check())
            {
                $order = ORM::factory('order')->where('ordernum', '=', $v['ordernum'])->find();
                if($order)
                {
                    $orderd = Order::instance($order->id); // guo add
                    $shipments = $orderd->shipments();// guo add
                    if($v['status'] == 'delivered')
                        $data['shipping_status'] = 'delivered';
                    elseif($v['status'] == 'pickup')
                        $data['shipping_status'] = 'pickup';

                    $data['logistics_days'] = $v['delivery_age'];
                    $data['deliver_time'] = $v['delivery_time'];
                    $order->values($data);
                    $ret = $order->save();
                    if($ret)
                       $success = 1;

                    if ($data['shipping_status'] == 'delivered')
                    {
                        $email_params = array(
                            'created' => date('Y-m-d',$orderd->get('created')),
                            'order_num' => $orderd->get('ordernum'),
                            'currency' => $orderd->get('currency'),
                            'amount' => round($orderd->get('amount'),2),
                            'email' => $orderd->get('email'),
                            'points' => floor($orderd->get('amount') / $orderd->get('rate')),
                        );
                        Mail::SendTemplateMail('CONFIRM_MAIL', $email_params['email'], $email_params);
                    }
                    elseif($data['shipping_status'] == 'pickup' && isset($shipments[0]['tracking_code']))
                    {
                       $email_params = array(
                            'firstname' => $orderd->get('shipping_firstname'),
                            'order_num' => $orderd->get('ordernum'),
                            'tracking_num' => $shipments[0]['tracking_code'],
                            'tracking_url' => $shipments[0]['tracking_link'],
                            'email' => $orderd->get('email'),
                        );

                        Mail::SendTemplateMail('PICK UP', $email_params['email'], $email_params);
                    }
                }
            }
            echo json_encode($success);
            exit;
        }
    }

    public function action_fb_product()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurl = "/home/data/www/htdocs/clothes/googleproduct/fb_product.xml"; 
        if (!file_exists($fileurl))
        {
            self::xmldata1($fileurl);
        }
        else
        {
            self::xmldata1($fileurl);
        }   

    }

    public static function xmldata1($v)
    {
        ini_set('memory_limit', '512M');  
        $fileurl = "/home/data/www/htdocs/clothes/googleproduct/fb_product.xml";

        $data_array1 = array(
                array(
                    'title' => "CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes",
                    'link' => 'http://www.choies.com',
                    'description' => "Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!",
                ),
            );
        $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo');
        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');

        $data_array3 = array();
        $j = 0;
        foreach ($products as $product)
        {
            if(!in_array($product['sku'],$brr))
            {     
	            $image_url = '';
	            $product_instance = Product::instance($product['id']);
	            $image_url = Image::linkfeed($product_instance->cover_image(), 9);
	            if (!$image_url)
	                Image::link($product_instance->cover_image(), 9);

	            $description = strip_tags($product['description']);
	            $description = str_replace('&nbsp', ' ', $description);
	            $description = str_replace($cate_wrong, '', $description);

	            $category = $product_instance->default_catalog();
	            $category = Catalog::instance($category)->get("name");
	            $category = str_replace('&', ' and ', $category);

	            $price = round($product['price'], 2);	            
	            $link = $product_instance->permalink();
                $data_array3[$j]['g:id'] = $product['id'];
                $data_array3[$j]['g:title'] = $product['name'];
                $data_array3[$j]['g:description'] = $description;
                $data_array3[$j]['g:link'] = $link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product';
                $data_array3[$j]['g:image_link'] = $image_url;
                $data_array3[$j]['g:brand'] = 'Choies';
                $data_array3[$j]['g:condition'] = 'new';
                $data_array3[$j]['g:availability'] = 'in stock';
                $data_array3[$j]['g:price'] = $price.' USD';
                $data_array3[$j]['g:shipping']['g:country'] = 'US';
                $data_array3[$j]['g:shipping']['g:service'] = 'Standard';
                $data_array3[$j]['g:shipping']['g:price'] = '0 USD';
                $data_array3[$j]['g:google_product_category'] = $category;             
                $j++;
            }
        }

        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        $xml->setIndentString('  ');
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8'); 
        $xml->startElement('rss'); 
        $xml->writeAttribute('xmlns:g',"http://base.google.com/ns/1.0");
        $xml->writeAttribute('version',"2.0");
        $xml->startElement('channel'); 
		
		foreach($data_array1 as $data)
		{
            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
		}
		
        foreach ($data_array3 as $data)
        {
        	$xml->startElement('item');
            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    if(is_array($row))
                    {
                    	foreach ($row as $key => $rows)
                    	{
                    		$xml->startElement($key);
                    		$xml->text($rows);
                    		$xml->endElement();
                    	}
                    }
                    else
                    {
                    	$xml->text($row);   //  设置内容                    	
                    }

                    $xml->endElement(); // $key
                }
            }
            $xml->endElement();         //  item
        }

        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';
        die;
    }

	/*
    public function action_tagtoo_product()
    {
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>http://www.choies.com</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
            $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo');

            $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products where visibility=1 and status=1 and stock!=0')->execute('slave');
            $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
            foreach($products as $product){
                    if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id']);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id>'.$product['id'].'</g:id>
        <g:title>'.$product['name'].'</g:title>
        <g:description>'.$description.'</g:description>
        <g:link>'.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product</g:link>
        <g:image_link>'.$image_url.'</g:image_link>
        <g:brand>'.'Choies'.'</g:brand>
        <g:condition>new</g:condition>
        <g:availability>in stock</g:availability>
        <g:price>'.$price.' USD'.'</g:price>
        <g:shipping>
            <g:country>US</g:country>
            <g:service>Standard</g:service>
            <g:price>0 USD</g:price>
        </g:shipping>
        <g:google_product_category>'.$category.'</g:google_product_category>
    </item>';
                    }
            }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }
*/
    public function action_fb_product_fr(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>http://www.choies.com</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
            $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo','&eacute','&Eacute','&agrave','&Agrave');

            $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_fr where visibility=1 and status=1 and stock!=0')->execute('slave');
            $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
            foreach($products as $product){
                    if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id'],LANGUAGE);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $proname = str_replace($cate_wrong, '', $product['name']);

                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id><![CDATA['.$product['id'].']]></g:id>
        <g:title><![CDATA['.$proname.']]></g:title>
        <g:description><![CDATA['.$description.']]></g:description>
        <g:link><![CDATA['.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product&amp;currency=eur]]></g:link>
        <g:image_link><![CDATA['.$image_url.']]></g:image_link>
        <g:brand><![CDATA['.'Choies'.']]></g:brand>
        <g:condition><![CDATA[new]]></g:condition>
        <g:availability><![CDATA[in stock]]></g:availability>
        <g:price><![CDATA['.$price.' EUR'.']]></g:price>
        <g:shipping>
            <g:country><![CDATA[FR]]></g:country>
            <g:service><![CDATA[Standard]]></g:service>
            <g:price><![CDATA[0 EUR]]></g:price>
        </g:shipping>
        <g:google_product_category><![CDATA['.$category.']]></g:google_product_category>
    </item>';
                    }
            }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }
	

    public function action_fb_product_de(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>http://www.choies.com</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
            $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo','&eacute','&Eacute','&agrave','&Agrave');

            $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_de where visibility=1 and status=1 and stock!=0')->execute('slave');
            $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
            foreach($products as $product){
                    if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id'],LANGUAGE);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $proname = str_replace($cate_wrong, '', $product['name']);

                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id><![CDATA['.$product['id'].']]></g:id>
        <g:title><![CDATA['.$proname.']]></g:title>
        <g:description><![CDATA['.$description.']]></g:description>
        <g:link><![CDATA['.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product&amp;currency=eur]]></g:link>
        <g:image_link><![CDATA['.$image_url.']]></g:image_link>
        <g:brand><![CDATA['.'Choies'.']]></g:brand>
        <g:condition><![CDATA[new]]></g:condition>
        <g:availability><![CDATA[in stock]]></g:availability>
        <g:price><![CDATA['.$price.' EUR'.']]></g:price>
        <g:shipping>
            <g:country><![CDATA[FR]]></g:country>
            <g:service><![CDATA[Standard]]></g:service>
            <g:price><![CDATA[0 EUR]]></g:price>
        </g:shipping>
        <g:google_product_category><![CDATA['.$category.']]></g:google_product_category>
    </item>';
                    }
            }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }

    public function action_fb_product_es(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>http://www.choies.com</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
            $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo','&eacute','&Eacute','&agrave','&Agrave');

            $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products_es where visibility=1 and status=1 and stock!=0')->execute('slave');
            $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
            foreach($products as $product){
                    if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id'],LANGUAGE);
                $image_url = Image::link($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $proname = str_replace($cate_wrong, '', $product['name']);

                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id><![CDATA['.$product['id'].']]></g:id>
        <g:title><![CDATA['.$proname.']]></g:title>
        <g:description><![CDATA['.$description.']]></g:description>
        <g:link><![CDATA['.$link.'?utm_source=facebook&amp;utm_medium=dpa&amp;utm_campaign=product&amp;currency=eur]]></g:link>
        <g:image_link><![CDATA['.$image_url.']]></g:image_link>
        <g:brand><![CDATA['.'Choies'.']]></g:brand>
        <g:condition><![CDATA[new]]></g:condition>
        <g:availability><![CDATA[in stock]]></g:availability>
        <g:price><![CDATA['.$price.' EUR'.']]></g:price>
        <g:shipping>
            <g:country><![CDATA[FR]]></g:country>
            <g:service><![CDATA[Standard]]></g:service>
            <g:price><![CDATA[0 EUR]]></g:price>
        </g:shipping>
        <g:google_product_category><![CDATA['.$category.']]></g:google_product_category>
    </item>';
                    }
            }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }


    public function action_fb_kyproduct(){
        header("Content-type: text/xml");
        $content = "<?xml version=\"1.0\"?>
<rss xmlns:g=\"http://base.google.com/ns/1.0\" version=\"2.0\">
    <channel>
        <title>CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes</title>
        <link>http://www.choies.com</link>
        <description>Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!</description>";
            $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo');

            $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products where visibility=1 and status=1 and stock!=0')->execute('slave');
            $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');
            foreach($products as $product){
                    if(!in_array($product['sku'],$brr)){
                $image_url = '';
                $product_instance = Product::instance($product['id']);
                $image_url = Image::linkfeed($product_instance->cover_image(), 9);
                if (!$image_url)
                    Image::link($product_instance->cover_image(), 9);

                $description = strip_tags($product['description']);
                $description = str_replace('&nbsp', ' ', $description);
                $description = str_replace($cate_wrong, '', $description);

                $category = $product_instance->default_catalog();
                $category = Catalog::instance($category)->get("name");
                $category = str_replace('&', ' and ', $category);

                $price = round($product['price'], 2);
                $link = $product_instance->permalink();

                $content .= '
    <item>
        <g:id>'.$product['id'].'</g:id>
        <g:title>'.$product['name'].'</g:title>
        <g:description>'.$description.'</g:description>
        <g:link>'.$link.'?utm_source=facebook&amp;utm_medium=dpaky&amp;utm_campaign=product</g:link>
        <g:image_link>'.$image_url.'</g:image_link>
        <g:brand>'.'Choies'.'</g:brand>
        <g:condition>new</g:condition>
        <g:availability>in stock</g:availability>
        <g:price>'.$price.' USD'.'</g:price>
        <g:shipping>
            <g:country>US</g:country>
            <g:service>Standard</g:service>
            <g:price>0 USD</g:price>
        </g:shipping>
        <g:google_product_category>'.$category.'</g:google_product_category>
    </item>';
                    }
            }

        $content .= '
    </channel>
</rss>';
        echo $content;
        exit();
    }

    public function action_gotocartproduct()
    {
       $result = DB::query(Database::SELECT, 'SELECT id,customer_id,data from cartcookies where is_go = 0 order by id desc limit 0,1000')->execute('slave');
       foreach($result as $v){
            $s = unserialize($v['data']);

            $data = array();
                $data = array(
                        'customer_id' => $v['customer_id'],
                        'item_id' => $s['id'],
                        'qty' => $s['quantity'],
                        'attribute'=>$s['attributes']['Size'],
                        'created'=>time(),
                        'is_cart'=>0

                    );
               $insert = DB::insert('cartproduct', array_keys($data))->values($data)->execute(); 
               $update = DB::update('cartcookies')->set(array('is_go'=>1))->where('id', '=', $v['id'])->execute();
           
           } 
    }

    public function action_get_celebrity_img_info_by_skus()
    {
        $skus=Arr::get($_POST, 'skus', '');
        if(empty($skus)) {
            echo "require data input";
            exit();
        }
        $skus=explode(',', $skus);
        $img_infos=array();
        foreach ($skus as $sku) {
            if(empty($sku)) continue;
            $product = DB::query(DATABASE::SELECT, 'SELECT id FROM products WHERE sku = "' . $sku.'" limit 1')->execute()->current();
            if(empty($product['id'])) continue;
            $product_id=$product['id'];
            $img_info = DB::query(DATABASE::SELECT, 'SELECT image,position FROM celebrity_images WHERE product_id = "' . $product_id.'" ')->execute()->as_array();
            if(!empty($img_info)){
                $img_infos[$sku]=$img_info;
            }
        }
        if(empty($img_infos)){
            echo 'no db data';
            exit();
        }else{
            echo json_encode($img_infos);
            exit();    
        }
        
    }
	
	/**
     * 获取 currencies表 name,fname,code,rate
     * @return json 
     * add 2015-12-23
     */
	 public function action_currency_list(){
		 $data=array();
		 $currenciesarr = DB::query(DATABASE::SELECT, 'SELECT name,fname,code,rate FROM currencies')->execute()->as_array();
		 
		 foreach($currenciesarr as $k=>$v){
			 $data[$v['name']]=$v;
		 }
		 echo json_encode($data);
		 exit;
	 }

    //guo  copyimage
    public function action_copy_image()
    {
        ignore_user_abort(true);
        set_time_limit(0); 
        ini_set('memory_limit', '512M');
        $filedir = "/home/data/www/htdocs/clothes/uploads/1/pimages/";
        $todir = "/home/data/www/htdocs/clothes/uploads/1/feedimage/";
        $products = DB::query(DATABASE::SELECT, "select id from products  where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $product_instance = Product::instance($product['id']);
            $imageid = $product_instance->cover_image();
            $imageurl = $imageid['id'].'.'.$imageid['suffix'];
            $fileurl = $filedir.$imageurl;
            $tourl = $todir.$imageurl;
            if(file_exists($fileurl)){
                $copy = copy($fileurl, $tourl);
                echo $product['id'] . ' success<br>';
            }
        }
    }

    public  function action_get_bai_image()
    {
        ignore_user_abort(true);
        set_time_limit(0); 
        ini_set('memory_limit', '512M');
        $dir = "/home/data/www/htdocs/clothes/uploads/1/feedimage/";
        $products = DB::query(DATABASE::SELECT, "select id from products  where `site_id`=1 and visibility=1 and status=1 order by created DESC")->execute('slave');
        foreach ($products as $product)
        {
            $product_instance = Product::instance($product['id']);
            $imageid = $product_instance->cover_image();
            $imageurl = $imageid['id'].'.'.$imageid['suffix'];  
            $fileurl = $dir.$imageurl;   
            if(file_exists($fileurl)){
                self::imagewhite($fileurl);
            }    

        }

    }

    public static function imagewhite($file)
    {
        //源图的路径，可以是本地文件，也可以是远程图片
        $src_path = $file;
        //最终保存图片的宽
        $width = 600;
        //最终保存图片的高
        $height = 600;

        //源图对象
        $src_image = imagecreatefromstring(file_get_contents($src_path));
        $src_width = imagesx($src_image);
        $src_height = imagesy($src_image);
        if($src_width == 600){
        //生成等比例的缩略图
        $tmp_image_width = 0;
        $tmp_image_height = 0;
        if ($src_width / $src_height >= $width / $height) {
        $tmp_image_width = $width;
        $tmp_image_height = round($tmp_image_width * $src_height / $src_width);
        } else {
        $tmp_image_height = $height;
        $tmp_image_width = round($tmp_image_height * $src_width / $src_height);
        }

        $tmpImage = imagecreatetruecolor($tmp_image_width, $tmp_image_height);
        imagecopyresampled($tmpImage, $src_image, 0, 0, 0, 0, $tmp_image_width, $tmp_image_height, $src_width, $src_height);

        //添加白边
        $final_image = imagecreatetruecolor($width, $height);
        $color = imagecolorallocate($final_image, 255, 255, 255);
        imagefill($final_image, 0, 0, $color);

        $x = round(($width - $tmp_image_width) / 2);
        $y = round(($height - $tmp_image_height) / 2);

        imagecopy($final_image, $tmpImage, $x, $y, 0, 0, $tmp_image_width, $tmp_image_height);

        //输出图片
        /*header('Content-Type: image/jpeg');*/
        imagejpeg($final_image,$file);

          }

    }

    public function action_send_birthday_mail()
    {
        set_time_limit(0);
        api::send_birthday_email();
        exit();
    }
/**
*ws触发订单产品报等接口
*zpz
*20160118
*/
    public function action_send_mail_baodeng()
    {
    
        set_time_limit(0);

        $res=array();
        
        
        $res['error_item']=array();
        $res['mes']=array();
        // $data=Arr::get($_POST, 'baodeng', '');
        $data=$_POST['baodeng'];

        if(empty($data)){
            echo 'no data input';
            exit();    
        }
        

        $data=json_decode($data,True);

        
        foreach ($data as $orderinfo) {

            $ordernum = $orderinfo['ordernum'];
            $sku=$orderinfo['sku'];
            $attr=$orderinfo['attributes'];
            $days=$orderinfo['days'];
            $erp_oid=$orderinfo['erp_oid'];
            //
            
            if(empty($ordernum)){
                $res['mes'][]='ordernum empty';
                continue;
            }
            if(empty($sku)){
                $res['mes'][]='sku empty';
                continue;
            }
            if(empty($days)){
                $res['mes'][]='days empty';
                continue;
            }
            
            
            $order = DB::query(DATABASE::SELECT, 'SELECT id FROM orders WHERE ordernum = "' . $ordernum.'" limit 1')->execute()->current();
            if(empty($order['id'])){
                $res['mes'][]='orderid empty';
                $res['error_item'][]=$erp_oid;
                continue;
            }
            $order_id=$order['id'];
            
            
            $item = DB::query(DATABASE::SELECT, 'SELECT id FROM order_items WHERE order_id = "' . $order_id.'" and sku ="'.$sku.'" and attributes="'.$attr.'" limit 1')->execute()->current();
            if(empty($item['id'])){
                $res['mes'][]='itemid empty';
                $res['error_item'][]=$erp_oid;
                continue;
            }
            $item_id=$item['id'];
            
            

            $r=api::send_wait_email($item_id,$order_id,$days);
            if(empty($r)){
                
                $res['error_item'][]=$erp_oid;
            }
        }
        echo json_encode($res);
        exit();
        //筛选是否发送过的机制在ws，此处不需要添加
    }
	
	
	
	/*
	  * feed tagtoo_product 
	  * wkf
	  * 16.01.21
	  */
	  public function action_tagtoo_product()
    {
        ignore_user_abort(true);
        set_time_limit(0);

        $fileurl = "/home/data/www/htdocs/clothes/googleproduct/tagtoo_product.xml"; 
        if (!file_exists($fileurl))
        {
            self::xmldata3($fileurl);
        }
        else
        {
            self::xmldata3($fileurl);
        }   

    }
	public function xmldata3($v)
    {
        ini_set('memory_limit', '512M');  
        $fileurl = "/home/data/www/htdocs/clothes/googleproduct/tagtoo_product.xml";

        $data_array1 = array(
                array(
                    'title' => "CHOiES: Offer Women's Fashion Clothing, Dresses &amp; Shoes",
                    'link' => 'http://www.choies.com',
                    'description' => "Discover the latest trends in women's fashion at CHOiES. With thousands of styles from Clothing, Dresses, Tops, Bottoms, Shoes and Accessories. Free Shipping and Shop Now!",
                ),
            );
        $cate_wrong = array('锛�','锛�', '&ndash','&rsquo', '&ampamp', '&aamp','&ldquo','&rdquo');
        $products = DB::query(DATABASE::SELECT, 'select id,name,sku,description,link,price,status,stock,configs,set_id from products where visibility=1 and status=1 and stock!=0')->execute('slave');
        $brr = array('credit','Expressshipping','LUCKYBAG2','YEARGIFT','CZ0004','BZ0005');

        $data_array3 = array();
        $j = 0;
        foreach ($products as $product)
        {
            if(!in_array($product['sku'],$brr))
            {     
	            $image_url = '';
	            $product_instance = Product::instance($product['id']);
	            $image_url = Image::linkfeed($product_instance->cover_image(), 9);
	            if (!$image_url)
	                Image::link($product_instance->cover_image(), 9);

	            $description = strip_tags($product['description']);
	            $description = str_replace('&nbsp', ' ', $description);
	            $description = str_replace($cate_wrong, '', $description);

	            $category = $product_instance->default_catalog();
	            $category = Catalog::instance($category)->get("name");
	            $category = str_replace('&', ' and ', $category);

	            $price = round($product['price'], 2);	            
	            $link = $product_instance->permalink();
                $data_array3[$j]['g:id'] = $product['id'];
                $data_array3[$j]['g:title'] = $product['name'];
                $data_array3[$j]['g:description'] = $description;
                $data_array3[$j]['g:link'] = $link;
                $data_array3[$j]['g:image_link'] = $image_url;
                $data_array3[$j]['g:brand'] = 'Choies';
                $data_array3[$j]['g:condition'] = 'new';
                $data_array3[$j]['g:availability'] = 'in stock';
                $data_array3[$j]['g:price'] = $price.' USD';
                $data_array3[$j]['g:shipping']['g:country'] = 'US';
                $data_array3[$j]['g:shipping']['g:service'] = 'Standard';
                $data_array3[$j]['g:shipping']['g:price'] = '0 USD';
                $data_array3[$j]['g:google_product_category'] = $category;             
                $j++;
            }
        }
		
		
        $xml = new XMLWriter();
        $xml->openUri($fileurl);
        $xml->setIndentString('  ');
        $xml->setIndent(true);
        $xml->startDocument('1.0', 'UTF-8'); 
        $xml->startElement('rss'); 
        $xml->writeAttribute('xmlns:g',"http://base.google.com/ns/1.0");
        $xml->writeAttribute('version',"2.0");
        $xml->startElement('channel'); 
		
		
		
		foreach($data_array1 as $data)
		{
            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    $xml->text($row);   //  设置内容
                    $xml->endElement(); // $key
                }
            }
		}
		
        foreach ($data_array3 as $data)
        {
        	$xml->startElement('item');
            if (is_array($data))
            {
                foreach ($data as $key => $row)
                {
                    $xml->startElement($key);
                    if(is_array($row))
                    {
                    	foreach ($row as $key => $rows)
                    	{
                    		$xml->startElement($key);
                    		$xml->text($rows);
                    		$xml->endElement();
                    	}
                    }
                    else
                    {
                    	$xml->text($row);   //  设置内容                    	
                    }

                    $xml->endElement(); // $key
                }
            }
            $xml->endElement();         //  item
        }

        $xml->endElement(); //  article
        $xml->endDocument();
        $xml->flush();
        echo "success".'<br />';
        die;
    }
	
	//wp批量发送未支付订单的邮件
	public function action_wpemail()
	{
		$sign_id = "";
		$sign_id = $_GET['sign_id'];
		//  校验码防止恶意刷   www.choies.com/api/wpemail?sign_id=8ESQ0BINOV4
		if($sign_id != '8ESQ0BINOV4'){
		  exit;
		}
		$result=array();
		
		//获取支付成功邮件
		$result_ok = DB::query(DATABASE::SELECT, 'SELECT * FROM `orders` WHERE payment_status in ("success","verify_pass") and email_status in (0,1) order by id desc limit 20')->execute()->as_array();
		
		foreach($result_ok as $k1=>$o1){
			//判断是否已发送过邮件
			$sendlog1 = DB::select('id')
				->from('mail_logs')
				->where('type', '=', 1)
				->where('table', '=', 1)
				->where('table_id', '=', $o1['id'])
				->execute()->current();
			if(empty($sendlog1))
			{
				if($o1['payment_status']=='verify_pass' || $o1['payment_status']=='success')
				{
					$mail_params['order_view_link'] = '<a href="http://' . Site::instance()->get('domain') . '/order/view/' . $o1['ordernum'] . '">View your order</a>';
					$mail_params['order_num'] = $o1['ordernum'];
					$mail_params['email'] = $o1['email'];
					$customer_id = $o1['customer_id'];
					$mail_params['firstname'] = Customer::instance($customer_id)->get('firstname');
					$products = $o1['products'] ? unserialize($o1['products']) : array();
					foreach ($products as $p)
					{
						$product = Product::instance($p['id']);
						$hits = $product->get('hits');
						$product->set(array('hits' => $hits + $p['quantity']));
					}
					$mail_params['order_product'] =
							'<table border="0" width="92%" style="color: #000000; font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 11px; cursor: text;">
												<tbody>
													<tr align="left">
														<td colspan="5"><strong>Product Details</strong></td>
													</tr>';
					$celebrity_id = Customer::instance($customer_id)->is_celebrity();
					$order_products = Order::instance($o1['id'])->products();
					$currency = Site::instance()->currencies($o1['currency']);
					foreach ($order_products as $rs)
					{
						$mail_params['order_product'] .= '<tr align="left">
																	<td>' . Product::instance($rs['item_id'], $o1['lang'])->get('name') . '</td>
																	<td>QTY:' . $rs['quantity'] . '</td>
																	<td>' . $rs['attributes'] . '</td>
																	<td>' . $currency['code'] . round($rs['price'] * $o1['rate'], 2) . '</td>
															</tr>';
					}
					$mail_params['order_product'] .= '</tbody></table>';

					$mail_params['currency'] = $o1['currency'];
					$mail_params['amount'] = $o1['amount'];
					$mail_params['pay_num'] = $o1['amount'];
					$mail_params['pay_currency'] = $o1['currency'];
					$mail_params['shipping_firstname'] = $o1['shipping_firstname'];
					$mail_params['shipping_lastname'] = $o1['shipping_lastname'];
					$mail_params['address'] = $o1['shipping_address'];
					$mail_params['city'] = $o1['shipping_city'];
					$mail_params['state'] = $o1['shipping_state'];
					$mail_params['country'] = $o1['shipping_country'];
					$mail_params['zip'] = $o1['shipping_zip'];
					$mail_params['phone'] = $o1['shipping_phone'];
					$mail_params['shipping_fee'] = $o1['amount_shipping'];
					$mail_params['payname'] = '';
					$mail_params['created'] = date('Y-m-d H:i', $o1['created']);
					$mail_params['points'] = floor($o1['amount'] / $o1['rate']);
					//支付成功的
					if ($celebrity_id)
					{
						Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
						$send=Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
					}
					else
					{
                        $mail_params['emailaddress'] = $o1['email'];
						$vip_level = Customer::instance($customer_id)->get('vip_level');
						$vip_return = DB::select('return')->from('vip_types')->where('level', '=', $vip_level)->execute()->get('return');
						$rate = $o1['rate'] ? $o1['rate'] : 1;
						$points = ($o1['amount'] / $rate) * $vip_return;
						$mail_params['order_points'] = $points;
						Kohana_Log::instance()->add('SendMail', 'PAYSUCCESS');
						$send=Mail::SendTemplateMail('PAYSUCCESS', $mail_params['email'], $mail_params);
					}
					$insert1 = array(
                        'type' => 1,
                        'table' => 1,
                        'table_id' => $o1['id'],
                        'email' => $o1['email'],
                        'status' => 0,
                        'send_date' => time()
                    );
					$updata1=array();
					$updata1 = array(
						'email_status' => 2,
					);
					DB::insert('mail_logs', array_keys($insert1))->values($insert1)->execute();
					DB::update('orders')->set($updata1)->where('id', '=', $o['id'])->execute();
				}
			}
		}
		echo "success!";
		exit;
	}
	
	public function action_add_all_elastic()
    {
        if(LANGUAGE)
        {
            $lang_table = '_' . LANGUAGE;
        }
        else
        {
            $lang_table = '';
        }
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $products = DB::select('id', 'name', 'sku', 'visibility', 'status', 'description', 'keywords', 'price', 'display_date', 'hits', 'has_pick', 'filter_attributes', 'default_catalog', 'position', 'attributes')
            ->from('products' . $lang_table)
            ->where('visibility', '=', 1)
            ->where('status', '=', 1)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();
        if(!LANGUAGE)
        {
            $catalog_config = Kohana::config('filter.colors');
            foreach($products as $key => $p)
            {
                $attributes = unserialize($p['attributes']);
                if(!empty($attributes['Size']))
                {
                    $attr_size = array();
                    if(strpos($p['attributes'], 'EUR') !== FALSE)
                    {
                        foreach($attributes['Size'] as $attr)
                        {
                            $attribute = explode('/', $attr);
                            if(!empty($attribute[2]))
                            {
                                $attr_size[] = preg_replace('/[A-Z]+/i', '', $attribute[2]);
                            }
                        }
                    }
                    if(empty($attr_size))
                        $attr_size = $attributes['Size'];
                    $products[$key]['size_value'] = implode(' ', $attr_size);
                    $attr_size = str_replace(' ', '', $attr_size);
                    $attr_string = 'size' . implode(' size', $attr_size);
                    $products[$key]['attributes'] = $attr_string;
                    $p_color = '';
                    foreach($catalog_config as $color)
                    {
                        $color = strtolower($color);
                        if(strpos($p['filter_attributes'], $color) !== FALSE)
                        {
                            $p_color = $color;
                            break;
                        }
                    }
                }
                $products[$key]['color_value'] = $p_color;
                $products[$key]['price'] = round($products[$key]['price'], 2);
                $products[$key]['default_catalog'] .= ',';
                $products[$key]['pro_price'] = round($products[$key]['price'], 2);
                $products[$key]['has_promotion'] = 0;

                $languages = Kohana::config('sites.language');
                foreach($languages as $language)
                {
                    if($language == 'en' || !$language)
                        continue;
                    $products[$key]['name_' . $language] = $products[$key]['name'];
                    $products[$key]['description_' . $language] = $products[$key]['description'];
                    $products[$key]['keywords_' . $language] = $products[$key]['keywords'];
                }
            }
            if(!empty($products))
            {
                $responses = $elastic->create_index($products);

                echo date('Y-m-d H:i:s');
                print_r($responses);
            }
        }
        else
        {
            echo LANGUAGE . ":<br>\n";
            $product_l = array();
            foreach($products as $key => $p)
            {
                $product_l['name_' . LANGUAGE] = $products[$key]['name'];
                $product_l['description_' . LANGUAGE] = $products[$key]['description'];
                $product_l['keywords_' . LANGUAGE] = $products[$key]['keywords'];
                $res = $elastic->update(array('id' => $p['id']), $product_l);
                echo $p['id'] . '-' . $res . "<br>\n";
            }
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_add_catalog_elastic()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 3000;
        $start = ($page - 1) * $limit;
        $result = DB::query(Database::SELECT, 'SELECT C.product_id, C.catalog_id 
            FROM catalog_products C LEFT JOIN products P ON C.product_id = P.id 
            RIGHT JOIN catalogs A ON C.catalog_id = A.id
            WHERE P.visibility = 1 AND P.status = 1 AND A.visibility = 1
            ORDER BY product_id LIMIT ' . $start . ', ' . $limit)->execute();
        $product_catalogs = array();
        foreach($result as $res)
        {
            if(isset($product_catalogs[$res['product_id']]))
            {
                $product_catalogs[$res['product_id']] .= ' ' . $res['catalog_id'];
            }
            else
            {
                $product_catalogs[$res['product_id']] = '' . $res['catalog_id'];
            }
        }
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        foreach($product_catalogs as $product_id => $catalogs)
        {
            $response = $elastic->update(array('id' => $product_id), array('default_catalog' => $catalogs));
            echo $product_id . '---' . $response . "<br>\n";
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_update_elastic()
    {
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $products = DB::select('id', 'price')
            ->from('products')
            ->where('visibility', '=', 1)
            ->where('status', '=', 1)
            ->order_by('id', 'desc')
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->execute('slave')->as_array();
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $catalog_config = Kohana::config('filter.colors');
        foreach($products as $key => $p)
        {
            $p_color = '';
            foreach($catalog_config as $color)
            {
                $color = strtolower($color);
                if(isset($p['filter_attributes']))
                {
                    if(strpos($p['filter_attributes'], $color) !== FALSE)
                    {
                        $p_color = $color;
                        break;
                    }                    
                }
            }

            $response = $elastic->update(array('id' => $p['id']), array('color_value' => $p_color));
            echo $p['id'] . '---' . '"' . $p_color . '"' . '---' . $response . "<br>\n";
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_init_elastic_price()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $filter = array('term' => array('has_promotion' => 1));
        $promotion_elastic = $elastic->search('', array(), 5000, 0, $filter);
        if(!empty($promotion_elastic['hits']['hits']))
        {
            foreach($promotion_elastic['hits']['hits'] as $pro)
            {
                $res = $elastic->do_update($pro['_index'], $pro['_type'], $pro['_id'], array('has_promotion' => 0, 'price' => $pro['_source']['pro_price']));
                if(empty($res['error']))
                {
                    echo $pro['_source']['id'] . "<br>\n";
                }
            }
        }
        exit;
    }

    public function action_update_elastic_price()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $spromotions = DB::query(Database::SELECT, 'SELECT S.product_id, S.price, P.price AS p_price FROM spromotions S 
            LEFT JOIN products P ON S.product_id = P.id
            WHERE S.type <> 0 AND S.expired > ' . time() . ' AND P.visibility = 1 AND P.status = 1')
            ->execute('slave')->as_array();
        $responses = '';
        foreach($spromotions as $spromotion)
        {
            if($spromotion['price'] >= $spromotion['p_price'])
                continue;
            $update = array(
                'price' => round($spromotion['price'], 2),
                'has_promotion' => 1,
            );

            $response = $elastic->update(array('id' => $spromotion['product_id']), $update);
            $responses .= $spromotion['product_id'] . '-' . $response . "<br>\n";

            $cache_key = '1/product_price/' . $spromotion['product_id'] . '/0';
            Cache::instance('memcache')->set($cache_key, $spromotion['price'], 7200);
        }
        echo $responses;exit;
    }

    public function action_update_elastic_brand()
    {
        $elastic_type = 'product';
        $elastic_index = 'basic_new';
        $elastic = Elastic::instance($elastic_type, $elastic_index);
        $page = Arr::get($_GET, 'page', 1);
        $limit = 1000;
        $start = ($page - 1) * $limit;
        $result = DB::query(Database::SELECT, 'SELECT id, keywords, brand_id FROM products WHERE visibility = 1 AND status = 1 LIMIT ' . $start . ', ' . $limit)->execute();
        foreach($result as $product)
        {
            if($product['brand_id'])
            {
                $product['keywords'] .= ' brand' . $product['brand_id'];
                $response = $elastic->update(array('id' => $product['id']), array('keywords' => $product['keywords']));
                echo $product['id'] . '---' . $response . "<br>\n";
            }
            else
            {
                echo $product['id'] . "---No Brand<br>\n";
            }
        }

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_catch_skus_info_from_ws()
    {

        if(empty($_POST['skus']))
        {
            die('empty input');
        }

        $skus=$_POST['skus'];

        $product_info_json=$this->action_catch_sku_info_from_ws($skus);
        $products=json_decode($product_info_json,true);

        if(empty($products))
        {
            Kohana_log::instance()->add('catch_product_info_from_ws', ' STATE:ERROR' . ' | RES:empty ' );
            exit();
        }else
        {
            Kohana_log::instance()->add('catch_product_info_from_ws', ' STATE:NORMAL' . ' | RES:' . $product_info_json );
        }

        $result=array();
        foreach ($products as $product) 
        {
            if(empty($product))
            {
                continue;
            }
            $pid_tmp=0;
            $mes_tmp='';
            $a=$this->action_do_sku_info_from_ws($product,$pid_tmp,$mes_tmp);
            
            if($a)
            {
                $p_instance=Product::instance($pid_tmp);
                $p_link=$p_instance->permalink();
                $result[]=array('sku'=>$product['sku'],'flag'=>1,'url'=>$p_link);
            }
            else
            {
                $result[]=array('sku'=>empty($product['sku'])?'':$product['sku'],'flag'=>0,'msg'=>$mes_tmp);
            }
        }

        if(!empty($result))
        {
            $str=json_encode($result);
            // echo $str;
            $this->return_status_to_ws($str);
        }

        
        
        exit();
    }

    function action_catch_sku_info_from_ws($skus)
    {
        if(empty($skus))
        {
            return false;
        }
     
        $url='http://erp.wxzeshang.com:8000/api/choies_get_ws_tribute/';
        // $url='http://192.168.11.24:8000/api/choies_get_ws_tribute/';

        $post_data=array('skus'=>$skus);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data);
        $product_info = curl_exec ( $ch );
        curl_close($ch);

        return $product_info;
    }

    function action_do_sku_info_from_ws($product_info,&$pid_tmp,&$mes_tmp)
    {

        if(empty($product_info))
        {
            
            Kohana_log::instance()->add('sync_product_info_from_ws', ' STATE:ERROR' . ' | RES:empty ' );
            $mes_tmp='empty data';
            return false;
        }

        if(empty($product_info['sku']))
        {
            
            Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:empty'.' | STATE:ERROR'  );
            $mes_tmp='empty data';
            return false;
        }
        
        $product=$product_info;

        $p_images=$product['image'];
        unset($product['image']);

        if(empty($product['img_updated']))
        {
            $p_img_updated=0;
        }else
        {
            $p_img_updated=1;
        }
        unset($product['img_updated']);

        
        $sku=$product['sku'];
        $res=api::import_product_info($product);

        if(empty($res['flag'])||empty($res['p_id']))
        {
            
            Kohana_log::instance()->add('sync_product_info_from_ws',  ' SKU:'.$sku .' | STATE:ERROR' .' |  MES:'.$res['mes']);
            $mes_tmp=$res['mes'];
            return false;
        }
        else
        {
            
            Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:'.$sku.' | STATE:product info save success'  );
        }

        $p_id=$res['p_id'];
        $pid_tmp=$p_id;


        if(!empty($p_img_updated))//img_updated
        {
            
            if($res['type']=='update')
            {
                $p_imgs = DB::select('id')
                ->from('images')
                ->where('obj_id', '=', $p_id)
                ->execute()->as_array();
                if(!empty($p_imgs))
                {
                    foreach ($p_imgs as $p_img) 
                    {
                        image::delete_uploads($p_img['id']);
                    }
                }
                
            }
            $image_default=0; 
            $img_data=array(); 
            $default_image=''; 
            $images_order=array();
            
            if(!empty($p_images))
            {
                ksort($p_images);
                foreach ($p_images as $k => $img_url) 
                {
                    if(!empty($img_url))
                    {
                        $image_in=array(
                            'type'=>1,
                            'suffix'=>'jpg',
                            'site_id'=>1,
                            'obj_id'=>$p_id,
                            'status'=>1,
                        );

                        $img_insert = DB::insert('images', array_keys($image_in))->values($image_in)->execute();
                        if(!empty($img_insert[0]))
                        {
                            $img_id=$img_insert[0];

                            if(empty($image_default))
                            {
                                $default_image=$img_id;
                                $image_default=1;
                            }
                            $images_order[]=$img_id;
                            $img_data[$img_id]=$img_url;
                            
                        }else
                        {
                            Kohana_log::instance()->add('sync_product_info_from_ws',  ' SKU:'.$sku.' | STATE:image insert error'  );
                            $mes_tmp='image insert error';
                            return false;
                        }
                    }
                }
            }
            
            if(!empty($image_default))
            {
                $img_save_state=true;
                foreach ($img_data as $img_id => $img_url) 
                {
                    $img_res=api::download_image($img_url,$img_id);
                    if(empty($img_res['flag']))
                    {
                        $img_save_state=false;
                    }
                }
                if(!$img_save_state)
                {
                    
                    Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:'.$sku.' | STATE:download image error'  );
                    $mes_tmp='download image error';
                    return false;
                }

                
                $img_config=array(
                    'default_image'=>$default_image,
                    'images_order'=>implode(',', $images_order),
                );
                
                $config=array(
                    'configs'=>serialize($img_config),
                );
                try
                {
                    $update=DB::update('products')->set($config)->where('id', '=', $p_id)->execute();

                    if($update)
                    {
                        $languages = Kohana::config('sites.'.'.product_info_catch_language');
                        
                        $update_l_state=true;
                        $update_l=array();
                        foreach ($languages as $l)
                        {
                            if($l==='en')
                            {
                                continue;
                            }
                            $update_s=DB::update('products_'.$l)->set($config)->where('id', '=', $p_id)->execute();

                            if(empty($update_s))
                            {
                                $update_l_state=false;
                            }
                        }
                        
                        
                        if($update_l_state)
                        {
                            return true;
                        }else
                        {
                            
                            Kohana_log::instance()->add('sync_product_info_from_ws', ' SKU:'.$sku.' | STATE:update product `config`_images languages failed'  );
                            $mes_tmp='update product `config`_images languages failed';
                            return false;
                        }
                            
                        
                    }else
                    {
                        Kohana_log::instance()->add('sync_product_info_from_ws',  ' SKU:'.$sku.' | STATE:update product `config`_images failed'  );
                        $mes_tmp='update product `config`_images failed';
                        return false;
                    }
                }
                catch (Exception $e)
                {
                    Kohana_log::instance()->add('sync_product_info_from_ws', 'SKU:'.$sku.' | STATE:ERROR' .' | MES:'.$e->getMessage());
                    $mes_tmp=$e->getMessage();
                    
                    return false;
                }

            }

        }
        
        return true;
        
    }

    function return_status_to_ws($str)
    {
        // echo $str;
        $url='http://erp.wxzeshang.com:8000/api/choies_item_status/';
        // $url='http://192.168.11.24:8000/api/choies_item_status/';

        $post_data=array('skus'=>$str);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
        curl_setopt ( $ch, CURLOPT_POST, true );
        curl_setopt ( $ch, CURLOPT_POSTFIELDS, $post_data);
        $product_info = curl_exec ( $ch );
        curl_close($ch);

        Kohana_log::instance()->add('return_status_to_ws', 'DATA:'.$str);
        return true;
    }

    // choies.com get product_relate from new.choeis --- sjm 2016-03-10
    public function action_get_product_relate()
    {
        $product_id = (int) Arr::get($_GET, 'product_id', 0);
        if($product_id)
        {
            $product_relate = DB::select('relate')
                ->from('ga_product_relate')
                ->where('product_id', '=', $product_id)
                ->where('relate_count', '>', 28)
                ->execute()->get('relate');
            echo $product_relate;
        }
        exit;
    }

    public function action_frow_ws_get_stock()
    {
        if($_POST)
        {     
            $skuarr = json_decode($_POST['skus']);

            #kohana_log::instance()->add('skus', serialize($skuarr));
            foreach ($skuarr as $key => $value)
            {
                $sku = $key;
                $product_id = Product::get_productId_by_sku(trim($sku));
                $proins = Product::instance($product_id);
                $source = $proins->get('source'); 
                if($source == '库存限制销售' || $source == '做货')
                {
                    $attributes = $proins->get('attributes');
                    $prostock = $proins->get('stock'); 
                    $set = $proins->get('set_id');

                    $newarr = array();
                    foreach ($value as $key2 => $value2)
                    {
                       $newarr[$key2] = $value2;     
                    }

                    $countws = count($newarr);
                    $countcs = count($attributes['Size']);

                    if($countcs >= $countws)
                    {
                        foreach ($attributes['Size'] as $key1 => $value1)
                        {
                            $sizeinput = $value1;
                            
                            if(strpos($sizeinput,'EUR') !== FALSE)
                            {
                                $arrsize = explode('/', $sizeinput);
                                $sizeinput = substr($arrsize[2], 3,2);
                            }

                            if($set == 2)
                            {
                                $sizesearch = 'EUR'.$sizeinput;
                                $isstock = DB::select('id')
                                ->from('product_stocks')
                                ->where('product_id', '=', $product_id)
                                ->where('attributes', 'LIKE', '%' . $sizesearch . '%')
                                ->execute('slave')->get('id');   
                            }
                            else
                            {
                                $isstock = DB::select('id')
                                ->from('product_stocks')
                                ->where('product_id', '=', $product_id)
                                ->where('attributes', '=', $sizeinput)
                                ->execute('slave')->get('id');           
                            }


                            if(array_key_exists($sizeinput, $newarr) or array_key_exists('ONESIZE', $newarr))
                            {
                                if($sizeinput == 'one size' or $sizeinput == 'One size')
                                {
                                    $qty = $value->ONESIZE;
                                }
                                else
                                {
                                    $qty = $value->$sizeinput;                       
                                }
                                if($isstock)
                                {
                                    $update = DB::update('product_stocks')->set(array('stocks' => $qty, 'isdisplay' => 1))->where('id', '=', $isstock)->execute();

                                    kohana_log::instance()->add('1updateskustock', $sku.':'.$sizeinput.':'.$qty);
                                    if($prostock != -1 && $update)
                                    {
                                        $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();                           
                                    }
                                }
                                else
                                {
                                    $stocks = array(
                                        'site_id' => 1,
                                        'product_id' => $product_id,
                                        'stocks' => $qty,
                                        'attributes' => $value1,

                                    );

                                    $insert = DB::insert('product_stocks', array_keys($stocks))->values($stocks )->execute();
                                    kohana_log::instance()->add('1insertskustock', $sku.':'.$sizeinput.':'.$qty);
                                    if($prostock != -1 && $insert)
                                    {
                                        $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();                           
                                    }
                                }
                            }
                            else
                            {
                                $qty = isset($value->$sizeinput) ? $value->$sizeinput : 0;
                                if($isstock)
                                {
                                    $update = DB::update('product_stocks')->set(array('stocks' => 0))->where('id', '=', $isstock)->execute();

                                    kohana_log::instance()->add('2updateskustock', $sku.':0:'.$qty);
                                    if($prostock != -1 && $update)
                                    {
                                        $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();                           
                                    }
                                }
                                else
                                {
                                    $stocks = array(
                                        'site_id' => 1,
                                        'product_id' => $product_id,
                                        'stocks' => $qty,
                                        'attributes' => $value1,

                                    );

                                    $insert = DB::insert('product_stocks', array_keys($stocks))->values($stocks)->execute();
                                    kohana_log::instance()->add('2insertskustock', $sku.':'.$sizeinput.':'.$qty);
                                    if($prostock != -1 && $insert)
                                    {
                                        $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();                           
                                    }
                                }
                            }
                        }
                    }
                    else
                    {
                        foreach ($newarr as $key3 => $value3) 
                        {
                            $sizeinput = $key3;
                            if($sizeinput == 'ONESIZE')
                            {
                                $sizeinput = 'one size';
                            }
                            if($set == 2)
                            {
                                $sizesearch = 'EUR'.$sizeinput;
                                $isstock = DB::select('id')
                                ->from('product_stocks')
                                ->where('product_id', '=', $product_id)
                                ->where('attributes', 'LIKE', '%' . $sizesearch . '%')
                                ->execute('slave')->get('id');   
                            }
                            else
                            {
                                $isstock = DB::select('id')
                                ->from('product_stocks')
                                ->where('product_id', '=', $product_id)
                                ->where('attributes', '=', $sizeinput)
                                ->execute('slave')->get('id');           
                            }

                            $shoesarr = Kohana::config('sites.apishoes'); 
                            if($set == 2)
                            {
                               $sizeinput = $shoesarr[$key3];
                            }

                            $isdisplay = 0;
                            if(in_array($sizeinput,$attributes['Size']))
                            {
                                $isdisplay = 1;
                            }

                            $qty = $value3;
                            if($isstock)
                            {
                                $update = DB::update('product_stocks')->set(array('stocks' => $qty,'isdisplay' => $isdisplay))->where('id', '=', $isstock)->execute();

                                kohana_log::instance()->add('updateskustock', $sku.$sizeinput.':'.$qty);
                                if($prostock != -1 && $update)
                                {
                                    $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();                           
                                }
                            }
                            else
                            {
                                $stocks = array(
                                    'site_id' => 1,
                                    'product_id' => $product_id,
                                    'stocks' => $qty,
                                    'attributes' => $sizeinput,
                                    'isdisplay' => $isdisplay
                                );

                                $insert = DB::insert('product_stocks', array_keys($stocks))->values($stocks )->execute();
                                kohana_log::instance()->add('insertskustock', $sku.$sizeinput.':'.$qty);
                                if($prostock != -1 && $insert)
                                {
                                    $updateproduct = DB::update('products')->set(array('stock' => -1))->where('id', '=', $product_id)->execute();                           
                                }
                            }
                        }
                    }
                }

            }

        }
    }

    public function action_test_memcache()
    {
        $product_id = Arr::get($_GET, 'product_id', '');
        echo Product::instance($product_id)->price();
        exit;
    }

    // ws传过来小于100个sku(用逗号隔开来)，返回对应item数据
    public function action_given_itemlist()
    {
        $skus = trim(Arr::get($_POST, 'skus', ''));
        if($skus)
        {
            $sku_list = explode(',', $skus);
            if(count($sku_list) > 100)
            {
                echo 'False';
                exit;
            }
            $product = array();
            $products = DB::select('id', 'name', 'sku', 'price', 'visibility', 'status', 'stock', 'configs', 'attributes', 'factory', 'offline_factory', 'taobao_url', 'total_cost', 'offline_sku', 'set_id', 'weight', 'cn_name', 'admin', 'created', 'offline_factory', 'offline_picker', 'filter_attributes', 'attributes', 'brief', 'description', 'source', 'cost', 'store')
                ->from('products')
                ->where('sku', 'in', $sku_list)
                ->execute('slave');
            foreach($products as $p)
            {
                $image_url = '';
                $images = unserialize($p['configs']);
                if (isset($images['default_image']))
                {
                    $image_url = STATICURL.'/pimg/o/' . $images['default_image'] . '.jpg';
                }
                else
                {
                    $pimages = DB::select('id', 'suffix')->from('images')->where('site_id', '=', 1)->where('obj_id', '=', $p['id'])->execute('slave')->current();
                    if (!empty($pimages))
                        $image_url =  STATICURL.'/pimg/o/' . $pimages['id'] . '.'.$pimages['suffix'];

                }

                $pstocks = array();
                $on_stock = $p['visibility'] && $p['status'];
                if ($on_stock && $p['stocks'] = -1)
                {
                    $stocks = DB::select('attributes', 'stocks')->from('product_stocks')->where('product_id', '=', $p['id'])->where('stocks', '>', 0)->execute('slave')->as_array();
                    if (!empty($stocks))
                    {
                        foreach ($stocks as $stock)
                        {
                            $pstocks[$stock['attributes']] = $stock['stocks'];
                        }
                    }
                }
                $set = Set::instance($p['set_id'])->get('name');
                $factory = trim($p['factory']) ? trim($p['factory']) : $p['offline_factory'];
                $link = Product::instance($p['id'])->permalink();

                $admin_email = User::instance($p['admin'])->get('email');
                $attributes = unserialize($p['attributes']);
                $sizes = array();
                if (isset($attributes['Size']))
                {
                    $sizes = $attributes['Size'];
                }
                elseif (isset($attributes['size']))
                {
                    $sizes = $attributes['size'];
                }
                foreach ($sizes as $key => $size)
                {
                    $sizename = strtoupper($size);
                    if(strpos($sizename, 'ONE') !== False)
                    {
                        $sizename = 'ONESIZE';
                    }
                    elseif (strpos($size, 'EUR') !== False)
                    {
                        $sizename = substr($size, strpos($size, 'EUR') + 3, 2);
                    }
                    $sizes[$key] = $sizename;
                }
                $product[] = array(
                    'id' => $p['id'],
                    'sku' => $p['sku'],
                    'price' => $p['price'],
                    'total_cost' => $p['total_cost'],
                    'color' => '',
                    'name' => $p['name'],
                    'set' => $set,
                    'attributes' => implode('#', $sizes),
                    'image_url' => $image_url,
                    'factory' => $factory,
                    'taobao_url' => $p['taobao_url'],
                    'offline_sku' => $p['offline_sku'],
                    'link' => $link,
                    'weight' => $p['weight'],
                    'cn_name' => $p['cn_name'],
                    'weight' => $p['weight'],
                    'admin_email' => $admin_email,
                    'offline_factory' => $p['offline_factory'],
                    'offline_picker' => $p['offline_picker'],
                    'filter_attributes' => $p['filter_attributes'],
                    'brief' => $p['brief'],
                    'description' => $p['description'],
                    'source' => $p['source'],
                    'cost' => $p['cost'],
                    'store' => $p['store'],
                );
            }
            echo json_encode($product);
        }
        exit;
    }

    //ws传过来['ordernum': 123, 'sku': 'ABC']，发送报缺邮件
    public function action_ws_set_outstock()
    {
        $success = array();
        $data = trim(Arr::get($_POST, 'item_miss'));
        $data = str_replace('\\', '', $data);
        // $data = '[{"ordernum": "14303331340", "sku": "DRES0407B020W", "order_item_id": 120271}, {"ordernum": "14304041340", "sku": "DRES0407B020W", "order_item_id": 120387}]';
        $item_miss = json_decode($data);
        $from = Site::instance()->get('email');
        if(!empty($item_miss))
        {
            foreach($item_miss as $item)
            {
                $ordernum = $item->ordernum;
                $sku = $item->sku;
                $order_item_id = $item->order_item_id;
                $order_data = DB::select('id', 'ordernum', 'email', 'shipping_firstname', 'payment_status')->from('orders')->where('ordernum', '=', $ordernum)->execute('slave')->current();
                if(empty($order_data))
                {
                    continue;
                }
                $update_item = DB::select('id', 'name', 'sku', 'price', 'attributes','quantity')->from('order_items')->where('order_id', '=', $order_data['id'])->where('sku', '=', $sku)->execute('slave')->current();
                if(empty($update_item))
                {
                    continue;
                }
                $update = DB::update('order_items')->set(array('status' => 'cancel', 'erp_line_status' => '缺货-WS'))->where('id', '=', $update_item['id'])->execute();
                if($update)
                {
                    $updateItems = array($update_item);
                    $rcpt = $order_data['email'];
                    $rcpts = array($rcpt, 'service@choies.com');
                    $subject = "Sorry dear, item you have ordered from Choies is not available now!";
                    $body = View::factory('/order/item_outstock_mail')->set('orderData', $order_data)->set('updateItems', $updateItems);
                    $send = Mail::Send($rcpts, $from, $subject, $body);

                    $comment_skus='';

                    foreach ($updateItems as $k0 => $v0) {
                        $comment_skus.=$v0['sku'].';';
                    }
                    $order = Order::instance($order_data['id']);
                    $order->add_history(array(
                        'order_status' => 'send baoque',
                        'message' => 'API报缺:'.$comment_skus,
                    ));

                    $success[] = $order_item_id;
                }
            }
        }
        echo json_encode($success);
        exit;
    }

    public function action_transforlanguage()
    {
        $starttime = time();
        $token = Arr::get($_GET, 'token', '');
        $lang = Arr::get($_GET, 'lang', ''); 
        $localtoken = 'jwinfuture'; 
        if($token != $localtoken)
        {
            die('REQUEST ERROR');
        }


        $page = Arr::get($_GET, 'page', 1);
        $limit = 100;
        $start = ($page - 1) * $limit;
        $result = DB::query(Database::SELECT, 'SELECT id, name FROM products WHERE visibility = 1 AND status = 1 order by id desc LIMIT ' . $start . ', ' . $limit)->execute('slave');
        $name = '';
        foreach($result as $product)
        {
            $name .= $product['name'].'+'; 
        }
        $name = substr($name, 0,-1);


        $proarr = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM trans')->execute('slave')->as_array();
        $arr = array();
        foreach ($proarr as $key => $value) 
        {
            array_push($arr, $value['product_id']);
        }

        $words1 = Site::googletransapi($blank='en',$target=$lang,$name);
        print_r($words1);
        if($words1 != 1)
        //if(1)
        {
            $words1 = json_decode($words1);
            $words1 = $words1->data->translations[0]->translatedText;

            $replarr1 = explode('+', $words1);

            if($replarr1)
            {
                foreach ($result as $key => $value)
                {
                    if(count($replarr1) == count($result))
                    {
                        #已存在，更新
                        if(in_array($value['id'], $arr))
                        {
                            $update = DB::update('trans')->set(array('trans_'.$lang => $replarr1[$key]))->where('product_id', '=', $value['id'])->execute();
                        }
                        else
                        {
                            $insert1 = array(
                            'trans_'.$lang => $replarr1[$key],
                            'product_id' => $value['id'],
                            );
                            DB::insert('trans', array_keys($insert1))->values($insert1)->execute();
                        }                        
                    }
                }
            }
        }

        $endtime = time();
        echo $endtime-$starttime;

        echo '<script type="text/javascript">
                setTimeout("pagerefresh()",3000);
                setTimeout("logout()",4000);
                function pagerefresh() 
                { 
                    window.open("?page=' . ($page + 1) . '&token='.$token.'&lang='.$lang.'");
                }
                function logout()
                {
                    parent.window.opener = null;
                    parent.window.open("", "_self");
                    parent.window.close();
                }
            </script>';
        exit;
    }

    public function action_transforempty()
    {
        $starttime = time();
        $token = Arr::get($_GET, 'token', '');
        $lang = Arr::get($_GET, 'lang', ''); 
        $localtoken = 'jwinfuture'; 
        if($token != $localtoken)
        {
            die('REQUEST ERROR');
        }

        $str = '" "';
        if($lang == 'de')
        {
            $proarr = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM trans where trans_de = '.$str)->execute('slave')->as_array();
        }
        elseif($lang == 'fr')
        {
            $proarr = DB::query(Database::SELECT, 'SELECT DISTINCT product_id FROM trans where trans_fr = '.$str)->execute('slave')->as_array();
        }
        else
        {

        }
        if(!empty($proarr))
        {
            $arr = array();
                $pro_id = '';
                foreach ($proarr as $key => $value) 
                {
                    $pro_id .= $value['product_id'].','; 
                    array_push($arr, $value['product_id']);
                }
                $pro_id = substr($pro_id, 0,-1);
                $pro_id = '('.$pro_id.')';

                $page = Arr::get($_GET, 'page', 1);
                $limit = 50;
                $start = ($page - 1) * $limit;
                $result = DB::query(Database::SELECT, 'SELECT id, name FROM products WHERE visibility = 1 AND status = 1 AND id in ' . $pro_id . ' LIMIT ' . $start . ', ' . $limit)->execute('slave');
                $name = '';
                foreach($result as $product)
                {
                    $name .= $product['name'].'+'; 
                }
                $name = substr($name, 0,-1);

                $words1 = Site::googletransapi($blank='en',$target=$lang,$name);
                print_r($words1);
                if($words1 != 1)
                //if(1)
                {
                    $words1 = json_decode($words1);
                    $words1 = $words1->data->translations[0]->translatedText;

                    $replarr1 = explode('+', $words1);

                    if($replarr1)
                    {
                        foreach ($result as $key => $value)
                        {
                            if(count($replarr1) == count($result))
                            {
                                #已存在，更新
                                if(in_array($value['id'], $arr))
                                {
                                    $update = DB::update('trans')->set(array('trans_'.$lang => $replarr1[$key]))->where('product_id', '=', $value['id'])->execute();
                                }
                                else
                                {
                                    $insert1 = array(
                                    'trans_'.$lang => $replarr1[$key],
                                    'product_id' => $value['id'],
                                    );
                                    DB::insert('trans', array_keys($insert1))->values($insert1)->execute();
                                }                        
                            }
                        }
                    }
                }

                $endtime = time();
                echo $endtime-$starttime;

                echo '<script type="text/javascript">
                        setTimeout("pagerefresh()",3000);
                        setTimeout("logout()",4000);
                        function pagerefresh() 
                        { 
                            window.open("?page=' . ($page + 1) . '&token='.$token.'&lang='.$lang.'");
                        }
                        function logout()
                        {
                            parent.window.opener = null;
                            parent.window.open("", "_self");
                            parent.window.close();
                        }
                    </script>';
                exit;            
        }
    
    }

    public function action_testtransmemcache()
    {
        $cache = Cache::instance('memcache');
        $key = 'trans_body_product_de66907';
        $con = $cache->get($key);
        Site::instance()->p($con);
    }

    public function action_catch_skus_by_timing()
    {
      /*
       * 传来的数据格式 array('data'=>json_str)
       * */
        if(empty($_POST['data']))
        {
            Kohana_log::instance()->add('catch_skus_by_timing', ' STATE:ERROR' . ' | RES:empty ' );
            exit();
        }
        else
        {
            Kohana_log::instance()->add('catch_skus_by_timing', ' STATE:NORMAL' . ' | RES:' . $_POST['data'] );
        }
        $not_update = array();
        $not_found = array();
        $languages = Kohana::config('sites.'.'.product_info_catch_language');
        $product = json_decode($_POST['data'],true);
        foreach ($product as $datas)
        {
            //Kohana_log::instance()->add('catch_sku:'.$datas['sku'], ' STATE:NORMAL' . ' | RES:' . json_encode($datas) );
            $obj = ORM::factory("product")
                ->where('site_id', '=', 1)
                ->where('sku', '=', $datas['sku'])
                ->find();
            if($obj->loaded())
            {
                $array = array();
                $filter = array('cost','total_cost','price','weight');//对这三个字段进行数据验证，大于0，更新,小于0，跳出本次循环
                //需要更新的字段
                foreach ($datas as $key =>  $data)
                {
                    if(!empty($data))
                    {
                        $type = in_array($key,$filter)?($data>0?1:0):1;
                        if(!$type)continue;
                        $array[$key] = $data;
                    }
                }
                //Kohana_log::instance()->add('update_sku:'.$datas['sku'], ' STATE:NORMAL' . ' | RES: '. json_encode($array));
                //产品表更新
                if(!empty($array))
                {
                    $update=DB::update('products')->set($array)->where('sku', '=', $datas['sku'])->execute();
                    if(!$update){
                        $not_update[$datas['sku']][]= 'en';
                    }
/*                   小语种不需要更新 foreach ($languages as $l)
                    {
                        if($l==='en')
                        {
                            continue;
                        }
                        $update=DB::update('products_'.$l)->set($array)->where('sku', '=', $datas['sku'])->execute();
                        if(empty($update))
                        {

                            $not_update[$datas['sku']][] =  $l;
                        }
                    }*/
                }
            }
            else
            {
                $not_found[] = $datas['sku'];
            }
        }
        Kohana_log::instance()->add('not found' , json_encode($not_found));
        Kohana_log::instance()->add('not update' , json_encode($not_update));
        exit();
    }
    public function action_small_language_data_back()
    {

        if(empty($_POST['data']))
        {
            Kohana_log::instance()->add('small_language_data_back' , 'empty');
            exit();
        }else{
            Kohana_log::instance()->add('small_language_data_back' , $_POST['data']);
        }

        $datas = json_decode($_POST['data'],true);
        $l = $datas['la'];
        $product = $datas['data'];
        $not_update = array();
        $update = array();
        $not_found= array();
        $n =0;
        $u =0;
        $m =0;
        foreach ($product as $data)
        {
            $obj = ORM::factory("product")
                ->where('site_id', '=', 1)
                ->where('sku', '=', $data['sku'])
                ->find();
            if($obj->loaded())
            {
                $res = DB::update('products_' . $l)->set($data)->where('sku', '=', $data['sku'])->execute();
                if (empty($res)) {
                    $n++;
                    $not_update[] = $data['sku'];
                } else {
                    $u++;
                    $update[] = $data['sku'];
                }
            }
            else
            {
                $m++;
                $not_found[] = $data['sku'];
            }
        }
        Kohana_log::instance()->add('small_language_update_'.$l , 'count:'.$u.'| sku:'.json_encode($update));
        Kohana_log::instance()->add('small_language_not_update_'.$l , 'count:'.$n.'| sku:'.json_encode($not_update));
        Kohana_log::instance()->add('small_language_not_found_'.$l , 'count:'.$m.'| sku:'.json_encode($not_found));
        exit();
    }
}

